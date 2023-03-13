<?php

namespace App\Http\Controllers\Vehicle;

use App\Models\Fleet\FleetDepartment;
use App\Models\Fleet\FleetEventHistory;
use App\Models\Fleet\FleetPublic;
use App\Models\FleetDisposal;
use App\Models\FleetPlacement;
use Livewire\Component;
use Livewire\WithFileUploads;

use App\Models\Location\Negeri;
use App\Models\Location\Cawangan;
use App\Models\Location\Daerah;
use App\Models\Kenderaan\Kategori\Kategori;
use App\Models\Kenderaan\Kategori\SubKategori;
use App\Models\Vehicle\Brand;
use App\Models\Vehicle\VehicleModel;
use App\Models\Location\Placement;
use App\Models\RefCategory;
use App\Models\RefEvent;
use App\Models\RefVehicleEventHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class VehicleHistoryDAO extends Component
{
    use WithFileUploads;

    public $isEdit = false;
    public $is_display = false;
    public $currentId = -1;
    public $negeris;
    public $cawangan;
    public $placement_list;
    public $daerah;
    public $location;
    public $categoryList;
    public $subCategoryList;
    public $subCategoryTypeList;
    public $brands;
    public $models;
    public $image;
    public $doc_id = -1;

    public $reg;
    public $maklumat;
    public $tambahan;
    public $vehicle_history_list;
    public $kenderaan;
    public $documents;

    public $succes;

    public $fails;
    public $photo;

    protected $regrepo;
    public $tab = 'pendaftaran';

    public $detail;

    protected $rules = [];
    protected $message = [];
    protected $listeners = [];

    public function mount(Request $request)
    {
        if ($request->input('success')) {
            $this->succes = $request->input('success');
        }

        if ($request->input('currentTab')) {
            $this->tab = request('currentTab');
        }
        Log::info('$this->tab  --> ' . $this->tab);

        $this->is_display = $request->input('is_display');

        $fleet_view = request('fleet_view') ? request('fleet_view') : 'department';
        switch ($fleet_view) {
            case 'department':
                $currentDetail = FleetDepartment::find($request->id);
                break;
            case 'public':
                $currentDetail = FleetPublic::find($request->id);
                break;
            case 'disposal':
                $currentDetail = FleetDisposal::find($request->id);
                break;
            default:
                $currentDetail = FleetDepartment::find($request->id);
                break;
        }

        if (!empty($currentDetail)) {
            $this->isEdit = true;
            $this->currentId = $currentDetail->id;
        }

        //normal user / orang awam
        if(!empty($currentDetail) && Auth::user()->isPublic()){
            if($currentDetail->kenderaanStatus->code != '01'){
                $this->is_display = 1;
            }
        }

        // if(auth()->user()->id != $currentDetail->user->id){
        //     $this->is_display = 1;
        // }

        // if data status selesai or status code  == '06'
        if($currentDetail && $currentDetail->kenderaanStatus){
            if($currentDetail->kenderaanStatus->code == '06'){
                $this->is_display = 1;
            }
        }

        session()->put('vehicle_current_detail_id', $this->currentId);

        $this->detail = $currentDetail;

        Log::info('isEdit ' . $this->isEdit);
        Log::info('$this->currentId ' . $this->currentId);

        $this->vehicle_history_list = RefEvent::where('status', 1)->get();
        $this->negeris = Negeri::all();
        $this->cawangan = Cawangan::all();
        $this->placement_list = FleetPlacement::all();
        $this->daerah = Daerah::all();
        $this->categoryList = RefCategory::all();

        $this->kategori = Kategori::all();
        $this->subKategori = SubKategori::all();
        $this->brands = Brand::all();
        $this->models = VehicleModel::all();

    }

    private function convertDateToSQLDate($dateVal, $format){
        return Carbon::createFromFormat('d/m/Y', $dateVal)->format($format);
    }

    public function addEventHistory(Request $request){
        $validator = Validator::make($request->all(), [
            'vehicle_event_id' => 'required',
            'vehicle_event_dt' => 'required',
        ],
        [
            'vehicle_event_id.required' => 'Sila Pilih Jenis Peristiwa',
            'vehicle_event_dt.required' => 'Sila Masukkan Tarikh Peristiwa',
        ]);

        $this->currentId = session()->get('vehicle_current_detail_id');
        Log::info('$this->currentId 222 ' . $this->currentId);

        FleetEventHistory::create([
            'vehicle_id' => $this->currentId,
            'event_id' => $request->vehicle_event_id,
            'event_dt' => $this->convertDateToSQLDate($request->vehicle_event_dt, 'Y-m-d'),
            'created_by' => Auth::user()->id,
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }
    }

}
