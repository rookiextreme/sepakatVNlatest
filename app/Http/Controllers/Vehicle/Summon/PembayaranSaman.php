<?php

namespace App\Http\Controllers\Vehicle\Summon;

use App\Models\Saman\DokumentSaman;
use App\Models\Saman\MaklumatKenderaanSaman;
use App\Models\Saman\Pengguna\MaklumatPembayaran;
use App\Models\Saman\Status\StatusSaman;
use App\Models\Saman\SummonDocument;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class PembayaranSaman extends Component
{
    use WithFileUploads;

    public $dokumen;
    public $tab = 'pendaftaran';
    public $bayar = [];
    public $saman_id;
    public $is_display = false;

    public function mount()
    {
        $this->saman_id =  request('summon_id');
        Session()->put('session_saman_id', $this->saman_id);
        Log::info("This ID: ". $this->saman_id);
    }

    public function imageUploadPost(Request $request)
    {

        $request->validate([
            'receipt_no' => 'required',
            'total_payment' => 'required',
            'payment_date' => 'required',
            'payment_method' => 'required',
            'hasNewDocument' => 'in:1,0',
            'dokumen_kemaskini' => 'required_if:hasNewDocument,1|mimes:jpeg,png,jpg,gif,pdf|max:2048',
        ], [
            'receipt_no.required' => 'Sila masukkan nombor resit',
            'total_payment.required' => 'Sila masukkan jumlah pembayaran',
            'payment_date.required' => 'Sila masukkan tarikh pembayaran',
            'payment_method.required' => 'Sila masukkan kaedah pembayaran',
            'dokumen_kemaskini.required_if' => 'Sila muat naik dokumen pembayaran',
            'dokumen_kemaskini.image' => 'Pastikan dokumen ialah fail pdf/imej',
            'dokumen_kemaskini.mimes' => 'Pastikan dokumen ialah fail jenis: pdf/jpeg,png,jpg,gif'
        ]);

        return $this->store($request);
    }

    private function convertDateToSQLDate($dateVal, $format){
        return Carbon::createFromFormat('d/m/Y', $dateVal)->format($format);
    }

    public function store(Request $request)
    {
        $this->saman_id = Session()->get('session_saman_id');
        Log::info('$this->saman_id --> '.$this->saman_id);
        $saman = MaklumatKenderaanSaman::find($this->saman_id);
        Log::info($saman);
        $update = 0;

        $paymentDt = isset($request['payment_date']) ? $request['payment_date'] : null;
        if($paymentDt){
            $paymentDt = $this->convertDateToSQLDate($paymentDt, 'Y-m-d');
        }

        if(!empty($saman->maklumatPembayaran)){
            Log::info('masuk sini :: update :: maklumatPembayaran');
            $update = $saman->maklumatPembayaran()->update([
                'receipt_no' => $request['receipt_no'],
                'total_payment' => $request['total_payment'],
                'payment_date' => $paymentDt,
                'payment_method' => $request['payment_method'],
            ]);

            $update = $saman->maklumatPembayaran;
        }else {

            Log::info('masuk sini :: create :: maklumatPembayaran');
            Log::info($request);
            $update = $saman->maklumatPembayaran()->create([
                'receipt_no' => $request['receipt_no'],
                'total_payment' => $request['total_payment'],
                'payment_date' => $paymentDt,
                'payment_method' => $request['payment_method'],
            ]);
        }

        if(!empty($request->dokumen_kemaskini))
        {
            $dat = $this->upload($request);

            Log::info($update);

            //todo remove symbol name. use hash

            $path = "kenderaan/dokumen/saman/resit/".$this->saman_id;
            if($update->dokumenPembayaran){

                $filename = $update->dokumenPembayaran->name_dokumen;
                $fullPath = $path.'/'.$filename;
                $this->deletePrevFile($fullPath);

                $update->dokumenPembayaran()->update([
                    'name_dokumen' => $dat['original_name'],
                    'path_dokumen' => $path
                ]);
            } else {
                $update->dokumenPembayaran()->create([
                    'name_dokumen' => $dat['original_name'],
                    'path_dokumen' => $path
                ]);
            }

        }

        $summonStatus = StatusSaman::where('code', '03')->first();

        $saman->update([
            'status_saman_id' => $summonStatus->id
        ]);

        // $user = $request->input('user');
        // switch ($user) {
        //     case 'not_admin':
        //         return $saman;
        //         break;

        //     default:
        //         return [
        //             'url' => route('vehicle.saman.daftar.save', ['id' => $this->saman_id, 'vehicle_id' => $saman->pendaftaran->id ])
        //         ];
        //         break;
            //}

        if(auth()->user()->isPublic()){
            $url = route('vehicle.saman.daftarbayar', ['id' => $this->saman_id, 'vehicle_id' => $saman->pendaftaran->id, 'tab' => 2 ]);
        } else {
            $url = route('vehicle.saman.daftar.save', ['id' => $this->saman_id, 'vehicle_id' => $saman->pendaftaran->id, 'tab' => 2 ]);
        }

        return 
        [
                'url' => $url
        ];


    }

    public function tukarMilik(Request $request)
    {
        $update = 0;
        $request->validate([
            'nama_pemandu' => 'required',
            'totalSupportDoc' => 'required',
        ], [
            'nama_pemandu.required' => 'Sila masukkan nama pemandu',
            'totalSupportDoc.required' => 'Sila Pilih Dokumen Sokongan',
        ]);
        $this->saman_id = Session()->get('session_saman_id');
        $summonId = session()->get('session_summon_id');
        $summonDetail = MaklumatKenderaanSaman::find($summonId);
        $summonStatus = StatusSaman::where('code', '04')->first();

        Log::info($summonDetail);
        $summonDetail->maklumatSaman()->update([
            'owner_name' => $request->nama_pemandu,
            'change_summon_owner' => true,
        ]);
        $summonDetail->update([
            'status_saman_id' => $summonStatus->id
        ]);


        $url = route('vehicle.saman.daftarbayar', ['id' => $this->saman_id, 'vehicle_id' => $summonDetail->pendaftaran->id]);
        return [
            'url' => $url
        ];

    }

    public function deleteSupportDoc(Request $request){
        $query = SummonDocument::find($request->id);
        if($query){
            $query->delete();
        }
    }

    public function view()
    {
        if(request('summon_id'))
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

    public function deletePrevFile($fullPath)
    {
        Log::info('$fullPath --> '.$fullPath);
        Storage::delete('public/'.$fullPath);
    }

    public function upload(Request $request)
    {
        $dokumen = $request->dokumen_kemaskini;

        $path = "public/kenderaan/dokumen/saman/resit/".$this->saman_id;
        
        $docFormat = $dokumen->getClientOriginalExtension();
        $fileName = Str::random(9).'.'.$docFormat;
        $data = [
            'id' => $this->saman_id,
            'original_name' => $fileName,
            'document_path' => $path
        ];

        //save
        $dokumen->storeAs($path, $fileName);

        return $data;

    }
}
