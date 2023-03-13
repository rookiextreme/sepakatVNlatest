<?php

namespace App\Http\Livewire\Dashboard\Saman\Components;

use App\Models\Saman\MaklumatKenderaanSaman;
use App\Repositories\Summon\RegisterSummonRepository;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;


class FormDokumen extends Component
{
    use WithFileUploads; 

    public $dokumen;
    public $saman_id;
    public $file = [];
    public $summon;

    public function mount()
    {
        $this->dokumen();
        $this->status();
    }

    public function dokumen()
    {
        $this->file['file'] = MaklumatKenderaanSaman::find($this->saman_id);

        if($this->file['file']->dokumenSaman)
        {
            $this->file['url'] = Storage::url($this->file['file']->dokumenSaman->path_dokumen.'/'.$this->file['file']->dokumenSaman->name_dokumen);
        }
    }

    public function registerSummonRepository()
    {
        $respository = new RegisterSummonRepository();

        return $respository;
    }

    public function status()
    {
        if(request('id'))
        {
            $summon = MaklumatKenderaanSaman::find($this->saman_id);

            if(!empty($summon->statusSaman))
            {
                $this->summin = $summon->status_saman;
            }
        }else{
            $this->summon = 'draf';
        }
    }

    public function upload()
    {
        $dokumen = $this->dokumen;
        
        $path = "public/kenderaan/dokumen/saman/".$this->saman_id;

        $data = [ 
            'id' => $this->saman_id,
            'original_name' => $dokumen->getClientOriginalName(),
            'document_path' => $path
        ];

        //save
        $dokumen->storeAs($path, $dokumen->getClientOriginalName());

        $store = $this->registerSummonRepository()->storeSummonDocument($data);

        $this->dokumen();

    }

    public function render()
    {
        return view('livewire.dashboard.saman.components.form-dokumen');
    }
}
