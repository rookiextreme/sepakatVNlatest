<?php

namespace App\Http\Livewire\Dashboard\Saman\Jurutera;

use App\Models\Saman\MaklumatKenderaanSaman;
use Livewire\Component;

class CartaAlir extends Component
{
    public $overdue;
    public $verification;
    public $paids;
    public $delete;
    
    public function mount()
    {
        $this->overdue = MaklumatKenderaanSaman::where('status_saman_id', 2)->count();
        $this->verification = MaklumatKenderaanSaman::where('status_saman_id', 4)->count();
        $this->paids = MaklumatKenderaanSaman::where('status_saman_id', 3)->count();
        $this->delete = MaklumatKenderaanSaman::where('status_saman_id', 5)->count();


    }

    public function render()
    {
        return view('livewire.dashboard.saman.jurutera.carta-alir');
    }
}
