<?php

use App\Http\Controllers\Assessment\Currvalue\AssessmentCurrvalueDAO;
use App\Http\Controllers\Assessment\Currvalue\Vehicle\AssessmentCurrvalueVehicleDAO;
use App\Http\Controllers\Helpers\HelpersFunction;
use App\Models\Assessment\AssessmentCurrvalue;
use App\Models\Assessment\AssessmentCurrvalueVehicle;
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

Route::group(['prefix' => 'currvalue', 'as' => '.currvalue', 'middleware' => 'auth'], function(){

    Route::get('/list', function(Request $request){

        $AssessmentCurrvalueDAO = new AssessmentCurrvalueDAO();
        $currvalueList = $AssessmentCurrvalueDAO->list($request);

        return view('assessment.currvalue.currvalue-list', [
            'currvalues' => $currvalueList,
        ]);

    })->name('.list');

    Route::get('/register', function (Request $request) {

        $AssessmentCurrvalueDAO = new AssessmentCurrvalueDAO();
        $detail = $AssessmentCurrvalueDAO->read($request);
        $agency_list = RefAgency::orderBy('desc')->get();
        // $workshop_list = RefWorkshop::orderByRaw('code=\'02\'')->get()->reverse();
        $workshop_list = RefWorkshop::orderByRaw('code')->get();
        $category_list = RefCategory::all();
        $brand_list = Brand::where('status', 1)->orderBy('name')->get();
        $owner_list = AssessmentOwnership::all();
        $state_list = RefState::all();
        $hasAssessment = AssessmentCurrvalue::whereHas('hasVehicle', function($q){
            $q->whereHas('hasAssessmentVehicleStatus', function($q){
                $q->where('code', '02');
            });
        })->count();

        $RefComponentChecklistLvl1 = RefComponentChecklistLvl1::whereHas('hasAssessmentType', function($q){
            $q->where('code', '01');
        });

        return view('assessment.currvalue.currvalue-register', [
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
        $AssessmentCurrvalueDAO = new AssessmentCurrvalueDAO();
        switch ($section) {
            case 'detail':
                return $AssessmentCurrvalueDAO->upsert($request);
                break;
            case 'verify':
                return $AssessmentCurrvalueDAO->verify($request);
                break;
            case 'examination':
                return $AssessmentCurrvalueDAO->examination();
                break;
            case 'set_appointment':
                return $AssessmentCurrvalueDAO->setAppointment($request);
                break;
        }
        return view('assessment.currvalue.currvalue-register');
    })->name('.register.save');

    Route::post('/verification', function (Request $request) {
        $AssessmentCurrvalueDAO = new AssessmentCurrvalueDAO();
        return $AssessmentCurrvalueDAO->verification();
    })->name('.verification');

    Route::post('/approval', function (Request $request) {
        $AssessmentCurrvalueDAO = new AssessmentCurrvalueDAO();
        return $AssessmentCurrvalueDAO->approval($request);
    })->name('.approval');

    Route::post('/approve', function (Request $request) {
        $AssessmentCurrvalueDAO = new AssessmentCurrvalueDAO();
        return $AssessmentCurrvalueDAO->approve();
    })->name('.approve');

    Route::post('/reject', function (Request $request) {
        $AssessmentCurrvalueDAO = new AssessmentCurrvalueDAO();
        return $AssessmentCurrvalueDAO->reject();
    })->name('.reject');

    Route::post('/delete', function(Request $request){
        $AssessmentCurrvalueDAO = new AssessmentCurrvalueDAO();
        return  $AssessmentCurrvalueDAO->delete($request);
    })->name('.delete');

    Route::post('/cancel', function(Request $request){
        $AssessmentCurrvalueDAO = new AssessmentCurrvalueDAO();
        return  $AssessmentCurrvalueDAO->cancel($request);
    })->name('.cancel');

    // Route::post('/vehicle-checkExistRegNumber', function(Request $request){

    //     $check = AssessmentCurrvalueVehicle::where('plate_no', $request->plate_no)
    //             ->whereHas('hasAssessmentDetail', function($q){
    //                 $q->whereHas('hasStatus', function($q2){
    //                     $q2->whereIn('code', ['01','02', '03', '04', '05']);
    //                 });
    //             })->first();

    //     if($check){
    //         return 1;
    //     }else{
    //         if(auth()->user()->isPublic()){
    //             $queryRegNumberIsExisted = AssessmentCurrvalueVehicle::where('plate_no', $request->plate_no)
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
    //     // $queryRegNumberIsExisted = AssessmentCurrvalueVehicle::where('plate_no', $request->plate_no)
    //     // ->whereHas('hasAssessmentDetail', function($q){
    //     //     $q->whereHas('hasStatus', function($q2){
    //     //         $q2->whereNotIn('code', ['06','08']);
    //     //     });
    //     // });
    //     // if($request->vehicle_id){
    //     //     $queryRegNumberIsExisted->where('id', '!=', $request->vehicle_id);
    //     // }
    //     // Log::info($queryRegNumberIsExisted->toSql());
    //     // return $queryRegNumberIsExisted->first() ? 1 : 0;
    // })->name('.vehicle.checkExistRegNumber');

    Route::post('/vehicle-checkExistRegNumber', function(Request $request){

        $response = [
            'data' => null,
            'status' => 0,
        ];

        $HelpersFunction = new HelpersFunction();
        $checkingVehicleInAssessment = $HelpersFunction->checkingVehicleInAssessment($request->plate_no, $request->assessment_type);

        // $check = AssessmentCurrvalueVehicle::where('plate_no', $request->plate_no)
        //         ->whereHas('hasAssessmentVehicleStatus', function($q){
        //             $q->whereNotIn('code', ['00']);
        //             })->whereHas('hasAssessmentDetail.hasStatus', function($q1){
        //                 $q1->whereIn('code', ['01','02', '03', '04', '05']);
        //         });
        //         Log::info('toSql() '.$check->toSql());
        //         Log::info('getBindings() ',$check->getBindings());
        if(count($checkingVehicleInAssessment)>0){
            $response['status'] = 1;
            $response['data'] = $checkingVehicleInAssessment->first();;
            return $response;
        }else{
            $checkingVehicleEverEvaluated = $HelpersFunction->checkingVehicleEverEvaluated($request->plate_no, $request->assessment_type);
            // $check = AssessmentCurrvalueVehicle::where('plate_no', $request->plate_no)
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
                $response['data'] = $checkingVehicleEverEvaluated->first();;
                return $response;

            } else {
                Log::info("bawah");
                $response['status'] = 0;

                if(auth()->user()->isPublic()){
                    $queryRegNumberIsExisted = AssessmentCurrvalueVehicle::where('plate_no', $request->plate_no)
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
        $AssessmentCurrvalueVehicleDAO = new AssessmentCurrvalueVehicleDAO();
        return $AssessmentCurrvalueVehicleDAO->upsert($request);
    })->name('.vehicle.save');

    Route::get('/vehicle-list', function (Request $request) {

        $AssessmentCurrvalueVehicleDAO = new AssessmentCurrvalueVehicleDAO();
        $vehicleList = $AssessmentCurrvalueVehicleDAO->list($request);

        $assessment_currvalue_id = session()->get('currvalue_current_detail_id');
        $hasAssessmentCurrvalueDetail = AssessmentCurrvalue::find($assessment_currvalue_id);

        $category_list = RefCategory::all();
        $brand_list = Brand::where('status', 1)->orderBy('name')->get();

        return view('assessment.currvalue.ajax.assessment-currvalue-vehicle-list', [
            'hasAssessmentCurrvalueDetail' => $hasAssessmentCurrvalueDetail,
            'category_list' => $category_list,
            'brand_list' => $brand_list,
            'vehicleList' => $vehicleList,
            'assessment_currvalue_id' => $assessment_currvalue_id
        ]);
    })->name('.vehicle.list');

    Route::get('/vehicle-appointment-list', function (Request $request) {

        $page = Request('page') ? Request('page') : 1;
        $limit = Request('limit') ? Request('limit') : 5;

        $AssessmentCurrvalueVehicleDAO = new AssessmentCurrvalueVehicleDAO();
        $response = $AssessmentCurrvalueVehicleDAO->listAppointment($request);

        $assessment_currvalue_id = session()->get('currvalue_current_detail_id');
        $hasAssessmentCurrvalueDetail = AssessmentCurrvalue::find($assessment_currvalue_id);

        $sql = 'select a.id, COALESCE(a.vehicle_price, 0) as v_price
        from assessment.assessment_currvalue_vehicle a
        join assessment.assessment_vehicle_status b on b.id = a.assessment_vehicle_status_id
        where a.assessment_currvalue_id = '.$assessment_currvalue_id.' and b.code not in (\'00\')
        ORDER BY a.created_at DESC
        OFFSET 0 ROWS FETCH NEXT '.($page > 1 ? (($page - 1) * $limit) : $limit).' ROWS ONLY
       ';
        $queryhasManyVehicle = DB::select($sql);
       $currentTotal = 0;
       $vehicleList = $response['list'];
       $totalPrice = $response['totalPrice'];

       if($page > 1){
        foreach ($queryhasManyVehicle as $key) {
            $currentTotal += $key->v_price;
        }
       }

       Log::info($sql);

        $foremenList = $AssessmentCurrvalueVehicleDAO->foremenList();

        return view('assessment.currvalue.ajax.assessment-currvalue-vehicle-appointment-list', [
            'hasAssessmentCurrvalueDetail' => $hasAssessmentCurrvalueDetail,
            'vehicleList' => $vehicleList,
            'foremenList' => $foremenList,
            'currentTotal' => $currentTotal,
            'totalPrice' => $totalPrice,
            'assessment_currvalue_id' => $assessment_currvalue_id
        ]);
    })->name('.vehicle-appointment.list');

    Route::post('/vehicle-appointment-updatePrice', function(Request $request){

        $AssessmentCurrvalueVehicleDAO = new AssessmentCurrvalueVehicleDAO();
        $AssessmentCurrvalueVehicleDAO->updatePrice($request);

    })->name('.vehicle-appointment-updatePrice');

    Route::post('/vehicle-appointment-assign', function(Request $request){

        $AssessmentCurrvalueVehicleDAO = new AssessmentCurrvalueVehicleDAO();
        switch ($request->assign_to) {
            case 'formen':
                $AssessmentCurrvalueVehicleDAO->assignToFormen($request);
                break;

            default:
                # code...
                break;
        }

    })->name('.vehicle-appointment-assign');

    Route::get('/vehicle-assessment-list', function (Request $request) {

        $AssessmentCurrvalueVehicleDAO = new AssessmentCurrvalueVehicleDAO();
        $vehicleList = $AssessmentCurrvalueVehicleDAO->list($request);

        $assessment_currvalue_id = session()->get('currvalue_current_detail_id');
        $hasAssessmentCurrvalueDetail = AssessmentCurrvalue::find($assessment_currvalue_id);

        return view('assessment.currvalue.ajax.assessment-currvalue-vehicle-assessment-list', [
            'hasAssessmentCurrvalueDetail' => $hasAssessmentCurrvalueDetail,
            'vehicleList' => $vehicleList,
            'assessment_currvalue_id' => $assessment_currvalue_id
        ]);
    })->name('.vehicle-assessment.list');

    Route::get('/vehicle-approval-list', function (Request $request) {

        $AssessmentCurrvalueVehicleDAO = new AssessmentCurrvalueVehicleDAO();
        $vehicleList = $AssessmentCurrvalueVehicleDAO->list($request);

        $assessment_currvalue_id = session()->get('currvalue_current_detail_id');
        $hasAssessmentCurrvalueDetail = AssessmentCurrvalue::find($assessment_currvalue_id);

        return view('assessment.currvalue.ajax.assessment-currvalue-vehicle-approval-list', [
            'hasAssessmentCurrvalueDetail' => $hasAssessmentCurrvalueDetail,
            'vehicleList' => $vehicleList,
            'assessment_currvalue_id' => $assessment_currvalue_id,
            'status_code' => $request->status_code ? $request->status_code : 'all_inprogress',
        ]);
    })->name('.vehicle-approval.list');

    Route::get('/vehicle-evaluation-list', function (Request $request) {

        $AssessmentCurrvalueVehicleDAO = new AssessmentCurrvalueVehicleDAO();
        $vehicleList = $AssessmentCurrvalueVehicleDAO->list($request);

        $assessment_currvalue_id = session()->get('currvalue_current_detail_id');
        $hasAssessmentCurrvalueDetail = AssessmentCurrvalue::find($assessment_currvalue_id);

        return view('assessment.currvalue.ajax.assessment-currvalue-vehicle-evaluation-list', [
            'hasAssessmentCurrvalueDetail' => $hasAssessmentCurrvalueDetail,
            'vehicleList' => $vehicleList,
            'assessment_currvalue_id' => $assessment_currvalue_id,
            'status_code' => $request->status_code ? $request->status_code : 'all_inprogress',
        ]);
    })->name('.vehicle-evaluation.list');

    Route::post('/vehicle-evaluation-save-receipt', function (Request $request) {

        $AssessmentCurrvalueDAO = new AssessmentCurrvalueDAO();
        $AssessmentCurrvalueDAO->saveReceipt($request);

    })->name('.vehicle-evaluation.save-receipt');

    Route::get('/vehicle-certificate-list', function (Request $request) {
        $AssessmentCurrvalueVehicleDAO = new AssessmentCurrvalueVehicleDAO();
        $vehicleList = $AssessmentCurrvalueVehicleDAO->list($request);

        $assessment_currvalue_id = session()->get('currvalue_current_detail_id');
        $hasAssessmentCurrvalueDetail = AssessmentCurrvalue::find($assessment_currvalue_id);

        // $allowToUDATECert = false;
        // $querySetting = RefSettingSub::whereHas('getSetting', function($q){
        //     $q->where('code', '04');
        // })->where('code', '03');
        // if($querySetting->first()){
        //     $allowToUDATECert = true;
        // }

        return view('assessment.currvalue.ajax.assessment-currvalue-vehicle-certificate-list', [
            'hasAssessmentCurrvalueDetail' => $hasAssessmentCurrvalueDetail,
            'vehicleList' => $vehicleList,
            'assessment_currvalue_id' => $assessment_currvalue_id
        ]);
    })->name('.vehicle-certificate.list');

    // Route::get('/vehicle-certificate-checkGenuine', function (Request $request) {
    //     $AssessmentCurrvalueVehicleDAO = new AssessmentCurrvalueVehicleDAO();
    //     $detail = $AssessmentCurrvalueVehicleDAO->checkGenuine($request);
    //     return view('assessment.currvalue.currvalue-vehicle-certificate-check-genuine', [
    //         'detail' => $detail
    //     ]);
    // })->name('.vehicle-certificate.checkGenuine');

    Route::get('/valuation', function (Request $request){
        return view('assessment.currvalue.tab.currvalue-valuation', [
            'request' => $request,
        ]);
    })->name('.valuation');

    Route::get('/vehicle-assessment-form', function(Request $request){
        $AssessmentCurrvalueVehicleDAO = new AssessmentCurrvalueVehicleDAO();
        $form = $AssessmentCurrvalueVehicleDAO->getForm($request);
        return view('assessment.currvalue.currvalue-vehicle-checklist-form',$form);
    })->name('.vehicle-assessment.form');

    Route::post('/vehicle-assessment-form-save', function(Request $request){
        $AssessmentCurrvalueVehicleDAO = new AssessmentCurrvalueVehicleDAO();
        return  $AssessmentCurrvalueVehicleDAO->saveFormCurrvalue($request);
    })->name('.vehicle-assessment.form.save');

    Route::post('/vehicle-assessment-form-saves', function(Request $request){
        $AssessmentCurrvalueVehicleDAO = new AssessmentCurrvalueVehicleDAO();
        return  $AssessmentCurrvalueVehicleDAO->saveForm($request);
    })->name('.vehicle-assessment.form.saves');

    Route::post('/vehicle-assessment-form-file-save', function(Request $request){
        $AssessmentCurrvalueVehicleDAO = new AssessmentCurrvalueVehicleDAO();
        return  $AssessmentCurrvalueVehicleDAO->saveFormFile($request);
    })->name('.vehicle-assessment.form-file.save');

    Route::post('/deleteRelatedDoc', function(Request $request){
        $AssessmentNewVehicleDAO = new AssessmentCurrvalueVehicleDAO();
        return  $AssessmentNewVehicleDAO->deleteRelatedDoc($request);
    })->name('.deleteRelatedDoc');

    Route::get('/vehicle-assessment-viewCertificate', function(Request $request){
        $AssessmentCurrvalueVehicleDAO = new AssessmentCurrvalueVehicleDAO();
        $response = $AssessmentCurrvalueVehicleDAO->viewCertificate($request);
        return view('assessment.currvalue.currvalue-vehicle-certificate', $response);
    })->name('.vehicle-assessment.viewCertificate');

    Route::post('/vehicle-delete', function(Request $request){
        $AssessmentCurrvalueVehicleDAO = new AssessmentCurrvalueVehicleDAO();
        return  $AssessmentCurrvalueVehicleDAO->delete($request);
    })->name('.vehicle.delete');

    Route::post('/vehicle-cancel', function(Request $request){
        $AssessmentCurrvalueVehicleDAO = new AssessmentCurrvalueVehicleDAO();
        return  $AssessmentCurrvalueVehicleDAO->cancel($request);
    })->name('.vehicle.cancel');

    Route::post('/vehicle-updateStatus', function(Request $request){
        $AssessmentCurrvalueVehicleDAO = new AssessmentCurrvalueVehicleDAO();
        return  $AssessmentCurrvalueVehicleDAO->updateStatus($request);
    })->name('.vehicle.updateStatus');

    Route::get('/vehicle-getVehicleForm', function(Request $request){
        $AssessmentCurrvalueVehicleDAO = new AssessmentCurrvalueVehicleDAO();
        return $AssessmentCurrvalueVehicleDAO->getVehicleForm($request);
    })->name('.vehicle.getVehicleForm');

    Route::get('/vehicle-getCertificateDetails', function(Request $request){
        $AssessmentCurrvalueVehicleDAO = new AssessmentCurrvalueVehicleDAO();
        return $AssessmentCurrvalueVehicleDAO->getCertificateDetails($request);
    })->name('.vehicle.getCertificateDetails');

    Route::post('/vehicle-editCertificate-save', function(Request $request){
        $AssessmentCurrvalueVehicleDAO = new AssessmentCurrvalueVehicleDAO();
        return $AssessmentCurrvalueVehicleDAO->editCertificateSave($request);
    })->name('.vehicle.editCertificate.save');

});



?>
