<?php

namespace App\Http\Livewire\Jurutera\Penolong;

use Livewire\Component;
use App\Models\Kenderaan\Pendaftaran;
class Semakan extends Component
{
    public $lists;

    public function mount()
    {
        $this->lists = Pendaftaran::all();
    }

    public function render()
    {
        return view('livewire.jurutera.penolong.semakan');
    }
}
