<?php

namespace App\Http\Controllers\Vehicle;

use App\Models\User;
use App\Mail\OperationEmailNotification;
use App\Mail\SummonPICEmailNotification;
use App\Mail\VehiclePICEmailNotification;
use App\Models\Fleet\FleetDepartment;
use App\Models\Fleet\FleetGrant;
use App\Models\Fleet\FleetLookupVehicle;
use App\Models\Fleet\FleetOwnershipHistory;
use App\Models\Fleet\FleetProject;
use App\Models\Fleet\FleetPublic;
use App\Models\FleetDisposal;
use App\Models\FleetPlacement;
use App\Models\Identifier\KenderaanStatus;
use Livewire\Component;
use Livewire\WithFileUploads;

use App\Models\Location\Negeri;
use App\Models\Location\Cawangan;
use App\Models\Location\Daerah;
use App\Models\Kenderaan\Kategori\Kategori;
use App\Models\Kenderaan\Kategori\SubKategori;
use App\Models\Vehicle\Brand;
use App\Models\Vehicle\VehicleModel;
use App\Models\Kenderaan\Pendaftaran;
use App\Models\Kenderaan\Dokumen;
use App\Models\Location\Placement;
use App\Models\RefBranch;
use App\Models\RefCategory;
use App\Models\RefDivision;
use App\Models\RefOwner;
use App\Models\RefOwnerType;
use App\Models\RefState;
use App\Models\RefSubCategory;
use App\Models\RefSubCategoryType;
use App\Models\RefVehicleStatus;
use App\Models\Saman\MaklumatKenderaanSaman;
use App\Repositories\Kenderaan\PendafaranRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use Intervention\Image\Facades\Image;
use League\CommonMark\Block\Element\Document;

class VehicleRegister extends Component
{
    use WithFileUploads;

    public $currentFleetTable = 'department';
    public $isEdit = false;
    public $is_display = false;
    public $currentId = -1;
    public $owner_type_list;
    public $states;
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
    public $vehicleStatusList;

    public $reg;
    public $maklumat;
    public $tambahan;
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

        $TaskFlowAccessVehicle = auth()->user()->vehicleWorkFlow('01', '01');

        if ($request->input('success')) {
            $this->succes = $request->input('success');
        }

        if ($request->input('currentTab')) {
            $this->tab = request('currentTab');
        }
        Log::info('$this->tab  --> ' . $this->tab);

        $this->is_display = $request->input('is_display');

        $fleet_view = request('fleet_view') ? request('fleet_view') : 'department';
        Log::info('$fleet_view '.$fleet_view);
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
            case 'grant':
                $currentDetail = FleetGrant::find($request->id);
                break;

