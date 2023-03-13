<?php

use App\Http\Controllers\Assessment\Safety\AssessmentSafetyDAO;
use App\Http\Controllers\Assessment\Safety\Vehicle\AssessmentSafetyVehicleDAO;
use App\Http\Controllers\Helpers\HelpersFunction;
use App\Models\Assessment\AssessmentSafetyVehicle;
use App\Models\Assessment\AssessmentOwnership;
use App\Models\Assessment\AssessmentSafety;
use App\Models\Fleet\FleetDepartment;
use App\Models\RefAgency;
use App\Models\RefCategory;
use App\Models\RefComponentChecklistLvl1;
use App\Models\RefSettingSub;
use App\Models\RefState;
use App\Models\RefWorkshop;
use App\Models\Vehicle\Brand;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::group(['prefix' => 'safety', 'as' => '.safety', 'middleware' => 'auth'], function(){

    Route::get('/list', function(Request $request){


        $AssessmentSafetyDAO = new AssessmentSafetyDAO();

        $safetyList = $AssessmentSafetyDAO->list($request);

        return view('assessment.safety.safety-list', [
            'safetys' => $safetyList,
        ]);

    })->name('.list');

    Route::get('/register', function (Request $request) {

        $AssessmentSafetyDAO = new AssessmentSafetyDAO();
        $detail = $AssessmentSafetyDAO->read($request);
        $agency_list = RefAgency::orderBy('desc')->get();
        // $workshop_list = RefWorkshop::orderByRaw('code=\'01\'')->get()->reverse();
        $workshop_list = RefWorkshop::orderBy('code')->get(); //by default ascending
        $category_list = RefCategory::all();
        $brand_list = Brand::where('status', 1)->orderBy('name')->get();
        $owner_list = AssessmentOwnership::all();
        $state_list = RefState::all();

        $RefComponentChecklistLvl1 = RefComponentChecklistLvl1::whereHas('hasAssessmentType', function($q){
            $q->where('code', '01');
        });

        return view('assessment.safety.safety-register', [
            'detail' => $detail,
            'agency_list' => $agency_list,
            'workshop_list' => $workshop_list,
            'category_list' => $category_list,
            'brand_list' => $brand_list,
            'owner_list' => $owner_list,
            'RefComponentChecklistLvl1' => $RefComponentChecklistLvl1->get(),
            'state_list' => $state_list,
        ]);

    })->name('.register');

    Route::post('/register-save', function (Request $request) {

        $section = $request->section;
        $AssessmentSafetyDAO = new AssessmentSafetyDAO();
        switch ($section) {
            case 'detail':
                return $AssessmentSafetyDAO->upsert($request);
                break;
            case 'verify':
                return $AssessmentSafetyDAO->verify($request);
                break;
            case 'examination':
                return $AssessmentSafetyDAO->examination();
                break;
            case 'set_appointment':
                return $AssessmentSafetyDAO->setAppointment($request);
                break;
        }
        return view('assessment.safety.safety-register');
    })->name('.register.save');

    Route::post('/verification', function (Request $request) {
        $AssessmentSafetyDAO = new AssessmentSafetyDAO();
        return $AssessmentSafetyDAO->verification();
    })->name('.verification');

    Route::post('/approval', function (Request $request) {
        $AssessmentSafetyDAO = new AssessmentSafetyDAO();
        return $AssessmentSafetyDAO->approval($request);
    })->name('.approval');

    Route::post('/approve', function (Request $request) {
        $AssessmentSafetyDAO = new AssessmentSafetyDAO();
        return $AssessmentSafetyDAO->approve();
    })->name('.approve');

    Route::post('/reject', function (Request $request) {
        $AssessmentSafetyDAO = new AssessmentSafetyDAO();
        return $AssessmentSafetyDAO->reject();
    })->name('.reject');

    Route::post('/delete', function(Request $request){
        $AssessmentSafetyDAO = new AssessmentSafetyDAO();
        return  $AssessmentSafetyDAO->delete($request);
    })->name('.delete');

    Route::post('/cancel', function(Request $request){
        $AssessmentSafetyDAO = new AssessmentSafetyDAO();
        return  $AssessmentSafetyDAO->cancel($request);
    })->name('.cancel');

    // Route::post('/vehicle-checkExistRegNumber', function(Request $request){

    //     $check = AssessmentSafetyVehicle::where('plate_no', $request->plate_no)
    //             ->whereHas('hasAssessmentDetail', function($q){
    //                 $q->whereHas('hasStatus', function($q2){
    //                     $q2->whereIn('code', ['01','02', '03', '04', '05']);
    //                 });
    //             })->first();

    //     if($check){
    //         return 1;
    //     }else{
    //         if(auth()->user()->isPublic()){
    //             $queryRegNumberIsExisted = AssessmentSafetyVehicle::where('plate_no', $request->plate_no)
    //             ->whereHas('hasAssessmentDetail', function($q){
    //                 $q->whereHas('hasStatus', function($q2){
    //                     $q2->whereNotIn('code', ['01','02', '03', '04', '05']);
    //                 });
    //             });
    //         }else{
    //             $queryRegNumberIsExisted = FleetDepartment::where('no_pendaftaran', $request->plate_no)
    //                 ->where('disaster_ready', false)
    //                 ->whereHas('hasVehicleStatus', function($q){
    //                     $q->whereNotIn('code', ['02', '03', '04']);
    //                 });
    //             ;
    //         }
    //         if($request->vehicle_id){
    //             $queryRegNumberIsExisted->where('id', '!=', $request->vehicle_id);
    //         }
    //         Log::info($queryRegNumberIsExisted->toSql());
    //         return $queryRegNumberIsExisted->first();
    //     }
    // })->name('.vehicle.checkExistRegNumber');

    Route::post('/vehicle-checkExistRegNumber', function(Request $request){

        $response = [
            'data' => null,
            'status' => 0,
        ];

        $HelpersFunction = new HelpersFunction();
        $checkingVehicleInAssessment = $HelpersFunction->checkingVehicleInAssessment($request->plate_no, $request->assessment_type);

        // $check = AssessmentSafetyVehicle::where('plate_no', $request->plate_no)
        //         ->whereHas('hasAssessmentVehicleStatus', function($q){
        //             $q->whereNotIn('code', ['00']);
        //             })->whereHas('hasAssessmentDetail.hasStatus', function($q1){
        //                 $q1->whereIn('code', ['01','02', '03', '04', '05']);
        //         });
        //         Log::info('toSql() '.$check->toSql());
        //         Log::info('getBindings() ',$check->getBindings());
        if(count($checkingVehicleInAssessment) > 0){
            $response['status'] = 1;
            $response['data'] = $checkingVehicleInAssessment->first();
            return $response;
        }else{
            $checkingVehicleEverEvaluated = $HelpersFunction->checkingVehicleEverEvaluated($request->plate_no, $request->assessment_type);
            // $check = AssessmentSafetyVehicle::where('plate_no', $request->plate_no)
            //     ->whereHas('hasAssessmentVehicleStatus', function($q){
            //         $q->whereIn('code', ['06']);
            //         })->whereHas('hasAssessmentDetail.hasStatus', function($q1){
            //             $q1->whereNotIn('code', ['00']);
            //     });

            //     Log::info('toSql() '.$check->toSql());
            //     Log::info('getBindings() ',$check->getBindings());

            if(count($checkingVehicleEverEvaluated) > 0){
                Log::info("atas");
                $response['status'] = 2;
                $response['data'] = $checkingVehicleEverEvaluated->first();
                return $response;

            } else {
                Log::info("bawah");
                $response['status'] = 0;

                if(auth()->user()->isPublic()){
                    $queryRegNumberIsExisted = AssessmentSafetyVehicle::where('plate_no', $request->plate_no)
                    ->whereHas('hasAssessmentVehicleStatus', function($q){
                            $q->whereNotIn('code', ['00']);
                        })->whereHas('hasAssessmentDetail.hasStatus', function($q1){
                            $q1->whereNotIn('code', ['01','02', '03', '04', '05']);
                    });
                }else{
                    $queryRegNumberIsExisted = FleetDepartment::where('no_pendaftaran', $request->plate_no)
                        ->where('disaster_ready', false)
                        ->whereHas('hasVehicleStatus', function($q){
                            $q->whereNotIn('code', ['02', '03', '04']);
                        });

                }
                if($request->vehicle_id){
                    $queryRegNumberIsExisted->where('id', '!=', $request->vehicle_id);
                }

                $response['data'] = $queryRegNumberIsExisted->first();
                return $response;

            }
        }

    })->name('.vehicle.checkExistRegNumber');

    Route::post('/vehicle-save', function (Request $request) {
        $AssessmentSafetyVehicleDAO = new AssessmentSafetyVehicleDAO();
        return $AssessmentSafetyVehicleDAO->upsert($request);
    })->name('.vehicle.save');

    Route::get('/vehicle-list', function (Request $request) {

        // $carbon = new Carbon();
        // $carbon->setLocale('ms');

        $AssessmentSafetyVehicleDAO = new AssessmentSafetyVehicleDAO();
        $vehicleList = $AssessmentSafetyVehicleDAO->list($request);

        $assessment_safety_id = session()->get('safety_current_detail_id');
        $hasAssessmentSafetyDetail = AssessmentSafety::find($assessment_safety_id);

        $category_list = RefCategory::all();
        $brand_list = Brand::where('status', 1)->orderBy('name')->get();

        return view('assessment.safety.ajax.assessment-safety-vehicle-list', [
            'hasAssessmentSafetyDetail' => $hasAssessmentSafetyDetail,
            'category_list' => $category_list,
            'brand_list' => $brand_list,
            'vehicleList' => $vehicleList,
            'assessment_safety_id' => $assessment_safety_id
        ]);
    })->name('.vehicle.list');

    Route::get('/vehicle-appointment-list', function (Request $request) {

        $AssessmentSafetyVehicleDAO = new AssessmentSafetyVehicleDAO();
        $vehicleList = $AssessmentSafetyVehicleDAO->listAppointment($request);

        $assessment_safety_id = session()->get('safety_current_detail_id');
        $hasAssessmentSafetyDetail = AssessmentSafety::find($assessment_safety_id);

        $foremenList = $AssessmentSafetyVehicleDAO->foremenList();

        return view('assessment.safety.ajax.assessment-safety-vehicle-appointment-list', [
            'hasAssessmentSafetyDetail' => $hasAssessmentSafetyDetail,
            'vehicleList' => $vehicleList,
            'foremenList' => $foremenList,
            'assessment_safety_id' => $assessment_safety_id
        ]);
    })->name('.vehicle-appointment.list');

    Route::post('/vehicle-appointment-assign', function(Request $request){

        $AssessmentSafetyVehicleDAO = new AssessmentSafetyVehicleDAO();
        switch ($request->assign_to) {
            case 'formen':
                $AssessmentSafetyVehicleDAO->assignToFormen($request);
                break;

            default:
                # code...
                break;
        }

    })->name('.vehicle-appointment-assign');

    Route::get('/vehicle-assessment-list', function (Request $request) {

        $AssessmentSafetyVehicleDAO = new AssessmentSafetyVehicleDAO();
        $vehicleList = $AssessmentSafetyVehicleDAO->list($request);

        $assessment_safety_id = session()->get('safety_current_detail_id');
        $hasAssessmentSafetyDetail = AssessmentSafety::find($assessment_safety_id);

        return view('assessment.safety.ajax.assessment-safety-vehicle-assessment-list', [
            'hasAssessmentSafetyDetail' => $hasAssessmentSafetyDetail,
            'vehicleList' => $vehicleList,
            'assessment_safety_id' => $assessment_safety_id
        ]);
    })->name('.vehicle-assessment.list');

    Route::get('/vehicle-approval-list', function (Request $request) {

        $AssessmentSafetyVehicleDAO = new AssessmentSafetyVehicleDAO();
        $vehicleList = $AssessmentSafetyVehicleDAO->listApproval($request);

        $assessment_safety_id = session()->get('safety_current_detail_id');
        $hasAssessmentSafetyDetail = AssessmentSafety::find($assessment_safety_id);

        return view('assessment.safety.ajax.assessment-safety-vehicle-approval-list', [
            'hasAssessmentSafetyDetail' => $hasAssessmentSafetyDetail,
            'vehicleList' => $vehicleList,
            'assessment_safety_id' => $assessment_safety_id
        ]);
    })->name('.vehicle-approval.list');

    Route::get('/vehicle-evaluation-list', function (Request $request) {

        $AssessmentSafetyVehicleDAO = new AssessmentSafetyVehicleDAO();
        $vehicleList = $AssessmentSafetyVehicleDAO->listEvaluation($request);

        $assessment_safety_id = session()->get('safety_current_detail_id');
        $hasAssessmentSafetyDetail = AssessmentSafety::find($assessment_safety_id);

        return view('assessment.safety.ajax.assessment-safety-vehicle-evaluation-list', [
            'hasAssessmentSafetyDetail' => $hasAssessmentSafetyDetail,
            'vehicleList' => $vehicleList,
            'assessment_safety_id' => $assessment_safety_id,
            'status_code' => $request->status_code ? $request->status_code : 'all_inprogress',
        ]);
    })->name('.vehicle-evaluation.list');

    Route::get('/vehicle-certificate-list', function (Request $request) {
        $AssessmentSafetyVehicleDAO = new AssessmentSafetyVehicleDAO();
        $vehicleList = $AssessmentSafetyVehicleDAO->listCertificate($request);

        $assessment_safety_id = session()->get('safety_current_detail_id');
        $hasAssessmentSafetyDetail = AssessmentSafety::find($assessment_safety_id);

        // $allowToUDATECert = false;
        // $querySetting = RefSettingSub::whereHas('getSetting', function($q){
        //     $q->where('code', '04');
        // })->where('code', '02');
        // if($querySetting->first()){
        //     $allowToUDATECert = true;
        // }

        return view('assessment.safety.ajax.assessment-safety-vehicle-certificate-list', [
            'hasAssessmentSafetyDetail' => $hasAssessmentSafetyDetail,
            'vehicleList' => $vehicleList,
            'assessment_safety_id' => $assessment_safety_id
        ]);
    })->name('.vehicle-certificate.list');

    Route::get('/vehicle-checklist-failed', function (Request $request) {

        $AssessmentSafetyVehicleDAO = new AssessmentSafetyVehicleDAO();

        $list = $AssessmentSafetyVehicleDAO->checkListFailed($request);

        return view('assessment.safety.ajax.assessment-safety-vehicle-certificate-checklist-failed', [
            'list' => $list
        ]);

    })->name('.vehicle.checklist.failed');

    // Route::get('/vehicle-certificate-checkGenuine', function (Request $request) {
    //     $AssessmentSafetyVehicleDAO = new AssessmentSafetyVehicleDAO();
    //     $detail = $AssessmentSafetyVehicleDAO->checkGenuine($request);
    //     return view('assessment.safety.safety-vehicle-certificate-check-genuine', [
    //         'detail' => $detail
    //     ]);
    // })->name('.vehicle-certificate.checkGenuine');

    Route::get('/vehicle-assessment-form', function(Request $request){
        $AssessmentSafetyVehicleDAO = new AssessmentSafetyVehicleDAO();
        $form = $AssessmentSafetyVehicleDAO->getForm($request);
        return view('assessment.safety.safety-vehicle-checklist-form',$form);
    })->name('.vehicle-assessment.form');

    Route::get('/vehicle-assessment-form-mockup', function(Request $request){
        $AssessmentSafetyVehicleDAO = new AssessmentSafetyVehicleDAO();
        $form = $AssessmentSafetyVehicleDAO->getForm($request);
        return view('assessment.safety.safety-vehicle-checklist-form-mockup',$form);
    })->name('.vehicle-assessment.form.mockup');

    Route::post('/vehicle-assessment-form-save', function(Request $request){
        $AssessmentSafetyVehicleDAO = new AssessmentSafetyVehicleDAO();
        return  $AssessmentSafetyVehicleDAO->saveForm($request);
    })->name('.vehicle-assessment.form.save');

    Route::post('/vehicle-assessment-form-file-save', function(Request $request){
        $AssessmentSafetyVehicleDAO = new AssessmentSafetyVehicleDAO();
        return  $AssessmentSafetyVehicleDAO->saveFormFile($request);
    })->name('.vehicle-assessment.form-file.save');

    Route::post('/vehicle-assessment-form-file-delete`', function(Request $request){
        $AssessmentSafetyVehicleDAO = new AssessmentSafetyVehicleDAO();
        return  $AssessmentSafetyVehicleDAO->deleteFormFile($request);
    })->name('.vehicle-assessment.form-file.delete');

    Route::get('/vehicle-assessment-viewCertificate', function(Request $request){
        $AssessmentSafetyVehicleDAO = new AssessmentSafetyVehicleDAO();
        $response = $AssessmentSafetyVehicleDAO->viewCertificate($request);
        return view('assessment.safety.safety-vehicle-certificate', $response);
    })->name('.vehicle-assessment.viewCertificate');

    Route::post('/vehicle-delete', function(Request $request){
        $AssessmentSafetyVehicleDAO = new AssessmentSafetyVehicleDAO();
        return  $AssessmentSafetyVehicleDAO->delete($request);
    })->name('.vehicle.delete');

    Route::post('/vehicle-cancel', function(Request $request){
        $AssessmentSafetyVehicleDAO = new AssessmentSafetyVehicleDAO();
        return  $AssessmentSafetyVehicleDAO->cancel($request);
    })->name('.vehicle.cancel');

    Route::post('/vehicle-updateStatus', function(Request $request){
        $AssessmentSafetyVehicleDAO = new AssessmentSafetyVehicleDAO();
        return  $AssessmentSafetyVehicleDAO->updateStatus($request);
    })->name('.vehicle.updateStatus');

    Route::get('/vehicle-getVehicleForm', function(Request $request){
        $AssessmentSafetyVehicleDAO = new AssessmentSafetyVehicleDAO();
        return $AssessmentSafetyVehicleDAO->getVehicleForm($request);
    })->name('.vehicle.getVehicleForm');

    Route::post('/vehicle-assignAppointment', function(Request $request){
        $AssessmentSafetyVehicleDAO = new AssessmentSafetyVehicleDAO();
        $AssessmentSafetyVehicleDAO->assignAppointment($request);
    })->name('.vehicle.assignAppointment');

    Route::get('/vehicle-getCertificateDetails', function(Request $request){
        $AssessmentSafetyVehicleDAO = new AssessmentSafetyVehicleDAO();
        return $AssessmentSafetyVehicleDAO->getCertificateDetails($request);
    })->name('.vehicle.getCertificateDetails');

    Route::post('/vehicle-editCertificate-save', function(Request $request){
        $AssessmentSafetyVehicleDAO = new AssessmentSafetyVehicleDAO();
        return $AssessmentSafetyVehicleDAO->editCertificateSave($request);
    })->name('.vehicle.editCertificate.save');

});



?>
