<?php

namespace App\Http\Controllers\Maintenance\Job;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Maintenance\Warrant\WarrantDistributionDAO;
use App\Mail\module\maintenance\job\SendEmailSubmissionAppNotifyToApplicantVehicleCompleted;
use App\Models\Fleet\FleetDepartment;
use App\Models\Fleet\FleetEventHistory;
use App\Models\Maintenance\MaintenanceApplicationStatus;
use App\Models\Maintenance\MaintenanceExternalRepair;
use App\Models\Maintenance\MaintenanceInspectionType;
use App\Models\Maintenance\MaintenanceJob;
use App\Models\Maintenance\MaintenanceJobExamProcurement;
use App\Models\Maintenance\MaintenanceJobPurposeType;
use App\Models\Maintenance\MaintenanceJobSupplierCompany;
use App\Models\Maintenance\MaintenanceJobVehicle;
use App\Models\Maintenance\MaintenanceJobVehicleStatus;
use App\Models\Maintenance\MaintenanceRepairMethod;
use App\Models\Maintenance\MaintenanceVehicleStatus;
use App\Models\Maintenance\WaranType;
use App\Models\Maintenance\MaintenanceJobVehicleExaminationForm;
use App\Models\Maintenance\MaintenanceJobVehicleExaminationFormChecklist;
use App\Models\Maintenance\MaintenanceJobVehicleExaminationFormComponent;
use App\Models\Maintenance\MaintenanceJobVehicleExaminationFormComponentSub;
use App\Models\Maintenance\MaintenanceJobVehicleExaminationFormRepair;
use App\Models\Maintenance\MaintenanceJobVExamFormInspectComponent;
use App\Models\Maintenance\MaintenanceQuotation;
use App\Models\Maintenance\MonitoringInfo;
use App\Models\Maintenance\OsolType;
use App\Models\Maintenance\RefMonitoringInfo;
use App\Models\Maintenance\WarrantDetail;
use App\Models\Maintenance\WarrantDetailStatement;
use App\Models\RefCategory;
use App\Models\RefComponentLvl1;
use App\Models\RefComponentLvl2;
use App\Models\RefComponentLvl3;
use App\Models\RefEvent;
use App\Models\User;
use Carbon\Carbon;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use LDAP\Result;
use PDO;

class MaintenanceJobVehicleDAO extends Controller
{

    public function list()
    {
        $maintenance_job_id = session()->get('mjob_current_detail_id');
        $data = MaintenanceJobVehicle::where('maintenance_job_id', $maintenance_job_id);

        if(auth()->user()->isForemenMaintenance()){
            $data->whereHas('foremenBy', function($q){
                $q->where('id', Auth::user()->id);
            });
        }

        return $data->latest()->paginate(5);
    }

    public function searchByPlateNo(Request $request)
    {

        $detail = null;
        if($request->search){
            $detail = MaintenanceJobVehicle::whereRaw("upper(plate_no) = '".strtoupper($request->search)."'")->get();
        }

        return $detail;
    }

