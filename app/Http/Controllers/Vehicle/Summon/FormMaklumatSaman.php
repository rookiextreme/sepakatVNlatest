<?php

namespace App\Http\Controllers\Vehicle\Summon;

use App\Exports\VehicleSummonExport;
use App\Models\Fleet\FleetLookupVehicle;
use App\Models\Location\Cawangan;
use App\Models\Location\Daerah;
use App\Models\Location\Negeri;
use App\Models\RefSummonAgency;
use App\Models\RefSummonType;
use App\Models\Saman\MaklumatKenderaanSaman;
use App\Models\Saman\Pengguna\DokumenPembayaran;
use App\Models\Saman\Pengguna\MaklumatPembayaran;
use App\Models\Saman\SummonDocument;
use App\Repositories\Summon\RegisterSummonRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;

class FormMaklumatSaman extends Component
{
    public $informations = [];
    public $vehicle_id;
    public $saman_id;

    public $vehicleDetail;
    public $summon_agencies;
    public $summon_types;
    public $branchs;
    public $states;
    public $cities;
    public $summon;

    public function mount()
    {
        $this->summon_agencies = RefSummonAgency::all();
        $this->summon_types = RefSummonType::all();
        $this->branchs = Cawangan::all();
        $this->states = Negeri::all();
        $this->cities = Daerah::all();
        $this->loadVehicleDetail();
        $this->availableData();
        $this->status();

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

            Log::info($summon->statusSaman);

            if(!empty($summon->statusSaman))
            {
                $this->summon = $summon->statusSaman->code;
            }
        }else{
            $this->summon = '01';
        }
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new VehicleSummonExport($request), 'vehicle_summon.xlsx');
    }

    private function convertDateToSQLDate($dateVal, $format){
        return Carbon::createFromFormat('d/m/Y', $dateVal)->format($format);
    }

    private function convertTimeToSQLTime($dateVal, $format){
        return Carbon::createFromFormat('h:i A', $dateVal)->format($format);
    }

    public function store(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'summon_agency_id' => 'required',
        //     'summon_type_id' => 'required',
        //     'summon_notice_no' => 'required',
        //     'notice_date' => 'required',
        //     'receive_notice_date' => 'required',
        //     'mistake_date' => 'required',
        //     'mistake_time' => 'required',
        //     // 'state_id' => 'required',
        //     'mistake_location' => 'required',
        //     // 'driver_id' => 'required',
        //     'total_compound' => 'required',
        //     'compound_reason' => 'required',
        // ], [
        //     'summon_agency_id.required' => 'Sila pilih pengeluaran saman',
        //     'summon_type_id.required' => 'Sila pilih jenis saman',
        //     'summon_notice_no.required' => 'Sila masukkan nombor notis saman',
        //     'notice_date.required' => 'Sila masukkan tarikh notis',
        //     'receive_notice_date.required' => 'Sila masukkan tarikh terima saman CDPK',
        //     'mistake_date.required' => 'Sila masukkan tarikh kesalahan',
        //     'mistake_time.required' => 'Sila masukkan masa kesalahan',
        //     // 'state_id.required' => 'Sila pilih negeri',
        //     'mistake_location.required' => 'Sila masukkan lokasi kesalahan',
        //     // 'driver_id.required' => 'Sila masukkan pemandu',
        //     'total_compound.required' => 'Sila masukkan jumlah kompaun',
        //     'compound_reason.required' => 'Sila masukkan sebab kompuan',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        // }

        $this->saman_id = session()->get('session_summon_id');
        Log::info('$this->saman_id --> '. $this->saman_id);

        $noticeDt = isset($request['notice_date']) ? $request['notice_date'] : null;
        if($noticeDt){
            $noticeDt = $this->convertDateToSQLDate($noticeDt, 'Y-m-d');
        }

        $receiveNoticeDt = isset($request['receive_notice_date']) ? $request['receive_notice_date'] : null;
        if($receiveNoticeDt){
            $receiveNoticeDt = $this->convertDateToSQLDate($receiveNoticeDt, 'Y-m-d');
        }

        $mistakeDt = isset($request['mistake_date']) ? $request['mistake_date'] : null;
        if($mistakeDt){
            $mistakeDt = $this->convertDateToSQLDate($mistakeDt, 'Y-m-d');
        }

        $mistakeTime = isset($request['mistake_time']) ? $request['mistake_time'] : null;
        if($mistakeTime){
            $mistakeTime = $this->convertTimeToSQLTime($mistakeTime, 'h:i A');
        }

        $data = [
            'id' => $this->saman_id,
            'state_id' => $request['state_id'],
            'district_id' => $request['district_id'],
            'branch_id' => $request['branch_id'],
            'summon_agency_id' => $request['summon_agency_id'],
            'summon_type_id' => $request['summon_type_id'],
            'summon_notice_no' => $request['summon_notice_no'],
            'notice_date' => $noticeDt,
            'receive_notice_date' => $receiveNoticeDt,
            'mistake_date' => $mistakeDt,
            'mistake_time' => $mistakeTime,
            'mistake_location' => $request['mistake_location'],
            'driver_id' => $request['driver_id'],
            'total_compound' => $request['total_compound'],
            'compound_reason' => $request['compound_reason'],
            'summon_notice_doc' => $request['summon_notice_doc'],
            'pic_name1' => $request->pic_name1,
            'pic_email1' => $request->pic_email1,
            'pic_name2' => $request->pic_name2,
            'pic_email2' => $request->pic_email2
        ];

        $store = $this->registerSummonRepository()->storeSummonInformation($data);

        return [
            'url' => route('vehicle.saman.daftar.save', ['id' => $this->saman_id, 'vehicle_id' => $request['vehicle_id'], 'tab' => 1 ])
        ];

    }

    public function loadVehicleDetail(){
        $query = FleetLookupVehicle::find($this->vehicle_id);
        $this->vehicleDetail = $query;
    }

    public function availableData()
    {
        Log::info('$this->saman_id --> '.$this->saman_id);
        $saman = MaklumatKenderaanSaman::find($this->saman_id);
        Log::info($saman);
        if($saman)
        {

            if(!empty($saman->maklumatSaman)){

                $x = $saman->maklumatSaman;

                Log::info('payment detail');
                Log::info($saman->maklumatPembayaran);
                Log::info($saman->maklumatSaman->hasDriver);

                $this->informations = [
                    'state_id' => $x->state_id,
                    'state_name' => $x->negeri ? $x->negeri-> negeri : '',
                    'district_id' => $x->district_id,
                    'district_name' => $x->daerah ? $x->daerah-> name : '',
                    'branch_id' => $x->branch_id,
                    'change_summon_owner' => $x->change_summon_owner,
                    'change_summon_owner_note' => $x->change_summon_owner_note,
                    'summon_agency' => $x->hasSummonAgency,
                    'summon_type' => $x->hasSummonType,
                    'summon_notice_no' => $x->summon_notice_no,
                    'notice_date' => $x->notice_date,
                    'mistake_date' => $x->mistake_date,
                    'receive_notice_date' => $x->receive_notice_date,
                    'mistake_time' => $x->mistake_time,
                    'mistake_location' => $x->mistake_location,
                    'hasSummonStatus' => $saman->statusSaman,
                    'hasSummonNoticeDoc' => $saman->hasSummonNoticeDoc,
                    'hasDriver' => $x->hasDriver,
                    'total_compound' => $x->total_compound,
                    'compound_reason' => $x->compound_reason,
                    'pic_name1' => $x->pic_name1,
                    'pic_email1' => $x->pic_email1,
                    'pic_name2' => $x->pic_name2,
                    'pic_email2' => $x->pic_email2,
                    'payment' => $saman->maklumatPembayaran,
                    'hasStatus' => $saman->hasStatus
                ];

                Log::info('informations');

                Log::info($this->informations);

                if(!empty($saman->maklumatSaman->owner_name) || ($saman->maklumatSaman->owner_name != null))
                {
                    $this->informations['nama_pemandu'] = $saman->maklumatSaman->owner_name;
                }

                // $childDB = MaklumatPembayaran::where('maklumat_kenderaan_saman_id', $this->saman_id)->get()->first();
                // $dokument_pembayaran = DokumenPembayaran::where('maklumat_pembayaran_id', $childDB->id)->exist();
                // if($dokument_pembayaran){
                //     Log::info("wujud");
                // }
            }

        }
    }

    public function uploadSupportDoc(Request $request){

        $fleetView = isset($request['fleet_view']) ? $request['fleet_view'] : 'department';

        $validator = Validator::make($request->all(), [
            'support_doc' => 'required|file|max:8192',
        ],
        [
            'support_doc.required' => "Sila pilih dokuman sokongan untuk dimuat naik gambar",
            'support_doc.max' => "Maksimum saiz fail adalah dibawah 8 megabait"
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $support_doc_file = $request->support_doc;

        $fileName = Str::random(9).'.'.$support_doc_file->getClientOriginalExtension();
        $currentId = session()->get('session_summon_id');

        $vehicleThumbnailPath = public_path('/thumbnails/summon/');

        if(!is_dir($vehicleThumbnailPath)) {

            mkdir($vehicleThumbnailPath, 0755, true);
        }

        $allowedMimeTypes = ['image/jpeg','image/gif','image/png','image/bmp','image/svg+xml'];

        if(in_array($support_doc_file->getClientMimeType(), $allowedMimeTypes)){
            $img = Image::make($support_doc_file->path());
            $img->resize(250, 150, function ($const) {
                $const->aspectRatio();
            })->save($vehicleThumbnailPath.'/'.$currentId.'-'.$fileName);
        }

        if($support_doc_file != null){

            Log::info($support_doc_file);
            Log::info($support_doc_file->getClientOriginalExtension());

            $path = 'public/dokumen/saman/';

            $support_doc_file->storeAs($path, $currentId.'-'.$fileName);

            $data = [
                'ref_id' => $currentId,
                'doc_path' => 'dokumen/saman/',
                'doc_path_thumbnail' => 'thumbnails/summon/',
                'doc_type' => 'dokumen_sokongan',
                'doc_format' => $support_doc_file->getClientOriginalExtension(),
                'doc_name' => $currentId.'-'.$fileName,
                'doc_desc' => $request->pic_desc,
                'created_by' => Auth::user()->id
            ];

            Log::info($data);

            return SummonDocument::create($data);
        }
    }

    public function deleteSupportDoc(Request $request){
        $queryDocument = SummonDocument::find($request->id);
        $queryDocument->delete();
    }

    public function deletePrevFile($fullPath)
    {
        Log::info('$fullPath --> '.$fullPath);
        Storage::delete('public/'.$fullPath);
    }

}