            default:
                $currentDetail = FleetDepartment::find($request->id);
                break;
        }

        $this->currentFleetTable = $fleet_view;

        if($fleet_view !== 'disposal'){
            if (!empty($currentDetail)) {
                $this->isEdit = true;
                $this->currentId = $currentDetail->id;

                $queryPrevOwnership = FleetOwnershipHistory::where('vehicle_id', $currentDetail->id)->first();
                if($currentDetail->hasOwnerType){
                    if($queryPrevOwnership){
                        if(in_array($queryPrevOwnership->hasOwnerType->code, ['01','02'])){
                            $this->currentFleetTable = 'department';
                        }
                    } else if(in_array($currentDetail->hasOwnerType->code, ['01','02'])){
                        $this->currentFleetTable = 'department';
                    }
                }
            }
        }

        Log::info($this->currentFleetTable);

        //normal user / orang awam
        if(!empty($currentDetail) && Auth::user()->roleAccess()->code == '04'){
            if($currentDetail->vAppStatus->code != '01'){
                $this->is_display = 1;
            }
        }

        // if(auth()->user()->id != $currentDetail->user->id){
        //     $this->is_display = 1;
        // }

        // if data status selesai or status code  == '06'
        if($currentDetail && $currentDetail->vAppStatus()){

            $TaskFlowAccessVehicle = auth()->user()->vehicleWorkFlow('01', '01');
            //verify and status code 03
            if($currentDetail->vAppStatus->code == '03' && $TaskFlowAccessVehicle->mod_fleet_verify){
                $this->is_display = 1;
            }
             else if($currentDetail->vAppStatus->code == '06'){
                $this->is_display = 1;
            }
        }

        //admin
        if(Auth::user()->isAdmin() || $TaskFlowAccessVehicle->mod_fleet_can_edit_after_approve){
            $this->is_display = 0;
        }

        if($request->view_as && $request->view_as == 'full_detail' ){
            $this->is_display = 1;
        }

        session()->put('vehicle_current_detail_id', $this->currentId);

        $this->detail = $currentDetail;

        Log::info('isEdit ' . $this->isEdit);

        $this->owner_type_list = RefOwnerType::where([
            'status' => 1,
            'display_for' => 'vehicle_register'
        ])->get();
        $this->states = RefState::all();
        // $this->cawangan = Cawangan::all();
        // $this->cawangan = RefDivision::all();
        $this->cawangan = RefOwner::where('owner_type_id')->where('status', 1)->get();
        $this->placement_list = FleetPlacement::all();
        $this->daerah = Daerah::all();
        $this->categoryList = RefCategory::all();
        $this->vehicleStatusList = RefVehicleStatus::all();

        $this->kategori = Kategori::all();
        $this->subKategori = SubKategori::all();
        $this->brands = Brand::orderBy('name')->get();
        $this->models = VehicleModel::orderBy('name')->get();

        Log::info('currentFleetTable'.$this->currentFleetTable);

        $this->load();
    }

    public function repo()
    {
        return new PendafaranRepository();
    }

    public function vehicleDAO(){
        return new VehicleDAO();
    }

    public function saveDetail(Request $request)
    {

        $validator = [
            'reg_no' => 'required',
            // 'reg_jkr' => 'required',
            'reg_hak' => 'required',
            'vehicle_status_id' => 'required_if:current_fleet_table,department',
            'state_id' => 'required',
            // 'person_incharge_id' => 'required',
            // 'main_driver_id' => 'required_if:current_fleet_table,department'
        ];

        $validatorMsg = [
            'reg_no.required' => 'Sila Masukkan No Pendaftaran',
            // 'reg_jkr.required' => 'Sila Masukkan No JKR',
            'reg_hak.required' => 'Sila Pilih Hak Milik',
            'vehicle_status_id.required_if' => 'Sila Pilih Status Kenderaan',
            'state_id.required' => 'Sila Pilih Negeri',
            // 'person_incharge_id.required' => 'Sila Pilih Pegawai',
            // 'main_driver_id.required_if' => 'Sila Pilih Pemandu',
            'reg_picemail.email' => 'Sila Masukkan Email Pegawai Bertanggungjawab mengikut format : Example@gmail.com'
        ];


        if ($request->current_fleet_table == 'grant') {

            $validator = [
                'reg_no' => 'required',
                'state_id' => 'required'
            ];

            $validatorMsg = [
                'reg_no.required' => 'Sila Masukkan No Pendaftaran',
                'state_id.required' => 'Sila Pilih Negeri'
            ];

        }

        $validator = Validator::make($request->all(), $validator ,$validatorMsg);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $this->currentId = session()->get('vehicle_current_detail_id');

        if($request->always_create){
            $this->currentId = -1;
        }

        $table = FleetLookupVehicle::class;

        if($request->fleet_view == 'grant'){
            $table = FleetGrant::class;
        }

        $queryRegNumberIsExisted = $table::where('no_pendaftaran', $request->reg_no)
        ->where('id', '!=', $this->currentId)
        ->whereHas('vAppStatus', function($q){
            $q->whereNotIn('code', ['00']);
        })
        ->first();

        if($queryRegNumberIsExisted){
            $validator->getMessageBag()->add('reg_no', 'No Pendaftaran '.$request->reg_no.' Telah Wujud');
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        Log::info($request);

        // //Trigger auto save
        $data = [
            'fleet_view' => isset($request['fleet_view']) ? $request['fleet_view'] : 'department',
            'state_id' => isset($request['state_id']) ? $request['state_id'] : null,
            'cawangan_id' => $request->reg_cawangan != -1 ? $request->reg_cawangan : null,
            'vehicle_status_id' => $request['vehicle_status_id'],
            'owner_type_id' => isset($request['reg_hak']) ? $request['reg_hak'] : null,
            'placement_id' => isset($request['reg_lokasi']) && $request['reg_lokasi'] != -1 ? $request['reg_lokasi'] : null,
            'no_pendaftaran' => isset($request['reg_no']) ? strtoupper($request['reg_no']) : null,
            'no_jkr' => isset($request['reg_jkr']) ? $request['reg_jkr'] : null
        ];

        if($request->main_driver_id){
            $data['main_driver_id'] = $request->main_driver_id;
        }

        if($request->person_incharge_id){
            $data['person_incharge_id'] = $request->person_incharge_id;
        }

        if($request->reg_noid){
            $data['no_id_pemunya'] = $request->reg_noid;
        }

        if($request->district_id){
            $data['district_id'] = $request->district_id;
        }

        if(isset($request['current_fleet_table']) == 'public'){
             $data['project'] = [
                'project_name' => $request['project_name'],
                'contract_no' => $request['contract_no'],
                'hopt' => $request['hopt'],
                'contractor_name' => $request['contractor_name'],
                'project_start_dt' => $request['project_start_dt'] ? $this->convertDateToSQLDate($request['project_start_dt'], 'Y-m-d') : null,
                'project_end_dt' => $request['project_end_dt'] ? $this->convertDateToSQLDate($request['project_end_dt'], 'Y-m-d') : null,
                'project_cpc_dt' => $request['project_cpc_dt'] ? $this->convertDateToSQLDate($request['project_cpc_dt'], 'Y-m-d') : null,
                'created_by' => Auth::user()->id,
            ];
        }

        Log::info(' current id =>'.$this->currentId);

        if ($this->currentId != -1) {

            $fleet_view = $request['fleet_view'];
            if($fleet_view == 'grant'){
                $table = FleetGrant::class;
            }
            elseif($fleet_view == 'department'){
                $table = FleetDepartment::class;
            } else {
                $table = FleetPublic::class;
            }

            $prevId = $this->currentId;

            $queryCheckOwnership = $table::find($this->currentId);

            Log::info($queryCheckOwnership);

            if($queryCheckOwnership && $data['owner_type_id'] == $queryCheckOwnership->owner_type_id){
                $data['updated_by'] = Auth::user()->id;
                $data['mode'] = 'update';

                if($request['current_fleet_table'] == 'public'){
                    $findFleetProject = FleetProject::find($queryCheckOwnership['project_id']);
                    if($findFleetProject){
                        $findFleetProject->update($data['project']);
                    } else {
                        Log::info('create project 1');
                        $inserted = FleetProject::create($data['project']);
                        $data['project_id'] = $inserted->id;
                    }

                }

                $response = $this->vehicleDAO()->update($data, $this->currentId);
            } else {

                $data = $queryCheckOwnership;

                $data['owner_type_id'] = $request->reg_hak;

                unset($data['id']);
                unset($data['updated_at']);
                unset($data['pic_name']);
                unset($data['pic_email']);

                $data['mode'] = 'ownership';

                if($request['current_fleet_table'] == 'public' || $data['owner_type_id'] == 5){
                    Log::info('create project 2');

                    $data['project'] = [
                        'project_name' => $request['project_name'],
                        'contract_no' => $request['contract_no'],
                        'hopt' => $request['hopt'],
                        'contractor_name' => $request['contractor_name'],
                        'project_start_dt' => $request['project_start_dt'] ? $this->convertDateToSQLDate($request['project_start_dt'], 'Y-m-d') : null,
                        'project_end_dt' => $request['project_end_dt'] ? $this->convertDateToSQLDate($request['project_end_dt'], 'Y-m-d') : null,
                        'project_cpc_dt' => $request['project_cpc_dt'] ? $this->convertDateToSQLDate($request['project_cpc_dt'], 'Y-m-d') : null,
                        'created_by' => Auth::user()->id,
                    ];

                    $inserted = FleetProject::create($data['project']);
                    $data['project_id'] = $inserted->id;
                }

                $response = $this->vehicleDAO()->insert($data->toArray());

                Log::info('x sama. kena delete prev data');
                Log::info($response);
                $this->currentId = $response['pendaftaran_id'];

                //update vehicle images
                if($fleet_view == 'department'){
                    $queryDoc = Dokumen::where('fleet_department_id', $prevId);

                    if($data['owner_type_id'] == 3 || $data['owner_type_id'] == 4){
                        $queryDoc->update([
                            'fleet_department_id' => $this->currentId,
                            'fleet_public_id' => null,
                        ]);
                    } else {
                        $queryDoc->update([
                            'fleet_department_id' => null,
                            'fleet_public_id' => $this->currentId,
                        ]);
                    }

                } else {
                    $queryDoc = Dokumen::where('fleet_public_id', $prevId);
                    $queryDoc->update([
                        'fleet_department_id' => $this->currentId,
                        'fleet_public_id' => null
                    ]);
                }

                $queryCheckOwnership->delete();
            }

            if($fleet_view == 'grant') {
                $tab = 1;
            } else {
                $tab = 2;
            }

            return [
                'url' => route('vehicle.register.detail', ['id' => $this->currentId, 'fleet_view' => $response['fleet_view'], 'tab' => $tab]),
                'reg_no' => $request->reg_no
            ];
        } else {
            $data['created_by'] = auth()->user()->id;

            if(Auth::user()->roleAccess()->code == '04'){
                $data['user_id'] = Auth::user()->id;
            }

            if(isset($request['current_fleet_table']) == 'public'){
                $inserted = FleetProject::create($data['project']);
                $data['project_id'] = $inserted->id;
            }

            $data['mode'] = 'new';

            $response = $this->vehicleDAO()->insert($data);

            //$response = $this->repo()->pendaftaran($data);
            return [
                'url' => route('vehicle.register.detail',
                [
                    'id' => $response['pendaftaran_id'],
                    'fleet_view' => $response['fleet_view'],
                    'tab' => 2
                ]),
                'reg_no' => $request->reg_no
            ];
        }
    }

    public function saveInfo(Request $request)
    {

        $request->validate([
            'hasNewDocument' => 'in:1,0',
            'doc_voc' => 'required_if:hasNewDocument,1',
        ], [
            'doc_voc.required_if' => 'Sila muat naik voc dokumen'
        ]);

        $this->currentId = session()->get('vehicle_current_detail_id');

        Log::info($request);

        $data = [
            'fleet_view' => isset($request['fleet_view']) ? $request['fleet_view'] : 'department',
            'owner_type_id' => isset($request['reg_hak']) ? $request['reg_hak'] : '',
            'pendaftaran_id' => $this->currentId,
            'category_id' => isset($request['category_id']) && $request['category_id'] != -1 ? $request['category_id'] : null,
            'sub_category_id' => isset($request['sub_category_id']) && $request['sub_category_id'] != -1 ? $request['sub_category_id'] : null,
            'sub_category_type_id' => isset($request['sub_category_type_id']) && $request['sub_category_type_id'] != -1 ? $request['sub_category_type_id'] : null,
            'brand_id' => isset($request['pembuat']) && $request['pembuat'] != -1 ? $request['pembuat'] : null,
            'model_id' => isset($request['model']) && $request['model'] != -1 ? $request['model'] : null,
            'no_chasis' => isset($request['chasis']) ? $request['chasis'] : '',
            'no_engine' => isset($request['engine']) ? $request['engine'] : '',
            'tarikh_belian' => isset($request['tarikhbelian']) ? $request['tarikhbelian'] : null,
            'no_resit' => isset($request['noresit']) ? $request['noresit'] : '',
            'pembeli' => isset($request['penerima']) ? $request['penerima'] : '',
            'v_primary_image' => isset($request['v_primary_image']) ? $request['v_primary_image'] : null,
            'no_id_pemunya' => isset($request['no_id_pemunya']) ? $request['no_id_pemunya'] : '',
        ];

        if($request->new_brand){
            $data['brand'] = $request['new_brand'] ? $request['new_brand'] : null;
        }
        if($request->new_model){
            $data['model'] = $request['new_model'] ? $request['new_model'] : null;
        }

        if(!empty($request->doc_voc))
        {
            $resDocData = $this->uploadVOCDocument($request);

            $path = "dokumen/vehicle/voc/";
            if($request->fleet_view == 'department'){
                $prevDocument = Dokumen::where([
                    'fleet_department_id' => $this->currentId,
                    'doc_type' => 'voc_doc'
                ])->first();
            } else {
                $prevDocument = Dokumen::where([
                    'fleet_department_id' => $this->currentId,
                    'doc_type' => 'voc_doc'
                ])->first();
            }

            $vocDocData = [
                'doc_type' => 'voc_doc',
                'doc_name' => $resDocData['original_name'],
                'doc_path' => $path
            ];
            if($request->fleet_view == 'department'){
                $vocDocData['fleet_department_id'] = $resDocData['id'];
            } else {
                $vocDocData['fleet_public_id'] = $resDocData['id'];
            }

            if($prevDocument){
                $filename = $prevDocument->doc_name;
                $fullPath = $path.'/'.$filename;
                $this->deletePrevFile($fullPath);
                $prevDocument->update($vocDocData);
            } else {
                Dokumen::create($vocDocData);
            }

            Log::info('$vocDocData');
            Log::info($vocDocData);

        }

        $data['updated_by'] = Auth::user()->id;
        $response = $this->vehicleDAO()->update($data, $this->currentId);

        return [
            'url' => route('vehicle.register.detail', ['id' => $this->currentId, 'fleet_view' => $response['fleet_view'], 'tab' => 3])
        ];
    }

    public function uploadVOCDocument(Request $request)
    {
        $this->currentId = session()->get('vehicle_current_detail_id');

        $dokumen = $request->doc_voc;

        $path = "public/dokumen/vehicle/voc/";

        $data = [
            'id' => $this->currentId,
            'original_name' => $dokumen->getClientOriginalName(),
            'document_path' => $path
        ];

        //save
        $dokumen->storeAs($path, $dokumen->getClientOriginalName());

        return $data;

    }

    public function uploadKewpa23(Request $request)
    {
        $this->currentId = session()->get('vehicle_current_detail_id');

        $dokumen = $request->kewpa_23;

        $path = "public/dokumen/vehicle/kewpa_23/";

        $data = [
            'original_name' => $dokumen->getClientOriginalName(),
            'document_path' => $path
        ];

        //save
        $dokumen->storeAs($path, $dokumen->getClientOriginalName());

        return $data;

    }

    public function uploadTransferLetter(Request $request)
    {
        $this->currentId = session()->get('vehicle_current_detail_id');

        $dokumen = $request->transfer_letter;

        $path = "public/dokumen/vehicle/transfer_letter/";

        $data = [
            'original_name' => $dokumen->getClientOriginalName(),
            'document_path' => $path
        ];

        //save
        $dokumen->storeAs($path, $dokumen->getClientOriginalName());

        return $data;

    }

    public function changeOwnerShip(Request $request){

        $ischange_ownership = false;
        $ownership = $request['ownership'];
        $fleet_view = $request['fleet_view'];
        $vehicle_id = $request['vehicle_id'];

        if($fleet_view == 'department'){
            $table = FleetDepartment::class;
        } else if($fleet_view == 'public'){
            $table = FleetPublic::class;
        }

        Log::info($table);

        $queryCheckOwnership = $table::find($vehicle_id);
        $currentHakMilik = $queryCheckOwnership->owner_type_id;
        $data = $queryCheckOwnership;

        $data['owner_type_id'] = $ownership;

        Log::info('hak_milik => '.$data['hak_milik']);
        Log::info($queryCheckOwnership);

        if($queryCheckOwnership && $data['hak_milik'] == $currentHakMilik){
            $data['updated_by'] = Auth::user()->id;
            $response = $this->vehicleDAO()->update($data, $vehicle_id);
        } else {
            unset($data['id']);
            unset($data['updated_at']);
            Log::info('data--> \n');
            Log::info($data);
            $data['ischange_ownership'] = $ischange_ownership;
            $response = $this->vehicleDAO()->insert($data->toArray());
            Log::info('x sama. kena delete prev data');
            Log::info($response);

            $querySummon = MaklumatKenderaanSaman::where('pendaftaran_id', $vehicle_id);
            $querySummon->update([
                'pendaftaran_id' => $response['pendaftaran_id']
            ]);

            if($fleet_view == 'department'){
                //update vehicle images
                $queryDoc = Dokumen::where('fleet_department_id', $vehicle_id);
                $queryDoc->update([
                    'fleet_department_id' => null,
                    'fleet_public_id' => $response['pendaftaran_id'],
                ]);
            } else {

                //update vehicle images
                $queryDoc = Dokumen::where('fleet_public_id', $vehicle_id);
                $queryDoc->update([
                    'fleet_department_id' => $response['pendaftaran_id'],
                    'fleet_public_id' => null
                ]);
            }

            $queryCheckOwnership->delete();
        }

    }

    public function declareForDisasterReady(Request $request){
        $fleetView = $request->fleet_view;
        if($fleetView == 'department'){
            $queryFleetDepartment = FleetDepartment::find($request->vehicle_id);
            $queryFleetDepartment->update([
                'disaster_ready' => true
            ]);
        }
    }

    public function undeclareForDisasterReady(Request $request){
        $fleetView = $request->fleet_view;
        if($fleetView == 'department'){
            $queryFleetDepartment = FleetDepartment::find($request->vehicle_id);
            $queryFleetDepartment->update([
                'disaster_ready' => false
            ]);
        }
    }

    public function dispose(Request $request){

        $validator = Validator::make($request->all(), [
            'disposal_id' => 'required',
            'dispose_dt' => 'required',
            'remark' => 'required'
        ],
        [
            'disposal_id.required' => 'Sila pilih jenis pelupusan',
            'dispose_dt.required' => 'Sila pilih tarikh pelupusan',
            'remark.required' => 'Sila masukkan catatan',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $vehicle_id = $request['vehicle_id'];
        $disposal_id = $request['disposal_id'];
        $remark = $request['remark'];
        $dispose_dt = $request['dispose_dt'];
        $recipient = $request->recipient;

        $findPrevTable = FleetLookupVehicle::find($vehicle_id);

        if(!$findPrevTable){
            return [
                'message' => 'Maklumat Telah Dilupuskan! '
            ];
        }

        $prev_table_type =  $findPrevTable->table_type;

        if($prev_table_type == 'department'){
            $table = FleetDepartment::class;
        } else if($prev_table_type == 'public'){
            $table = FleetPublic::class;
        }

        Log::info($table);

        $currentData = $table::find($vehicle_id);
        $data = $currentData;
        unset($data['id']);
        unset($data['updated_at']);

        $data['disposal_id'] = $disposal_id;
        $data['remark'] = $remark ? $remark: null;
        if($dispose_dt){
            $data['dispose_dt'] = $this->convertDateToSQLDate($dispose_dt, 'Y-m-d');
        }
        $data['updated_by'] = Auth::user()->id;
        $data['recipient'] = $recipient;
        $data['prev_fleet_type'] = $prev_table_type;

        $data['vehicle_status_id'] = $this->vehicleStatus('04');

        $response = $this->vehicleDAO()->insertToDisposal($data->toArray());

        if(!empty($request->kewpa_23))
        {
            $VehicleRegister = new VehicleRegister();
            $data = $VehicleRegister->uploadKewpa23($request);

            $path = "dokumen/vehicle/kewpa_23/";

            $kewpaAttr = [
                'fleet_disposal_id' => $response['pendaftaran_id'],
                'doc_type' => 'kewpa_23',
                'doc_name' => $data['original_name'],
                'doc_path' => $path
            ];

            Dokumen::create($kewpaAttr);

        }

        if(!empty($request->transfer_letter))
        {
            $VehicleRegister = new VehicleRegister();
            $data = $VehicleRegister->uploadTransferLetter($request);

            $path = "dokumen/vehicle/transfer_letter/";

            $kewpaAttr = [
                'fleet_disposal_id' => $response['pendaftaran_id'],
                'doc_type' => 'transfer_letter',
                'doc_name' => $data['original_name'],
                'doc_path' => $path
            ];

            Dokumen::create($kewpaAttr);

        }

        //update vehicle images
        if($prev_table_type == 'department'){
            $queryDoc = Dokumen::where('fleet_department_id', $vehicle_id);
            $queryDoc->update([
                'fleet_department_id' => null,
                'fleet_disposal_id' => $response['pendaftaran_id'],
            ]);
        }
        else if($prev_table_type == 'public'){
            $queryDoc = Dokumen::where('fleet_public_id', $vehicle_id);
            $queryDoc->update([
                'fleet_disposal_id' => $response['pendaftaran_id'],
                'fleet_public_id' => null
            ]);
        }

        $currentData->delete();

        return [
            'message' => 'Maklumat Berjaya Dilupuskan! '
        ];

    }

    public function undispose(Request $request){

        $data = FleetDisposal::find($request->vehicle_id);
        $prev_fleet_type = $data->prev_fleet_type;

        if($prev_fleet_type == 'department'){
            $table = FleetDepartment::class;
        } else if($prev_fleet_type == 'public'){
            $table = FleetPublic::class;
        }

        unset($data['id']);
        unset($data['prev_table_type']);
        unset($data['pic_name']);
        unset($data['pic_email']);

        $table::create($data->toArray());

        $queryDoc = Dokumen::where('fleet_disposal_id', $request->vehicle_id);
        $totalDoc = $queryDoc->count();
        $totalDeleted = 0;
        foreach ($queryDoc->get() as $key) {
            $key->delete();
            $totalDeleted++;
        }
        Log::info($totalDeleted);
        Log::info($queryDoc->count());
        if($totalDeleted == $totalDoc){
            $data->delete();
        }

    }

    private function convertDateToSQLDate($dateVal, $format){
        return Carbon::createFromFormat('d/m/Y', $dateVal)->format($format);
    }

    public function saveAddon(Request $request)
    {

        $this->currentId = session()->get('vehicle_current_detail_id');
        if($this->currentId){
            $this->isEdit = true;
        }

        Log::info($request);

        $roadTaxDt = isset($request['roadTaxDt']) ? $request['roadTaxDt'] : null;
        if($roadTaxDt){
            $roadTaxDt = $this->convertDateToSQLDate($roadTaxDt, 'Y-m-d');
        }

        $acqDt = isset($request['acqDt']) ? $request['acqDt'] : null;
        if($acqDt){
            $acqDt = $this->convertDateToSQLDate($acqDt, 'Y-m-d');
        }

        $purchaseDt = isset($request['tarikhPembelian']) ? $request['tarikhPembelian'] : null;
        if($purchaseDt){
            $purchaseDt = $this->convertDateToSQLDate($purchaseDt, 'Y-m-d');
        }

        $examPhyscalDt = isset($request['pemeriksaanFizikal']) ? $request['pemeriksaanFizikal'] : null;
        if($examPhyscalDt){
            $examPhyscalDt = $this->convertDateToSQLDate($examPhyscalDt, 'Y-m-d');
        }

        $examSafeTyDt = isset($request['pemeriksaanKeselamatan']) ? $request['pemeriksaanKeselamatan'] : null;
        if($examSafeTyDt){
            $examSafeTyDt = $this->convertDateToSQLDate($examSafeTyDt, 'Y-m-d');
        }

        $mdDate = isset($request['manufactureDate']) ? $request['manufactureDate'] : null;
        if($mdDate){
            $mdDate = Carbon::createFromFormat('Y', $mdDate)->format('Y');
        }

        $data = [
            'fleet_view' => isset($request['fleet_view']) ? $request['fleet_view'] : 'department',
            'pendaftaran_id' => $this->currentId,
            'hak_milik' => isset($request['reg_hak']) ? $request['reg_hak'] : '',
            'no_loji' => isset($request['noLoji']) ? $request['noLoji'] : '',
            'tarikh_cukai_jalan'  => $roadTaxDt,
            'acqDt' => $acqDt,
            'harga_perolehan' => isset($request['hargaPerolehan']) && $request['hargaPerolehan'] !=null ? str_replace(',', '', $request['hargaPerolehan']) : 0.00,
            'tarikh_pembelian_kenderaan' => $purchaseDt,
            'no_lo' => isset($request['noLo']) ? $request['noLo'] : '',
            'tarikh_pemeriksaan_fizikal' => $examPhyscalDt,
            'tarikh_pemeriksaan_keselamatan' => $examSafeTyDt,
            'manufacture_year' => $mdDate,
            'tarikh_kemaskini' => Carbon::now()->format('Y-m-d')
        ];

        Log::info($data);

        $data['updated_by'] = Auth::user()->id;
        $response = $this->vehicleDAO()->update($data, $this->currentId);

        return [
            'url' => route('vehicle.register.detail', ['id' => $this->currentId, 'fleet_view' => $response['fleet_view'], 'tab' => 3])
        ];
    }

    public function kenderaanStatus($const)
    {
        $status = KenderaanStatus::where('code',$const)->first();

        return $status->id;
    }

    public function submitForVerification($request)
    {
        $this->currentId = session()->get('vehicle_current_detail_id');

        $table = FleetDepartment::class;

        if($request->fleet_view == 'public'){
            $table = FleetPublic::class;
        } elseif($request->fleet_view == 'grant'){
            $table = FleetGrant::class;
        }
        $query = $table::find($this->currentId);
        $result = $query->update([
            'vapp_status_id' => $this->kenderaanStatus('02')
        ]);

        if($result == 1){
            // $usersOperation = User::whereHas(
            //     'roles', function($q){
            //         $q->whereIn('name', ["03","04"]);
            //     }
            // )->get();

            $usersAdmin = User::whereHas(
                'roles', function($q){
                    $q->whereIn('name', ['01']);
                }
            )->whereHas('detail', function($q){
                $q->whereHas('refStatus', function($q){
                    $q->where('code', '06');
                });
            })->get();

            $vehicleDetailUrl = route('vehicle.register', [ 'id' => $this->currentId]);
            $emailBody = [
                'subject' => 'Maklumat Kenderaan '.Carbon::now()->format('d/m/Y'),
                'title' => 'Maklumat Kenderaan bagi Plat Nombor '.$query['plate_no'],
                'plate_no' => $query['no_pendaftaran'],
                'usersOperation' => $usersAdmin,
                'url' => Route('.redirect').'?redirectTo='.$vehicleDetailUrl
            ];

            Log::info($usersAdmin);
            Log::info($emailBody);

            Mail::to($usersAdmin)->send(new OperationEmailNotification($emailBody));
        }

        return $result;
    }

    public function submitForApproval(Request $request)
    {
        $result = 0;
        $vehicle_ids = $request->input('vehicle_ids');

        $table = FleetDepartment::class;

        if($request->fleet_view == 'public'){
            $table = FleetPublic::class;
        }
        $query = $table::whereIn('id', $vehicle_ids);
        $result = $query->update([
            'vapp_status_id' => $this->kenderaanStatus('03')
        ]);

        Log::info($result);

        return $result;
    }

    public function approve(Request $request)
    {
        $result = 0;
        $vehicle_ids = $request->input('vehicle_ids');

        $table = FleetDepartment::class;

        if($request->fleet_view == 'public'){
            $table = FleetPublic::class;
        }
        $query = $table::whereIn('id', $vehicle_ids);
        $result = $query->update([
            'vapp_status_id' => $this->kenderaanStatus('06')
        ]);

        Log::info($result);

        return $result;
    }

    public function deleteVehicle(Request $request)
    {
        $result = 0;
        $vehicle_ids = $request->input('vehicle_ids');

        $table = FleetDepartment::class;

        if($request->fleet_view == 'public'){
            $table = FleetPublic::class;
        } elseif($request->fleet_view == 'disposal'){
            $table = FleetDisposal::class;
        }

        $query = $table::whereIn('id', $vehicle_ids);
        $result = $query->update([
            'vapp_status_id' => $this->kenderaanStatus('00'),
            'updated_by' => Auth::user()->id
        ]);

        Log::info($result);

        return $result;
    }

    public function load()
    {
    }

    public function uploadVehicleImage(Request $request){

        $fleetView = isset($request['fleet_view']) ? $request['fleet_view'] : 'department';

        $validator = Validator::make($request->all(), [
            'vehicle_image' => 'required|file|max:8192',
        ],
        [
            'vehicle_image.required' => "Sila pilih gambar kenderaan untuk dimuat naik gambar",
            'vehicle_image.max' => "Maksimum saiz fail adalah dibawah 8 megabait"
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $photo = $request->vehicle_image;

        $fileName = Str::random(9).'.'.$photo->getClientOriginalExtension();
        $currentId = session()->get('vehicle_current_detail_id');

        $vehicleThumbnailPath = public_path('/thumbnails/vehicle/');

        if(!is_dir($vehicleThumbnailPath)) {

            mkdir($vehicleThumbnailPath, 0755, true);
        }

        $img = Image::make($photo->path());
        $img->resize(250, 150, function ($const) {
            $const->aspectRatio();
        })->save($vehicleThumbnailPath.'/'.$currentId.'-'.$fileName);

        if($photo != null){

            Log::info($photo);
            Log::info($photo->getClientOriginalExtension());

            $path = 'public/dokumen/vehicle/';

            $photo->storeAs($path, $currentId.'-'.$fileName);

            $data['id'] = $currentId;
            $data['fleetView'] = $fleetView;
            $data['kenderaan'] = [
                'doc_path' => 'dokumen/vehicle/',
                'doc_path_thumbnail' => 'thumbnails/vehicle/',
                'doc_type' => 'gambarKenderaan',
                'doc_name' => $currentId.'-'.$fileName,
                'doc_desc' => $request->pic_desc
            ];

            Log::info($data);

            return $this->repo()->vehicleImage($data);
        }
    }

    public function deleteVehicleImage(Request $request){
        $queryDocument = Dokumen::find($request->id);
        $queryDocument->delete();
    }

    public function deletePrevFile($fullPath)
    {
        Log::info('$fullPath --> '.$fullPath);
        Storage::delete('public/'.$fullPath);
    }

    public function vehicleStatus($code)
    {
        $query = RefVehicleStatus::where('code', $code)->first();
        return $query->id;
    }

}
