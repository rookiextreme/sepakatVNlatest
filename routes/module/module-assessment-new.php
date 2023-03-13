<?php

use App\Http\Controllers\Assessment\New\AssessmentNewDAO;
use App\Http\Controllers\Assessment\New\Vehicle\AssessmentNewVehicleDAO;
use App\Models\Assessment\AssessmentNew;
use App\Models\Assessment\AssessmentNewVehicle;
use App\Models\Assessment\AssessmentOwnership;
use App\Models\RefAgency;
use App\Models\RefCategory;
use App\Models\RefComponentChecklistLvl1;
use App\Models\RefSetting;
use App\Models\RefSettingSub;
use App\Models\RefState;
use App\Models\RefWorkshop;
use App\Models\Vehicle\Brand;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

Route::group(['prefix' => 'new', 'as' => '.new', 'middleware' => 'auth'], function(){

    Route::get('/list', function(Request $request){

        $AssessmentNewDAO = new AssessmentNewDAO();
        $newList = $AssessmentNewDAO->list($request);

        return view('assessment.new.new-list', [
            'news' => $newList,
        ]);

    })->name('.list');

    Route::get('/register', function (Request $request) {

        $AssessmentNewDAO = new AssessmentNewDAO();
        $detail = $AssessmentNewDAO->read($request);
        $agency_list = RefAgency::orderBy('desc')->get();
        // $workshop_list = RefWorkshop::orderByRaw('code=\'01\'')->get()->reverse();
        $workshop_list = RefWorkshop::orderBy('id')->get();
        $category_list = RefCategory::all();
        $brand_list = Brand::where('status', 1)->orderBy('name')->get();
        $owner_list = AssessmentOwnership::all();
        $state_list = RefState::all();
        $AssessmentNewVehicleDAO = new AssessmentNewVehicleDAO();
        $vehicleList = $AssessmentNewVehicleDAO->list($request);

        $RefComponentChecklistLvl1 = RefComponentChecklistLvl1::whereHas('hasAssessmentType', function($q){
            $q->where('code', '01');
        });

        return view('assessment.new.new-register', [
            'detail' => $detail,
            'agency_list' => $agency_list,
            'workshop_list' => $workshop_list,
            'category_list' => $category_list,
            'brand_list' => $brand_list,
            'owner_list' => $owner_list,
            'RefComponentChecklistLvl1' => $RefComponentChecklistLvl1->get(),
            'state_list' => $state_list,
            'vehicleList' => $vehicleList,
        ]);

    })->name('.register');

    Route::post('/register-save', function (Request $request) {

        $section = $request->section;
        $AssessmentNewDAO = new AssessmentNewDAO();
        switch ($section) {
            case 'detail':
                return $AssessmentNewDAO->upsert($request);
                break;
            case 'verify':
                return $AssessmentNewDAO->verify($request);
                break;
            case 'examination':
                return $AssessmentNewDAO->examination();
                break;
            case 'set_appointment':
                return $AssessmentNewDAO->setAppointment($request);
                break;
        }
        return view('assessment.new.new-register');
    })->name('.register.save');

    Route::post('/verification', function (Request $request) {
        $AssessmentNewDAO = new AssessmentNewDAO();
        return $AssessmentNewDAO->verification();
    })->name('.verification');

    Route::post('/approval', function (Request $request) {
        $AssessmentNewDAO = new AssessmentNewDAO();
        return $AssessmentNewDAO->approval($request);
    })->name('.approval');

    Route::post('/approve', function (Request $request) {
        $AssessmentNewDAO = new AssessmentNewDAO();
        return $AssessmentNewDAO->approve();
    })->name('.approve');

    Route::post('/reject', function (Request $request) {
        $AssessmentNewDAO = new AssessmentNewDAO();
        return $AssessmentNewDAO->reject();
    })->name('.reject');

    Route::post('/delete', function(Request $request){
        $AssessmentNewDAO = new AssessmentNewDAO();
        return  $AssessmentNewDAO->delete($request);
    })->name('.delete');

    Route::post('/cancel', function(Request $request){
        $AssessmentNewDAO = new AssessmentNewDAO();
        return  $AssessmentNewDAO->cancel($request);
    })->name('.cancel');

    Route::post('/vehicle-checkExistRegNumber', function(Request $request){
        $response = [
            'data' => null,
            'status' => 0,
        ];

        $queryRegNumberIsExisted = AssessmentNewVehicle::where('plate_no', $request->plate_no)
        ->whereHas('hasAssessmentDetail', function($q){
            $q->whereHas('hasStatus', function($q2){
                $q2->whereNotIn('code', ['00','06','07','08']);
            });
        });
        if($request->vehicle_id){
            $queryRegNumberIsExisted->where('id', '!=', $request->vehicle_id);
        }
        if($queryRegNumberIsExisted->first()){
            $response['status'] = 1;
            $response['data'] = $queryRegNumberIsExisted->first();
            return $response;
        }
        else{
            $response['status'] = 0;
            $response['data'] = null;
        }
        // Log::info($queryRegNumberIsExisted->toSql());
        // return $queryRegNumberIsExisted->first() ? 1 : 0;
        return $response;
    })->name('.vehicle.checkExistRegNumber');

    Route::post('/vehicle-save', function (Request $request) {
        $AssessmentNewVehicleDAO = new AssessmentNewVehicleDAO();
        return $AssessmentNewVehicleDAO->upsert($request);
    })->name('.vehicle.save');

    Route::get('/vehicle-list', function (Request $request) {

        $AssessmentNewVehicleDAO = new AssessmentNewVehicleDAO();
        $vehicleList = $AssessmentNewVehicleDAO->list($request);

        $assessment_new_id = session()->get('new_current_detail_id');
        $hasAssessmentNewDetail = AssessmentNew::find($assessment_new_id);

        $category_list = RefCategory::all();
        $brand_list = Brand::where('status', 1)->orderBy('name')->get();

        return view('assessment.new.ajax.assessment-new-vehicle-list', [
            'hasAssessmentNewDetail' => $hasAssessmentNewDetail,
            'category_list' => $category_list,
            'brand_list' => $brand_list,
            'vehicleList' => $vehicleList,
            'assessment_new_id' => $assessment_new_id
        ]);
    })->name('.vehicle.list');

    Route::get('/vehicle-appointment-list', function (Request $request) {

        $AssessmentNewVehicleDAO = new AssessmentNewVehicleDAO();
        $response = $AssessmentNewVehicleDAO->listAppointment($request);

        $vehicleList = $response['list'];
        $totalPrice = $response['totalPrice'];

        $assessment_new_id = session()->get('new_current_detail_id');
        $hasAssessmentNewDetail = AssessmentNew::find($assessment_new_id);

        $foremenList = $AssessmentNewVehicleDAO->foremenList();

        return view('assessment.new.ajax.assessment-new-vehicle-appointment-list', [
            'hasAssessmentNewDetail' => $hasAssessmentNewDetail,
            'vehicleList' => $vehicleList,
            'totalPrice' => $totalPrice,
            'foremenList' => $foremenList,
            'assessment_new_id' => $assessment_new_id
        ]);

    })->name('.vehicle-appointment.list');

    Route::post('/vehicle-appointment-updatePrice', function(Request $request){

        $AssessmentNewVehicleDAO = new AssessmentNewVehicleDAO();
        $AssessmentNewVehicleDAO->updatePrice($request);

    })->name('.vehicle-appointment-updatePrice');

    Route::post('/vehicle-appointment-assign', function(Request $request){

        $AssessmentNewVehicleDAO = new AssessmentNewVehicleDAO();
        switch ($request->assign_to) {
            case 'formen':
                $AssessmentNewVehicleDAO->assignToFormen($request);
                break;

            default:
                # code...
                break;
        }

    })->name('.vehicle-appointment-assign');

    Route::get('/vehicle-assessment-list', function (Request $request) {

        $AssessmentNewVehicleDAO = new AssessmentNewVehicleDAO();
        $vehicleList = $AssessmentNewVehicleDAO->list($request);

        $assessment_new_id = session()->get('new_current_detail_id');
        $hasAssessmentNewDetail = AssessmentNew::find($assessment_new_id);

        return view('assessment.new.ajax.assessment-new-vehicle-assessment-list', [
            'hasAssessmentNewDetail' => $hasAssessmentNewDetail,
            'vehicleList' => $vehicleList,
            'assessment_new_id' => $assessment_new_id,
            'status_code' => $request->status_code ? $request->status_code : 'all_inprogress',
        ]);
    })->name('.vehicle-assessment.list');

    Route::get('/vehicle-approval-list', function (Request $request) {

        $AssessmentNewVehicleDAO = new AssessmentNewVehicleDAO();
        $vehicleList = $AssessmentNewVehicleDAO->listApproval($request);

        $assessment_new_id = session()->get('new_current_detail_id');
        $hasAssessmentNewDetail = AssessmentNew::find($assessment_new_id);

        return view('assessment.new.ajax.assessment-new-vehicle-approval-list', [
            'hasAssessmentNewDetail' => $hasAssessmentNewDetail,
            'vehicleList' => $vehicleList,
            'assessment_new_id' => $assessment_new_id
        ]);
    })->name('.vehicle-approval.list');

    Route::get('/vehicle-evaluation-list', function (Request $request) {

        $AssessmentNewVehicleDAO = new AssessmentNewVehicleDAO();
        $vehicleList = $AssessmentNewVehicleDAO->listEvaluation($request);

        $assessment_new_id = session()->get('new_current_detail_id');
        $hasAssessmentNewDetail = AssessmentNew::find($assessment_new_id);

        return view('assessment.new.ajax.assessment-new-vehicle-evaluation-list', [
            'hasAssessmentNewDetail' => $hasAssessmentNewDetail,
            'vehicleList' => $vehicleList,
            'assessment_new_id' => $assessment_new_id,
            'status_code' => $request->status_code ? $request->status_code : 'all_inprogress',
        ]);
    })->name('.vehicle-evaluation.list');

    Route::post('/vehicle-evaluation-save-receipt', function (Request $request) {

        $AssessmentNewDAO = new AssessmentNewDAO();
        $AssessmentNewDAO->saveReceipt($request);

    })->name('.vehicle-evaluation.save-receipt');

    Route::get('/vehicle-certificate-list', function (Request $request) {
        $AssessmentNewVehicleDAO = new AssessmentNewVehicleDAO();
        $vehicleList = $AssessmentNewVehicleDAO->listCertificate($request);
        $assessment_new_id = session()->get('new_current_detail_id');
        $hasAssessmentNewDetail = AssessmentNew::find($assessment_new_id);

        // $allowToUDATECert = false;
        // $querySetting = RefSettingSub::whereHas('getSetting', function($q){
        //     $q->where('code', '04');
        // })->where('code', '01');
        // if($querySetting->first()){
        //     $allowToUDATECert = true;
        // }

        return view('assessment.new.ajax.assessment-new-vehicle-certificate-list', [
            'hasAssessmentNewDetail' => $hasAssessmentNewDetail,
            'vehicleList' => $vehicleList,
            'assessment_new_id' => $assessment_new_id
        ]);
    })->name('.vehicle-certificate.list');

    // Route::get('/vehicle-certificate-checkGenuine', function (Request $request) {
    //     $AssessmentNewVehicleDAO = new AssessmentNewVehicleDAO();
    //     $detail = $AssessmentNewVehicleDAO->checkGenuine($request);
    //     return view('assessment.new.new-vehicle-certificate-check-genuine', [
    //         'detail' => $detail
    //     ]);
    // })->name('.vehicle-certificate.checkGenuine');

    Route::get('/vehicle-assessment-form', function(Request $request){
        $AssessmentNewVehicleDAO = new AssessmentNewVehicleDAO();
        $form = $AssessmentNewVehicleDAO->getForm($request);
        return view('assessment.new.new-vehicle-checklist-form',$form, [
            'status_code' => $request->status_code ? $request->status_code : 'all_inprogress'
        ]);

    })->name('.vehicle-assessment.form');

    Route::post('/vehicle-assessment-form-save', function(Request $request){
        $AssessmentNewVehicleDAO = new AssessmentNewVehicleDAO();
        return  $AssessmentNewVehicleDAO->saveForm($request);
    })->name('.vehicle-assessment.form.save');

    Route::post('/vehicle-assessment-form-file-save', function(Request $request){
        $AssessmentNewVehicleDAO = new AssessmentNewVehicleDAO();
        return  $AssessmentNewVehicleDAO->saveFormFile($request);
    })->name('.vehicle-assessment.form-file.save');

    Route::post('/vehicle-assessment-form-file-delete`', function(Request $request){
        $AssessmentNewVehicleDAO = new AssessmentNewVehicleDAO();
        return  $AssessmentNewVehicleDAO->deleteFormFile($request);
    })->name('.vehicle-assessment.form-file.delete');

    Route::post('/vehicle-assessment-saveDocument-save', function(Request $request){
        $AssessmentNewVehicleDAO = new AssessmentNewVehicleDAO();
        return  $AssessmentNewVehicleDAO->saveDocument($request);
    })->name('.vehicle-assessment.saveDocument.save');

    Route::post('/deleteRelatedDoc', function(Request $request){
        $AssessmentNewVehicleDAO = new AssessmentNewVehicleDAO();
        return  $AssessmentNewVehicleDAO->deleteRelatedDoc($request);
    })->name('.deleteRelatedDoc');

    Route::get('/vehicle-assessment-viewCertificate', function(Request $request){
        $AssessmentNewVehicleDAO = new AssessmentNewVehicleDAO();
        $response = $AssessmentNewVehicleDAO->viewCertificate($request);
        return view('assessment.new.new-vehicle-certificate', $response);
    })->name('.vehicle-assessment.viewCertificate');

    Route::post('/vehicle-delete', function(Request $request){
        $AssessmentNewVehicleDAO = new AssessmentNewVehicleDAO();
        return  $AssessmentNewVehicleDAO->delete($request);
    })->name('.vehicle.delete');

    Route::post('/vehicle-cancel', function(Request $request){
        $AssessmentNewVehicleDAO = new AssessmentNewVehicleDAO();
        return  $AssessmentNewVehicleDAO->cancel($request);
    })->name('.vehicle.cancel');

    Route::post('/vehicle-updateStatus', function(Request $request){
        $AssessmentNewVehicleDAO = new AssessmentNewVehicleDAO();
        return  $AssessmentNewVehicleDAO->updateStatus($request);
    })->name('.vehicle.updateStatus');

    Route::get('/vehicle-getVehicleForm', function(Request $request){
        $AssessmentNewVehicleDAO = new AssessmentNewVehicleDAO();
        return $AssessmentNewVehicleDAO->getVehicleForm($request);
    })->name('.vehicle.getVehicleForm');

    Route::get('/vehicle-getCertificateDetails', function(Request $request){
        $AssessmentNewVehicleDAO = new AssessmentNewVehicleDAO();
        return $AssessmentNewVehicleDAO->getCertificateDetails($request);
    })->name('.vehicle.getCertificateDetails');

    Route::post('/vehicle-editCertificate-save', function(Request $request){
        $AssessmentNewVehicleDAO = new AssessmentNewVehicleDAO();
        return $AssessmentNewVehicleDAO->editCertificateSave($request);
    })->name('.vehicle.editCertificate.save');

});



?>
