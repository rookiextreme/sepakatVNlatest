<?php

namespace App\Http\Livewire\Vehicle\Saman;

use App\Repositories\Summon\RegisterSummonRepository;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class DaftarSaman extends Component
{
    public $saman;
    public $tab;

    protected $listerners = [
        'checkSubmition'
    ];

    public function mount()
    {
        $this->saman['id'] = request('id');
        $this->tab = 'pendaftaran';
    }

    public function registerSummonRepository()
    {
        $repo = new RegisterSummonRepository();

        return $repo;
    }

    public function checkSubmition()
    {
        $check = $this->registerSummonRepository()->completionCheck($this->saman['id']);

        if($check['status'] == 400)
        {

            Session::flash('submition', $check['message']);

        }else{

            Session::flash('submition', 'Submition Berjaya!');
            

        }

        return redirect()->route('saman.jurutera.rekod');
        
    }

    public function render()
    {
        return view('livewire.vehicle.saman.daftar-saman');
    }
}
