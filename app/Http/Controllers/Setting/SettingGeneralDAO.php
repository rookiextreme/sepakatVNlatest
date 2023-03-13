<?php

namespace App\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use App\Models\RefSetting;
use App\Models\RefSettingSub;
use App\Models\User;
use App\Models\Users\Detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class SettingGeneralDAO extends Controller
{
    public $settingList;

    public function mount(){

        $this->settingList = RefSetting::orderBy('code')->get();

    }

    public function save(Request $request)
    {
        Log::info($request);
        $this->settingList = RefSetting::all();
        $validateList = [];
        $validateMessageList = [];

        foreach ($this->settingList as $setting) {
            if($setting->is_required){
                $settingId = 'setting_sub_id_'.$setting->id;
                $validateList[$settingId] = 'required';
                $validateMessageList[$settingId.'.required'] = 'Sila pilih '.$setting->name;
            }
        }

        Log::info($validateList);
        Log::info($validateMessageList);

        $request->validate($validateList, $validateMessageList);

        return $this->store($request);
    }

    public function saveDetails(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'identityNo' => 'required|regex:/^\d{6}-\d{2}-\d{4}$/',
            'telbimbit' => 'required',
            'emel' => 'required',
            'address' => 'required',
            'postcode' => 'required',
            'state_id' => 'required',
            // 'workshop_id' => 'required',
            
            'owner_type_id' => 'required_if:register_purpose,is_jkr',
            'branch_id' => 'required_if:register_purpose,is_jkr',
            'agency_id' => 'required_if:register_purpose,is_gover_agency',
            'companyname' => 'required_if:register_purpose,is_contractor',
            'ssm_no' => 'required_if:register_purpose,is_contractor',
            'latest_project_name' => 'required_if:register_purpose,is_contractor',
            'ministry_id' => 'required_if:register_purpose,is_contractor',
            'department_name' => 'required',

        ],[
            'name.required' => 'Sila isi nama',
            'identityNo.required' => 'Sila masukkan no MyKad anda',
            'identityNo.regex' => 'Sila masukkan format no MyKad yang betul',
            'telbimbit.required' => 'Sila isi no telefon bimbit',
            'emel.required' => 'Sila isi emel',
            'address.required' => 'Sila isi alamat',
            'postcode.required' => 'Sila isi poskod',
            'state_id.required' => 'Sila pilih negeri',
            // 'workshop_id.required' => 'Sila pilih worksyop',

            'owner_type_id.required_if' => 'Sila Pilih Pemilikan',
            'agency_id.required_if' => 'Sila pilih sektor',
            'branch_id.required_if' => 'Sila pilih cawangan',
            'companyname.required_if' => 'Sila masukkan nama syarikat anda',
            'ssm_no.required_if' => 'Sila masukkan no ssm syarikat anda',
            'latest_project_name.required_if' => 'Sila masukkan nama projek terkini anda',
            'ministry_id.required_if' => 'Sila pilih kementerian',
            'department_name.required' => 'Sila isi jabatan/agensi',

        ]);

        $user = User::find($request->user_id);
        if($user){

            $details = [
                'name' => $request->name,
                'identity_no' => $request->identityNo,
                'telbimbit' => $request->telbimbit,
                'address' => $request->address,
                'postcode' => $request->postcode,
                'state_id' => $request->state_id,
                'department_name' => $request->department_name,
                'workshop_id' => $user->detail->workshop_id,//$request->workshop_id,
            ];

            //update email

            $checkOtherEmail = User::where('email', $request->emel)->where('id', '!=' , Auth::user()->id)->first();
            Log::info($checkOtherEmail);
            if(!$checkOtherEmail){
                $user->update([
                    'name' => $request->name,
                    'email' => $request->emel
                ]);
            } elseif($checkOtherEmail){
                return response()->json(['success' => false, 'errors' => [
                    'emel' => ['Emel Telah digunakan']
                ]], 422);
            }

            $detailProfilePath = public_path('/dokumen/detail/profail/');

            if(!is_dir($detailProfilePath)) {

                mkdir($detailProfilePath, 0755, true);
            }

            if($request->doc_image != null){
                $image = $request->doc_image;
                $image_doc = $image->getClientOriginalExtension();
                $imageName = Str::random(9).'.'.$image_doc;
                
                $img = Image::make($request->doc_image->path());
                $img->resize(250, null, function ($const) {
                    $const->aspectRatio();
                })
                ->save($detailProfilePath.'/'.$imageName);

                $details['doc_image_path'] = '/dokumen/detail/profail/';
                $details['doc_image'] = $imageName;
            }
    
            if($request->doc_signature != null){
                $pdf = $request->doc_signature;
                $pdf_doc = $pdf->getClientOriginalExtension();
                $fileName = Str::random(9).'.'.$pdf_doc;

                $img = Image::make($request->doc_signature->path());
                $img->resize(200, null, function ($const) {
                    $const->aspectRatio();
                })
                ->save($detailProfilePath.'/'.$fileName);

                $details['doc_signature_path'] = '/dokumen/detail/profail/';
                $details['doc_signature'] = $fileName;
            }

            $user->detail->update($details);
            $detail = $user->detail;

            if($request->register_purpose == 'is_jkr')
            {
                $this->jkr($detail, $request);
            } else if($request->register_purpose == 'is_gover_agency'){
                $this->gov_agency($detail, $request);
            } else if($request->register_purpose == 'is_contractor'){
                $this->contractor($detail, $request);
            }  else if($request->register_purpose == 'is_public'){
                $this->public($detail, $request);
            } else if($request->register_purpose == 'is_public_jkr'){
                $this->jkrPublicStaff($detail, $request);
            }

            $response = $user->detail->update($details);
            return $response;
        }
    }

    public function jkr($detail, $data)
    {
        $dataJkr = [
            'owner_type_id' => $data['owner_type_id'],
            'branch_id' => $data['branch_id'],
            'division_desc' => $data['division_desc']
        ];

        if($detail->jkrStaff){
            $detail->jkrStaff()->update($dataJkr);
        } else {
            $detail->jkrStaff()->create($dataJkr);
        }
    }

    public function gov_agency($detail, $data)
    {
        $dataGovAgency = [
            'agency_id' => $data['agency_id'],
            'division_desc' => $data['division_desc']
        ];

        if($detail->govAgencyStaff){
            $detail->govAgencyStaff()->update($dataGovAgency);
        } else {
            $detail->govAgencyStaff()->create($dataGovAgency);
        }

    }

    public function contractor($detail, $data)
    {
        $dataContractor = [
            'company_name' => $data['companyname'],
            'ssm_no' => $data['ssm_no'],
            'latest_project_name' => $data['latest_project_name'],
            'ministry_id' => $data['company_kem']
        ];

        if($detail->contractorStaff){
            $detail->contractorStaff()->update($dataContractor);
        } else {
            $detail->contractorStaff()->create($dataContractor);
        }

    }

    public function public($detail, $data)
    {
        if($detail->publicStaff){

        } else {
            $detail->publicStaff()->create();
        }
    }

    public function jkrPublicStaff($detail, $data)
    {
        if($detail->jkrPublicStaff){

        } else {
            $detail->jkrPublicStaff()->create();
        }
    }

    public function unsetStatusSettingSub(){
        $Setting = RefSettingSub::where('status', 1);
        $Setting->update([
            'status' => 0
        ]);
    }

    public function store(Request $request){

        $this->unsetStatusSettingSub();

        foreach ($request['setting_ids'] as $setting_id) {

            $setting_sub_id = $request['setting_sub_id_'.$setting_id];
            if(is_array($setting_sub_id)){
                $findSettingSub = RefSettingSub::whereIn('id', $setting_sub_id);
                if($findSettingSub){
                    $findSettingSub->update([
                        'status' => 1
                    ]);
                }
            } else {
                $findSettingSub = RefSettingSub::find($setting_sub_id);
                    if($findSettingSub){
                        $findSettingSub->update([
                            'status' => 1
                        ]);
                    }
            }
            
        }
        return back()
        ->with('success','Maklumat Berjaya Disimpan');

    }

    public function validatePassword($password){

        //$username = auth()->user()->username;

        Log::info('password : '.$password);
        $hashPassword=  Hash::make($password);
        $username = auth()->user()->username;
        Log::info('username : '.$username);

        $validatePasswordStatus = false;
        $user = User::where('username', $username)->first();
        if(Hash::check($password, $user->password)){
            $validatePasswordStatus = true;

        }

        return $validatePasswordStatus;



    }

    public function updatePassword($newPassword){

        $hashPassword=  Hash::make($newPassword);
        $username = auth()->user()->username;

        $user = User::where('username', $username)->first();
        $updated = $user->update([
            'password' => $hashPassword
        ]);

        // $returnValue = DB::update('
        // UPDATE users.users SET "password" = ?  AND updated_at = NOW() WHERE username = ? '
        // , [$hashPassword, $username]);

        // Log::info('returnValue : '.$returnValue);

        Log::info('updated => '.$updated);

        return $updated;

    }
}
