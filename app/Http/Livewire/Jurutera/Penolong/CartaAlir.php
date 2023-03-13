<?php

namespace App\Http\Livewire\Jurutera\Penolong;

use App\Models\Kenderaan\Pendaftaran;
use Livewire\Component;

class CartaAlir extends Component
{
    // public $status;

    // public function mount()
    // {
    //     $this->status = KenderaanStatus::all();
    // }

    // public function car

    public $totalNew;
    public $totalWaiting;
    public $totalVehicle;
    public $totalCorrection;
    public $totalDelete;

    public function mount()
    {
        $this->totalNew = Pendaftaran::join('kenderaans.status_semakans', 'pendaftarans.id', '=', 'kenderaans.status_semakans.pendaftaran_id')->where('kenderaans.status_semakans.vapp_status_id', 1)->count();
        $this->totalWaiting = Pendaftaran::join('kenderaans.status_semakans', 'pendaftarans.id', '=', 'kenderaans.status_semakans.pendaftaran_id')->where('kenderaans.status_semakans.vapp_status_id', 2)->count();
        $this->totalVehicle = Pendaftaran::all()->count();
        $this->totalCorrection = Pendaftaran::join('kenderaans.status_semakans', 'pendaftarans.id', '=', 'kenderaans.status_semakans.pendaftaran_id')->where('kenderaans.status_semakans.vapp_status_id', 5)->count();
        $this->totalDelete = Pendaftaran::join('kenderaans.status_semakans', 'pendaftarans.id', '=', 'kenderaans.status_semakans.pendaftaran_id')->where('kenderaans.status_semakans.vapp_status_id', 4)->count();


    }

    public function render()
    {
        return view('livewire.jurutera.penolong.carta-alir');
    }
}
