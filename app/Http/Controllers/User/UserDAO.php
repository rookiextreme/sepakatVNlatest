<?php

namespace App\Http\Controllers\User;

use App\Models\RefAgency;
use App\Models\RefRole;
use App\Models\RefState;
use App\Models\RefStatus;
use App\Models\RefWorkshop;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserDAO
{
    public function refRole($code)
    {
        $query = RefRole::where('code', $code)->first();
        return $query->id;
    }

    private function refStatus($code){
        return RefStatus::where('code', $code)->first()->id;
     }

     private function refAgency($code){
        return RefAgency::where('code', $code)->first()->id;
     }

     private function refState($code){
        return RefState::where('code', $code)->first()->id;
     }

     private function hasWorkshop($code){
         return RefWorkshop::where('code', $code)->first()->id;
     }

    public function createUserAdmin($name, $username, $email, $password, $workshop_code, $register_purpose, $telbimbit){
        $user = User::create([
            'name' => strtoupper($name),
            'username' => $username,
            'email' => $email,
            'password' =>  Hash::make($password)
        ]);
        $user->assignRole('01');
        $user->detail()->create([
            'user_id' => $user->id,
            'ref_status_id' => $this->refStatus('06'),
            'ref_role_id' => $this->refRole('01'),
            'register_purpose' => $register_purpose,
            'telbimbit' => $telbimbit,
            'workshop_id' => $workshop_code ? $this->hasWorkshop($workshop_code) : null
        ]);

        return $user;
    }

    public function createUserTopMngt($name, $username, $email, $password, $workshop_code, $register_purpose, $telbimbit){
        $user = User::create([
            'name' => strtoupper($name),
            'username' => $username,
            'email' => $email,
            'password' =>  Hash::make($password)
        ]);
        $user->assignRole('02');
        $user->detail()->create([
            'user_id' => $user->id,
            'ref_status_id' => $this->refStatus('06'),
            'ref_role_id' => $this->refRole('02'),
            'register_purpose' => $register_purpose,
            'telbimbit' => $telbimbit,
            'workshop_id' => $workshop_code ? $this->hasWorkshop($workshop_code) : null
        ]);
    }

    public function createUserEngineer($name, $username, $email, $password, $workshop_code, $register_purpose, $telbimbit, $roleCode){
        $user = User::create([
            'name' => strtoupper($name),
            'username' => $username,
            'email' => $email,
            'password' =>  Hash::make($password)
        ]);
        Log::info('createUserEngineer :: new user-id => '.$user->id);
        $user->assignRole($roleCode);
        $user->detail()->create([
            'user_id' => $user->id,
            'ref_status_id' => $this->refStatus('06'),
            'ref_role_id' => $this->refRole($roleCode),
            'register_purpose' => $register_purpose,
            'telbimbit' => $telbimbit,
            'workshop_id' => $workshop_code ? $this->hasWorkshop($workshop_code) : null
        ]);
        return $user;
    }

    public function createUserAssistEngineer($name, $username, $email, $password, $workshop_code, $register_purpose, $telbimbit, $roleCode){
        $user = User::create([
            'name' => strtoupper($name),
            'username' => $username,
            'email' => $email,
            'password' =>  Hash::make($password)
        ]);
        $user->assignRole($roleCode);
        $user->detail()->create([
            'user_id' => $user->id,
            'ref_status_id' => $this->refStatus('06'),
            'ref_role_id' => $this->refRole($roleCode),
            'register_purpose' => $register_purpose,
            'telbimbit' => $telbimbit,
            'workshop_id' => $workshop_code ? $this->hasWorkshop($workshop_code) : null
        ]);
        return $user;
    }

    public function createUserPublic($name, $username, $email, $password, $workshop_code, $register_purpose, $telbimbit){
        $user = User::create([
            'name' => strtoupper($name),
            'username' => $username,
            'email' => $email,
            'password' =>  Hash::make($password)
        ]);
        $user->assignRole('05');
        $user->detail()->create([
            'user_id' => $user->id,
            'ref_status_id' => $this->refStatus('06'),
            'ref_role_id' => $this->refRole('05'),
            'register_purpose' => $register_purpose,
            'telbimbit' => $telbimbit,
            'workshop_id' => $workshop_code ? $this->hasWorkshop($workshop_code) : null
        ]);
        return $user;
    }

    public function createUserPublicGovAgency($name, $username, $email, $password, $workshop_code, $agencyCode, $departName, $address, $postcode, $stateCode, $register_purpose, $telbimbit){
        $user = User::create([
            'name' => strtoupper($name),
            'username' => $username,
            'email' => $email,
            'password' =>  Hash::make($password)
        ]);
        $user->assignRole('05');
        $user->detail()->create([
            'user_id' => $user->id,
            'ref_status_id' => $this->refStatus('06'),
            'ref_role_id' => $this->refRole('05'),
            'register_purpose' => $register_purpose,
            'telbimbit' => $telbimbit,
            'workshop_id' => $workshop_code ? $this->hasWorkshop($workshop_code) : null,
            'agency_id' => $this->refAgency($agencyCode),
            'department_name' => $departName,
            'address' => $address,
            'postcode' => $postcode,
            'state_id' => $this->refState($stateCode)
        ]);
    }

    public function createUserDriver($name, $username, $email, $password, $workshop_code, $register_purpose, $telbimbit){
        $user = User::create([
            'name' => strtoupper($name),
            'username' => $username,
            'email' => $email,
            'password' =>  Hash::make($password)
        ]);
        $user->assignRole('06');
        $user->detail()->create([
            'user_id' => $user->id,
            'ref_status_id' => $this->refStatus('06'),
            'ref_role_id' => $this->refRole('06'),
            'register_purpose' => $register_purpose,
            'telbimbit' => $telbimbit,
            'workshop_id' => $workshop_code ? $this->hasWorkshop($workshop_code) : null
        ]);
    }

    public function createUserForemenAssessment($name, $username, $email, $password, $workshop_code, $telbimbit){
        $user = User::create([
            'name' => strtoupper($name),//'Pembantu Kemahiran 01',
            'username' => $username,//'pemkem',
            'email' => $email,//'pemkem@spakat.com',
            'password' =>  Hash::make($password)//asdqwe123
        ]);
        $user->assignRole('07');
        $user->detail()->create([
            'user_id' => $user->id,
            'ref_status_id' => RefStatus::where('code', '06')->first()-> id,
            'ref_role_id' => $this->refRole('07'),
            'register_purpose' => 'is_jkr',
            'workshop_id' => $workshop_code ? $this->hasWorkshop($workshop_code) : null,
            'telbimbit' => $telbimbit,
        ]);

        return $user;
    }

    public function foremanMaintenanceEva($name, $username, $email, $password, $workshop_code, $telbimbit){
        $user = User::create([
            'name' => strtoupper($name),
            'username' => $username,
            'email' => $email,
            'password' =>  Hash::make($password)//asdqwe123
        ]);
        $user->assignRole('08');
        $user->detail()->create([
            'user_id' => $user->id,
            'ref_status_id' => RefStatus::where('code', '06')->first()-> id,
            'ref_role_id' => $this->refRole('08'),
            'register_purpose' => 'is_jkr',
            'workshop_id' => RefWorkshop::where('code', $workshop_code)->first()->id,
            'telbimbit' => $telbimbit,
        ]);
    }

    public function createUserSeniorEngineer($name, $username, $email, $password, $workshop_code, $register_purpose, $telbimbit, $roleCode){
        $user = User::create([
            'name' => strtoupper($name),
            'username' => $username,
            'email' => $email,
            'password' =>  Hash::make($password)
        ]);
        $user->assignRole($roleCode);
        $user->detail()->create([
            'user_id' => $user->id,
            'ref_status_id' => $this->refStatus('06'),
            'ref_role_id' => $this->refRole($roleCode),
            'register_purpose' => $register_purpose,
            'telbimbit' => $telbimbit,
            'workshop_id' => $workshop_code ? $this->hasWorkshop($workshop_code) : null
        ]);
    }

    public function createUserForemen($name, $username, $email, $password, $workshop_code, $telbimbit){
        $user = User::create([
            'name' => strtoupper($name),//'Pembantu Kemahiran 01',
            'username' => $username,//'pemkem',
            'email' => $email,//'pemkem@spakat.com',
            'password' =>  Hash::make($password)//asdqwe123
        ]);
        $user->assignRole('16');
        $user->detail()->create([
            'user_id' => $user->id,
            'ref_status_id' => RefStatus::where('code', '06')->first()-> id,
            'ref_role_id' => $this->refRole('16'),
            'register_purpose' => 'is_jkr',
            'workshop_id' => $workshop_code ? $this->hasWorkshop($workshop_code) : null,
            'telbimbit' => $telbimbit,
        ]);

        return $user;
    }


    public function createUserCoordinator($name, $username, $email, $password, $workshop_code, $register_purpose, $telbimbit, $roleCode){
        $user = User::create([
            'name' => strtoupper($name),
            'username' => $username,
            'email' => $email,
            'password' =>  Hash::make($password)
        ]);
        $user->assignRole($roleCode);
        $user->detail()->create([
            'user_id' => $user->id,
            'ref_status_id' => $this->refStatus('06'),
            'ref_role_id' => $this->refRole($roleCode),
            'register_purpose' => $register_purpose,
            'telbimbit' => $telbimbit,
            'workshop_id' => $workshop_code ? $this->hasWorkshop($workshop_code) : null
        ]);
    }

}
