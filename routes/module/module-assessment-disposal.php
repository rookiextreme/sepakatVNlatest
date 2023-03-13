<?php

use App\Http\Controllers\Assessment\Disposal\AssessmentDisposalDAO;
use App\Http\Controllers\Assessment\Disposal\Vehicle\AssessmentDisposalVehicleDAO;
use App\Http\Controllers\Helpers\HelpersFunction;
use App\Models\Assessment\AssessmentAccidentVehicle;
use App\Models\Assessment\AssessmentCurrvalueVehicle;
use App\Models\Assessment\AssessmentDisposal;
use App\Models\Assessment\AssessmentDisposalVehicle;
use App\Models\Assessment\AssessmentGovLoanVehicle;
use App\Models\Assessment\AssessmentNewVehicle;
use App\Models\Assessment\AssessmentOwnership;
use App\Models\Assessment\AssessmentSafetyVehicle;
use App\Models\Fleet\FleetDepartment;
use App\Models\FleetDisposal;
use App\Models\RefAgency;
use App\Models\RefCategory;
use App\Models\RefComponentChecklistLvl1;
use App\Models\RefSettingSub;
use App\Models\RefState;
use App\Models\RefWorkshop;
use App\Models\Vehicle\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'disposal', 'as' => '.disposal', 'middleware' => 'auth'], function(){

    Route::get('/list', function(Request $request){

        $AssessmentDisposalDAO = new AssessmentDisposalDAO();
        $disposalList = $AssessmentDisposalDAO->list($request);

        return view('assessment.disposal.disposal-list', [
            'disposals' => $disposalList,
        ]);

    })->name('.list');

    Route::get('/register', function (Request $request) {

        $AssessmentDisposalDAO = new AssessmentDisposalDAO();
        $detail = $AssessmentDisposalDAO->read($request);
        $agency_list = RefAgency::orderBy('desc')->get();
        // $workshop_list = RefWorkshop::orderByRaw('code=\'02\'')->get()->reverse();
        $workshop_list = RefWorkshop::orderByRaw('code')->get();
        $category_list = RefCategory::all();
        $brand_list = Brand::where('status', 1)->orderBy('name')->get();
        $owner_list = AssessmentOwnership::all();
        $state_list = RefState::all();

        $RefComponentChecklistLvl1 = RefComponentChecklistLvl1::whereHas('hasAssessmentType', function($q){
            $q->where('code', '01');
        });

        return view('assessment.disposal.disposal-register', [
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
        $AssessmentDisposalDAO = new AssessmentDisposalDAO();
        switch ($section) {
            case 'detail':
                return $AssessmentDisposalDAO->upsert($request);
                break;
            case 'verify':
                return $AssessmentDisposalDAO->verify($request);
                break;
            case 'examination':
                return $AssessmentDisposalDAO->examination();
                break;
            case 'set_appointment':
                return $AssessmentDisposalDAO->setAppointment($request);
                break;
        }
        return view('assessment.disposal.disposal-register');
    })->name('.register.save');

    Route::post('/verification', function (Request $request) {
        $AssessmentDisposalDAO = new AssessmentDisposalDAO();
        return $AssessmentDisposalDAO->verification();
    })->name('.verification');

    Route::post('/approval', function (Request $request) {
        $AssessmentDisposalDAO = new AssessmentDisposalDAO();
        return $AssessmentDisposalDAO->approval($request);
    })->name('.approval');

    Route::post('/approve', function (Request $request) {
        $AssessmentDisposalDAO = new AssessmentDisposalDAO();
        return $AssessmentDisposalDAO->approve();
    })->name('.approve');

    Route::post('/reject', function (Request $request) {
        $AssessmentDisposalDAO = new AssessmentDisposalDAO();
        return $AssessmentDisposalDAO->reject();
    })->name('.reject');

    Route::post('/delete', function(Request $request){
        $AssessmentDisposalDAO = new AssessmentDisposalDAO();
        return  $AssessmentDisposalDAO->delete($request);
    })->name('.delete');

    Route::post('/cancel', function(Request $request){
        $AssessmentDisposalDAO = new AssessmentDisposalDAO();
        return  $AssessmentDisposalDAO->cancel($request);
    })->name('.cancel');

    Route::post('/vehicle-checkExistRegNumber', function(Request $request){

        $response = [
            'data' => null,
            'status' => 0,
        ];

        $HelpersFunction = new HelpersFunction();
        $checkingVehicleInAssessment = $HelpersFunction->checkingVehicleInAssessment($request->plate_no, $request->assessment_type);

        if(count($checkingVehicleInAssessment)>0){
            // $check = AssessmentDisposalVehicle::where('plate_no', $request->plate_no)
            //     ->whereHas('hasAssessmentVehicleStatus', function($q){
            //         $q->whereNotIn('code', ['00']);
            //         })->whereHas('hasAssessmentDetail.hasStatus', function($q1){
            //             $q1->whereIn('code', ['01','02', '03', '04', '05']);
            //     });
            //     Log::info('toSql() '.$check->toSql());
            //     Log::info('getBindings() ',$check->getBindings());
            $response['status'] = 1;
            $response['data'] = $checkingVehicleInAssessment->first();
            return $response;
        }else{
            $checkingVehicleEverEvaluated = $HelpersFunction->checkingVehicleEverEvaluated($request->plate_no, $request->assessment_type);

            if($checkingVehicleEverEvaluated){
                // $check = AssessmentDisposalVehicle::where('plate_no', $request->plate_no)
                // ->whereHas('hasAssessmentVehicleStatus', function($q){
                //     $q->whereIn('code', ['06']);
                //     })->whereHas('hasAssessmentDetail.hasStatus', function($q1){
                //         $q1->whereNotIn('code', ['00']);
                // });

                // Log::info('toSql() '.$check->toSql());
                // Log::info('getBindings() ',$check->getBindings());
                Log::info("atas");
                $response['status'] = 2;
                $response['data'] = $checkingVehicleEverEvaluated->first();
                return $response;
            }else{
                if(auth()->user()->isPublic()){
                    $queryRegNumberIsExisted = AssessmentDisposalVehicle::where('plate_no', $request->plate_no)
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

        $check = AssessmentDisposalVehicle::where('plate_no', $request->plate_no)
                ->whereHas('hasAssessmentVehicleStatus', function($q){
                    $q->whereNotIn('code', ['00']);
                    })->whereHas('hasAssessmentDetail.hasStatus', function($q1){
                        $q1->whereIn('code', ['01','02', '03', '04', '05']);
                });
                Log::info('toSql() '.$check->toSql());
                Log::info('getBindings() ',$check->getBindings());


        if($check->first()){
            $response['status'] = 1;
            $response['data'] = $check->first();
            return $response;
        }else{
            $check = AssessmentDisposalVehicle::where('plate_no', $request->plate_no)
                ->whereHas('hasAssessmentVehicleStatus', function($q){
                    $q->whereIn('code', ['06']);
                    })->whereHas('hasAssessmentDetail.hasStatus', function($q1){
                        $q1->whereNotIn('code', ['00']);
                });

                Log::info('toSql() '.$check->toSql());
                Log::info('getBindings() ',$check->getBindings());

            if($check->first()){
                Log::info("atas");
                $response['status'] = 2;
                $response['data'] = $check->first();
                return $response;

            } else {
                Log::info("bawah");
                $response['status'] = 0;

                if(auth()->user()->isPublic()){
                    $queryRegNumberIsExisted = AssessmentDisposalVehicle::where('plate_no', $request->plate_no)
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
        $AssessmentDisposalVehicleDAO = new AssessmentDisposalVehicleDAO();
        return $AssessmentDisposalVehicleDAO->upsert($request);
    })->name('.vehicle.save');

    Route::post('/vehicle-update', function (Request $request) {
        $AssessmentDisposalVehicleDAO = new AssessmentDisposalVehicleDAO();
        return $AssessmentDisposalVehicleDAO->updateCost($request);
    })->name('.vehicle.update');

    Route::get('/vehicle-list', function (Request $request) {

        $AssessmentDisposalVehicleDAO = new AssessmentDisposalVehicleDAO();
        $vehicleList = $AssessmentDisposalVehicleDAO->list($request);

        $assessment_disposal_id = session()->get('disposal_current_detail_id');
        $hasAssessmentDisposalDetail = AssessmentDisposal::find($assessment_disposal_id);

        $category_list = RefCategory::all();
        $brand_list = Brand::where('status', 1)->orderBy('name')->get();

        return view('assessment.disposal.ajax.assessment-disposal-vehicle-list', [
            'hasAssessmentDisposalDetail' => $hasAssessmentDisposalDetail,
            'category_list' => $category_list,
            'brand_list' => $brand_list,
            'vehicleList' => $vehicleList,
            'assessment_disposal_id' => $assessment_disposal_id
        ]);
    })->name('.vehicle.list');

    Route::get('/vehicle-appointment-list', function (Request $request) {

        $AssessmentDisposalVehicleDAO = new AssessmentDisposalVehicleDAO();
        $vehicleList = $AssessmentDisposalVehicleDAO->listAppointment($request);

        $assessment_disposal_id = session()->get('disposal_current_detail_id');
        $hasAssessmentDisposalDetail = AssessmentDisposal::find($assessment_disposal_id);

        $foremenList = $AssessmentDisposalVehicleDAO->foremenList();

        return view('assessment.disposal.ajax.assessment-disposal-vehicle-appointment-list', [
            'hasAssessmentDisposalDetail' => $hasAssessmentDisposalDetail,
            'vehicleList' => $vehicleList,
            'foremenList' => $foremenList,
            'assessment_disposal_id' => $assessment_disposal_id
        ]);
    })->name('.vehicle-appointment.list');

    Route::post('/vehicle-appointment-assign', function(Request $request){

        $AssessmentDisposalVehicleDAO = new AssessmentDisposalVehicleDAO();
        switch ($request->assign_to) {
            case 'formen':
                $AssessmentDisposalVehicleDAO->assignToFormen($request);
                break;

            default:
                # code...
                break;
        }

    })->name('.vehicle-appointment-assign');

    Route::get('/vehicle-assessment-list', function (Request $request) {

        $AssessmentDisposalVehicleDAO = new AssessmentDisposalVehicleDAO();
        $vehicleList = $AssessmentDisposalVehicleDAO->list($request);

        $assessment_disposal_id = session()->get('disposal_current_detail_id');
        $hasAssessmentDisposalDetail = AssessmentDisposal::find($assessment_disposal_id);

        return view('assessment.disposal.ajax.assessment-disposal-vehicle-assessment-list', [
            'hasAssessmentDisposalDetail' => $hasAssessmentDisposalDetail,
            'vehicleList' => $vehicleList,
            'assessment_disposal_id' => $assessment_disposal_id
        ]);
    })->name('.vehicle-assessment.list');

    Route::get('/vehicle-approval-list', function (Request $request) {

        $AssessmentDisposalVehicleDAO = new AssessmentDisposalVehicleDAO();
        $vehicleList = $AssessmentDisposalVehicleDAO->listApproval($request);

        $assessment_disposal_id = session()->get('disposal_current_detail_id');
        $hasAssessmentDisposalDetail = AssessmentDisposal::find($assessment_disposal_id);

        return view('assessment.disposal.ajax.assessment-disposal-vehicle-approval-list', [
            'hasAssessmentDisposalDetail' => $hasAssessmentDisposalDetail,
            'vehicleList' => $vehicleList,
            'assessment_disposal_id' => $assessment_disposal_id
        ]);
    })->name('.vehicle-approval.list');

    Route::get('/vehicle-evaluation-list', function (Request $request) {

        $AssessmentDisposalVehicleDAO = new AssessmentDisposalVehicleDAO();
        $vehicleList = $AssessmentDisposalVehicleDAO->listEvaluation($request);

        $assessment_disposal_id = session()->get('disposal_current_detail_id');
        $hasAssessmentDisposalDetail = AssessmentDisposal::find($assessment_disposal_id);

        return view('assessment.disposal.ajax.assessment-disposal-vehicle-evaluation-list', [
            'hasAssessmentDisposalDetail' => $hasAssessmentDisposalDetail,
            'vehicleList' => $vehicleList,
            'assessment_disposal_id' => $assessment_disposal_id
        ]);
    })->name('.vehicle-evaluation.list');

    Route::get('/vehicle-certificate-list', function (Request $request) {
        $AssessmentDisposalVehicleDAO = new AssessmentDisposalVehicleDAO();
        $vehicleList = $AssessmentDisposalVehicleDAO->listCertificate($request);

        $assessment_disposal_id = session()->get('disposal_current_detail_id');
        $hasAssessmentDisposalDetail = AssessmentDisposal::find($assessment_disposal_id);

        // $allowToUDATECert = false;
        // $querySetting = RefSettingSub::whereHas('getSetting', function($q){
        //     $q->where('code', '04');
        // })->where('code', '05');
        // if($querySetting->first()){
        //     $allowToUDATECert = true;
        // }

        return view('assessment.disposal.ajax.assessment-disposal-vehicle-certificate-list', [
            'hasAssessmentDisposalDetail' => $hasAssessmentDisposalDetail,
            'vehicleList' => $vehicleList,
            'assessment_disposal_id' => $assessment_disposal_id
        ]);
    })->name('.vehicle-certificate.list');

    Route::get('/vehicle-certificate-checkGenuine', function (Request $request) {
        $AssessmentDisposalVehicleDAO = new AssessmentDisposalVehicleDAO();
        $detail = $AssessmentDisposalVehicleDAO->checkGenuine($request);
        return view('assessment.disposal.disposal-vehicle-certificate-check-genuine', [
            'detail' => $detail
        ]);
    })->name('.vehicle-certificate.checkGenuine');

    // Route::get('/disposal-letter', function (Request $request) {
    //     $AssessmentDisposalVehicleDAO = new AssessmentDisposalVehicleDAO();
    //     $vehicleList = $AssessmentDisposalVehicleDAO->listCertificate($request);

    //     $assessment_disposal_id = session()->get('disposal_current_detail_id');
    //     $hasAssessmentDisposalDetail = AssessmentDisposal::find($assessment_disposal_id);

    //     return view('assessment.disposal.tab.disposal-letter', [
    //         'hasAssessmentDisposalDetail' => $hasAssessmentDisposalDetail,
    //         'vehicleList' => $vehicleList
    //     ]);
    // })->name('.disposal-letter');

    Route::post('/vehicle-assessment-generateForm', function(Request $request){
        $AssessmentDisposalVehicleDAO = new AssessmentDisposalVehicleDAO();
        return $AssessmentDisposalVehicleDAO->generateForm($request);
    })->name('.vehicle-assessment.generateForm');

    Route::get('/vehicle-assessment-form', function(Request $request){
        $AssessmentDisposalVehicleDAO = new AssessmentDisposalVehicleDAO();
        $form = $AssessmentDisposalVehicleDAO->getForm($request);
        return view('assessment.disposal.disposal-vehicle-checklist-form',$form);
    })->name('.vehicle-assessment.form');

    Route::get('/vehicle-assessment-form-mockup', function(Request $request){
        $AssessmentDisposalVehicleDAO = new AssessmentDisposalVehicleDAO();
        $form = $AssessmentDisposalVehicleDAO->getForm($request);
        return view('assessment.disposal.disposal-vehicle-checklist-form-mockup',$form);
    })->name('.vehicle-assessment.form.mockup');

    Route::post('/vehicle-assessment-form-save', function(Request $request){
        $AssessmentDisposalVehicleDAO = new AssessmentDisposalVehicleDAO();
        return  $AssessmentDisposalVehicleDAO->saveForm($request);
    })->name('.vehicle-assessment.form.save');

    Route::post('/vehicle-assessment-form-file-save', function(Request $request){
        $AssessmentDisposalVehicleDAO = new AssessmentDisposalVehicleDAO();
        return  $AssessmentDisposalVehicleDAO->saveFormFile($request);
    })->name('.vehicle-assessment.form-file.save');

    Route::post('/deleteRelatedDoc', function(Request $request){
        $AssessmentDisposalVehicleDAO = new AssessmentDisposalVehicleDAO();
        return  $AssessmentDisposalVehicleDAO->deleteRelatedDoc($request);
    })->name('.deleteRelatedDoc');

    Route::get('/vehicle-assessment-viewCertificate', function(Request $request){
        $AssessmentDisposalVehicleDAO = new AssessmentDisposalVehicleDAO();
        $response = $AssessmentDisposalVehicleDAO->viewCertificate($request);
        return view('assessment.disposal.disposal-vehicle-certificate', $response);
    })->name('.vehicle-assessment.viewCertificate');

    Route::post('/vehicle-delete', function(Request $request){
        $AssessmentDisposalVehicleDAO = new AssessmentDisposalVehicleDAO();
        return  $AssessmentDisposalVehicleDAO->delete($request);
    })->name('.vehicle.delete');

    Route::post('/vehicle-cancel', function(Request $request){
        $AssessmentDisposalVehicleDAO = new AssessmentDisposalVehicleDAO();
        return  $AssessmentDisposalVehicleDAO->cancel($request);
    })->name('.vehicle.cancel');

    Route::post('/vehicle-updateStatus', function(Request $request){
        $AssessmentDisposalVehicleDAO = new AssessmentDisposalVehicleDAO();
        return  $AssessmentDisposalVehicleDAO->updateStatus($request);
    })->name('.vehicle.updateStatus');

    Route::get('/vehicle-getVehicleForm', function(Request $request){
        $AssessmentDisposalVehicleDAO = new AssessmentDisposalVehicleDAO();
        return $AssessmentDisposalVehicleDAO->getVehicleForm($request);
    })->name('.vehicle.getVehicleForm');

    Route::post('/vehicle-assignAppointment', function(Request $request){
        $AssessmentDisposalVehicleDAO = new AssessmentDisposalVehicleDAO();
        $AssessmentDisposalVehicleDAO->assignAppointment($request);
    })->name('.vehicle.assignAppointment');

    Route::get('/vehicle-getCertificateDetails', function(Request $request){
        $AssessmentDisposalVehicleDAO = new AssessmentDisposalVehicleDAO();
        return $AssessmentDisposalVehicleDAO->getCertificateDetails($request);
    })->name('.vehicle.getCertificateDetails');

    Route::post('/vehicle-editCertificate-save', function(Request $request){
        $AssessmentDisposalVehicleDAO = new AssessmentDisposalVehicleDAO();
        return $AssessmentDisposalVehicleDAO->editCertificateSave($request);
    })->name('.vehicle.editCertificate.save');

});
?>
