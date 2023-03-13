<?php

namespace App\Http\Livewire\Dashboard\Pengguna;

use Livewire\Component;
use App\Models\Identifier\Jawatan;
use App\Models\Identifier\IdentityType;
use App\Models\Identifier\Jabatan;
use App\Models\Identifier\Kementerian;
use App\Models\Location\Cawangan;
use App\Repositories\Auth\RegisterRepository;
use Illuminate\Support\Facades\Log;

class Profile extends Component
{
    public $selectedId;
    public $email;
    public $name;
    public $identity;
    public $identityNo;
    public $office;
    public $phone;
    public $gover;


    public $jkr;
    public $jawatan;
    public $jabatan;
    public $unit;
    public $kem;
    public $branch;

    public $companyName;
    public $ssmno;
    public $projectName;
    public $companyKem;
    
    public $jawatans;
    public $jabatans;
    public $identities;
    public $cawangan;
    public $ministryLists;

    public $idLabel = 'No Kad Pengenalan';

    public function mount()
    {

        $this->selectedId = auth()->user()->id;

        $this->jawatans = Jawatan::all();
        $this->jabatans = Jabatan::all();
        $this->identities = IdentityType::all();
        $this->cawangan = Cawangan::all();
        $this->ministryLists = Kementerian::all();
        
        $user = \App\Models\User::find(request('id'));

        $this->email = $user->email;
        $this->name = $user->name;
        $this->identity = $user->detail ? $user->detail->identityType->id : null;
        $this->identityNo = $user->detail ? $user->detail->identity_no : null;
        $this->office = $user->detail ? $user->detail->telpejabat : null;
        $this->phone= $user->detail ? $user->detail->telbimbit : null;
        $this->gover = $user->detail && $user->detail->gov_staff == true ? 'true' : 'false';
        $this->jkr = $user->detail && $user->detail->jkr_staff == true ? 'true' : 'false';
        $this->branch = $user->detail && $user->detail->jkrStaff ? $user->detail->jkrStaff->cawangan->id : null;
        $this->kem = $user->detail && $user->detail->jkrStaff ? $user->detail->jkrStaff->kementerian : null;
        $this->jawatan = $user->detail && $user->detail->jkrStaff ?  $user->detail->jkrStaff->jawatan->id : null;



    }

    public function save()
    {   
        Log::info('haii');
        $register = new RegisterRepository();
        // error_log('message here.');

        if($this->gover == 'true')
        {
            $gover = true;

            if($this->jkr == 'true')
            {
                $jkr = true;
            }else{
                $jkr = false;
            }

        }else{

            $gover = false;
            $jkr = false;


        }

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'identity' => $this->identity,
            'identityNo' => $this->identityNo,
            'office' => $this->office,
            'phone' => $this->phone,
            'gover' => $gover,
            'jkr' => $jkr,
            'jawatan' => $this->jawatan,
            'jabatan' => $this->jabatan,
            'cawangan' => $this->branch,
            'company_name' => $this->companyName,
            'ssmno' => $this->ssmno,
            'project_name' => $this->projectName,
            'company_kem' => $this->companyKem
        ];

        $reg = $register->update($data, $this->selectedId);

        if($reg['status'] == 200)
        {
            return redirect()->route('spakat.success');
        }
    }

    public function render()
    {
        return view('livewire.dashboard.pengguna.profile');
    }
}
