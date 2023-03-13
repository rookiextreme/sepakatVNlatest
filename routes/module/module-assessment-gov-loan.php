<?php

use App\Http\Controllers\Assessment\GovLoan\AssessmentGovLoanDAO;
use App\Http\Controllers\Assessment\GovLoan\Vehicle\AssessmentGovLoanVehicleDAO;
use App\Http\Controllers\Helpers\HelpersFunction;
use App\Models\Assessment\AssessmentGovLoan;
use App\Models\Assessment\AssessmentGovLoanVehicle;
use App\Models\Assessment\AssessmentOwnership;
use App\Models\Fleet\FleetDepartment;
use App\Models\RefAgency;
use App\Models\RefCategory;
use App\Models\RefComponentChecklistLvl1;
use App\Models\RefEngineFuelType;
use App\Models\RefSettingSub;
use App\Models\RefState;
use App\Models\RefWorkshop;
use App\Models\Vehicle\Brand;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

Route::group(['prefix' => 'gov_loan', 'as' => '.gov_loan', 'middleware' => 'auth'], function(){

    Route::get('/list', function(Request $request){

        $AssessmentGovLoanDAO = new AssessmentGovLoanDAO();
        $govLoanList = $AssessmentGovLoanDAO->list($request);

        return view('assessment.gov_loan.gov-loan-list', [
            'gov_loans' => $govLoanList,
        ]);

    })->name('.list');

    Route::get('/register', function (Request $request) {

        $AssessmentGovLoanDAO = new AssessmentGovLoanDAO();
        $detail = $AssessmentGovLoanDAO->read($request);
        $agency_list = RefAgency::orderBy('desc')->get();
        // $workshop_list = RefWorkshop::orderByRaw('code=\'02\'')->get()->reverse();
        $workshop_list = RefWorkshop::orderByRaw('code')->get();
        $category_list = RefCategory::all();
        $brand_list = Brand::where('status', 1)->orderBy('name')->get();
        $owner_list = AssessmentOwnership::all();
        $state_list = RefState::all();
        $hasAssessment = AssessmentGovLoan::whereHas('hasVehicle', function($q){
            $q->whereHas('hasAssessmentVehicleStatus', function($q){
                $q->where('code', '02');
            });
        })->count();

        $RefComponentChecklistLvl1 = RefComponentChecklistLvl1::whereHas('hasAssessmentType', function($q){
            $q->where('code', '01');
        });

        return view('assessment.gov_loan.gov-loan-register', [
            'detail' => $detail,
            'agency_list' => $agency_list,
            'workshop_list' => $workshop_list,
            'category_list' => $category_list,
            'brand_list' => $brand_list,
            'owner_list' => $owner_list,
            'RefComponentChecklistLvl1' => $RefComponentChecklistLvl1->get(),
            'state_list' => $state_list,
            'hasAssessment' => $hasAssessment,
        ]);

    })->name('.register');

    Route::post('/register-save', function (Request $request) {

        $section = $request->section;
        $AssessmentGovLoanDAO = new AssessmentGovLoanDAO();
        switch ($section) {
            case 'detail':
                return $AssessmentGovLoanDAO->upsert($request);
                break;
            case 'verify':
                return $AssessmentGovLoanDAO->verify($request);
                break;
            case 'examination':
                return $AssessmentGovLoanDAO->examination();
                break;
            case 'set_appointment':
                return $AssessmentGovLoanDAO->setAppointment($request);
                break;
        }
        return view('assessment.gov_loan.gov-loan-register');
    })->name('.register.save');

    Route::post('/verification', function (Request $request) {
        $AssessmentGovLoanDAO = new AssessmentGovLoanDAO();
        return $AssessmentGovLoanDAO->verification();
    })->name('.verification');

    Route::post('/approval', function (Request $request) {
        $AssessmentGovLoanDAO = new AssessmentGovLoanDAO();
        return $AssessmentGovLoanDAO->approval($request);
    })->name('.approval');

    Route::post('/approve', function (Request $request) {
        $AssessmentGovLoanDAO = new AssessmentGovLoanDAO();
        return $AssessmentGovLoanDAO->approve();
    })->name('.approve');

    Route::post('/reject', function (Request $request) {
        $AssessmentGovLoanDAO = new AssessmentGovLoanDAO();
        return $AssessmentGovLoanDAO->reject();
    })->name('.reject');

    Route::post('/delete', function(Request $request){
        $AssessmentGovLoanDAO = new AssessmentGovLoanDAO();
        return  $AssessmentGovLoanDAO->delete($request);
    })->name('.delete');

    Route::post('/cancel', function(Request $request){
        $AssessmentGovLoanDAO = new AssessmentGovLoanDAO();
        return  $AssessmentGovLoanDAO->cancel($request);
    })->name('.cancel');

    Route::post('/vehicle-checkExistRegNumber', function(Request $request){

        $response = [
            'data' => null,
            'status' => 0,
        ];

        $HelpersFunction = new HelpersFunction();
        $checkingVehicleInAssessment = $HelpersFunction->checkingVehicleInAssessment($request->plate_no, $request->assessment_type);

        // $check = AssessmentGovLoanVehicle::where('plate_no', $request->plate_no)
        //         ->whereHas('hasAssessmentVehicleStatus', function($q){
        //             $q->whereNotIn('code', ['00']);
        //             })->whereHas('hasAssessmentDetail.hasStatus', function($q1){
        //                 $q1->whereIn('code', ['01','02', '03', '04', '05']);
        //         });
        //         Log::info('toSql() '.$check->toSql());
        //         Log::info('getBindings() ',$check->getBindings());
        if(count($checkingVehicleInAssessment)>0){
            $response['status'] = 1;
            $response['data'] = $checkingVehicleInAssessment->first();
            return $response;
        }else{
            $checkingVehicleEverEvaluated = $HelpersFunction->checkingVehicleEverEvaluated($request->plate_no, $request->assessment_type);
            // $check = AssessmentGovLoanVehicle::where('plate_no', $request->plate_no)
            //     ->whereHas('hasAssessmentVehicleStatus', function($q){
            //         $q->whereIn('code', ['06']);
            //         })->whereHas('hasAssessmentDetail.hasStatus', function($q1){
            //             $q1->whereNotIn('code', ['00']);
            //     });

            //     Log::info('toSql() '.$check->toSql());
            //     Log::info('getBindings() ',$check->getBindings());

            if($checkingVehicleEverEvaluated){
                Log::info("atas");
                $response['status'] = 2;
                $response['data'] = $checkingVehicleEverEvaluated->first();
                return $response;

            } else {
                Log::info("bawah");
                $response['status'] = 0;

                if(auth()->user()->isPublic()){
                    $queryRegNumberIsExisted = AssessmentGovLoanVehicle::where('plate_no', $request->plate_no)
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

    // Route::post('/vehicle-checkExistRegNumber', function(Request $request){
    //     $check = AssessmentGovLoanVehicle::where('plate_no', $request->plate_no)
    //             ->whereHas('hasAssessmentDetail', function($q){
    //                 $q->whereHas('hasStatus', function($q2){
    //                     $q2->whereIn('code', ['01','02', '03', '04', '05']);
    //                 });
    //             })->first();

    //     if($check){
    //         return 1;
    //     }else{
    //         if(auth()->user()->isPublic()){
    //             $queryRegNumberIsExisted = AssessmentGovLoanVehicle::where('plate_no', $request->plate_no)
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



    Route::post('/vehicle-save', function (Request $request) {
        $AssessmentGovLoanVehicleDAO = new AssessmentGovLoanVehicleDAO();
        return $AssessmentGovLoanVehicleDAO->upsert($request);
    })->name('.vehicle.save');

    Route::get('/vehicle-list', function (Request $request) {

        $AssessmentGovLoanVehicleDAO = new AssessmentGovLoanVehicleDAO();
        $vehicleList = $AssessmentGovLoanVehicleDAO->list($request);

        $assessment_gov_loan_id = session()->get('govloan_current_detail_id');
        $hasAssessmentGovLoanDetail = AssessmentGovLoan::find($assessment_gov_loan_id);

        $category_list = RefCategory::all();
        $brand_list = Brand::where('status', 1)->orderBy('name')->get();

        return view('assessment.gov_loan.ajax.assessment-gov-loan-vehicle-list', [
            'hasAssessmentGovLoanDetail' => $hasAssessmentGovLoanDetail,
            'category_list' => $category_list,
            'brand_list' => $brand_list,
            'vehicleList' => $vehicleList,
            'assessment_gov_loan_id' => $assessment_gov_loan_id
        ]);
    })->name('.vehicle.list');

    Route::get('/vehicle-appointment-list', function (Request $request) {

        $AssessmentGovLoanVehicleDAO = new AssessmentGovLoanVehicleDAO();
        $response = $AssessmentGovLoanVehicleDAO->listAppointment($request);

        $assessment_gov_loan_id = session()->get('govloan_current_detail_id');
        $hasAssessmentGovLoanDetail = AssessmentGovLoan::find($assessment_gov_loan_id);
        $vehicleList = $response['list'];
        $totalPrice = $response['totalPrice'];
        $foremenList = $AssessmentGovLoanVehicleDAO->foremenList();

        return view('assessment.gov_loan.ajax.assessment-gov-loan-vehicle-appointment-list', [
            'hasAssessmentGovLoanDetail' => $hasAssessmentGovLoanDetail,
            'vehicleList' => $vehicleList,
            'foremenList' => $foremenList,
            'totalPrice' => $totalPrice,
            'assessment_gov_loan_id' => $assessment_gov_loan_id
        ]);
    })->name('.vehicle-appointment.list');

    Route::post('/vehicle-appointment-updatePrice', function(Request $request){

        $AssessmentGovLoanVehicleDAO = new AssessmentGovLoanVehicleDAO();
        $AssessmentGovLoanVehicleDAO->updatePrice($request);

    })->name('.vehicle-appointment-updatePrice');

    Route::post('/vehicle-appointment-assign', function(Request $request){

        $AssessmentGovLoanVehicleDAO = new AssessmentGovLoanVehicleDAO();
        switch ($request->assign_to) {
            case 'formen':
                $AssessmentGovLoanVehicleDAO->assignToFormen($request);
                break;

            default:
                # code...
                break;
        }

    })->name('.vehicle-appointment-assign');

    Route::get('/vehicle-assessment-list', function (Request $request) {

        $AssessmentGovLoanVehicleDAO = new AssessmentGovLoanVehicleDAO();
        $vehicleList = $AssessmentGovLoanVehicleDAO->list($request);

        $assessment_gov_loan_id = session()->get('govloan_current_detail_id');
        $hasAssessmentGovLoanDetail = AssessmentGovLoan::find($assessment_gov_loan_id);

        return view('assessment.gov_loan.ajax.assessment-gov-loan-vehicle-assessment-list', [
            'hasAssessmentGovLoanDetail' => $hasAssessmentGovLoanDetail,
            'vehicleList' => $vehicleList,
            'assessment_gov_loan_id' => $assessment_gov_loan_id
        ]);
    })->name('.vehicle-assessment.list');

    Route::get('/vehicle-approval-list', function (Request $request) {

        $AssessmentGovLoanVehicleDAO = new AssessmentGovLoanVehicleDAO();
        $vehicleList = $AssessmentGovLoanVehicleDAO->list($request);

        $assessment_gov_loan_id = session()->get('govloan_current_detail_id');
        $hasAssessmentGovLoanDetail = AssessmentGovLoan::find($assessment_gov_loan_id);

        return view('assessment.gov_loan.ajax.assessment-gov-loan-vehicle-approval-list', [
            'hasAssessmentGovLoanDetail' => $hasAssessmentGovLoanDetail,
            'vehicleList' => $vehicleList,
            'assessment_gov_loan_id' => $assessment_gov_loan_id
        ]);
    })->name('.vehicle-approval.list');

    Route::get('/vehicle-evaluation-list', function (Request $request) {

        $AssessmentGovLoanVehicleDAO = new AssessmentGovLoanVehicleDAO();
        $vehicleList = $AssessmentGovLoanVehicleDAO->list($request);

        $assessment_gov_loan_id = session()->get('govloan_current_detail_id');
        $hasAssessmentGovLoanDetail = AssessmentGovLoan::find($assessment_gov_loan_id);

        return view('assessment.gov_loan.ajax.assessment-gov-loan-vehicle-evaluation-list', [
            'hasAssessmentGovLoanDetail' => $hasAssessmentGovLoanDetail,
            'vehicleList' => $vehicleList,
            'assessment_gov_loan_id' => $assessment_gov_loan_id
        ]);
    })->name('.vehicle-evaluation.list');

    Route::post('/vehicle-evaluation-save-receipt', function (Request $request) {

        $AssessmentCurrvalueDAO = new AssessmentGovLoanDAO();
        $AssessmentCurrvalueDAO->saveReceipt($request);

    })->name('.vehicle-evaluation.save-receipt');

    Route::get('/vehicle-certificate-list', function (Request $request) {
        $AssessmentGovLoanVehicleDAO = new AssessmentGovLoanVehicleDAO();
        $vehicleList = $AssessmentGovLoanVehicleDAO->list($request);

        $assessment_gov_loan_id = session()->get('govloan_current_detail_id');
        $hasAssessmentGovLoanDetail = AssessmentGovLoan::find($assessment_gov_loan_id);

        // $allowToUDATECert = false;
        // $querySetting = RefSettingSub::whereHas('getSetting', function($q){
        //     $q->where('code', '04');
        // })->where('code', '04');
        // if($querySetting->first()){
        //     $allowToUDATECert = true;
        // }

        return view('assessment.gov_loan.ajax.assessment-gov-loan-vehicle-certificate-list', [
            'hasAssessmentGovLoanDetail' => $hasAssessmentGovLoanDetail,
            'vehicleList' => $vehicleList,
            'assessment_gov_loan_id' => $assessment_gov_loan_id
        ]);
    })->name('.vehicle-certificate.list');

    // Route::get('/vehicle-certificate-checkGenuine', function (Request $request) {
    //     $AssessmentGovLoanVehicleDAO = new AssessmentGovLoanVehicleDAO();
    //     $detail = $AssessmentGovLoanVehicleDAO->checkGenuine($request);
    //     return view('assessment.gov_loan.gov-loan-vehicle-certificate-check-genuine', [
    //         'detail' => $detail
    //     ]);
    // })->name('.vehicle-certificate.checkGenuine');

    Route::get('/valuation', function (Request $request){
        return view('assessment.gov_loan.tab.gov-loan-valuation', [
            'request' => $request,
        ]);
    })->name('.valuation');

    Route::get('/vehicle-assessment-form', function(Request $request){
        $AssessmentGovLoanVehicleDAO = new AssessmentGovLoanVehicleDAO();
        $form = $AssessmentGovLoanVehicleDAO->getForm($request);
        return view('assessment.gov_loan.gov-loan-vehicle-checklist-form',$form);
    })->name('.vehicle-assessment.form');

    Route::post('/vehicle-assessment-form-save', function(Request $request){
        $AssessmentGovLoanVehicleDAO = new AssessmentGovLoanVehicleDAO();
        return  $AssessmentGovLoanVehicleDAO->saveFormGovLoan($request);
    })->name('.vehicle-assessment.form.save');

    Route::post('/vehicle-assessment-form-saves', function(Request $request){
        $AssessmentGovLoanVehicleDAO = new AssessmentGovLoanVehicleDAO();
        return  $AssessmentGovLoanVehicleDAO->saveForm($request);
    })->name('.vehicle-assessment.form.saves');

    Route::post('/vehicle-assessment-form-file-save', function(Request $request){
        $AssessmentGovLoanVehicleDAO = new AssessmentGovLoanVehicleDAO();
        return  $AssessmentGovLoanVehicleDAO->saveFormFile($request);
    })->name('.vehicle-assessment.form-file.save');

    Route::post('/deleteRelatedDoc', function(Request $request){
        $AssessmentNewVehicleDAO = new AssessmentGovLoanVehicleDAO();
        return  $AssessmentNewVehicleDAO->deleteRelatedDoc($request);
    })->name('.deleteRelatedDoc');

    Route::get('/vehicle-assessment-viewCertificate', function(Request $request){
        $AssessmentGovLoanVehicleDAO = new AssessmentGovLoanVehicleDAO();
        $response = $AssessmentGovLoanVehicleDAO->viewCertificate($request);
        return view('assessment.gov_loan.gov-loan-vehicle-certificate', $response);
    })->name('.vehicle-assessment.viewCertificate');

    Route::post('/vehicle-delete', function(Request $request){
        $AssessmentGovLoanVehicleDAO = new AssessmentGovLoanVehicleDAO();
        return  $AssessmentGovLoanVehicleDAO->delete($request);
    })->name('.vehicle.delete');

    Route::post('/vehicle-cancel', function(Request $request){
        $AssessmentGovLoanVehicleDAO = new AssessmentGovLoanVehicleDAO();
        return  $AssessmentGovLoanVehicleDAO->cancel($request);
    })->name('.vehicle.cancel');

    Route::post('/vehicle-updateStatus', function(Request $request){
        $AssessmentGovLoanVehicleDAO = new AssessmentGovLoanVehicleDAO();
        return  $AssessmentGovLoanVehicleDAO->updateStatus($request);
    })->name('.vehicle.updateStatus');

    Route::get('/vehicle-getVehicleForm', function(Request $request){
        $AssessmentGovLoanVehicleDAO = new AssessmentGovLoanVehicleDAO();
        return $AssessmentGovLoanVehicleDAO->getVehicleForm($request);
    })->name('.vehicle.getVehicleForm');

    Route::get('/vehicle-getCertificateDetails', function(Request $request){
        $AssessmentGovLoanVehicleDAO = new AssessmentGovLoanVehicleDAO();
        return $AssessmentGovLoanVehicleDAO->getCertificateDetails($request);
    })->name('.vehicle.getCertificateDetails');

    Route::post('/vehicle-editCertificate-save', function(Request $request){
        $AssessmentGovLoanVehicleDAO = new AssessmentGovLoanVehicleDAO();
        return $AssessmentGovLoanVehicleDAO->editCertificateSave($request);
    })->name('.vehicle.editCertificate.save');

});



?>
