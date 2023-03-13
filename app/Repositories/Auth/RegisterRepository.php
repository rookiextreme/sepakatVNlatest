<?php

namespace App\Repositories\Auth;

use App\Mail\RegistrationEmailNotificationToOperation;
use App\Mail\RegistrationEmailNotificationToUser;
use App\Mail\userEmailVerification;
use App\Models\RefRole;
use App\Models\RefStatus;
use App\Models\User;
use App\Models\Users\UserVerification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RegisterRepository
{
    public $lang = 'bm';

    public function register($data)
    {

        if(session()->get('sess_lang')){
            $this->lang = session()->get('sess_lang');
        }

        $langEmailSubject = [
            'bm' => 'Pengaktifan Akaun Spakat',
            'en' => 'Spakat Account Activation'
        ];

        $randPass = Str::random(10);

        Log::info('default password :: normal register '. $randPass);

        $user = User::create([
            'name' => $data['name'],
            'username' => null,
            'email' => $data['email'],
            'password' => Hash::make($randPass)
        ]);

        $user->assignRole('05');

        $refRoleCode = "05";
        $refRole = RefRole::where('code', $refRoleCode)->first();

        Log::info($data);

        $dataDetail = [
            'identity_no' => $data['identityNo'],
            'telpejabat' => $data['office'],
            'telbimbit' => $data['phone'],
            'register_purpose' => $data['registerPurpose'],
            'company_name' => $data['company_name'],
            'owner_type_id' => $data['owner_type_id'],
            'ref_role_id' => $refRole->id,
        ];

        $isNeedApproval = [];//['is_jkr', 'is_contractor'];

        if(in_array($data['registerPurpose'], $isNeedApproval)){
            $refStatus = RefStatus::where('code', '03')->first();
            $dataDetail['ref_status_id'] = $refStatus -> id;
        } else {
            $refStatus = RefStatus::where('code', '06')->first();
            $dataDetail['ref_status_id'] = $refStatus -> id;
        }

        $detail = $user->detail()->create($dataDetail);

        Log::info('register');
        Log::info($data);

        if($data['registerPurpose'] == 'is_jkr')
        {
            $this->jkr($detail, $data);
        } else if($data['registerPurpose'] == 'is_gover_agency'){
            $this->gov_agency($detail, $data);
        } else if($data['registerPurpose'] == 'is_contractor'){
            $this->contractor($detail, $data);
        }  else if($data['registerPurpose'] == 'is_public'){
            $this->public($detail, $data);
        }

        if(in_array($data['registerPurpose'], $isNeedApproval)){
            $registerData = [
                'from' => env('MAIL_FROM_NAME'),
                'subject' => $langEmailSubject[$this->lang],
                'title'=> '',
                'body' => '',
                'fullname' => $data['name'],
                'url' => route('login'),
                'lang' => $this->lang,
            ];
    
            Log::info('Send Email To User  >>>>> '.$data['email']);
            Mail::to($data['email'])->send(new RegistrationEmailNotificationToUser($registerData));
    
            Log::info('Send Email To Role Admin  >>>>>');
            $approvalByAdminUsers = DB::select("select a.email from users.users a
            join model_has_roles b on b.model_id = a.id
            join roles c on c.id = b.role_id
            join ref_role d on d.code = c.name
            join ref_role_access e on e.id = d.ref_role_access_id
            where e.code in ('01')");
            Mail::to($approvalByAdminUsers)->send(new RegistrationEmailNotificationToOperation($registerData));
        } else {
            $token = sha1(uniqid(time(), true));

            $url = route('activation.user', [
                "token" => $token,
                "view" => 'create'
            ]);

            $data = [
                'from' => env('MAIL_FROM_NAME'),
                'subject' => $langEmailSubject[$this->lang],
                'title'=> '',
                'body' => 'asdsd',
                'fullname' => $user-> name,
                'url' => $url,
                'lang' => $this->lang,
            ];

            Log::info('$url UserVerification --> '.$url);

            UserVerification::create([
                'user_id'=> $user->id,
                'token' => $token,
                'status' => true,
                'expired_token' => Carbon::now()->addDays(3)
            ]);
            
            Mail::to($user)->send(new userEmailVerification($data));
        }

        return [
            'status' => 200
        ];
    }

    public function update($data, $selectedId)
    {

        $user = User::find($selectedId);

        Log::info($user);

        $refStatusCode = "03";
        $refStatus = RefStatus::where('code', '=', $refStatusCode)->first();

        $detail = $user->detail()->update([
            'identity_type_id' => $data['identity'],
            'identity_no' => $data['identityNo'],
            'telpejabat' => $data['office'],
            'telbimbit' => $data['phone'],
            'gov_staff' => $data['gover'],
            'jkr_staff' => $data['jkr'],
            'ref_status_id' => $refStatus -> id
        ]);

        if($data['registerPurpose'] == 'is_jkr')
        {
            $this->jkr($detail, $data);
        } else if($data['registerPurpose'] == 'is_gover_agency'){
            $this->gov_agency($detail, $data);
        } else if($data['registerPurpose'] == 'is_contractor'){
            $this->contractor($detail, $data);
        }  else if($data['registerPurpose'] == 'is_public'){
            $this->public($detail, $data);
        }

        return [
            'status' => 200
        ];
    }

    public function jkr($detail, $data)
    {
        Log::info('hai masuk staff');
        $staff =  $detail->jkrStaff()->create([
            'designation' => $data['designation'],
            'owner_type_id' => $data['owner_type_id'],
            'branch_id' => $data['branch_id'],
            'division_desc' => $data['division_desc']
        ]);
    }

    public function gov_agency($detail, $data)
    {
        $staff =  $detail->govAgencyStaff()->create([
            'designation' => $data['designation'],
            'owner_type_id' => $data['owner_type_id'],
            'agency_id' => $data['agency_id'],
            'division_desc' => $data['division_desc']
        ]);
    }

    public function contractor($detail, $data)
    {
        $staff =  $detail->contractorStaff()->create([
            'designation' => $data['designation'],
            'company_name' => $data['company_name'],
            'ssm_no' => $data['ssm_no'],
            'latest_project_name' => $data['latest_project_name'],
            'ministry_id' => $data['company_kem']
        ]);
    }

    public function public($detail, $data)
    {
        $staff =  $detail->publicStaff()->create();
    }
}
