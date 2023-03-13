<?php

namespace App\Http\Livewire\Dashboard\Saman\Pengguna;

use App\Models\Saman\MaklumatKenderaanSaman;
use App\Models\Saman\Pengguna\MaklumatPembayaran;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class PembayaranSaman extends Component
{
    use WithFileUploads; 

    public $dokumen;
    public $tab = 'pendaftaran';
    public $bayar = [];
    public $saman_id;

    public function mount()
    {
        $this->saman_id =  request('id');
    }

    public function store()
    {
        $saman = MaklumatKenderaanSaman::find($this->saman_id);

        $update = $saman->maklumatPembayaran()->create([
            'no_resit' => $this->bayar['resit'],
            'jumlah_bayaran' => $this->bayar['jumlah'],
            'tarikh_bayaran' => $this->bayar['tarikh'],
        ]);

        if(!empty($this->dokument))
        {
            $dat = $this->upload();

            $update->dokumentPembayaran()->create([
                'name_dokumen' => $dat['original_name'],
                'path_dokumen' => $dat['document_path']
            ]);
        }

        $saman->update([
            'status_saman_id' => 4
        ]);

        Session::flash('submition', 'Pembyaran direkodkan');

        redirect()->route('saman.pengguna.rekod');

    }

    public function view()
    {
        if(request('id'))
        {
            $bayar = MaklumatPembayaran::find(request('id'));

            $this->bayar = [
                'resit' => $bayar->no_resit,
                'jumlah' => $bayar->jumlah_bayaran,
                'tarikh_bayaran' => $bayar->tarikh_bayaran
             ];
             
            if(!empty($bayar->dokumenPembayaran))
            {
                $this->bayar['url'] = Storage::url($bayar->dokumenPembayaran->path_dokumen.'/'.$bayar->dokumenPembayaran->name_dokumen);
            }
        }


        

    }

    public function upload()
    {
        $dokumen = $this->dokumen;
        
        $path = "public/kenderaan/dokumen/saman/resit/".$this->saman_id;

        $data = [ 
            'id' => $this->saman_id,
            'original_name' => $dokumen->getClientOriginalName(),
            'document_path' => $path
        ];

        //save
        $dokumen->storeAs($path, $dokumen->getClientOriginalName());

        return $data;

    }

    public function render()
    {
        return view('livewire.dashboard.saman.pengguna.pembayaran-saman');
    }
}
