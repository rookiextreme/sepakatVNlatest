<?php

namespace App\Http\Livewire\Components\Jurutera;

use App\Models\Identifier\KenderaanStatus;
use App\Models\Kenderaan\Pendaftaran;
use App\Models\Kenderaan\StatusSemakan;
use Livewire\Component;

class ModalSemakan extends Component
{
    public $pendaftaran_id;
    public $comment;
    public $success;

    public function mount()
    {
        $this->success = '';
    }
    
    public function updateStatus($status)
    {
        $semakan = Pendaftaran::find($this->pendaftaran_id);

        $stat = KenderaanStatus::where('status', $status)->first();

        $update = $semakan->statusSemakan()->update([
            'vapp_status_id' => $stat->id,
            'comment' => $this->comment
        ]);

        $this->success = 'Status rekod dikemaskini!';
    }

    public function batalRekod()
    {
        $status = 'ditolak';

        $this->updateStatus($status);
    }

    public function semakanSemula()
    {
        $status = 'tidak_lengkap';

        $this->updateStatus($status);
    }

    public function pasti()
    {
        $status = 'menunggu_pengesahan';

        $this->updateStatus($status);
    }


    public function render()
    {
        return view('livewire.components.jurutera.modal-semakan');
    }
}
