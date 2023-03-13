<?php

namespace App\Http\Livewire\Dashboard\Saman\Components;

use App\Models\Saman\MaklumatKenderaanSaman;
use Livewire\Component;

class DeleteModal extends Component
{  
    public $saman_id;
    public $message = [
        'style' => 'danger',
        'header' => 'Kepastian !',
        'message' => 'Anda pasti ingin membuang rekod saman ini ?'
    ];

    public function delete()
    {
        $saman = MaklumatKenderaanSaman::find($this->saman_id);

        $update = $saman->update([
            'status_saman_id' => 5
        ]);

        if($update)
        {
            $this->message = [
                'style' => 'success',
                'header' => 'Berjaya!',
                'message' => 'Rekod berjaya dibuang'
            ];
            
        }else{

            $this->message = [
                'style' => 'danger',
                'header' => 'Tidak Berjaya',
                'message' => 'Rekod tidak berjaya dibuang'
            ];

        }

        redirect()->route('saman.jurutera.rekod');

    }

    public function render()
    {
        return view('livewire.dashboard.saman.components.delete-modal');
    }
}
