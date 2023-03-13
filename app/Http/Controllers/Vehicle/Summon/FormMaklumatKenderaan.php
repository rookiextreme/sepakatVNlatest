<?php

namespace App\Http\Controllers\Vehicle\Summon;

use App\Mail\SummonPICEmailNotification;
use App\Models\Fleet\FleetLookupVehicle;
use App\Models\Saman\MaklumatKenderaanSaman;
use App\Models\User;
use App\Repositories\Summon\RegisterSummonRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class FormMaklumatKenderaan extends Component
{
    public $informations = [];
    public $saman_id;
    public $summon;
    public $is_display = false;
    public $SummonFormVehicle;

    protected $listeners = [
        'updateOwner',
        'updateVehicle'
    ];

    public function mount()
    {
        $this->availableData();
        $this->status();
    }

    public function updateVehicle($id)
    {
        $request['vehicle_id'] = $id;

        $vehicle = FleetLookupVehicle::find($id);

        $request['no_pendaftaran'] = $vehicle->no_pendaftaran;
    }

    public function status()
    {
        if(request('id'))
        {
            Session()->put('session_saman_id', $this->saman_id);
            $summon = MaklumatKenderaanSaman::find($this->saman_id);

            if(!empty($summon->statusSaman))
            {
                $this->summon = $summon->status_saman;
            }
        }else{
            $this->summon = 'draf';
        }
    }

    public function updateOwner($id)
    {
        $request['owner_id'] = $id;


        $pemilik = User::find($id)->detail;

        $request['no_identiti'] = $pemilik->identity_no;
    }

    public function registerSummonRepository()
    {
        $respository = new RegisterSummonRepository();

        return $respository;
    }

    public function emailNotifyToVehiclePIC($vehicle_id, $summon_id){

        $vehicleDetail = FleetLookupVehicle::find($vehicle_id);
        $summonDetail = MaklumatKenderaanSaman::find($summon_id);

        $summonDetailUrl = route('vehicle.saman.daftar', [ 'id' => $summonDetail->id, 'vehicle_id' => $vehicle_id]);

        $regextAnd = "/[&]/";
        $summonDetailUrl = preg_replace($regextAnd, ',', $summonDetailUrl);

        Log::info($vehicleDetail->hasPersonIncharge);
        Log::info('summonDetailUrl --> '.$summonDetailUrl);

        $emailBody = [
            'subject' => 'Maklumat Saman Kenderaan '.Carbon::now()->format('d/m/Y'),
            'title' => 'Maklumat Saman Kenderaan bagi Plat Nombor '.$vehicleDetail['plate_no'],
            'vehicle_plat_no' => $vehicleDetail['no_pendaftaran'],
            'mistake_date' => $summonDetail->maklumatSaman->mistake_date,
            'mistake_time' => $summonDetail->maklumatSaman->mistake_time,
            'summon_notice_no' => $summonDetail->maklumatSaman->summon_notice_no,
            'vehicler_type' => $summonDetail->pendaftaran->hasSubCategoryType() ? $summonDetail->pendaftaran->hasSubCategoryType()->name : '-',
            'placement_name' => $summonDetail->pendaftaran->hasPlacement() ? $summonDetail->pendaftaran->hasPlacement()->name : '-',
            'pic_name' => $vehicleDetail->hasPersonIncharge ? $vehicleDetail->hasPersonIncharge->email : 'farid.developer.1992@gmail.com',
            'url' => Route('.redirect').'?redirectTo='.$summonDetailUrl
        ];

        Log::info($emailBody);

        if($vehicleDetail->hasPersonIncharge && $vehicleDetail->hasPersonIncharge->email){
            Mail::to($vehicleDetail->hasPersonIncharge->email)->send(new SummonPICEmailNotification($emailBody));
        }

        Log::info($vehicleDetail->cawangan);

        if($vehicleDetail->cawangan && $vehicleDetail->cawangan->email1){
            Mail::to($vehicleDetail->cawangan->email1)->send(new SummonPICEmailNotification($emailBody));
        }
        if($vehicleDetail->cawangan && $vehicleDetail->cawangan->email2){
            Mail::to($vehicleDetail->cawangan->email2)->send(new SummonPICEmailNotification($emailBody));
        }

        if($summonDetail->maklumatSaman->pic_email1){
            Mail::to($summonDetail->maklumatSaman->pic_email1)->send(new SummonPICEmailNotification($emailBody));
        }
        if($summonDetail->maklumatSaman->pic_email2){
            Mail::to($summonDetail->maklumatSaman->pic_email2)->send(new SummonPICEmailNotification($emailBody));
        }

        Mail::to('farid.developer.1992@gmail.com')->send(new SummonPICEmailNotification($emailBody));
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'vehicle_id' => 'required',
            'summon_agency_id' => 'required',
            'summon_type_id' => 'required',
            'summon_notice_no' => 'required',
            'notice_date' => 'required',
            'receive_notice_date' => 'required',
            'mistake_date' => 'required',
            // 'mistake_time' => 'required',
            // 'state_id' => 'required',
            'mistake_location' => 'required',
            // 'driver_id' => 'required',
            'total_compound' => 'required',
            'compound_reason' => 'required',
            'pic_email1' => 'nullable|email:rfc,dns',
            'pic_email2' => 'nullable|email:rfc,dns',
            'summon_notice_doc' => 'required_if:has_summon_notice_doc,0'
        ], [
            'vehicle_id.required' => 'Sila pilih maklumat kenderaan',
            'summon_agency_id.required' => 'Sila pilih pengeluaran saman',
            'summon_type_id.required' => 'Sila pilih jenis saman',
            'summon_notice_no.required' => 'Sila masukkan nombor notis saman',
            'notice_date.required' => 'Sila masukkan tarikh notis',
            'receive_notice_date.required' => 'Sila masukkan tarikh terima saman CDPK',
            'mistake_date.required' => 'Sila masukkan tarikh kesalahan',
            // 'mistake_time.required' => 'Sila masukkan masa kesalahan',
            // 'state_id.required' => 'Sila pilih negeri',
            'mistake_location.required' => 'Sila masukkan lokasi kesalahan',
            // 'driver_id.required' => 'Sila masukkan pemandu',
            'total_compound.required' => 'Sila masukkan jumlah kompaun',
            'compound_reason.required' => 'Sila masukkan sebab kompuan',
            'pic_email1.email' => 'Sila masukkan emel dengan betul seperti : youremail1@gmail.com',
            'pic_email2.email' => 'Sila masukkan emel dengan betul seperti : youremail2@gmail.com',
            'summon_notice_doc.required_if' => 'Sila muat naik dokumen notis saman'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $store = $this->registerSummonRepository()->storeVehicleInformation($request);

        return [
            'url' => route('vehicle.saman.daftar.save', ['id' => $store['id'], 'vehicle_id' => $request['vehicle_id'], 'tab' => 1 ])
        ];

    }

    public function availableData()
    {

        $summonId = -1;
        if(!empty($this->saman_id)){

            $this->SummonFormVehicle = MaklumatKenderaanSaman::find($this->saman_id);

            if($this->SummonFormVehicle){
                $summonId = $this->SummonFormVehicle->id;

                if(Request('is_display')){
                    $this->is_display = Request('is_display');
                }

                if(Auth::user()->isPublic()){
                    $this->is_display = 1;
                }
            }

            $identityNo = "";
            if(!empty($this->SummonFormVehicle->user->detail)){
                $identityNo = $this->SummonFormVehicle->user->detail->identity_no;
            }

            $this-> informations = [
                'vehicle_id' => $this->SummonFormVehicle->pendaftaran_id,
                'owner_id' => $this->SummonFormVehicle->user_id,
                'head_email' => $this->SummonFormVehicle->emel_ketua_jabatan,
                'owner_address' => $this->SummonFormVehicle->alamat_pejabat_pemilik,
                'no_pendaftaran' => $this->SummonFormVehicle->pendaftaran->no_pendaftaran,
                'no_identiti' => $identityNo
            ];
        }

        session()->put('session_summon_id', $summonId);
    }

    public function hantar()
    {
        $check = $this->registerSummonRepository()->completionCheck($this->saman_id);

        if($check['status'] == 400)
        {

            Session::flash('submition', $check['message']);

        }else{

            Session::flash('submition', 'Submition Berjaya!');

            redirect()->route('vehicle.saman.jurutera.rekod');
        }

    }
}
