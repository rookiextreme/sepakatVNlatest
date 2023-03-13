<?php

namespace App\Http\Livewire\Dashboard\Kenderaan\Komponen;

use App\Repositories\Kenderaan\StatusRepository;
use Livewire\Component;

class SubmitModal extends Component
{
    public $regid;
    public $messages;

    public function mount()
    {
        $this->messages = $this->checkStatus();
    }

    public function status()
    {
        $status = new StatusRepository();

        return $status;
    }

    public function registerSubmit()
    {
        $status =  $this->status()->registerSubmit($this->regid);

        if($status['status'] == 200)
        {
            return redirect()->route('vehicle.list');
        }
    }

    public function checkStatus()
    {
        $status = $this->status()->submitionCheck($this->regid);

        return $status;
    }

    public function semakSemula()
    {
        $this->messages = $this->checkStatus();
        
    }
    public function render()
    {
        return view('livewire.dashboard.kenderaan.komponen.submit-modal');
    }
}
