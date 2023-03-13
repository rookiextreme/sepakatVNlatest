<?php

namespace App\Http\Livewire\Dashboard\Saman\Pengguna;

use App\Models\Saman\MaklumatKenderaanSaman;
use Livewire\Component;

class CartaAlir extends Component
{
    public $overdue;
    public $verification;
    public $paids;
    
    public function mount()
    {
        $this->overdue = MaklumatKenderaanSaman::where('status_saman_id', 2)->where('user_id', auth()->user()->id)->count();
        $this->verification = MaklumatKenderaanSaman::where('status_saman_id', 4)->where('user_id', auth()->user()->id)->count();
        $this->paids = MaklumatKenderaanSaman::where('status_saman_id', 3)->where('user_id', auth()->user()->id)->count();

    }

    public function render()
    {
        return view('livewire.dashboard.saman.pengguna.carta-alir');
    }
}
