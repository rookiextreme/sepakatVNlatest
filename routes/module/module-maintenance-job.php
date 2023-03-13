<?php

use App\Http\Controllers\Maintenance\Job\MaintenanceJobDAO;
use App\Http\Controllers\Maintenance\Job\MaintenanceJobVehicleDAO;
use App\Models\Maintenance\MaintenanceExternalRepair;
use App\Models\Maintenance\MaintenanceJob;
use App\Models\Maintenance\MaintenanceJobPurposeType;
use App\Models\Maintenance\MaintenanceJobVehicle;
use App\Models\Maintenance\MaintenanceJobVehicleExaminationFormRepair;
use App\Models\Maintenance\MaintenanceRepairMethod;
use App\Models\RefAgency;
use App\Models\RefCategory;
use App\Models\RefEngineFuelType;
use App\Models\RefOwner;
use App\Models\RefState;
use App\Models\RefWorkshop;
use App\Models\User;
use App\Models\Vehicle\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

//Start Job

Route::group(['prefix' => 'job', 'as' => '.job', 'middleware' => 'auth'], function(){

    Route::get('/list', function(Request $request) {

        $MaintenanceJobDAO = new MaintenanceJobDAO();
        $maintenance_job_list = $MaintenanceJobDAO->list($request);
        return view('maintenance.job.job-list', [
            'maintenance_job_list' => $maintenance_job_list,
        ]);

    })->name('.list');

    Route::get('/register', function(Request $request) {

        $MaintenanceJobDAO = new MaintenanceJobDAO();
        $detail = $MaintenanceJobDAO->read($request);

        $variables = [
            'detail' => $detail,
            'agency_list' => RefAgency::orderBy('desc')->get(),
            'workshop_list' => RefWorkshop::orderByRaw('code=\'02\'')->get()->reverse(),
            'category_list' => RefCategory::all(),
            'brand_list' => Brand::where('status', 1)->orderBy('name')->get(),
            'owner_list' => RefOwner::all(),
            'state_list' => RefState::all(),
            'fuel_type_list' => RefEngineFuelType::all(),
            'maintenance_job_purpose_type_list' => MaintenanceJobPurposeType::all()
        ];

        if(auth()->user()->isEngineer() || auth()->user()->isEngineerMaintenance()){
            $filter_by_roles = array('12');
            $users = User::select(
                'users.users.id AS id',
                'users.users.name AS name',
                'users.users.email AS email'
            );
            $users->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.users.id');
            $users->join('ref_role', 'ref_role.id', '=', 'model_has_roles.role_id');
            $users->whereIn('ref_role.code', $filter_by_roles);

            $users->whereHas('detail', function($q){
                $q->whereHas('refStatus', function($q2){
                    $q2->where('code', '06');
                })->whereHas('hasWorkshop', function($q3){
                    $q3->where('id', auth()->user()->detail->workshop_id);
                });
            });

            $variables['assist_engineer_list'] = $users->get();
        };

        return view('maintenance.job.job-register', $variables);

    })->name('.register');

    Route::post('/changeWorkshop', function (Request $request) {
        $MaintenanceEvaluationDAO = new MaintenanceJobDAO();
        return $MaintenanceEvaluationDAO->changeWorkshop($request);
    })->name('.changeWorkshop');

    Route::post('/assign-assistant-engineer', function (Request $request) {
        $MaintenanceEvaluationDAO = new MaintenanceJobDAO();
        return $MaintenanceEvaluationDAO->assignAssistantEngineer($request);
    })->name('.assign.assistant.engineer');

    Route::post('/register-save', function (Request $request) {

        $section = $request->section;
        $MaintenanceJobDAO = new MaintenanceJobDAO();
        switch ($section) {
            case 'detail':
                return $MaintenanceJobDAO->upsert($request);
                break;
            case 'verify':
                return $MaintenanceJobDAO->verify($request);
                break;
            case 'examination':
                return $MaintenanceJobDAO->examination();
                break;
            case 'set_appointment':
                return $MaintenanceJobDAO->setAppointment($request);
                break;
        }
        return view('maintenance.job.job-register');
    })->name('.register.save');


    Route::post('/verification', function (Request $request) {
        $MaintenanceJobDAO = new MaintenanceJobDAO();
        return $MaintenanceJobDAO->verification();
    })->name('.verification');

    Route::get('/vehicle-getOsolType', function (Request $request) {

        $MaintenanceJobVehicleDAO = new MaintenanceJobVehicleDAO();
        return $MaintenanceJobVehicleDAO->getOsolType($request);
    })->name('.vehicle.getOsolType');

    Route::post('/vehicle-save', function (Request $request) {
        $MaintenanceJobVehicleDAO = new MaintenanceJobVehicleDAO();
        return $MaintenanceJobVehicleDAO->upsert($request);
    })->name('.vehicle.save');

    Route::post('/vehicle-checkExistRegNumber', function(Request $request){

        $validator = Validator::make($request->all(), [
            'plate_no' => 'required',
        ],
        [
            'plate_no.required' => 'Sila masukkan no pendaftaran'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $queryRegNumberIsExisted = MaintenanceJobVehicle::where('plate_no', $request->plate_no)
        ->whereHas('hasMaintenanceDetail', function($q){
            $q->whereHas('hasStatus', function($q2){
                $q2->whereNotIn('code', ['00','06','08']);
            });
        });
        if($request->vehicle_id){
            $queryRegNumberIsExisted->where('id', '!=', $request->vehicle_id);
        }
        Log::info($queryRegNumberIsExisted->toSql());
        return $queryRegNumberIsExisted->first() ? 1 : 0;
    })->name('.vehicle.checkExistRegNumber');

    Route::get('/vehicle-list', function (Request $request) {

        $MaintenanceJobVehicleDAO = new MaintenanceJobVehicleDAO();
        $vehicleList = $MaintenanceJobVehicleDAO->list($request);

        $maintenance_job_id = session()->get('mjob_current_detail_id');
        $hasMaintenanceJobDetail = MaintenanceJob::find($maintenance_job_id);

        $category_list = RefCategory::all();
        $brand_list = Brand::where('status', 1)->orderBy('name')->get();

        return view('maintenance.job.ajax.maintenance-job-vehicle-list', [
            'hasMaintenanceJobDetail' => $hasMaintenanceJobDetail,
            'category_list' => $category_list,
            'brand_list' => $brand_list,
            'vehicleList' => $vehicleList
        ]);
    })->name('.vehicle.list');

    Route::get('/vehicle-appointment-list', function (Request $request) {

        $MaintenanceJobVehicleDAO = new MaintenanceJobVehicleDAO();
        $vehicleList = $MaintenanceJobVehicleDAO->list($request);

        $maintenance_job_id = session()->get('mjob_current_detail_id');
        $hasMaintenanceJobDetail = MaintenanceJob::find($maintenance_job_id);

        $foremenList = $MaintenanceJobVehicleDAO->foremenList();

        return view('maintenance.job.ajax.maintenance-job-vehicle-appointment-list', [
            'hasMaintenanceJobDetail' => $hasMaintenanceJobDetail,
            'vehicleList' => $vehicleList,
            'foremenList' => $foremenList
        ]);
    })->name('.vehicle-appointment.list');

    Route::get('/vehicle-examination-form-component-list', function (Request $request) {

        $MaintenanceJobVehicleDAO = new MaintenanceJobVehicleDAO();
        $componentList = $MaintenanceJobVehicleDAO->getFormComponentList($request);

        return view('maintenance.job.ajax.maintenance-job-vehicle-examination-form-component-list', [
            'componentList' => $componentList
        ]);
    })->name('.vehicle-examnination.form.component.list');

    Route::post('/vehicle-appointment-assign', function(Request $request){

        $MaintenanceJobVehicleDAO = new MaintenanceJobVehicleDAO();
        switch ($request->assign_to) {
            case 'formen':
                $MaintenanceJobVehicleDAO->assignToFormen($request);
                break;

            default:
                # code...
                break;
        }

    })->name('.vehicle-appointment-assign');

    Route::get('/vehicle-assessment-list', function (Request $request) {
        Log::info("vehicle-assessment-list => MaintenanceJobVehicleDAO");
        $MaintenanceJobVehicleDAO = new MaintenanceJobVehicleDAO();
        $vehicleList = $MaintenanceJobVehicleDAO->list($request);

        $maintenance_job_id = session()->get('mjob_current_detail_id');
        $hasMaintenanceJobDetail = MaintenanceJob::find($maintenance_job_id);

        return view('maintenance.job.ajax.maintenance-job-vehicle-assessment-list', [
            'hasMaintenanceJobDetail' => $hasMaintenanceJobDetail,
            'vehicleList' => $vehicleList
        ]);
    })->name('.vehicle-assessment.list');

    Route::get('/vehicle-evaluation-list', function (Request $request) {

        $MaintenanceJobVehicleDAO = new MaintenanceJobVehicleDAO();
        $vehicleList = $MaintenanceJobVehicleDAO->list($request);

        $maintenance_job_id = session()->get('mjob_current_detail_id');
        $hasMaintenanceJobDetail = MaintenanceJob::find($maintenance_job_id);

        return view('maintenance.job.ajax.maintenance-job-vehicle-evaluation-list', [
            'hasMaintenanceJobDetail' => $hasMaintenanceJobDetail,
            'vehicleList' => $vehicleList
        ]);
    })->name('.vehicle-evaluation.list');

    Route::get('/vehicle-approval-list', function (Request $request) {

        $MaintenanceJobVehicleDAO = new MaintenanceJobVehicleDAO();
        $vehicleList = $MaintenanceJobVehicleDAO->list($request);

        $maintenance_job_id = session()->get('mjob_current_detail_id');
        $hasMaintenanceJobDetail = MaintenanceJob::find($maintenance_job_id);

        return view('maintenance.job.ajax.maintenance-job-vehicle-approval-list', [
            'hasMaintenanceJobDetail' => $hasMaintenanceJobDetail,
            'vehicleList' => $vehicleList
        ]);
    })->name('.vehicle-approval.list');

    Route::get('/vehicle-certificate-list', function (Request $request) {
        $MaintenanceJobVehicleDAO = new MaintenanceJobVehicleDAO();
        $vehicleList = $MaintenanceJobVehicleDAO->list($request);

        $maintenance_job_id = session()->get('mjob_current_detail_id');
        $hasMaintenanceJobDetail = MaintenanceJob::find($maintenance_job_id);

        return view('maintenance.job.ajax.maintenance-job-vehicle-certificate-list', [
            'hasMaintenanceJobDetail' => $hasMaintenanceJobDetail,
            'vehicleList' => $vehicleList
        ]);
    })->name('.vehicle-certificate.list');

    Route::get('/vehicle-certificate-checkGenuine', function (Request $request) {
        $MaintenanceJobVehicleDAO = new MaintenanceJobVehicleDAO();
        $detail = $MaintenanceJobVehicleDAO->checkGenuine($request);
        return view('maintenance.job.job-vehicle-certificate-check-genuine', [
            'detail' => $detail
        ]);
    })->name('.vehicle-certificate.checkGenuine');

    Route::post('/approval', function (Request $request) {
        $MaintenanceJobDAO = new MaintenanceJobDAO();
        return $MaintenanceJobDAO->approval();
    })->name('.approval');

    Route::post('/approve', function (Request $request) {
        $MaintenanceJobDAO = new MaintenanceJobDAO();
        return $MaintenanceJobDAO->approve();
    })->name('.approve');

    Route::get('/vehicle-getComponentLvl1', function(Request $request){
        $MaintenanceEvaluationVehicleDAO = new MaintenanceJobVehicleDAO();
        return $MaintenanceEvaluationVehicleDAO->getComponentLvl1($request);
    })->name('.vehicle.getComponentLvl1');

    Route::get('/vehicle-getComponentLvl2', function(Request $request){
        $MaintenanceEvaluationVehicleDAO = new MaintenanceJobVehicleDAO();
        return $MaintenanceEvaluationVehicleDAO->getComponentLvl2($request);
    })->name('.vehicle.getComponentLvl2');

    Route::get('/vehicle-getComponentLvl3', function(Request $request){
        $MaintenanceEvaluationVehicleDAO = new MaintenanceJobVehicleDAO();
        return $MaintenanceEvaluationVehicleDAO->getComponentLvl3($request);
    })->name('.vehicle.getComponentLvl3');

    Route::get('/vehicle-maintenance-form', function(Request $request){
        $MaintenanceEvaluationVehicleDAO = new MaintenanceJobVehicleDAO();
        $form = $MaintenanceEvaluationVehicleDAO->getForm($request);
        return view('maintenance.job.examination.job-vehicle-examination-form',$form);
    })->name('.vehicle-maintenance.form');

    Route::post('/vehicle-maintenance-form-save', function(Request $request){
        $MaintenanceJobVehicleDAO = new MaintenanceJobVehicleDAO();
        return  $MaintenanceJobVehicleDAO->saveForm($request);
    })->name('.vehicle.maintenance.form.save');

    Route::post('/vehicle-delete', function(Request $request){
        $MaintenanceJobVehicleDAO = new MaintenanceJobVehicleDAO();
        return  $MaintenanceJobVehicleDAO->delete($request);
    })->name('.vehicle.delete');

    Route::post('/vehicle-updateStatus', function(Request $request){
        $MaintenanceJobVehicleDAO = new MaintenanceJobVehicleDAO();
        return  $MaintenanceJobVehicleDAO->updateStatus($request);
    })->name('.vehicle.updateStatus');

    Route::get('/vehicle-getVehicleForm', function(Request $request){
        $MaintenanceJobVehicleDAO = new MaintenanceJobVehicleDAO();
        return $MaintenanceJobVehicleDAO->getVehicleForm($request);
    })->name('.vehicle.getVehicleForm');

    Route::post('/vehicle-getVehicleForm-inspect-component-save', function(Request $request){
        $MaintenanceJobVehicleDAO = new MaintenanceJobVehicleDAO();
        $MaintenanceJobVehicleDAO->saveInspectComponent($request);
    })->name('.vehicle.getVehicleForm.inspect.component.save');

    Route::post('/vehicle-getVehicleForm-inspect-component-delete', function(Request $request){
        $MaintenanceJobVehicleDAO = new MaintenanceJobVehicleDAO();
        $MaintenanceJobVehicleDAO->deleteInspectComponent($request);
    })->name('.vehicle.getVehicleForm.inspect.component.delete');

    Route::get('/vehicle-getVehicleForm-inspect-component-list', function(Request $request){
        $MaintenanceJobVehicleDAO = new MaintenanceJobVehicleDAO();
        $res = $MaintenanceJobVehicleDAO->getInspectComponentList($request);
        return view('maintenance.job.examination.ajax.maintenance-job-vehicle-examination-form-inspect-component-list', $res);
    })->name('.vehicle.getVehicleForm.inspect.component.list');

    Route::post('/vehicle-getVehicleForm-inspect-quotation-save', function(Request $request){
        $MaintenanceJobVehicleDAO = new MaintenanceJobVehicleDAO();
        return $MaintenanceJobVehicleDAO->saveInspectQuotation($request);
    })->name('.vehicle.getVehicleForm.inspect.quotation.save');

    Route::post('/vehicle-getVehicleForm-component-save', function(Request $request){
        $MaintenanceJobVehicleDAO = new MaintenanceJobVehicleDAO();
        $MaintenanceJobVehicleDAO->saveFormComponent($request);
    })->name('.vehicle.getVehicleForm.component.save');

    Route::post('/vehicle-getVehicleForm-component-price-save', function(Request $request){
        $MaintenanceJobVehicleDAO = new MaintenanceJobVehicleDAO();
        $MaintenanceJobVehicleDAO->saveFormComponentPrice($request);
    })->name('.vehicle.getVehicleForm.component.price.save');

    Route::post('/vehicle-getVehicleForm-component-delete', function(Request $request){
        $MaintenanceJobVehicleDAO = new MaintenanceJobVehicleDAO();
        $MaintenanceJobVehicleDAO->deleteFormComponent($request);
    })->name('.vehicle.getVehicleForm.component.delete');

    Route::get('/vehicle-getVehicleForm-research-market-component-list', function(Request $request){
        $MaintenanceJobVehicleDAO = new MaintenanceJobVehicleDAO();
        $res = $MaintenanceJobVehicleDAO->getFormMarketComponentList($request);
        return view('maintenance.job.examination.ajax.maintenance-job-vehicle-examination-form-research-market-component-list', $res);
    })->name('.vehicle.getVehicleForm.research.market.component.list');

    Route::post('/vehicle-getVehicleForm-research-market-component-sub-save', function(Request $request){
        $MaintenanceJobVehicleDAO = new MaintenanceJobVehicleDAO();
        return $MaintenanceJobVehicleDAO->saveComponentSub($request);
    })->name('.vehicle.getVehicleForm.research.market.component.sub.save');

    Route::post('/vehicle-getVehicleForm-research-market-component-sub-delete', function(Request $request){
        $MaintenanceJobVehicleDAO = new MaintenanceJobVehicleDAO();
        return $MaintenanceJobVehicleDAO->delComponentSub($request);
    })->name('.vehicle.getVehicleForm.research.market.component.sub.delete');

    Route::post('/vehicle-getVehicleForm-supplier-save', function(Request $request){
        $MaintenanceJobVehicleDAO = new MaintenanceJobVehicleDAO();
        $MaintenanceJobVehicleDAO->saveFormSupplier($request);
    })->name('.vehicle.getVehicleForm.research.market.supplier.save');

    Route::post('/vehicle-getVehicleForm-supplier-delete', function(Request $request){
        $MaintenanceJobVehicleDAO = new MaintenanceJobVehicleDAO();
        $MaintenanceJobVehicleDAO->deleteFormSupplier($request);
    })->name('.vehicle.getVehicleForm.research.market.supplier.delete');

    Route::get('/vehicle-getVehicleForm-research-market-supplier-list', function(Request $request){
        $MaintenanceJobVehicleDAO = new MaintenanceJobVehicleDAO();
        $res = $MaintenanceJobVehicleDAO->getFormSupplierList($request);
        return view('maintenance.job.examination.ajax.maintenance-job-vehicle-examination-form-research-market-supplier-list', $res);
    })->name('.vehicle.getVehicleForm.research.market.supplier.list');

    Route::get('/vehicle-getVehicleForm-research-market-WaranType', function(Request $request){
        $MaintenanceJobVehicleDAO = new MaintenanceJobVehicleDAO();
        return $MaintenanceJobVehicleDAO->WaranType($request);
    })->name('.vehicle.getVehicleForm.research.market.WaranType');

    Route::get('/vehicle-getVehicleForm-research-market-OsolType', function(Request $request){
        $MaintenanceJobVehicleDAO = new MaintenanceJobVehicleDAO();
        return $MaintenanceJobVehicleDAO->OsolType($request);
    })->name('.vehicle.getVehicleForm.research.market.OsolType');

    Route::get('/vehicle-getVehicleForm-procurement-component-list', function(Request $request){
        $MaintenanceJobVehicleDAO = new MaintenanceJobVehicleDAO();
        $res = $MaintenanceJobVehicleDAO->getFormProcurementComponentList($request);
        return view('maintenance.job.examination.ajax.maintenance-job-vehicle-examination-form-procurement-component-list', $res);
    })->name('.vehicle.getVehicleForm.procurement.component.list');

    Route::post('/vehicle-getVehicleForm-procurement-component-save', function(Request $request){
        $MaintenanceJobVehicleDAO = new MaintenanceJobVehicleDAO();
        return $MaintenanceJobVehicleDAO->formProcurementComponentSave($request);
    })->name('.vehicle.getVehicleForm.procurement.component.save');

    Route::get('/vehicle-getVehicleForm-monitoring-info-list', function(Request $request){
        $MaintenanceJobVehicleDAO = new MaintenanceJobVehicleDAO();
        $res = $MaintenanceJobVehicleDAO->getMonitoringInfoList($request);
        return view('maintenance.job.examination.ajax.maintenance-job-vehicle-examination-form-monitoring-info-list', $res);
    })->name('.vehicle.getVehicleForm.monitoring.info.list');

    Route::get('/vehicle-getVehicleForm-quotation-monitoring-info-list', function(Request $request){
        $MaintenanceJobVehicleDAO = new MaintenanceJobVehicleDAO();
        $res = $MaintenanceJobVehicleDAO->getMonitoringInfoList($request);
        return view('maintenance.job.examination.ajax.maintenance-job-vehicle-examination-form-quotation-monitoring-info-list', $res);
    })->name('.vehicle.getVehicleForm.quotation.monitoring.info.list');

    Route::get('/vehicle-getVehicleForm-external-quotation-monitoring-info-list', function(Request $request){
        $MaintenanceJobVehicleDAO = new MaintenanceJobVehicleDAO();
        $res = $MaintenanceJobVehicleDAO->getMonitoringInfoList($request);
        return view('maintenance.job.examination.ajax.maintenance-job-vehicle-examination-form-external-quotation-monitoring-info-list', $res);
    })->name('.vehicle.getVehicleForm.external.quotation.monitoring.info.list');

    Route::post('/vehicle-getVehicleForm-monitoring-info-save', function(Request $request){
        $MaintenanceJobVehicleDAO = new MaintenanceJobVehicleDAO();
        return $MaintenanceJobVehicleDAO->saveMonitoringInfo($request);
    })->name('.vehicle.getVehicleForm.monitoring.info.save');

    Route::post('/vehicle-getVehicleForm-quotation-monitoring-info-save', function(Request $request){
        $MaintenanceJobVehicleDAO = new MaintenanceJobVehicleDAO();
        return $MaintenanceJobVehicleDAO->saveMonitoringInfo($request);
    })->name('.vehicle.getVehicleForm.quotation.monitoring.info.save');

    Route::post('/vehicle-getVehicleForm-external-quotation-monitoring-info-save', function(Request $request){
        $MaintenanceJobVehicleDAO = new MaintenanceJobVehicleDAO();
        return $MaintenanceJobVehicleDAO->saveMonitoringInfo($request);
    })->name('.vehicle.getVehicleForm.external.quotation.monitoring.info.save');

    Route::post('/vehicle-getVehicleForm-monitoring-info-delete', function(Request $request){
        $MaintenanceJobVehicleDAO = new MaintenanceJobVehicleDAO();
        return $MaintenanceJobVehicleDAO->deleteMonitoringInfo($request);
    })->name('.vehicle.getVehicleForm.monitoring.info.delete');

    Route::post('/vehicle-assignAppointment', function(Request $request){
        $MaintenanceJobVehicleDAO = new MaintenanceJobVehicleDAO();
        $MaintenanceJobVehicleDAO->assignAppointment($request);
    })->name('.vehicle.assignAppointment');

    Route::post('/delete', function(Request $request){
        $MaintenanceJobDAO = new MaintenanceJobDAO();
        return  $MaintenanceJobDAO->delete($request);
    })->name('.delete');

    Route::post('/cancel', function(Request $request){
        $MaintenanceJobDAO = new MaintenanceJobDAO();
        return  $MaintenanceJobDAO->cancel($request);
    })->name('.cancel');

    Route::post('/reject', function (Request $request) {
        $MaintenanceJobDAO = new MaintenanceJobDAO();
        return $MaintenanceJobDAO->reject();
    })->name('.reject');

    Route::get('/vehicle-monitoring-done-form', function (Request $request) {

        $MaintenanceJobVehicleDAO = new MaintenanceJobVehicleDAO();

        if($request->jve_form_repair_id){
            $detail = MaintenanceJobVehicleExaminationFormRepair::find($request->jve_form_repair_id);
            $hasVehicle = $detail->hasVehicle;
            $hasMaintenanceDetail = $detail->hasVehicle->hasMaintenanceDetail;
        }
        else if($request->vehicle_id){
            $detail = MaintenanceJobVehicle::find($request->vehicle_id);
            $hasVehicle = $detail;
            $hasMaintenanceDetail = $detail->hasMaintenanceDetail;
        } else {
            $detail = $MaintenanceJobVehicleDAO->searchByPlateNo($request);
            $hasVehicle = $detail;
            $hasMaintenanceDetail = $detail->hasMaintenanceDetail;
        }
        return view('maintenance.job.done.job-monitoring-done-form', [
            'detail' => $detail,
            'hasVehicle' => $hasVehicle,
            'hasMaintenanceDetail' => $hasMaintenanceDetail,
            'jve_form_repair_id' => $request->jve_form_repair_id
        ]);
    })->name('.vehicle.monitoring.done.form');

    Route::post('/vehicle-monitoring-done-form-complete', function (Request $request) {
        $MaintenanceJobDAO = new MaintenanceJobDAO();
        return $MaintenanceJobDAO->completeMaintenance($request);
    })->name('.vehicle.monitoring.done.form.complete');

    Route::get('/price-list', function (Request $request) {
        if($request->jve_form_repair_id){
            $detail = MaintenanceJobVehicleExaminationFormRepair::find($request->jve_form_repair_id);
            $hasForm = $detail;
            $hasVehicle = $detail->hasVehicle;
            $hasMaintenanceDetail = $detail->hasVehicle->hasMaintenanceDetail;
        } else {
            $detail = MaintenanceJobVehicle::find($request->id);
            $hasForm = $detail->hasExamform;
            $hasVehicle = $detail;
            $hasMaintenanceDetail = $detail->hasMaintenanceDetail;
        }
        return view('maintenance.job.done.price-list', [
            'detail' => $detail,
            'hasForm' => $hasForm,
            'hasVehicle' => $hasVehicle,
            'hasMaintenanceDetail' => $hasMaintenanceDetail,
        ]);
    })->name('.vehicle.price-list');

    Route::get('/justification-part-1', function (Request $request) {

        if($request->jve_form_repair_id){
            $detail = MaintenanceJobVehicleExaminationFormRepair::find($request->jve_form_repair_id);
            $hasForm = $detail;
            $hasJVEForm = $detail->hasJVEForm;
            $hasVehicle = $detail->hasVehicle;
            $hasMaintenanceDetail = $detail->hasVehicle->hasMaintenanceDetail;
            $purpose_types = $detail->hasVehicle->hasManyPurposeType();
            $repair_methods = $detail->hasJVEForm && $detail->hasJVEForm->hasRepairMethod() ? $detail->hasJVEForm->hasRepairMethod()->get() : [];
            $external_repairs = $detail->hasExternalRepair ? $detail->hasExternalRepair : [];
        } else {
            $detail = MaintenanceJobVehicle::find($request->id);
            $hasForm = $detail->hasExamform;
            $hasJVEForm = $detail->hasExamform;
            $hasVehicle = $detail;
            $hasMaintenanceDetail = $detail->hasMaintenanceDetail;
            $purpose_types = $detail->hasManyPurposeType();
            $repair_methods = $detail->hasExamform && $detail->hasExamform->hasRepairMethod() ? $detail->hasExamform->hasRepairMethod()->get() : [];
            $external_repairs = $detail->hasExamform ? $detail->hasExamform->hasExternalRepair : [];
        }

        // echo '<pre>';
        // print_r($hasForm->hasManyMVInspectComponentList);
        // echo '</pre>';
        // die();
        Log::info($repair_methods);
        Log::info($external_repairs);

        return view('maintenance.job.done.justification-part-1', [
            'detail' => $detail,
            'hasForm' => $hasForm,
            'hasJVEForm' => $hasJVEForm,
            'hasVehicle' => $hasVehicle,
            'hasMaintenanceDetail' => $hasMaintenanceDetail,
            'purpose_types' => $purpose_types,
            'repair_methods' => $repair_methods,
            'external_repairs' => $external_repairs
        ]);
    })->name('.vehicle.justification-part-1');

    Route::get('/justification-part-2', function (Request $request) {

        if($request->jve_form_repair_id){
            $detail = MaintenanceJobVehicleExaminationFormRepair::find($request->jve_form_repair_id);
            $hasForm = $detail;
            $hasJVEForm = $detail->hasJVEForm;
            $hasVehicle = $detail->hasVehicle;
            $hasMaintenanceDetail = $detail->hasVehicle->hasMaintenanceDetail;
            $purpose_types = $detail->hasVehicle->hasManyPurposeType();
            $repair_methods = $detail->hasJVEForm && $detail->hasJVEForm->hasRepairMethod() ? $detail->hasJVEForm->hasRepairMethod()->get() : [];
            $external_repairs = $detail->hasExternalRepair ? $detail->hasExternalRepair : [];
        } else {
            $detail = MaintenanceJobVehicle::find($request->id);
            $hasForm = $detail->hasExamform;
            $hasJVEForm = $detail->hasExamform;
            $hasVehicle = $detail;
            $hasMaintenanceDetail = $detail->hasMaintenanceDetail;
            $purpose_types = $detail->hasManyPurposeType();
            $repair_methods = $detail->hasExamform && $detail->hasExamform->hasRepairMethod() ? $detail->hasExamform->hasRepairMethod()->get() : [];
            $external_repairs = $detail->hasExamform ? $detail->hasExamform->hasExternalRepair : [];
        }

        // echo '<pre>';
        // print_r($hasForm->hasManyMVInspectComponentList);
        // echo '</pre>';
        // die();

        Log::info($repair_methods);
        Log::info($external_repairs);

        return view('maintenance.job.done.justification-part-2', [
            'detail' => $detail,
            'hasForm' => $hasForm,
            'hasJVEForm' => $hasJVEForm,
            'hasVehicle' => $hasVehicle,
            'hasMaintenanceDetail' => $hasMaintenanceDetail,
            'purpose_types' => $purpose_types,
            'repair_methods' => $repair_methods,
            'external_repairs' => $external_repairs
        ]);
    })->name('.vehicle.justification-part-2');


    Route::get('/maintenance-record', function (Request $request) {
        if($request->jve_form_repair_id){
            $detail = MaintenanceJobVehicleExaminationFormRepair::find($request->jve_form_repair_id);
            $hasForm = $detail;
            $hasVehicle = $detail->hasVehicle;
            $hasMaintenanceDetail = $detail->hasVehicle->hasMaintenanceDetail;
            $purpose_types = $detail->hasVehicle->hasManyPurposeType();
        } else {
            $detail = MaintenanceJobVehicle::find($request->id);
            $hasForm = $detail->hasExamform;
            $hasVehicle = $detail;
            $hasMaintenanceDetail = $detail->hasMaintenanceDetail;
        }
        return view('maintenance.job.done.maintenance-record', [
            'detail' => $detail,
            'hasForm' => $hasForm,
            'hasVehicle' => $hasVehicle,
            'hasMaintenanceDetail' => $hasMaintenanceDetail,
        ]);
    })->name('.vehicle.maintenance-record');


    Route::get('/market-research', function (Request $request) {
        if($request->jve_form_repair_id){
            $detail = MaintenanceJobVehicleExaminationFormRepair::find($request->jve_form_repair_id);
            $hasForm = $detail;
            $hasVehicle = $detail->hasVehicle;
            $hasMaintenanceDetail = $detail->hasVehicle->hasMaintenanceDetail;
        } else {
            $detail = MaintenanceJobVehicle::find($request->id);
            $hasForm = $detail->hasExamform;
            $hasVehicle = $detail;
            $hasMaintenanceDetail = $detail->hasMaintenanceDetail;
        }

        return view('maintenance.job.done.market-research', [
            'detail' => $detail,
            'hasForm' => $hasForm,
            'hasVehicle' => $hasVehicle,
            'hasMaintenanceDetail' => $hasMaintenanceDetail,
        ]);
    })->name('.vehicle.market-research');

    Route::get('/external', function (Request $request) {
        if($request->jve_form_repair_id){
            $detail = MaintenanceJobVehicleExaminationFormRepair::find($request->jve_form_repair_id);
            $hasForm = $detail;
            $hasVehicle = $detail->hasVehicle;
            $hasMaintenanceDetail = $detail->hasVehicle->hasMaintenanceDetail;
        } else {
            $detail = MaintenanceJobVehicle::find($request->id);
            $hasForm = $detail->hasExamform;
            $hasVehicle = $detail;
            $hasMaintenanceDetail = $detail->hasMaintenanceDetail;
        }
        return view('maintenance.job.done.external', [
            'detail' => $detail,
            'hasForm' => $hasForm,
            'hasVehicle' => $hasVehicle,
            'hasMaintenanceDetail' => $hasMaintenanceDetail,
        ]);
    })->name('.vehicle.external');

    Route::get('/quotation', function (Request $request) {
        // $detail = MaintenanceJobVehicle::find($request->id);
        $formRepair = MaintenanceJobVehicleExaminationFormRepair::find($request->jve_form_repair_id);
        $detail = null;
        $job = null;
        if($formRepair && $formRepair->hasVehicle){
            $detail = $formRepair->hasVehicle;
            $job = $formRepair->hasVehicle->hasMaintenanceDetail;
        }
        $jobDetail = $job;
        return view('maintenance.job.done.quotation', [
            'detail' => $detail,
            'formRepair' => $formRepair,
            'jobDetail' => $jobDetail
        ]);
    })->name('.vehicle.quotation');

});

//End Job
