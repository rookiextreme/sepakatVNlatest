<?php

namespace App\Http\Livewire\Vehicle\Saman\Components;

use App\Models\Kenderaan\Pendaftaran;
use App\Models\Users\Detail;
use Livewire\Component;

class SearchModal extends Component
{

    public $vehicle;
    public $owner;

    protected $queryString = ['vehicle', 'owner'];

    public function pemilik($id)
    {
        $this->emitUp('updateOwner', $id);
        $this->dispatchBrowserEvent('closePSMD');
    }

    public function kenderaan($id)
    {
        $this->emitUp('updateVehicle', $id);
    }

    public function render()
    {
        return view('livewire.vehicle.saman.components.search-modal', [
            'kenderaan' => Pendaftaran::where('no_pendaftaran', 'like', '%'.$this->vehicle.'%')->limit(10)->get(),
            'pemiliks' => Detail::where('identity_no', 'like', '%'.$this->owner.'%')->limit(10)->get()
        ]);
    }
}
