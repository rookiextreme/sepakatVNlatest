<?php

namespace App\Http\Livewire\Vehicle\Saman\Components;

use App\Models\Kenderaan\Pendaftaran;
use App\Models\Saman\MaklumatKenderaanSaman;
use App\Models\User;
use App\Models\Users\Detail;
use App\Repositories\Summon\RegisterSummonRepository;
use Livewire\Component;
use Illuminate\Support\Facades\Session;

class FormMaklumatKenderaan extends Component
{
    public $informations = [];
    public $saman_id;
    public $summon;

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
        $this->informations['vehicle_id'] = $id;

        $vehicle = Pendaftaran::find($id);

        $this->informations['no_pendaftaran'] = $vehicle->no_pendaftaran;
    }

    public function status()
    {
        if(request('id'))
        {
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
        $this->informations['owner_id'] = $id;


        $pemilik = User::find($id)->detail;

        $this->informations['no_identiti'] = $pemilik->identity_no;
    }

    public function registerSummonRepository()
    {
        $respository = new RegisterSummonRepository();

        return $respository;
    }
    
    public function store() 
    {
        $data = [
            'vehicle_id' => $this->informations['vehicle_id'],
            'owner_id' => $this->informations['owner_id'],
            'head_email' => $this->informations['head_email'],
            'owner_address' => $this->informations['owner_address'],

        ];

        $store = $this->registerSummonRepository()->storeVehicleInformation($data);

        return redirect()->route('saman.daftar.save', ['id' => $store['id']]);
    }

    public function availableData()
    {
        if(!empty($this->saman_id)){

            $x = MaklumatKenderaanSaman::find($this->saman_id);

            $this->informations = [
                'vehicle_id' => $x->pendaftaran_id,
                'owner_id' => $x->user_id,
                'head_email' => $x->emel_ketua_jabatan,
                'owner_address' => $x->alamat_pejabat_pemilik,
                'no_pendaftaran' => $x->pendaftaran->no_pendaftaran,
                'no_identiti' => $x->user->detail->identity_no
            ];
        }
    }

    public function hantar()
    {
        $check = $this->registerSummonRepository()->completionCheck($this->saman_id);

        if($check['status'] == 400)
        {

            Session::flash('submition', $check['message']);

        }else{

            Session::flash('submition', 'Submition Berjaya!');
            
            redirect()->route('saman.jurutera.rekod');
        }

    }

    public function render()
    {
        return view('livewire.vehicle.saman.components.form-maklumat-kenderaan');
    }
}