    public function upsert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'plate_no' => 'required',
            'engine_no' => 'required',
            'chasis_no' => 'required',
            'vehicle_brand_id' => 'required',
            'model_name' => 'required',
            'current_loc' => 'required',
            'fuel_type_id' => 'required',
        ],
        [
            'plate_no.required' => 'Sila masukkan no pendaftaran',
            'engine_no.required' => 'Sila masukkan no engine',
            'chasis_no.required' => 'Sila masukkan no chasis',
            'vehicle_brand_id.required' => 'Sila pilih buatan',
            'model_name.required' => 'Sila masukkan nama model',
            'current_loc.required' => 'Sila isi maklumat lokasi kenderaan',
            'fuel_type_id.required' => 'Sila pilih jenis bahan bakar',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $dataVehicle = [
            'maintenance_job_id' => session()->get('mjob_current_detail_id'),
            'maintenance_job_purpose_type' => $request->maintenance_job_purpose_type,
            'last_service_dt' => $request->last_service_dt ? $this->convertDateToSQLDateTime($request->last_service_dt, 'Y-m-d') : null,
            'complaint_damage' => $request->complaint_damage,
            'plate_no' => $request->plate_no,
            'engine_no' => $request->engine_no,
            'chasis_no' => $request->chasis_no,
            'vehicle_brand_id' => $request->vehicle_brand_id,
            'model_name' => $request->model_name,
            'current_loc' => $request->current_loc,
            'fuel_type_id' => $request->fuel_type_id
        ];

        $this->detail = MaintenanceJobVehicle::find($request->maintenance_job_vehicle_id);

        if($this->detail){
            // $dataVehicle['purchase_dt'] = $this->convertDateToSQLDateTime($request->purchase_dt, 'Y-m-d');
            // $dataVehicle['registration_vehicle_dt'] = $this->convertDateToSQLDateTime($request->registration_vehicle_dt, 'Y-m-d');
            $dataVehicle['updated_by'] =  Auth::user()->id;
            $query = $this->detail->update($dataVehicle);
            $this->message = 'Maklumat Berjaya Dikemaskini';
        } else {

            $dataVehicle['maintenance_vehicle_status_id'] = $this->hasMaintenanceVehicleStatus("01");

            $MaintenanceJobVehicleId = session()->get('maintenance_job_vehicle_id');
            $checkIsExisted = FleetDepartment::find($MaintenanceJobVehicleId);

            if($checkIsExisted){
                $vehicleEvent = RefEvent::where('code', '08')->first();
                FleetEventHistory::create([
                    'vehicle_id' => $MaintenanceJobVehicleId,
                    'event_id' => $vehicleEvent->id,
                    'event_dt' => Carbon::now()->format('Y-m-d'),
                    'created_by' => Auth::user()->id,
                ]);
                $checkIsExisted->update([
                    'is_maintenance' => true
                ]);
            }

            $dataVehicle['created_by'] =  Auth::user()->id;
            $query = MaintenanceJobVehicle::create($dataVehicle);

            $checkExistForm = MaintenanceJobVehicleExaminationForm::where([
                'vehicle_id' => $query->id
            ])->first();

            if(!$checkExistForm){
                $data = [
                    'vehicle_id' => $query->id,
                    'job_vehicle_status_id' => $this->hasMaintenanceJobVehicleStatus('01')
                ];

                MaintenanceJobVehicleExaminationForm::create($data);
            }

            $this->message = 'Maklumat Berjaya Ditambah';
        }

        $MaintenanceJob = MaintenanceJob::find(session()->get('mjob_current_detail_id'));

        $response = [
            'query' => $query,
            'code' => 200,
            'total_vehicle' => $MaintenanceJob->hasVehicle->count(),
            'message' =>  $this->message
        ];

        unset($response['query']);
        return $response;
    }

    public function getOsolType(Request $request){
        $warrantTypeId = $request->warrantTypeId;
        $query = OsolType::where('warrant_type_id', $warrantTypeId);
        return $query->get();
    }

    public function getVehicleForm(Request $request)
    {

        $vehicleId = $request->vehicleId;
        $data = MaintenanceJobVehicle::find($vehicleId);
        $array = [
            'id' => $data->id,
            'maintenance_job_id' => $data->maintenance_job_id,
            'category_id' => $data->category_id,
            'sub_category_id' => $data->sub_category_id,
            'sub_category_type_id' => $data->sub_category_type_id,
            'vehicle_brand_id' => $data->vehicle_brand_id,
            'purchase_dt' => $data->purchase_dt,
            'company_name' => $data->company_name,
            'lo_no' => $data->lo_no,
            'current_loc' => $data->current_loc,
            'is_gover' => $data->is_gover,
            'plate_no' => $data->plate_no,
            'engine_no' => $data->engine_no,
            'chasis_no' => $data->chasis_no,
            'brand_id' => $data->vehicle_brand_id,
            'fuel_type_id' => $data->fuel_type_id,
            'model_name' => $data->model_name,
            'manufacture_year' => $data->manufacture_year,
            'registration_vehicle_dt' => $data->registration_vehicle_dt,
            'maintenance_job_purpose_type' => explode (',', $data->maintenance_job_purpose_type),
            'complaint_damage' => $data->complaint_damage,
            'last_service_dt' => $data->last_service_dt
        ];
        return json_encode($array);
    }

    public function saveInspectComponent(Request $request){

        $request->validate([
            'purpose_type_id' => 'required',
            'lvl1_id' => 'required'
        ],[
            'purpose_type_id.required' => 'Sila pilih jenis penyenggaraan',
            'lvl1_id.required' => 'Sila pilih sistem',
        ]);

        $note = [];

        $query = MaintenanceJobVExamFormInspectComponent::find($request->id);
        $data = [
            'maintenance_job_purpose_type_id' => $request->purpose_type_id,
            'ref_component_lvl1_id' => $request->lvl1_id,
            'ref_component_lvl2_id' => $request->lvl2_id,
            'form_id' => $request->form_id,
            'note' => $request->note,
            'noted_by' => Auth::user()->id
        ];

        if($query){
            $query->update($data);
        } else {
            MaintenanceJobVExamFormInspectComponent::create($data);
        }
    }

    public function getInspectComponentList(Request $request){

        $form_id = $request->form_id;
        $filter = [];

        if($request->repair_method_id){
            $query = MaintenanceJobVehicleExaminationFormRepair::find($form_id);
            $filter['form_id'] = $query->hasJVEForm->id;
        } else {
            $filter['form_id'] = $form_id;
        }

        $componentList = MaintenanceJobVExamFormInspectComponent::where($filter)->orderBy('updated_at','desc');
        return [
            'detail' => $componentList->first() ? $componentList->first()->hasForm : null,
            'componentList' => $componentList->paginate(5)
        ];
    }

    public function deleteInspectComponent(Request $request){
        $query = MaintenanceJobVExamFormInspectComponent::whereIn('id',$request->ids);
        if($query){
            $query->delete();
        }
    }

    public function saveInspectQuotation(Request $request){

        Log::info(' masuk /saveInspectQuotation');
        $request->validate([
            'waran_type_id' => 'required',
            'osol_type_id' => 'required_if:waran_type_id,1',
            'quotation_no' => 'required',
            'company_name' => 'required',
            'quotation_dt' => 'required',
            'total_price' => 'required'
        ],[
            'waran_type_id.required' => 'Sila pilih waran',
            'osol_type_id.required_if' => 'Sila masukkan jenis osol',
            'quotation_no.required' => 'Sila masukkan no sebut harga',
            'company_name.required' => 'Sila masukkan nama syarikat',
            'quotation_dt.required' => 'Sila pilih tarikh sebut harga',
            'total_price.required' => 'Sila masukkan jumlah sebutharga'
        ]);

        $data = [
            'waran_type_id' => $request->waran_type_id,
            'osol_type_id' => $request->osol_type_id,
            'quotation_no' =>  $request->quotation_no,
            'company_name' => $request->company_name,
            'quotation_dt' =>  $request->quotation_dt ? $this->convertDateToSQLDateTime($request->quotation_dt, 'Y-m-d') : null,
            'sst_dt' => $request->sst_dt ? $this->convertDateToSQLDateTime($request->sst_dt, 'Y-m-d') : null,
            'end_dt' => $request->end_dt ? $this->convertDateToSQLDateTime($request->end_dt, 'Y-m-d') : null,
            'total_price' => $request->total_price ? preg_replace('/,/', '', $request->total_price) : 0.00
        ];

        $query = MaintenanceQuotation::where([
            'repair_method_id' => $request->repair_method_id,
            'job_v_exam_id' => session()->get('session_vehicle_form_id'),
        ])->first();

        $form_id = session()->get('session_vehicle_form_id');
        $hasForm = MaintenanceJobVehicleExaminationForm::find($form_id);

        if($query){
            $updateQuot = [];
            $hasRepairMethod = MaintenanceRepairMethod::find($request->repair_method_id);
            if($hasForm){   
                if($hasRepairMethod->code == '01'){
                    $updateQuot['internal_quot_id'] = $query->id;
                }
                elseif($hasRepairMethod->code == '02'){
                    $updateQuot['external_quot_id'] = $query->id;
                }
                $hasForm->update($updateQuot);
            }

            $query->update($data);
        } else {
            $data['job_v_exam_id'] = session()->get('session_vehicle_form_id');
            $data['repair_method_id'] = $request->repair_method_id;
            $query = MaintenanceQuotation::create($data);
            $quot_id = $query->id;
            $hasRepairMethod = MaintenanceRepairMethod::find($request->repair_method_id);
            $updateQuot = [];
            if($hasForm){
                if($hasRepairMethod->code == '01'){
                    $updateQuot['internal_quot_id'] = $quot_id;
                }
                elseif($hasRepairMethod->code == '02'){
                    $updateQuot['external_quot_id'] = $quot_id;
                }
                $hasForm->update($updateQuot);
            }

        }

        $formData = [
            'waran_type_id' => $request->waran_type_id ? $request->waran_type_id : null,
            'osol_type_id' => $request->osol_type_id ?$request->osol_type_id : null,
            'advance' => $request->total_price ? preg_replace('/,/', '', $request->total_price) : 0.00
        ];

        if($query->hasRepairMethod->code == '01'){
            $query->hasForm->hasFormRepairInternal()->update($formData);

        } else if($query->hasRepairMethod->code == '02') {
            $query->hasForm->hasFormRepairExternal()->update($formData);
        }

        $response = [
            'message' => 'Maklumat sebutharga berjaya disimpan'
        ];

        return $response;
    }

    public function saveFormComponent(Request $request){

        $request->validate([
            'purpose_type_id' => 'required',
            'lvl1_id' => 'required',
            'detail' => 'required'

        ],[
            'purpose_type_id.required' => 'Sila pilih jenis penyenggaraan',
            'lvl1_id.required' => 'Sila pilih sistem',
            'detail.required' => 'Sila masukkan maklumat perihal kerja'
        ]);

        $query = MaintenanceJobVehicleExaminationFormComponent::find($request->id);
        $hasJVEFormRepair = MaintenanceJobVehicleExaminationFormRepair::find($request->form_id);
        $data = [
            'maintenance_job_purpose_type_id' => $request->purpose_type_id,
            'ref_component_lvl1_id' => $request->lvl1_id,
            'ref_component_lvl2_id' => $request->lvl2_id,
            'detail' => $request->detail,
            'note' => $request->note,
            'noted_by' => Auth::user()->id,
            // 'quantity' => 1
        ];

        if($hasJVEFormRepair->hasJVEForm){
            $data['form_id'] = $hasJVEFormRepair->hasJVEForm->id;
            $data['jve_form_repair_id'] = $hasJVEFormRepair->id;
        }

        if($request->quantity){
            $data['quantity'] = $request->quantity;
        }
        if($request->per_price){
            $data['per_price'] = $request->per_price;
        }

        if(isset($data['quantity']) && isset($data['per_price'])){
            $total_price = $data['quantity'] * $data['per_price'];
            $data['total_price'] = $total_price;
        }

        if($query){
            $query->update($data);
        } else {
            $inserted = MaintenanceJobVehicleExaminationFormComponent::create($data);
            $query = MaintenanceJobVehicleExaminationFormComponent::find($inserted->id);

            $checkExistSupplierComp = MaintenanceJobExamProcurement::where([
                'mjob_exam_form_component_id' => $query->id
            ])->first();

            if(!$checkExistSupplierComp){
                $filterSupplierComp = [];

                if($hasJVEFormRepair){
                    $filterSupplierComp['jve_form_repair_id'] = $hasJVEFormRepair->id;
                } else {
                    $filterSupplierComp['form_id'] = $request->form_id;
                }

                $querySupplierComp = MaintenanceJobSupplierCompany::where($filterSupplierComp)->get();

                foreach ($querySupplierComp as $key) {
                    $data = [
                        'mjob_exam_form_component_id' => $query->id,
                        'supplier_company_id' => $key->id,
                        'created_by' => Auth::user()->id
                    ];
                    MaintenanceJobExamProcurement::create($data);
                }
            }
        }

        if($hasJVEFormRepair){
            $this->updatePriceBudgetFormRepair($hasJVEFormRepair->id);
        }

        $this->updatePriceBudget($query->hasForm->id);
        
    }

    public function saveFormComponentPrice(Request $request){
        $query = MaintenanceJobVehicleExaminationFormComponent::find($request->id);
        $query->update([
            'quantity' => $request->quantity,
            'per_price' => $request->price,
            'total_price' => $query->quantity*$request->price
        ]);

        if($query->jve_form_repair_id){
            $this->updatePriceBudgetFormRepair($query->jve_form_repair_id);
        }

        $this->updatePriceBudget($query->hasForm->id);

    }

    private function updatePriceBudget($form_id){
        $data = DB::select(DB::raw('SELECT SUM (A.total_price) AS total_budget FROM maintenance.mjob_exam_form_component A WHERE A.form_id = '.$form_id.''));
        $query = MaintenanceJobVehicleExaminationForm::find($form_id);
        $query->update([
            'price_budget' => $data[0]->total_budget
        ]);

    }

    private function updatePriceBudgetFormRepair($jve_form_repair_id){
        $data = DB::select(DB::raw('SELECT SUM (A.total_price) AS total_budget FROM maintenance.mjob_exam_form_component A WHERE A.jve_form_repair_id = '.$jve_form_repair_id.''));
        $query = MaintenanceJobVehicleExaminationFormRepair::find($jve_form_repair_id);
        $query->update([
            'price_budget' => $data[0]->total_budget
        ]);

    }

    public function getFormComponentList(Request $request){

        $filter = [];

        if($request->repair_method_id){
            $hasJVEFormRepair = MaintenanceJobVehicleExaminationFormRepair::find($request->form_id);
            $filter['jve_form_repair_id'] = $hasJVEFormRepair->id;
        } else {
            $filter['form_id'] = $request->form_id;
        }

        $componentList = MaintenanceJobVehicleExaminationFormComponent::where($filter)->orderBy('updated_at','desc');
        $firstComp = $componentList->first();
        return [
            'detail' => $firstComp ? $firstComp->hasForm : null,
            'componentList' => $componentList->paginate(5)
        ];
    }

    public function getFormProcurementComponentList(Request $request){

        $filter = [];

        if($request->repair_method_id){
            $hasJVEFormRepair = MaintenanceJobVehicleExaminationFormRepair::find($request->form_id);
            $filter = [
                'form_id' => $hasJVEFormRepair->hasJVEForm->id,
                'jve_form_repair_id' => $hasJVEFormRepair->id,
            ];
        } else {
            $filter = [
                'form_id' => $request->form_id
            ];
        }


        $componentList = MaintenanceJobVehicleExaminationFormComponent::where($filter)->orderBy('updated_at','asc');
        return [
            'componentList' => $componentList->get(),
            'detail' => $componentList->first() ? $componentList->first() : null,
            'can_edit' => $request->can_edit,
            'can_delete' => $request->can_delete,
        ];
    }

    public function formProcurementComponentSave(Request $request){
        $query = MaintenanceJobExamProcurement::find($request->id);
        $data = [
            'price' => $request->price
        ];
        if($query){
            $query->update($data);
        }
        return [
            'message' => 'Maklumat Berjaya Disimpan'
        ];
    }

    public function getFormMarketComponentList(Request $request){

        $page = $request->page ? $request->page : 1;
        $limit = $request->limit ? $request->limit : 5;

        $filterComp = [];
        $filterTotal = '';

        if($request->jve_form_repair_id){
            $filterComp['jve_form_repair_id'] = $request->jve_form_repair_id;
            $filterTotal = 'a.jve_form_repair_id = '.$request->jve_form_repair_id;
        } else {
            $filterComp['form_id'] = $request->form_id;
            $filterTotal = 'a.form_id = '.$request->form_id;
        }

        $componentList = MaintenanceJobVehicleExaminationFormComponent::where($filterComp)->orderBy('id','asc');
        $firstComp = $componentList->first();

        

        $sql = 'select a.id, COALESCE(a.total_price, 0) as comp_price 
        from maintenance.mjob_exam_form_component a 
        where '.$filterTotal.'
        ORDER BY a.id DESC
        OFFSET 0 ROWS FETCH NEXT '.($page > 1 ? (($page - 1) * $limit) : $limit).' ROWS ONLY
       ';

       $nextSql = 'select a.id, COALESCE(a.total_price, 0) as comp_price 
        from maintenance.mjob_exam_form_component a 
        where '.$filterTotal.'
        ORDER BY a.id DESC
        OFFSET '.($page > 0 ? (($page) * $limit) : $limit).'
       ';
    
       $queryhasManyComponent = DB::select($sql);
       $queryhasManyComponentNext = DB::select($nextSql);
       $currentTotal = 0;
       $nextTotal = 0;
       
       if($page > 1){
        foreach ($queryhasManyComponent as $key) {
            $currentTotal += $key->comp_price;
        }
       }

       foreach ($queryhasManyComponentNext as $key) {
            $nextTotal += $key->comp_price;
        }

        return [
            'page' => $page,
            'detail' => $firstComp ? $firstComp->hasForm : null,
            'formRepair' => $firstComp ? $firstComp->hasFormRepair: null,
            'componentList' => $componentList->paginate($limit),
            'currentTotal' => $currentTotal,
            'nextTotal' => $nextTotal,
            'can_edit' => $request->can_edit,
            'can_delete' => $request->can_delete,
        ];
    }

    public function deleteFormComponent(Request $request){
        $query = MaintenanceJobVehicleExaminationFormComponent::whereIn('id',$request->ids);
        foreach ($query->get() as $key) {
            $currentTotal = $key->hasManyResearchMarketComponent->count();
            $currentSupplierTotal = $key->hasManyExamProcurement->count();
            $totalDeleted = 0;
            $totalSupplierDeleted = 0;
            foreach ($key->hasManyResearchMarketComponent as $key2) {
                $key2->delete();
                $totalDeleted++;
            }

            foreach ($key->hasManyExamProcurement as $key3) {
                $key3->delete();
                $totalSupplierDeleted++;
            }
            if($currentTotal == $totalDeleted){
                $key->delete();
                if($key->hasFormRepair){
                    $this->updatePriceBudgetFormRepair($key->hasFormRepair->id);
                }
                $this->updatePriceBudget($key->hasForm->id);
            }

            if($currentSupplierTotal == $totalSupplierDeleted){
                $key->delete();
                if($key->hasFormRepair){
                    $this->updatePriceBudgetFormRepair($key->hasFormRepair->id);
                }
                $this->updatePriceBudget($key->hasForm->id);
            }
        }
    }

    public function saveComponentSub(Request $request){

        $lvl = 2;
        if($request->lvl3_id){
            $lvl = 3;
        }
        $data = [
            'mjob_exam_form_comp_id' => $request->form_complvl1_id,
            'lvl' => $lvl,
            'comp_lvl2_id' => $request->lvl2_id,
            'comp_lvl3_id' => $request->lvl3_id
        ];

        $inserted = MaintenanceJobVehicleExaminationFormComponentSub::create($data);

        return [
            'inserted' => [
                'id' => $inserted->id
            ],
            'message' => 'Sub komponen berjaya ditambah'
        ];
    }

    public function delComponentSub(Request $request){
        $query = MaintenanceJobVehicleExaminationFormComponentSub::whereIn('id',$request->ids);
        if($query){
            $query->delete();
        }
        return [
            'message' => 'Sub komponen berjaya dihapuskan'
        ];
    }

    // Start Research Market => Supplier
    public function saveFormSupplier(Request $request){
        $query = MaintenanceJobSupplierCompany::find($request->id);
        $data = [
            'company_name' => $request->company_name,
            'created_by' => Auth::user()->id
        ];

        if($request->repair_method_id){
            $jveFormRepair = MaintenanceJobVehicleExaminationFormRepair::find($request->form_id);
            $data['form_id'] = $jveFormRepair->hasJVEForm->id;
            $data['jve_form_repair_id'] = $jveFormRepair->id;
        } else {
            $data['form_id'] = $request->form_id;
        }

        if($query){
            $data['updated_by'] = Auth::user()->id;
            $query->update($data);
        } else {
            $inserted = MaintenanceJobSupplierCompany::create($data);
            if($request->repair_method_id){
                $this->createProcurementCompSupplier($jveFormRepair->id, $inserted->id);
            }else {
                $this->createProcurementCompSupplier($request->form_id, $inserted->id);
            }
        }
    }

    private function createProcurementCompSupplier($form_id, $supplierCompId){

        $hasJVEFormRepair = MaintenanceJobVehicleExaminationFormRepair::find($form_id);

        $componentList = MaintenanceJobVehicleExaminationFormComponent::where([
            'form_id' => $hasJVEFormRepair->hasJVEForm->id,
            'jve_form_repair_id' => $hasJVEFormRepair->id,
        ])->get();

        foreach ($componentList as $component) {
            $data = [
                'mjob_exam_form_component_id' => $component->id,
                'supplier_company_id' => $supplierCompId,
                'created_by' => Auth::user()->id
            ];

            MaintenanceJobExamProcurement::create($data);
        }
    }

    public function deleteFormSupplier(Request $request){
        $query = MaintenanceJobSupplierCompany::whereIn('id',$request->ids);
        if($query){
            $deletedForeign = 0;
            foreach ($query->get() as $self) {
                $self->hasManyProcurement()->delete();
                $deletedForeign++;
            }

            if($deletedForeign == $query->count()){
                $query->delete();
            }
        }
    }

    public function getFormSupplierList(Request $request){

        $form_id = $request->form_id;
        $jve_form_repair_id = $request->jve_form_repair_id;
        $filter = [];

        if($request->repair_method_id){
            $filter['jve_form_repair_id'] = $jve_form_repair_id;
        } else {
            $filter['form_id'] = $form_id;
        }

        $supplierList = MaintenanceJobSupplierCompany::where($filter)->orderBy('updated_at','desc');

        return [
            'form_id' => $request->form_id,
            'jve_form_repair_id' => $request->jve_form_repair_id,
            'supplierList' => $supplierList->paginate(5),
            'can_edit' => $request->can_edit,
            'can_delete' => $request->can_delete,
        ];
    }

    public function getMonitoringInfoList(Request $request){

        $form_id = $request->form_id;
        $filter = [];

        if($request->repair_method_id){
            $query = MaintenanceJobVehicleExaminationFormRepair::find($form_id);
            $filter['jve_form_repair_id'] = $query->id;
        } else {
            $filter['form_id'] = $form_id;
        }

        $monitoringInfoList = MonitoringInfo::where($filter)->orderBy('updated_at','desc');
        return [
            'form_id' => $request->form_id,
            'monitoringInfoList' => $monitoringInfoList->paginate(5)
        ];
    }

    // End Research Market => Supplier

    public function WaranType(Request $request){

        $monthDesc = [
            '0' => 'Sepanjang Tahun',
            '1' => 'Januari',
            '2' => 'Febuari',
            '3' => 'March',
            '4' => 'April',
            '5' => 'May',
            '6' => 'Jun',
            '7' => 'Julai',
            '8' => 'Ogos',
            '9' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Disember'

        ];

        $selectedYear = Carbon::now()->format('Y');

        $selectedMonth = $request->selectedMonth ? $request->selectedMonth : date('n');

        $vehicleDepreciationDAO = new WarrantDistributionDAO();
        $listYear = $vehicleDepreciationDAO->getYear();

        $osolKKR = $vehicleDepreciationDAO->getWarrantDataByWaranType(2,$selectedYear,$selectedMonth);
        $osolSumKKR = $vehicleDepreciationDAO->getWarrantSum('02',$selectedYear,$selectedMonth);

        $osolExternal = $vehicleDepreciationDAO->getWarrantDataByWaranType(3,$selectedYear,$selectedMonth);
        $osolSumExternal = $vehicleDepreciationDAO->getWarrantSum('03',$selectedYear,$selectedMonth);

        $osolSum26 = $vehicleDepreciationDAO->getWarrantSumMHPV('01',$selectedYear,$selectedMonth);
        $osolSum28 = $vehicleDepreciationDAO->getWarrantSumMHPV('02',$selectedYear,$selectedMonth);

        $unlistedKKRState = DB::select('
        select aa.id AS workshop_id, bb.code, bb.desc AS state_name from ref_workshop aa
		join ref_state bb on bb.id = aa.state_id
		where aa.code not in (
            SELECT b.code FROM "maintenance"."warrant_detail" A 
            JOIN ref_workshop b ON b.ID=A.workshop_id 
            JOIN ref_state C ON C.ID=b.state_id 
            WHERE A.waran_type_id=2 AND A.year='.$selectedYear.' AND A."month"='.$selectedMonth.' ORDER BY A.workshop_id ASC
        )');

        $unlistedAgencyState = DB::select('
        select aa.id AS workshop_id, bb.code, bb.desc AS state_name from ref_workshop aa
		join ref_state bb on bb.id = aa.state_id
		where aa.code not in (
            SELECT b.code FROM "maintenance"."warrant_detail" A 
            JOIN ref_workshop b ON b.ID=A.workshop_id 
            JOIN ref_state C ON C.ID=b.state_id 
            WHERE A.waran_type_id=3 AND A.year='.$selectedYear.' AND A."month"='.$selectedMonth.' ORDER BY A.workshop_id ASC
        )');

        return view('maintenance.job.examination.tab.preview.waran-type',[
            'is_preview' => $request->is_preview ? $request->is_preview : 1,
            'listYear' => $listYear,
            'selectedYear' => $selectedYear,
            'selectedMonth' => $selectedMonth,
            'monthDesc' => $monthDesc,
            'waran_type_code' => $request->waran_type_code,
            'osolKKR' => $osolKKR,
            'osolSumKKR' => $osolSumKKR,
            'osolExternal' => $osolExternal,
            'osolSumExternal' => $osolSumExternal,
            'osolSum26' => $osolSum26,
            'osolSum28' => $osolSum28,
            'unlistedKKRState' => $unlistedKKRState,
            'unlistedAgencyState' => $unlistedAgencyState,
            'osol_type_code' => null
        ]);
    }

    public function OsolType(Request $request){

        $monthDesc = [
            '0' => 'Sepanjang Tahun',
            '1' => 'Januari',
            '2' => 'Febuari',
            '3' => 'March',
            '4' => 'April',
            '5' => 'May',
            '6' => 'Jun',
            '7' => 'Julai',
            '8' => 'Ogos',
            '9' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Disember'

        ];

        $selectedYear = Carbon::now()->format('Y');

        $selectedMonth = $request->selectedMonth ? $request->selectedMonth : date('n');

        $vehicleDepreciationDAO = new WarrantDistributionDAO();

        $vehicleDepreciationDAO->generateFirstData($selectedYear);
        $osol26 = $vehicleDepreciationDAO->getWarrantDataByOsolType(1,$selectedYear,$selectedMonth);
        $osol28 = $vehicleDepreciationDAO->getWarrantDataByOsolType(2,$selectedYear,$selectedMonth);
        $osolSum26 = $vehicleDepreciationDAO->getWarrantSumMHPV('01',$selectedYear,$selectedMonth);
        $osolSum28 = $vehicleDepreciationDAO->getWarrantSumMHPV('02',$selectedYear,$selectedMonth);

        $listYear = $vehicleDepreciationDAO->getYear();

        return view('maintenance.job.examination.tab.preview.osol-type',[
            'is_preview' => $request->is_preview ? $request->is_preview : 1,
            'listYear' => $listYear,
            'selectedYear' => $selectedYear,
            'selectedMonth' => $selectedMonth,
            'monthDesc' => $monthDesc,
            'osol26' => $osol26,
            'osolSum26' => $osolSum26,
            'osol28' => $osol28,
            'osolSum28' => $osolSum28,
            'osol_type_code' => $request->osol_type_code
        ]);
    }

    private function createMonitoringFile($file, $prevFilename){
        $docFormat = $file->getClientOriginalExtension();
        $fileName = Str::random(9).'.'.$docFormat;

        if($file != null){

            $mjobvMonitorThumbnailPath = public_path('/thumbnails/maintenance/job/vehicle/');

            if(!is_dir($mjobvMonitorThumbnailPath)) {

                mkdir($mjobvMonitorThumbnailPath, 0755, true);
            }

            $img = Image::make($file->path());
            $img->resize(250, 150, function ($const) {
                $const->aspectRatio();
            })->save($mjobvMonitorThumbnailPath.'/'.$fileName);

            $path = 'public/dokumen/maintenance/job/vehicle/monitoring/';

            $file->storeAs($path, $fileName);

            $data = [
                'doc_path_thumbnail' => 'thumbnails/maintenance/job/vehicle/',
                'doc_path' => 'dokumen/maintenance/job/vehicle/monitoring/',
                'doc_type' => 'monitoring_file',
                'doc_format' => $docFormat,
                'doc_name' => $fileName
            ];

            $prevPath = $mjobvMonitorThumbnailPath.'/'.$prevFilename;
            if($prevFilename && file_exists($prevPath)){
                unlink($prevPath);
            }

            $prevStoragePath = public_path().'/storage/dokumen/maintenance/job/vehicle/monitoring/'.$prevFilename;
            if($prevFilename && file_exists($prevStoragePath)){
                unlink($prevStoragePath);
            }
            flush();

            return $data;
        }
    }

    public function saveMonitoringInfo(Request $request){
        //1024 =  1mb

        $validator = Validator::make($request->all(), [
            'monitoring_file' => 'max:1024'
        ],
        [
            'monitoring_file.max' => 'Sila pilih fail kurang daripada satu megabait'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $query = MonitoringInfo::find($request->id);

        $data = [
            'ref_info_id' => $request->ref_info_id,
            'monitoring_dt' => $request->monitoring_dt ? $this->convertDateToSQLDateTime($request->monitoring_dt, 'Y-m-d') : null,
            'note' => $request->note,
            'created_by' => Auth::user()->id
        ];

        if($request->repair_method_id){
            $jveFormRepair = MaintenanceJobVehicleExaminationFormRepair::find($request->form_id);
            $data['form_id'] = $jveFormRepair->hasJVEForm->id;
            $data['jve_form_repair_id'] = $jveFormRepair->id;
        } else {
            $data['form_id'] = $request->form_id;
        }

        if($query){
            $data['updated_by'] = Auth::user()->id;
            $query->update($data);
            $message = 'Maklumat berjaya dikemaskini';
        } else {
            $query = MonitoringInfo::create($data);

            $message = 'Maklumat berjaya ditambah';
        }

        if($request->has_new_file == 1){
            $prevFilename = $query->doc_name;
            $res = $this->createMonitoringFile($request->monitoring_file, $prevFilename);
            $query->update($res);
        }

        return [
            'message' => $message
        ];
    }

    public function deleteMonitoringInfo(Request $request){
        $query = MonitoringInfo::whereIn('id',$request->ids);
        if($query){
            $query->delete();
        }
    }

    public function foremenList(){
        $query = User::whereHas('roles', function($q){
            $q->where('name', '08');
        })->whereHas('detail', function($q){
            $queryMaintenanceJobDetail = MaintenanceJob::find(session()->get('mjob_current_detail_id'));
            $q->where('workshop_id', $queryMaintenanceJobDetail->hasWorkShop->id)
            ->whereHas('refStatus', function($q2){
                $q2->where('code', '06');
            });
        });
        return $query->get();
    }

    public function assignToFormen(Request $request){
        $query = MaintenanceJobVehicle::find($request->vehicle_id);
        $query->update([
            'foremen_by' => $request->user_id
        ]);
    }

    public function getComponentLvl1(Request $request){
        $query = RefComponentLvl1::where([
            'job_purpose_type_id' => $request->pr_type_id
        ]);

        return $query->get();
    }

    public function getComponentLvl2(Request $request){
        $query = RefComponentLvl2::where([
            'id_component_lvl1' => $request->compId
        ]);

        return $query->get();
    }

    public function getComponentLvl3(Request $request){
        $query = RefComponentLvl3::where([
            'id_component_lvl2' => $request->compId
        ]);

        return $query->get();
    }

    public function getForm(Request $request){

        if($request->repair_method_id){
            $detail = MaintenanceJobVehicleExaminationFormRepair::where([
                'vehicle_id' => $request->vehicle_id,
                'repair_method_id' => $request->repair_method_id,
            ])->first();
            session()->put('session_vehicle_form_repair_id', $detail->id);
            
            // if($detail->hasRepairMethod->code == '02'){
            //     $detail->update([
            //         'job_vehicle_status_id' => $detail->hasJVEForm->job_vehicle_status_id
            //     ]);
            // }
        } else {
            $detail = MaintenanceJobVehicleExaminationForm::where([
                'vehicle_id' => $request->vehicle_id
            ])->first();
            session()->put('session_vehicle_form_id', $detail->id);
        }

        $purpose_type_list = MaintenanceJobPurposeType::all();
        $component_lvl1_list = RefComponentLvl1::all();
        $external_repair_list = MaintenanceExternalRepair::all();
        $repair_method_list = MaintenanceRepairMethod::all();
        $waran_type_list = WaranType::all();
        $osol_type_list = OsolType::all();
        $monitoring_info_list = RefMonitoringInfo::all();
        $category_list = RefCategory::all();
        $inspect_type_list = MaintenanceInspectionType::all();
        return [
            'repair_method_id' => $request->repair_method_id,
            'detail' => $detail,
            'category_list' => $category_list,
            'purpose_type_list' => $purpose_type_list,
            'component_lvl1_list' => $component_lvl1_list,
            'external_repair_list' => $external_repair_list,
            'repair_method_list' => $repair_method_list,
            'waran_type_list' => $waran_type_list,
            'osol_type_list' => $osol_type_list,
            'monitoring_info_list' => $monitoring_info_list,
            'inspect_type_list' => $inspect_type_list
        ];
    }

    private function generateMaintenanceCheckList($formId){

        $hasJveRepair = MaintenanceJobVehicleExaminationFormRepair::find($formId);

        if($hasJveRepair){
            $checkFormChecklist = MaintenanceJobVehicleExaminationFormChecklist::where([
                'form_id' => $hasJveRepair->hasJVEForm->id,
                'jve_form_repair_id' => $hasJveRepair->id,
            ])->first();
        } else {
            $checkFormChecklist = MaintenanceJobVehicleExaminationFormChecklist::where([
                'form_id' => $formId
            ])->first();
        }

        if(!$checkFormChecklist){
            $compLvl1 = RefComponentLvl1::whereHas('hasJobPurposeType', function($q) {
                $q->where('code', '02');
            })->get();

            foreach ($compLvl1 as $lvl1) {

                $checkListLvl1Data = [
                    'component_lvl1_id' => $lvl1->id,
                    'lvl' => 1,
                    'created_by' => Auth::user()->id
                ];

                if($hasJveRepair){
                    $checkListLvl1Data['form_id'] = $hasJveRepair->hasJVEForm->id;
                    $checkListLvl1Data['jve_form_repair_id'] = $hasJveRepair->id;
                } else {
                    $checkListLvl1Data['form_id'] = $formId;
                }

                MaintenanceJobVehicleExaminationFormChecklist::create($checkListLvl1Data);

                foreach ($lvl1->hasManyLvl2 as $lvl2) {
                    $checkListLvl2Data = [
                        'component_lvl1_id' => $lvl2->hasCompLvl1->id,
                        'component_lvl2_id' => $lvl2->id,
                        'lvl' => 2,
                        'created_by' => Auth::user()->id
                    ];

                    if($hasJveRepair){
                        $checkListLvl2Data['form_id'] = $hasJveRepair->hasJVEForm->id;
                        $checkListLvl2Data['jve_form_repair_id'] = $hasJveRepair->id;
                    } else {
                        $checkListLvl2Data['form_id'] = $formId;
                    }

                    MaintenanceJobVehicleExaminationFormChecklist::create($checkListLvl2Data);

                    foreach ($lvl2->hasManyLvl3 as $lvl3) {
                        $checkListLvl3Data = [
                            'component_lvl1_id' => $lvl3->hasCompLvl2->hasCompLvl1->id,
                            'component_lvl2_id' => $lvl3->hasCompLvl2->id,
                            'component_lvl3_id' => $lvl3->id,
                            'form_id' => $hasJveRepair->hasJVEForm->id,
                            'jve_form_repair_id' => $hasJveRepair->id,
                            'lvl' => 3,
                            'created_by' => Auth::user()->id
                        ];

                        if($hasJveRepair){
                            $checkListLvl3Data['form_id'] = $hasJveRepair->hasJVEForm->id;
                            $checkListLvl3Data['jve_form_repair_id'] = $hasJveRepair->id;
                        } else {
                            $checkListLvl3Data['form_id'] = $formId;
                        }

                        MaintenanceJobVehicleExaminationFormChecklist::create($checkListLvl3Data);
                    }
                }
            }
        }
    }

    public function saveForm(Request $request){
        $query = MaintenanceJobVehicleExaminationForm::find(session()->get('session_vehicle_form_id'));

        if($request->repair_method_id){
           
            $query = MaintenanceJobVehicleExaminationFormRepair::find(session()->get('session_vehicle_form_repair_id'));
        }

        $listcomponent = MaintenanceJobVehicleExaminationFormComponent::where(
            [
                // 'form_id' => session()->get('session_vehicle_form_id'),
                'jve_form_repair_id' => session()->get('session_vehicle_form_repair_id'),
            ]
            )->get();
        
        foreach($listcomponent as $component){
            $component->update([
                'note' => $request['note_'.$component->id]
            ]);
        }

        $data = [
            'external_repair_id' => $request->external_repair_id ? : $query->external_repair_id,
            'is_research_market' => $request->is_research_market ? $request->is_research_market: $query->is_research_market,
            'is_research_market_external' => $request->is_research_market_external ? $request->is_research_market_external: $query->is_research_market_external,
            'inspect_type' => $request->inspect_type ? : $query->inspect_type,
        ];

        if($request->other_damages){
            $data['other_damages'] = $request->other_damages;
        }

        if($request->waran_type_id){
            $data['waran_type_id'] = $request->waran_type_id;
        }

        if($request->osol_type_id){
            $data['osol_type_id'] = $request->osol_type_id;
        }

        if($request->other_external_note){
            $data['other_external_note'] = $request->other_external_note;
        } else if($query->other_external_note){
            $data['other_external_note'] = $query->other_external_note;
        }

        if($request->is_research_market != 2){
            $data['internal_quot_id'] = null;
        }
        elseif($request->is_research_market_external != 2){
            $data['external_quot_id'] = null;
        }

        switch ($request->save_as) {

            case 'inspect_verification':

                $data['job_vehicle_status_id'] = $this->hasMaintenanceJobVehicleStatus('03');
                $data['inspected_by'] = Auth::user()->id;
                $data['inspected_dt'] = Carbon::now();

                break;

            case 'inspect_research_market':
                $data['inspected_done_by'] = Auth::user()->id;
                $data['inspected_done_dt'] = Carbon::now();
                $data['job_vehicle_status_id'] = $this->hasMaintenanceJobVehicleStatus('05');
                if($query->hasFormRepairIsMarketResearch){
                    $query->hasFormRepairIsMarketResearch()->update([
                        'is_start' => true
                    ]);
                }
                break;

            case 'research_market_approval':
                $data['rsm_prepared_by'] = Auth::user()->id;
                $data['rsm_prepared_dt'] = Carbon::now();
                $data['job_vehicle_status_id'] = $this->hasMaintenanceJobVehicleStatus('06');
                break;

            case 'inspect_not_research_market':
                $data['inspected_done_by'] = Auth::user()->id;
                $data['inspected_done_dt'] = Carbon::now();
                // if($query->hasRepairMethod()->count()>0){
                //     Log::info('procurement_approve ');
                //     foreach ($query->hasRepairMethod()->get() as $method) {
                //         if($method->code == '01'){
                //             $data['internal_repair_status_id'] = 1;
                //         }
                //         if($method->code == '02'){
                //             $data['ext_repair_status_id'] = 4;
                //         }
                //     }
                // }

                if($query->hasJVEForm){
                    if($query->hasRepairMethod->code == '01'){
                        $data['internal_repair_status_id'] = 1;
                    }
                    else if($query->hasRepairMethod->code == '02'){
                        $data['ext_repair_status_id'] = 4;
                    }
                } else {
                    foreach ($query->hasRepairMethod()->get() as $method) {
                        if($method->code == '01'){
                            $data['internal_repair_status_id'] = 1;
                        }
                        if($method->code == '02'){
                            $data['ext_repair_status_id'] = 4;
                        }
                    }
                }
                    $data['job_vehicle_status_id'] = $this->hasMaintenanceJobVehicleStatus('11'); 
                                   
                break;
            case 'research_market_approve':
                $data['rsm_verified_by'] = Auth::user()->id;
                $data['rsm_verified_dt'] = Carbon::now();
                $data['job_vehicle_status_id'] = $this->hasMaintenanceJobVehicleStatus('08');

                $WarrantDistributionDAO = new WarrantDistributionDAO();
                $currentYear = date('Y');
                $WarrantDistributionDAO->generateFirstData($currentYear);

                break;

            case 'procurement_verification':
                $data['pro_prepared_by'] = Auth::user()->id;
                $data['pro_prepared_dt'] = Carbon::now();
                $data['job_vehicle_status_id'] = $this->hasMaintenanceJobVehicleStatus('09');

                break;

            case 'procurement_approval':
                $data['pro_verified_by'] = Auth::user()->id;
                $data['pro_verified_dt'] = Carbon::now();
                $data['job_vehicle_status_id'] = $this->hasMaintenanceJobVehicleStatus('10');
                break;

            case 'procurement_approve':

                if($query->hasJVEForm){
                    if($query->hasRepairMethod->code == '01'){
                        $data['internal_repair_status_id'] = 1;
                    }
                    else if($query->hasRepairMethod->code == '02'){
                        $data['ext_repair_status_id'] = 4;
                    }
                } else {
                    foreach ($query->hasRepairMethod()->get() as $method) {
                        if($method->code == '01'){
                            $data['internal_repair_status_id'] = 1;
                        }
                        if($method->code == '02'){
                            $data['ext_repair_status_id'] = 4;
                        }
                    }
                }

                $form_id = $query->id;
                $data['job_vehicle_status_id'] = $this->hasMaintenanceJobVehicleStatus('11');
                $data['pro_approved_by'] = Auth::user()->id;
                $data['pro_approved_dt'] = Carbon::now();
                $data['advance'] = $query->pro_budget_price;

                break;

            case 'maintenance_verification':
                $data['internal_repair_status_id'] = 2;
                $data['tested_by'] = Auth::user()->id;
                $data['tested_dt'] = Carbon::now();
                break;

            case 'maintenance_done':

                $data['internal_repair_status_id'] = 3;
                $data['tested_done_by'] = Auth::user()->id;
                $data['tested_done_dt'] = Carbon::now();
                $query->update($data);

                if($query->hasJVEForm){
                    
                    if($query->hasJVEForm->hasFormRepairInternal){
                        $query->hasJVEForm->hasFormRepairInternal()->update([
                            'job_vehicle_status_id' => $this->hasMaintenanceJobVehicleStatus('12')
                        ]);
                    }
                    else if($query->hasJVEForm->hasFormRepairExternal){
                        if($query->hasJVEForm->hasFormRepairExternal->first()->is_research_market == 0){

                            $query->hasJVEForm->hasFormRepairExternal()->update([
                                'job_vehicle_status_id' => $this->hasMaintenanceJobVehicleStatus('11')
                            ]);

                            $query->hasJVEForm->update([
                                'ext_repair_status_id' => 4
                            ]);
                        }
                        else if($query->hasJVEForm->hasFormRepairExternal->first()->is_research_market == 1){
                            $query->hasJVEForm->hasFormRepairExternal()->update([
                                'job_vehicle_status_id' => $this->hasMaintenanceJobVehicleStatus('05')
                            ]);
                        }
                        elseif($query->hasJVEForm->hasFormRepairExternal->first()->is_research_market == 2){
                            $query->hasJVEForm->update([
                                'ext_repair_status_id' => 4
                            ]);

                            $query->hasJVEForm->hasFormRepairExternal()->update([
                                'job_vehicle_status_id' => $this->hasMaintenanceJobVehicleStatus('11')
                            ]);
                        }
                     }
                }else {
                    if($query->hasExternalRepairStatus && $query->hasExternalRepairStatus->code == '04'){
                        $query->update([
                            'job_vehicle_status_id' => $this->hasMaintenanceJobVehicleStatus('11')
                        ]);
                    } else {
                        $query->update([
                            'job_vehicle_status_id' => $this->hasMaintenanceJobVehicleStatus('12')
                        ]);
                    }
                }
                break;

            case 'monitoring_verification':
                $data['ext_repair_status_id'] = 5;
                if($query->hasFormRepairExternal){
                    $query->hasFormRepairExternal()->update([
                        'ext_repair_status_id' => 5,
                        'job_vehicle_status_id' => $this->hasMaintenanceJobVehicleStatus('11')
                    ]);
                } else{
                    $query->update($data);
                }
                
                break;

            case 'monitoring_done':
                $data['ext_repair_status_id'] = 6;
                $data['job_vehicle_status_id'] = $this->hasMaintenanceJobVehicleStatus('12');
                $data['tested_done_by'] = Auth::user()->id;
                $data['tested_done_dt'] = Carbon::now();

                if($query->hasJVEForm && $query->hasJVEForm->hasFormRepairExternal){
                    $query->hasJVEForm->hasFormRepairExternal()->update([
                        'ext_repair_status_id' => 6,
                        'job_vehicle_status_id' => $this->hasMaintenanceJobVehicleStatus('12')
                    ]);
                } 
                else {
                    $query->update([
                        'ext_repair_status_id' => 6,
                        'job_vehicle_status_id' => $this->hasMaintenanceJobVehicleStatus('12')
                    ]);
                }
                $query->update($data);
                $query->hasJVEForm->update($data);

                break;
            
                case 'testing_verification':
                
                $data['testing_info'] = $request->testing_info;                    
                $data['job_vehicle_status_id'] = $this->hasMaintenanceJobVehicleStatus('11');                        

                if($query->hasJVEForm){ //form                               
                    if($query->hasJVEForm->hasInternalRepairStatus){  
                        if($query->hasJVEForm->hasInternalRepairStatus->code == '03'){
                        }else{
                            $data['internal_repair_status_id'] = 2;
                        }
                    }

                    if($query->hasJVEForm->hasInternalRepairStatus && $query->hasJVEForm->hasInternalRepairStatus->code == '03' && $query->hasJVEForm->hasExternalRepairStatus){
                        $data['ext_repair_status_id'] = 5;
                    } 
                    
                    if(!$query->hasJVEForm->hasInternalRepairStatus && $query->hasJVEForm->hasExternalRepairStatus){
                        $data['ext_repair_status_id'] = 5;
                    }

                    // $query->hasJVEForm->update($data);
                    // $query->update($data);
                }
    
                break;
    
                case 'testing_done':
                    $data['testing_info'] = $request->testing_info;  
                    if($query->hasJVEForm){ //form
                                   
                        if($query->hasJVEForm->hasInternalRepairStatus){  
                            if($query->hasJVEForm->hasInternalRepairStatus->code == '03'){
                            }else{
                                $data['internal_repair_status_id'] = 3;
                                // $data['job_vehicle_status_id'] = $this->hasMaintenanceJobVehicleStatus('12');
                                $query->update([
                                    'job_vehicle_status_id' => $this->hasMaintenanceJobVehicleStatus('12')
                                ]);
                            }
                        }

                        if($query->hasJVEForm->hasInternalRepairStatus && $query->hasJVEForm->hasInternalRepairStatus->code == '03' && $query->hasJVEForm->hasExternalRepairStatus){
                            $data['ext_repair_status_id'] = 6;
                            $data['job_vehicle_status_id'] = $this->hasMaintenanceJobVehicleStatus('12');
                        } 
                        
                        if(!$query->hasJVEForm->hasInternalRepairStatus && $query->hasJVEForm->hasExternalRepairStatus){
                            $data['ext_repair_status_id'] = 6;
                            $data['job_vehicle_status_id'] = $this->hasMaintenanceJobVehicleStatus('12');
                        }
    
                        $query->hasJVEForm->update($data);
                        $query->update($data);
                    } 

                    break;

                default:
                # code...
                break;
        }

        switch ($request->section) {

            case 'inspect': 
                $repair_method = $request->repair_method ? $request->repair_method : $query->repair_method;
                
                $data['repair_method'] = $repair_method;
                if($repair_method && $request->save_as !== 'draf'){
                    foreach (explode(',', $repair_method) as $index => $id) {
                        $tbl = new MaintenanceJobVehicleExaminationFormRepair;
                        $hasItem = $tbl::where([
                            'vehicle_id' => $query->vehicle_id,
                            'jve_form_id' => $query->id,
                            'repair_method_id' => $id,
                        ])->first();
                        if(!$hasItem){
                            $is_research_market = null;
                            $internal_repair_status_id = null;
                            $ext_repair_status_id = null;

                            $dataFormRepair = [
                                'vehicle_id' => $query->vehicle_id,
                                'jve_form_id' => $query->hasJVEForm ? $query->hasJVEForm->id : $query->id,
                                'repair_method_id' => $id,
                                'inspected_by' => $query->inspected_by,
                                'inspected_dt' => $query->inspected_dt,
                                'rsm_prepared_by' => Auth::user()->id,
                                'rsm_prepared_dt' => Carbon::now(),
                                'is_research_market' => 0,
                                'external_repair_id' => $data['external_repair_id'],
                            ];

                            $repairMethod = MaintenanceRepairMethod::find($id);

                            if($repairMethod->code == '01'){
                               
                                $dataFormRepair['internal_repair_status_id'] = 1;
                                if($request->is_research_market == 1){
                                    $dataFormRepair['is_research_market'] = $request->is_research_market;
                                    $dataFormRepair['job_vehicle_status_id'] = $this->hasMaintenanceJobVehicleStatus('05');
                                } 
                                elseif($request->is_research_market == 2){
                                    $dataFormRepair['is_research_market'] = $request->is_research_market;
                                    $dataFormRepair['job_vehicle_status_id'] = $this->hasMaintenanceJobVehicleStatus('11');
                                }
                                else {
                                    $dataFormRepair['job_vehicle_status_id'] = $this->hasMaintenanceJobVehicleStatus('11');
                                }

                                $inserted = $tbl::create($dataFormRepair);

                                $this->generateMaintenanceCheckList($inserted->id);

                            } elseif($repairMethod->code == '02'){

                                $dataFormRepair['ext_repair_status_id'] = 4;
                                
                                if($request->is_research_market_external == 1){
                                    $dataFormRepair['is_research_market'] = $request->is_research_market_external;
                                    $dataFormRepair['job_vehicle_status_id'] = $this->hasMaintenanceJobVehicleStatus('05'); 

                                    $query->update([
                                        'job_vehicle_status_id' => $this->hasMaintenanceJobVehicleStatus('05')
                                    ]);

                                }
                                elseif($request->is_research_market_external == 2){
                                    $dataFormRepair['is_research_market'] = $request->is_research_market_external;
                                    $dataFormRepair['job_vehicle_status_id'] = $this->hasMaintenanceJobVehicleStatus('11');
                               

                                } else {
                                    $dataFormRepair['job_vehicle_status_id'] = $this->hasMaintenanceJobVehicleStatus('11');
                                }
                                

                                $inserted = $tbl::create($dataFormRepair);

                                $this->generateMaintenanceCheckList($inserted->id);
                            }
                        }
                    }
                }
            break;

            case 'procurement':

                $request->validate([
                    'pro_budget_price_supl_id' => 'required',
                ],[
                    'pro_budget_price_supl_id.required' => 'Sila pilih syor pembekal',
                ]);

                $data['pro_budget_price_supl_id'] = $request->pro_budget_price_supl_id ? $request->pro_budget_price_supl_id: $query->pro_budget_price_supl_id;
                $data['pro_budget_price'] = $request->pro_budget_price ? $request->pro_budget_price : $query->pro_budget_price;
                $data['pro_budget_price_note'] = $request->pro_budget_price_note ? $request->pro_budget_price_note : $query->pro_budget_price_note;
            break;

            case 'maintenance':
                $data['tested_detail'] = $request->tested_detail;
                $data['tester_note'] =  $request->tester_note;
                $data['next_service_dt'] = $request->next_service_dt ? $this->convertDateToSQLDateTime($request->next_service_dt, 'Y-m-d') : null;
                $data['next_service_odometer'] = $request->next_service_odometer;
                
                    if($request->repair_method_id){
                        $checkFormChecklist = MaintenanceJobVehicleExaminationFormChecklist::where('jve_form_repair_id', $query->id)->get();
                    } else {
                        $checkFormChecklist = MaintenanceJobVehicleExaminationFormChecklist::where('form_id', $query->id)->get();
                    }
                    if($checkFormChecklist->count()>0){

                        foreach ($checkFormChecklist as $CheckList){

                            $dataCheckList = [
                                'is_pass' => $request['is_pass_id_'.$CheckList->id] ? true: false,
                                'noted' => $request['note_id_'.$CheckList->id],
                                'noted_by' => Auth::user()->id
                            ];

                            $CheckList->update($dataCheckList);
                        }
                    }
            break;

            default:
                # code...
                break;
        }

        if($query){

            $isdone_internal = false;
            $isdone_external = false;

            if($query->hasJVEForm && $query->hasJVEForm->hasInternalRepairStatus && in_array($query->hasJVEForm->hasInternalRepairStatus->code, array('03'))){
                $isdone_internal = true;
            } else if($query && $query->hasInternalRepairStatus && in_array($query->hasInternalRepairStatus->code, array('03'))){
                $isdone_internal = true;
            } else if(!$query->hasJVEForm && !$query->hasInternalRepairStatus){
                $isdone_internal = true;
            }

            if($query->hasJVEForm && $query->hasJVEForm->hasExternalRepairStatus && in_array($query->hasJVEForm->hasExternalRepairStatus->code, array('06'))){
                $isdone_external = true;
            } else if($query && $query->hasExternalRepairStatus && in_array($query->hasExternalRepairStatus->code, array('06'))){
                $isdone_external = true;
            } else if(!$query->hasJVEForm && !$query->hasExternalRepairStatus){
                $isdone_external = true;
            }

            if($isdone_internal && $isdone_external && (in_array($request->section, ['maintenance','monitoring', 'testing', 'external-testing']))){
                $applicant_name = $query->hasVehicle->hasMaintenanceDetail->applicant_name;
                $vehicle = $query->hasVehicle;
                $email = $query->hasVehicle->hasMaintenanceDetail->email;
                $data['job_vehicle_status_id'] = $this->hasMaintenanceJobVehicleStatus('12');
                $data['v_completed_dt'] = Carbon::now();
                $query->update($data);
                if($query->hasJVEForm){

                    unset($data['repair_method']);
                    unset($data['is_research_market_external']);
                    
                    if($query->hasRepairMethod->code == '01'){
                        $query->hasJVEForm->hasFormRepairInternal()->update($data);
                    }

                    if($query->hasRepairMethod->code == '02'){
                        $query->hasJVEForm->hasFormRepairExternal()->update($data);
                    }

                    if($query->hasVehicle->hasMaintenanceDetail->hasInProgressVehicle->count() == 0){
                        $query->hasVehicle->hasMaintenanceDetail->update([
                            'app_status_id' => $this->hasMaintenanceAppStatus('08')
                        ]);
                    }

                } else {
                    if($query->hasVehicle->hasMaintenanceDetail->hasInProgressVehicle->count() == 0){
                        $query->hasVehicle->hasMaintenanceDetail->update([
                            'app_status_id' => $this->hasMaintenanceAppStatus('08')
                        ]);
                    }
                }

                $query->hasVehicle->update([
                    'maintenance_vehicle_status_id' => $this->hasMaintenanceVehicleStatus('08')
                ]);

                $this->sendEmailNotificationApplicantWhenDone($applicant_name, $vehicle, $email);
            } else {
                
                if($query->hasJVEForm){
                    $query->hasJVEForm()->update($data);
                    unset($data['repair_method']);
                    unset($data['is_research_market_external']);
                }

                Log::info('saveForm => ',$data);

                $query->update($data);

                if($query->hasJVEForm && $query->hasJVEForm->hasInternalRepairStatus && !$isdone_internal){

                    $query->hasJVEForm->update([
                        'job_vehicle_status_id' => $query->job_vehicle_status_id
                    ]);
                    
                    if($query->hasRepairMethod->code == '01'){
                        $query->hasJVEForm->hasFormRepairInternal()->update($data);
                    }
                    
                } else if($query->hasJVEForm && $query->hasJVEForm->hasFormRepairExternal && !$isdone_external){

                    $query->hasJVEForm->update([
                        'job_vehicle_status_id' => $query->job_vehicle_status_id
                    ]);
                    
                    if($query->hasRepairMethod->code == '02'){
                        $query->hasJVEForm->hasFormRepairExternal()->update($data);
                    }

                    if($query->is_research_market == 2)
                        if($query->hasJVEForm->hasInternalRepairStatus && $query->hasJVEForm->hasInternalRepairStatus->code == '02' && $query->hasJVEForm->hasExternalRepairStatus && $query->hasJVEForm->hasExternalRepairStatus->code == '04'){
                            $query->hasJVEForm()->update([
                                'job_vehicle_status_id' => $this->hasMaintenanceJobVehicleStatus('11')
                            ]);
                        }
                }

                if($request->category_id){
                    $query->hasVehicle->update([
                        'category_id' => $request->category_id,
                        'sub_category_id' => $request->sub_category_id,
                        'sub_category_type_id' => $request->sub_category_type_id,
                        // 'other_sub_category_type' => $request->other_sub_category_type
                    ]);
                }
            }


            if($query->hasVehicle->hasExamform->hasFormRepair->count() && $query->hasVehicle->hasMaintenanceDetail->hasVehicleInprogress->count() == 0){
                $query->hasVehicle->update([
                    'maintenance_vehicle_status_id' => $this->hasMaintenanceVehicleStatus('08')
                ]);
                $query->hasVehicle->hasMaintenanceDetail->update([
                    'app_status_id' => $this->hasMaintenanceAppStatus('08')
                ]);
                if($query->hasJVEForm){
                    $query->hasJVEForm->update([
                        'job_vehicle_status_id' => $this->hasMaintenanceJobVehicleStatus('12')
                    ]);
                }
            }
        }

        if(
            $request->save_as == 'inspect_not_research_market' ||
            $request->save_as == 'procurement_approve'
        ){
            if($query->hasJVEForm){
                if($query->hasWaranType){
                    $this->updateWarrantFormRepair($query, false);
                }
            } else {
                if($query->hasWaranType){
                    $this->updateWarrant($query);
                }
            }
        }

        return [
            'message' => 'Maklumat Berjaya Disimpan'
        ];
    }

    public function updateWarrant($query){
        $year = date('Y');
        $month = date('n');

        $sql = 'select COALESCE(sum(advance),0) AS advance, COALESCE(sum(expense),0) AS expense FROM maintenance.job_vehicle_examination_form a
        join maintenance.job_vehicle b ON b.id = a.vehicle_id
        join maintenance.job c ON c.id = b.maintenance_job_id
        where c.workshop_id = '.$query->hasVehicle->hasMaintenanceDetail->hasWorkShop->id.' and EXTRACT(MONTH FROM a.pro_verified_dt) = '.$month.' and EXTRACT(YEAR FROM a.pro_verified_dt) = '.$year.' and a.waran_type_id = '.$query->waran_type_id.'
        or (EXTRACT(MONTH FROM a.inspected_dt) = '.$month.' AND a.is_research_market = 2)';

        if($query->hasWaranType && $query->hasWaranType->code == '01'){
            $sql = $sql.' and a.osol_type_id = '.$query->osol_type_id;
        }

        $queryCalc = DB::select(DB::raw($sql));

        $WarrantDistributionDAO = new WarrantDistributionDAO();

        $year = date('Y');
        $WarrantDistributionDAO->generateWarrantData($year);

        $queryWarant = [
            'year' => date('Y'),
            'month' => date('n'),
            'workshop_id' => $query->hasVehicle->hasMaintenanceDetail->hasWorkShop->id,
            'waran_type_id' => $query->waran_type_id
        ];
        $queryWarrantDetail = WarrantDetail::where($queryWarant);

        if($query->osol_type_id) {
            $queryWarant['osol_type_id'] = $query->osol_type_id;
        }

        $queryWarrantDetail->update([
            'expense' => $queryCalc[0]->expense,
            'advance' => $queryCalc[0]->advance
        ]);

        $WDStatementData = [
            'wd_id' => $queryWarrantDetail->first()->id,
            'expense' => $queryWarrantDetail->first()->expense,
            'advance' => $queryWarrantDetail->first()->advance,
            'expense_dt' => Carbon::now(),
            'created_by' => Auth::user()->id
        ];

        WarrantDetailStatement::create($WDStatementData);

        $query->update([
            'warrant_detail_id' => $queryWarrantDetail->first()->id
        ]);

    }

    public function updateWarrantFormRepair($query, $is_complete){

        Log::info('updateWarrantFormRepair ');

        $year = date('Y');
        $month = date('n');

        $sql = 'select COALESCE(sum(advance),0) AS advance, COALESCE(sum(expense),0) AS expense FROM maintenance.job_vehicle_examination_form_repair a
        join maintenance.job_vehicle b ON b.id = a.vehicle_id
        join maintenance.job c ON c.id = b.maintenance_job_id
        where c.workshop_id = '.$query->hasVehicle->hasMaintenanceDetail->hasWorkShop->id.' and EXTRACT(MONTH FROM a.pro_verified_dt) = '.$month.' and EXTRACT(YEAR FROM a.pro_verified_dt) = '.$year.' and a.waran_type_id = '.$query->waran_type_id.' and a.job_vehicle_status_id = 12';

        // and a.repair_method_id = '.$query->repair_method_id
        
        // or (EXTRACT(MONTH FROM a.inspected_dt) = '.$month.' AND a.is_research_market = 2)';

        if($query->hasWaranType && $query->hasWaranType->code == '01'){
            $sql = $sql.' and a.osol_type_id = '.$query->osol_type_id;
        }

        Log::info('updateWarrantFormRepair => $sql '.$sql);

        // $queryCalc = DB::select(DB::raw($sql));

        $WarrantDistributionDAO = new WarrantDistributionDAO();

        $year = date('Y');
        $WarrantDistributionDAO->generateWarrantData($year);

        $queryWarant = [
            'year' => date('Y'),
            'month' => date('n'),
            'workshop_id' => $query->hasVehicle->hasMaintenanceDetail->hasWorkShop->id,
            'waran_type_id' => $query->waran_type_id
        ];

        if($query->osol_type_id) {
            $queryWarant['osol_type_id'] = $query->osol_type_id;
        }

        $queryWarrantDetail = WarrantDetail::where($queryWarant)->first();

        Log::info('$queryWarrantDetail '.$queryWarrantDetail);

        $currentExpense = $queryWarrantDetail->expense;
        $currentAdvance = $queryWarrantDetail->advance;

        if($is_complete){
            $currentAdvance = $currentAdvance - $query->expense;
            $currentExpense = $currentExpense + $query->expense;
        } else {
            $currentAdvance = $currentAdvance + $query->advance;
        }

        $WDStatementData = [
            'wd_id' => $queryWarrantDetail->id,
            'expense' => $query->expense,
            'advance' => $query->advance,
            'expense_dt' => Carbon::now(),
            'created_by' => Auth::user()->id
        ];

        WarrantDetailStatement::create($WDStatementData);

        $queryWarrantDetail->update([
            'expense' => $currentExpense,
            'advance' => $currentAdvance,
        ]);

        $query->update([
            'warrant_detail_id' => $queryWarrantDetail->id
        ]);

    }

    private function sendEmailNotificationApplicantWhenDone($applicant_name, $vehicle, $email){
        $emailBody = [
            'title' => 'Maklumat Servis/Pembaikan Kenderaan',
            'applicant_name' => $applicant_name,
            'subject' => 'Maklumat Servis/Pembaikan Kenderaan '.Carbon::now()->format('d/m/Y'),
            'vehicle' => $vehicle,
        ];

        $userEmail = ['farid.developer.1992@gmail.com'];
        array_push($userEmail, $email);

        Mail::to($userEmail)->send(new SendEmailSubmissionAppNotifyToApplicantVehicleCompleted($emailBody));
    }

    public function updateStatus(Request $request){
        $vehicle_id = $request->vehicle_id;
        $vehicle_status_code = $request->status_code;
        $query = MaintenanceJobVehicle::find($vehicle_id);
        $query->update([
            'maintenance_vehicle_status_id' => $this->hasMaintenanceVehicleStatus($vehicle_status_code)
        ]);

        $response = [
            'code' => 200,
            'message' => 'Maklumat berjaya dikemaskini'
        ];

        return $response;
    }

    public function delete(Request $request){
        $ids = $request->ids;
        $query = MaintenanceJobVehicle::whereIn('id', $ids);

        $checkExistForm = MaintenanceJobVehicleExaminationForm::where([
            'vehicle_id' => $ids
        ])->first();

        if($checkExistForm){
            $checkExistForm->delete();
        }

        $query->delete();
     
        $response = [
            'code' => 200,
            'message' => 'Maklumat berjaya dihapus'
        ];

        return $response;
    }

    private function convertDateToSQLDateTime($dateVal, $format){
        return Carbon::createFromFormat('d/m/Y', $dateVal)->format($format);
    }

    private function hasMaintenanceAppStatus($code){
        $data = MaintenanceApplicationStatus::where('code', $code)->first();
        return $data->id;
    }

    private function hasMaintenanceVehicleStatus($code){
        $data = MaintenanceVehicleStatus::where('code', $code)->first();
        return $data->id;
    }

    private function hasMaintenanceJobVehicleStatus($code){
        $data = MaintenanceJobVehicleStatus::where('code', $code)->first();
        return $data->id;
    }
}
