<?php

use App\Http\Controllers\Maintenance\Evaluation\MaintenanceEvaluationDAO;
use App\Http\Controllers\Maintenance\Evaluation\MaintenanceEvaluationVehicleDAO;
use App\Models\Maintenance\MaintenanceEvaluation;
use App\Models\Maintenance\MaintenanceEvaluationLetter;
use App\Models\Maintenance\MaintenanceEvaluationVehicle;
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

Route::group(['prefix' => 'evaluation', 'as' => '.evaluation', 'middleware' => 'auth'], function(){

    Route::get('/list', function(Request $request) {

        $MaintenanceEvaluationDAO = new MaintenanceEvaluationDAO();
        $maintenance_evaluation_list = $MaintenanceEvaluationDAO->list($request);
        return view('maintenance.evaluation.evaluation-list', [
            'maintenance_evaluation_list' => $maintenance_evaluation_list,
        ]);

    })->name('.list');

    Route::get('/register', function(Request $request) {

        $AccessMaintenanceEvaluation = auth()->user()->vehicle('03', '02');
        $TaskFlowAccessMaintenanceEvaluation = auth()->user()->vehicleWorkFlow('03', '02');

        $MaintenanceEvaluationDAO = new MaintenanceEvaluationDAO();
        $detail = $MaintenanceEvaluationDAO->read($request);
        $variables = [
            'detail' => $detail,
            'agency_list' => RefAgency::orderBy('desc')->get(),
            'workshop_list' => RefWorkshop::orderByRaw('code=\'02\'')->get()->reverse(),
            'category_list' => RefCategory::all(),
            'brand_list' => Brand::where('status', 1)->orderBy('name')->get(),
            'owner_list' => RefOwner::all(),
            'state_list' => RefState::all(),
            'fuel_type_list' => RefEngineFuelType::all(),
        ];

        $variables['assist_engineer_list'] = [];

        Log::info($TaskFlowAccessMaintenanceEvaluation);

        if($TaskFlowAccessMaintenanceEvaluation->mod_fleet_approval){

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
                })
                ->where('workshop_id', auth()->user()->detail->workshop_id);
            });

            $variables['assist_engineer_list'] = $users->get();
        };
        return view('maintenance.evaluation.evaluation-register', $variables);

    })->name('.register');

    Route::get('/generate-damage', function(Request $request) {
        $MaintenanceEvaluationVehicleDAO = new MaintenanceEvaluationVehicleDAO();
        $vehicleList = $MaintenanceEvaluationVehicleDAO->list($request);
        $maintenance_evaluation_id = session()->get('mevaluation_current_detail_id');
        $detail = MaintenanceEvaluation::find($maintenance_evaluation_id);
        $hasMaintenanceEvaluationDetail = MaintenanceEvaluation::find($maintenance_evaluation_id);
        return view('maintenance.evaluation.evaluation-vehicle-letter-form', [
            'hasMaintenanceEvaluationDetail' => $hasMaintenanceEvaluationDetail,
            'vehicleList' => $vehicleList,
            'detail' => $detail,
        ]);

    })->name('.generate-damage');

    Route::post('/changeWorkshop', function (Request $request) {
        $MaintenanceEvaluationDAO = new MaintenanceEvaluationDAO();
        return $MaintenanceEvaluationDAO->changeWorkshop($request);
    })->name('.changeWorkshop');

    Route::post('/assign-assistant-engineer', function (Request $request) {
        $MaintenanceEvaluationDAO = new MaintenanceEvaluationDAO();
        return $MaintenanceEvaluationDAO->assignAssistantEngineer($request);
    })->name('.assign.assistant.engineer');

    Route::post('/register-save', function (Request $request) {

        $section = $request->section;
        $MaintenanceEvaluationDAO = new MaintenanceEvaluationDAO();
        switch ($section) {
            case 'detail':
                return $MaintenanceEvaluationDAO->upsert($request);
                break;
            case 'verify':
                return $MaintenanceEvaluationDAO->verify($request);
                break;
            case 'examination':
                return $MaintenanceEvaluationDAO->examination();
                break;
            case 'set_appointment':
                return $MaintenanceEvaluationDAO->setAppointment($request);
                break;
        }
        return view('maintenance.evaluation.evaluation-register');
    })->name('.register.save');

    Route::post('/verification', function (Request $request) {
        $MaintenanceEvaluationDAO = new MaintenanceEvaluationDAO();
        return $MaintenanceEvaluationDAO->verification();
    })->name('.verification');

    Route::post('/vehicle-save', function (Request $request) {
        $MaintenanceEvaluationVehicleDAO = new MaintenanceEvaluationVehicleDAO();
        return $MaintenanceEvaluationVehicleDAO->upsert($request);
    })->name('.vehicle.save');

    Route::post('/vehicle-maintenance-form-save', function(Request $request){
        $MaintenanceEvaluationVehicleDAO = new MaintenanceEvaluationVehicleDAO();
        return  $MaintenanceEvaluationVehicleDAO->saveForm($request);
    })->name('.vehicle-maintenance.form.save');

    Route::post('/vehicle-maintenance-form-file-save', function(Request $request){
        $MaintenanceEvaluationVehicleDAO = new MaintenanceEvaluationVehicleDAO();
        return  $MaintenanceEvaluationVehicleDAO->saveFormFile($request);
    })->name('.vehicle-maintenance.form-file.save');

    Route::post('/vehicle-maintenance-form-file-delete', function(Request $request){
        $MaintenanceEvaluationVehicleDAO = new MaintenanceEvaluationVehicleDAO();
        return  $MaintenanceEvaluationVehicleDAO->deleteDocFile($request);
    })->name('.vehicle-maintenance.form-file.delete');

    Route::post('/vehicle-checkExistRegNumber', function(Request $request){
        $queryRegNumberIsExisted = MaintenanceEvaluationVehicle::where('plate_no', $request->plate_no)
        ->whereHas('hasMaintenanceDetail', function($q){
            $q->whereHas('hasStatus', function($q2){
                $q2->whereNotIn('code', ['00','06','10']);
            });
        });
        if($request->vehicle_id){
            $queryRegNumberIsExisted->where('id', '!=', $request->vehicle_id);
        }
        Log::info($queryRegNumberIsExisted->toSql());
        return $queryRegNumberIsExisted->first() ? 1 : 0;
    })->name('.vehicle.checkExistRegNumber');

    Route::get('/vehicle-list', function (Request $request) {

        $MaintenanceEvaluationVehicleDAO = new MaintenanceEvaluationVehicleDAO();
        $vehicleList = $MaintenanceEvaluationVehicleDAO->list($request);

        $maintenance_evaluation_id = session()->get('mevaluation_current_detail_id');
        $hasMaintenanceEvaluationDetail = MaintenanceEvaluation::find($maintenance_evaluation_id);

        $category_list = RefCategory::all();
        $brand_list = Brand::where('status', 1)->orderBy('name')->get();

        return view('maintenance.evaluation.ajax.maintenance-evaluation-vehicle-list', [
            'hasMaintenanceEvaluationDetail' => $hasMaintenanceEvaluationDetail,
            'category_list' => $category_list,
            'brand_list' => $brand_list,
            'vehicleList' => $vehicleList
        ]);
    })->name('.vehicle.list');

    Route::get('/vehicle-appointment-list', function (Request $request) {

        $MaintenanceEvaluationVehicleDAO = new MaintenanceEvaluationVehicleDAO();
        $vehicleList = $MaintenanceEvaluationVehicleDAO->list($request);

        $maintenance_evaluation_id = session()->get('mevaluation_current_detail_id');
        $hasMaintenanceEvaluationDetail = MaintenanceEvaluation::find($maintenance_evaluation_id);

        $foremenList = $MaintenanceEvaluationVehicleDAO->foremenList();

        return view('maintenance.evaluation.ajax.maintenance-evaluation-vehicle-appointment-list', [
            'hasMaintenanceEvaluationDetail' => $hasMaintenanceEvaluationDetail,
            'vehicleList' => $vehicleList,
            'foremenList' => $foremenList
        ]);
    })->name('.vehicle-appointment.list');

    Route::post('/vehicle-appointment-assign', function(Request $request){

        $MaintenanceEvaluationVehicleDAO = new MaintenanceEvaluationVehicleDAO();
        switch ($request->assign_to) {
            case 'formen':
                $MaintenanceEvaluationVehicleDAO->assignToFormen($request);
                break;

            default:
                # code...
                break;
        }

    })->name('.vehicle-appointment-assign');

    Route::get('/vehicle-assessment-list', function (Request $request) {

        $MaintenanceEvaluationVehicleDAO = new MaintenanceEvaluationVehicleDAO();
        $vehicleList = $MaintenanceEvaluationVehicleDAO->list($request);

        $maintenance_evaluation_id = session()->get('mevaluation_current_detail_id');
        $hasMaintenanceEvaluationDetail = MaintenanceEvaluation::find($maintenance_evaluation_id);

        return view('maintenance.evaluation.ajax.maintenance-evaluation-vehicle-assessment-list', [
            'hasMaintenanceEvaluationDetail' => $hasMaintenanceEvaluationDetail,
            'vehicleList' => $vehicleList
        ]);
    })->name('.vehicle-assessment.list');

    Route::get('/vehicle-evaluation-list', function (Request $request) {

        $MaintenanceEvaluationVehicleDAO = new MaintenanceEvaluationVehicleDAO();
        $vehicleList = $MaintenanceEvaluationVehicleDAO->list($request);

        $maintenance_evaluation_id = session()->get('mevaluation_current_detail_id');
        $hasMaintenanceEvaluationDetail = MaintenanceEvaluation::find($maintenance_evaluation_id);

        return view('maintenance.evaluation.ajax.maintenance-evaluation-vehicle-evaluation-list', [
            'hasMaintenanceEvaluationDetail' => $hasMaintenanceEvaluationDetail,
            'vehicleList' => $vehicleList
        ]);
    })->name('.vehicle-evaluation.list');

    Route::get('/vehicle-generate-letter-list', function (Request $request) {

        $MaintenanceEvaluationVehicleDAO = new MaintenanceEvaluationVehicleDAO();
        $vehicleList = $MaintenanceEvaluationVehicleDAO->list($request);

        $maintenance_evaluation_id = session()->get('mevaluation_current_detail_id');
        $hasMaintenanceEvaluationDetail = MaintenanceEvaluation::find($maintenance_evaluation_id);

        return view('maintenance.evaluation.ajax.maintenance-evaluation-vehicle-generate-letter-list', [
            'hasMaintenanceEvaluationDetail' => $hasMaintenanceEvaluationDetail,
            'vehicleList' => $vehicleList
        ]);
    })->name('.vehicle-generate-letter.list');

    Route::post('/vehicle-proceedToMJob', function(Request $request){

        $MaintenanceEvaluationVehicleDAO = new MaintenanceEvaluationVehicleDAO();
        return $MaintenanceEvaluationVehicleDAO->proceedToMJob($request);

    })->name('.vehicle-proceedToMJob');

    Route::get('/vehicle-approval-list', function (Request $request) {

        $MaintenanceEvaluationVehicleDAO = new MaintenanceEvaluationVehicleDAO();
        $vehicleList = $MaintenanceEvaluationVehicleDAO->list($request);

        $maintenance_evaluation_id = session()->get('mevaluation_current_detail_id');
        $hasMaintenanceEvaluationDetail = MaintenanceEvaluation::find($maintenance_evaluation_id);

        return view('maintenance.evaluation.ajax.maintenance-evaluation-vehicle-approval-list', [
            'hasMaintenanceEvaluationDetail' => $hasMaintenanceEvaluationDetail,
            'vehicleList' => $vehicleList
        ]);
    })->name('.vehicle-approval.list');

    Route::get('/vehicle-certificate-list', function (Request $request) {
        $MaintenanceEvaluationVehicleDAO = new MaintenanceEvaluationVehicleDAO();
        $vehicleList = $MaintenanceEvaluationVehicleDAO->list($request);

        $assessment_accident_id = session()->get('mevaluation_current_detail_id');
        $hasMaintenanceEvaluationDetail = MaintenanceEvaluation::find($assessment_accident_id);

        return view('maintenance.evaluation.ajax.maintenance-evaluation-vehicle-certificate-list', [
            'hasMaintenanceEvaluationDetail' => $hasMaintenanceEvaluationDetail,
            'vehicleList' => $vehicleList
        ]);
    })->name('.vehicle-certificate.list');

    Route::post('/approval', function (Request $request) {
        $MaintenanceEvaluationDAO = new MaintenanceEvaluationDAO();
        return $MaintenanceEvaluationDAO->approval();
    })->name('.approval');

    Route::post('/approve', function (Request $request) {
        $MaintenanceEvaluationDAO = new MaintenanceEvaluationDAO();
        return $MaintenanceEvaluationDAO->approve();
    })->name('.approve');

    Route::get('/vehicle-maintenance-form', function(Request $request){
        $MaintenanceEvaluationVehicleDAO = new MaintenanceEvaluationVehicleDAO();
        $form = $MaintenanceEvaluationVehicleDAO->getForm($request);
        return view('maintenance.evaluation.evaluation-vehicle-checklist-form',$form);
    })->name('.vehicle-maintenance.form');

    Route::get('/vehicle-maintenance-loji-form', function(Request $request){
        $MaintenanceEvaluationVehicleDAO = new MaintenanceEvaluationVehicleDAO();
        $form = $MaintenanceEvaluationVehicleDAO->getForm($request);
        return view('maintenance.evaluation.evaluation-loji-vehicle-checklist-form',$form);
    })->name('.vehicle-maintenance-loji.form');

    Route::get('/vehicle-maintenance-letter', function(Request $request){
        $MaintenanceEvaluationVehicleDAO = new MaintenanceEvaluationVehicleDAO();
        $form = $MaintenanceEvaluationVehicleDAO->getLetter($request);
        return view('maintenance.evaluation.evaluation-vehicle-letter-form',$form);
    })->name('.vehicle-maintenance.letter');

    Route::get('/ajax-vehicle-maintenance-letter', function(Request $request){
        $MaintenanceEvaluationVehicleDAO = new MaintenanceEvaluationVehicleDAO();
        return $MaintenanceEvaluationVehicleDAO->getLetter($request);
    })->name('.ajax.vehicle-maintenance.letter');

    Route::post('/ajax-vehicle-maintenance-letter-field-save', function(Request $request){
        $MaintenanceEvaluationVehicleDAO = new MaintenanceEvaluationVehicleDAO();
        return $MaintenanceEvaluationVehicleDAO->saveLetterField($request);
    })->name('.ajax.vehicle-maintenance.letter.field.save');

    Route::post('/vehicle-maintenance-letter-save', function(Request $request){
        $MaintenanceEvaluationVehicleDAO = new MaintenanceEvaluationVehicleDAO();
        return $MaintenanceEvaluationVehicleDAO->saveLetter($request);
    })->name('.vehicle-maintenance.letter.save');

    Route::post('/vehicle-maintenance-exam-letter-save', function(Request $request){
        $MaintenanceEvaluationVehicleDAO = new MaintenanceEvaluationVehicleDAO();
        return $MaintenanceEvaluationVehicleDAO->saveExamLetter($request);
    })->name('.vehicle-maintenance.exam.letter.save');

    Route::post('/vehicle-maintenance-letter-verification', function(Request $request){
        $MaintenanceEvaluationVehicleDAO = new MaintenanceEvaluationVehicleDAO();
        return $MaintenanceEvaluationVehicleDAO->verificationLetter($request);
    })->name('.vehicle-maintenance.letter.verification');

    Route::post('/vehicle-maintenance-letter-approval', function(Request $request){
        $MaintenanceEvaluationVehicleDAO = new MaintenanceEvaluationVehicleDAO();
        return $MaintenanceEvaluationVehicleDAO->approvalLetter($request);
    })->name('.vehicle-maintenance.letter.approval');

    Route::post('/vehicle-maintenance-letter-approve', function(Request $request){
        $MaintenanceEvaluationVehicleDAO = new MaintenanceEvaluationVehicleDAO();
        return $MaintenanceEvaluationVehicleDAO->approveLetter($request);
    })->name('.vehicle-maintenance.letter.approve');

    Route::post('/vehicle-maintenance-letter-checklist-save', function(Request $request){
        $MaintenanceEvaluationVehicleDAO = new MaintenanceEvaluationVehicleDAO();
        return $MaintenanceEvaluationVehicleDAO->saveLetterCheckList($request);
    })->name('.vehicle-maintenance.letter.checklist.save');

    Route::post('/vehicle-maintenance-letter-checklist-delete', function(Request $request){
        $MaintenanceEvaluationVehicleDAO = new MaintenanceEvaluationVehicleDAO();
        return $MaintenanceEvaluationVehicleDAO->deleteLetterCheckList($request);
    })->name('.vehicle-maintenance.letter.checklist.delete');

    Route::get('/vehicle-maintenance-letter-checklist-list', function(Request $request){
        $MaintenanceEvaluationVehicleDAO = new MaintenanceEvaluationVehicleDAO();
        $letterCheckList = $MaintenanceEvaluationVehicleDAO->getLetterCheckList($request);
        return view('maintenance.evaluation.ajax.maintenance-evaluation-vehicle-letter-checklist-list', [
            'letterCheckList' => $letterCheckList,
            'is_preview' => $request->is_preview
        ]);
    })->name('.vehicle-maintenance.letter.checklist.list');

    Route::post('/vehicle-delete', function(Request $request){
        $MaintenanceEvaluationVehicleDAO = new MaintenanceEvaluationVehicleDAO();
        return  $MaintenanceEvaluationVehicleDAO->delete($request);
    })->name('.vehicle.delete');

    Route::post('/vehicle-updateStatus', function(Request $request){
        $MaintenanceEvaluationVehicleDAO = new MaintenanceEvaluationVehicleDAO();
        return  $MaintenanceEvaluationVehicleDAO->updateStatus($request);
    })->name('.vehicle.updateStatus');

    Route::get('/vehicle-getVehicleForm', function(Request $request){
        $MaintenanceEvaluationVehicleDAO = new MaintenanceEvaluationVehicleDAO();
        return $MaintenanceEvaluationVehicleDAO->getVehicleForm($request);
    })->name('.vehicle.getVehicleForm');

    Route::get('/vehicle-report', function (Request $request) {
        $MaintenanceEvaluationVehicleDAO = new MaintenanceEvaluationVehicleDAO();
        if($request->vehicle_id){
            $detail = MaintenanceEvaluationVehicle::find($request->vehicle_id);
        } else {
            $detail = $MaintenanceEvaluationVehicleDAO->searchByPlateNo($request);
        }
        return view('maintenance.evaluation.report.eval-report-form', [
            'detail' => $detail
        ]);
    })->name('.vehicle.report');

    Route::post('/vehicle-assignAppointment', function(Request $request){
        $MaintenanceEvaluationVehicleDAO = new MaintenanceEvaluationVehicleDAO();
        $MaintenanceEvaluationVehicleDAO->assignAppointment($request);
    })->name('.vehicle.assignAppointment');

    Route::post('/delete', function(Request $request){
        $MaintenanceEvaluationDAO = new MaintenanceEvaluationDAO();
        return  $MaintenanceEvaluationDAO->delete($request);
    })->name('.delete');

    Route::post('/cancel', function(Request $request){
        $MaintenanceEvaluationDAO = new MaintenanceEvaluationDAO();
        return  $MaintenanceEvaluationDAO->cancel($request);
    })->name('.cancel');

    Route::post('/reject', function (Request $request) {
        $MaintenanceEvaluationDAO = new MaintenanceEvaluationDAO();
        return $MaintenanceEvaluationDAO->reject();
    })->name('.reject');

});


?>
