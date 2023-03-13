<?php

namespace App\Http\Livewire\Dashboard\Saman\Pengguna;

use App\Models\Saman\MaklumatKenderaanSaman;
use Livewire\Component;

class RekodSaman extends Component
{
    public $summons;

    public function mount()
    {
        if(request('id'))
        {
            $this->summons = MaklumatKenderaanSaman::where('user_id', auth()->user()->id)->where('status_saman_id', request('id'))->get();

        }else{
            $this->summons = MaklumatKenderaanSaman::where('user_id', auth()->user()->id)->get();
        }
    }

    public function render()
    {
        return view('livewire.dashboard.saman.pengguna.rekod-saman');
    }
}
