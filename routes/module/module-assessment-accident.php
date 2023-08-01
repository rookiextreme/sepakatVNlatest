<?php

use App\Http\Controllers\Assessment\Accident\AssessmentAccidentDAO;
use App\Http\Controllers\Assessment\Accident\Vehicle\AssessmentAccidentVehicleDAO;
use App\Http\Controllers\Helpers\HelpersFunction;
use App\Models\Assessment\AssessmentAccident;
use App\Models\Assessment\AssessmentAccidentVehicle;
use App\Models\Assessment\AssessmentOwnership;
use App\Models\Fleet\FleetDepartment;
use App\Models\RefAgency;
use App\Models\RefCategory;
use App\Models\RefComponentChecklistLvl1;
use App\Models\RefSetting;
use App\Models\RefState;
use App\Models\RefWorkshop;
use App\Models\Vehicle\Brand;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

Route::group(['prefix' => 'accident', 'as' => '.accident', 'middleware' => 'auth'], function(){

    Route::get('/list', function(Request $request){

        $AssessmentAccidentDAO = new AssessmentAccidentDAO();
        $accidentList = $AssessmentAccidentDAO->list($request);

        return view('assessment.accident.accident-list', [
            'accidents' => $accidentList,
        ]);

    })->name('.list');

    Route::get('/register', function (Request $request) {

        $AssessmentAccidentDAO = new AssessmentAccidentDAO();
        $detail = $AssessmentAccidentDAO->read($request);
        $agency_list = RefAgency::orderBy('desc')->get();
        // $workshop_list = RefWorkshop::orderByRaw('code=\'02\'')->get()->reverse();
        $workshop_list = RefWorkshop::orderBy('code')->get();
        $category_list = RefCategory::all();
        $brand_list = Brand::where('status', 1)->orderBy('name')->get();
        $owner_list = AssessmentOwnership::all();
        $state_list = RefState::all();

        $RefComponentChecklistLvl1 = RefComponentChecklistLvl1::whereHas('hasAssessmentType', function($q){
            $q->where('code', '01');
        });
        return view('assessment.accident.accident-register', [
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
        $AssessmentAccidentDAO = new AssessmentAccidentDAO();
        switch ($section) {
            case 'detail':
                return $AssessmentAccidentDAO->upsert($request);
                break;
            case 'verify':
                return $AssessmentAccidentDAO->verify($request);
                break;
            case 'examination':
                return $AssessmentAccidentDAO->examination();
                break;
            case 'set_appointment':
                return $AssessmentAccidentDAO->setAppointment($request);
                break;
        }
        return view('assessment.accident.accident-register');
    })->name('.register.save');

    Route::post('/assessment-foremen', function (Request $request) {

        $AssessmentAccidentVehicleDAO = new AssessmentAccidentVehicleDAO();

        return $AssessmentAccidentVehicleDAO->assessmentForemen($request);

    })->name('.foremen');

    Route::post('/verification', function (Request $request) {
        $AssessmentAccidentDAO = new AssessmentAccidentDAO();
        return $AssessmentAccidentDAO->verification($request);
    })->name('.verification');

    Route::post('/approval', function (Request $request) {
        $AssessmentAccidentDAO = new AssessmentAccidentDAO();
        return $AssessmentAccidentDAO->approval();
    })->name('.approval');

    Route::post('/approve', function (Request $request) {
        $AssessmentAccidentDAO = new AssessmentAccidentDAO();
        return $AssessmentAccidentDAO->approve();
    })->name('.approve');

    Route::post('/reject', function (Request $request) {
        $AssessmentAccidentDAO = new AssessmentAccidentDAO();
        return $AssessmentAccidentDAO->reject();
    })->name('.reject');

    Route::post('/delete', function(Request $request){
        $AssessmentAccidentDAO = new AssessmentAccidentDAO();
        return  $AssessmentAccidentDAO->delete($request);
    })->name('.delete');

    Route::post('/deleteVehiclePicture', function(Request $request){
        $AssessmentAccidentDAO = new AssessmentAccidentVehicleDAO();
        return  $AssessmentAccidentDAO->deleteVehiclePicture($request);
    })->name('.deleteVehiclePicture');

    Route::post('/deleteVehicleDamageForm', function(Request $request){
        $AssessmentAccidentDAO = new AssessmentAccidentVehicleDAO();
        return  $AssessmentAccidentDAO->deleteVehicleDamageForm($request);
    })->name('.deleteVehicleDamageForm');

    Route::post('/cancel', function(Request $request){
        $AssessmentAccidentDAO = new AssessmentAccidentDAO();
        return  $AssessmentAccidentDAO->cancel($request);
    })->name('.cancel');

    // Route::post('/vehicle-checkExistRegNumber', function(Request $request){
    //     $queryRegNumberIsExisted = AssessmentAccidentVehicle::where('plate_no', $request->plate_no)->where('id', '!=', session()->get('accident_current_detail_id'));
    //     Log::info($queryRegNumberIsExisted->toSql());
    //     return $queryRegNumberIsExisted->first() ? 1 : 0;
    // })->name('.vehicle.checkExistRegNumber');

    Route::post('/vehicle-checkExistRegNumber', function(Request $request){

        $response = [
            'data' => null,
            'status' => 0,
        ];

        $HelpersFunction = new HelpersFunction();
        $checkingVehicleInAssessment = $HelpersFunction->checkingVehicleInAssessment($request->plate_no, $request->assessment_type);
        // $check = AssessmentAccidentVehicle::where('plate_no', $request->plate_no)
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
            // $check = AssessmentAccidentVehicle::where('plate_no', $request->plate_no)
            //     ->whereHas('hasAssessmentVehicleStatus', function($q){
            //         $q->whereIn('code', ['06']);
            //         })->whereHas('hasAssessmentDetail.hasStatus', function($q1){
            //             $q1->whereNotIn('code', ['00']);
            //     });

            //     Log::info('toSql() '.$check->toSql());
            //     Log::info('getBindings() ',$check->getBindings());

            if(count($checkingVehicleEverEvaluated) > 0){
                $response['status'] = 2;
                $response['data'] = $checkingVehicleEverEvaluated->first();;
                return $response;

            } else {
                $response['status'] = 0;

                if(auth()->user()->isPublic()){
                    $queryRegNumberIsExisted = AssessmentAccidentVehicle::where('plate_no', $request->plate_no)
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

    Route::post('/form-save', function (Request $request) {
        $AssessmentAccidentVehicleDAO = new AssessmentAccidentVehicleDAO();
        return $AssessmentAccidentVehicleDAO->upsertForm($request);
    })->name('.form.save');

    Route::post('/vehicle-save', function (Request $request) {
        $AssessmentAccidentVehicleDAO = new AssessmentAccidentVehicleDAO();
        return $AssessmentAccidentVehicleDAO->upsert($request);
    })->name('.vehicle.save');

    Route::post('/vehicle-information-save', function (Request $request) {
        $AssessmentAccidentVehicleDAO = new AssessmentAccidentVehicleDAO();
        return $AssessmentAccidentVehicleDAO->informationSave($request);
    })->name('.vehicle.information.save');

    Route::post('/vehicle-information-form-file-save', function(Request $request){
        $AssessmentDisposalVehicleDAO = new AssessmentAccidentVehicleDAO();
        return  $AssessmentDisposalVehicleDAO->informationSaveFormFile($request);
    })->name('.vehicle.information.form-file.save');

    Route::post('/vehicle-information-damage-form-file-save', function(Request $request){
        $AssessmentDisposalVehicleDAO = new AssessmentAccidentVehicleDAO();
        return  $AssessmentDisposalVehicleDAO->informationDamageImage($request);
    })->name('.vehicle.information.damage.form-file.save');

    Route::post('/vehicle-damage-save', function (Request $request) {
        $AssessmentAccidentVehicleDAO = new AssessmentAccidentVehicleDAO();
        return $AssessmentAccidentVehicleDAO->damageForm($request);
    })->name('.vehicle.damage.save');

    Route::post('/vehicle-damage-additional-cost', function (Request $request) {
        $AssessmentAccidentVehicleDAO = new AssessmentAccidentVehicleDAO();
        return $AssessmentAccidentVehicleDAO->damageCost($request);
    })->name('.vehicle.damage.cost');

    Route::post('/vehicle-damage-update-estimate-price', function (Request $request) {
        $AssessmentAccidentVehicleDAO = new AssessmentAccidentVehicleDAO();
        return $AssessmentAccidentVehicleDAO->updateDamageEstimatePrice($request);
    })->name('.vehicle.damage.update.estimate.price');

    Route::get('/vehicle-list', function (Request $request) {

        $AssessmentAccidentVehicleDAO = new AssessmentAccidentVehicleDAO();
        $vehicleList = $AssessmentAccidentVehicleDAO->list($request);

        $assessment_accident_id = session()->get('accident_current_detail_id');
        $hasAssessmentAccidentDetail = AssessmentAccident::find($assessment_accident_id);

        $category_list = RefCategory::all();
        $brand_list = Brand::where('status', 1)->orderBy('name')->get();

        return view('assessment.accident.ajax.assessment-accident-vehicle-list', [
            'hasAssessmentAccidentDetail' => $hasAssessmentAccidentDetail,
            'category_list' => $category_list,
            'brand_list' => $brand_list,
            'vehicleList' => $vehicleList,
            'assessment_accident_id' => $assessment_accident_id
        ]);
    })->name('.vehicle.list');

    Route::get('/struck-vehicle-list', function (Request $request) {

        $AssessmentAccidentVehicleDAO = new AssessmentAccidentVehicleDAO();
        $vehicleList = $AssessmentAccidentVehicleDAO->struckList($request);

        $assessment_accident_id = session()->get('accident_current_detail_id');
        $hasAssessmentAccidentDetail = AssessmentAccident::find($assessment_accident_id);

        $category_list = RefCategory::all();
        $brand_list = Brand::where('status', 1)->orderBy('name')->get();

        return view('assessment.accident.ajax.assessment-accident-struck-vehicle-list', [
            'hasAssessmentAccidentDetail' => $hasAssessmentAccidentDetail,
            'category_list' => $category_list,
            'brand_list' => $brand_list,
            'vehicleList' => $vehicleList,
            'assessment_accident_id' => $assessment_accident_id
        ]);
    })->name('.struck.vehicle.list');

    Route::get('/vehicle-appointment-list', function (Request $request) {

        $AssessmentAccidentVehicleDAO = new AssessmentAccidentVehicleDAO();
        $vehicleList = $AssessmentAccidentVehicleDAO->list($request);

        $assessment_accident_id = session()->get('accident_current_detail_id');
        $hasAssessmentAccidentDetail = AssessmentAccident::find($assessment_accident_id);

        $foremenList = $AssessmentAccidentVehicleDAO->foremenList();

        return view('assessment.accident.ajax.assessment-accident-vehicle-appointment-list', [
            'hasAssessmentAccidentDetail' => $hasAssessmentAccidentDetail,
            'vehicleList' => $vehicleList,
            'foremenList' => $foremenList,
            'assessment_accident_id' => $assessment_accident_id
        ]);
    })->name('.vehicle-appointment.list');

    Route::post('/vehicle-appointment-assign', function(Request $request){

        $AssessmentAccidentVehicleDAO = new AssessmentAccidentVehicleDAO();
        switch ($request->assign_to) {
            case 'formen':
                $AssessmentAccidentVehicleDAO->assignToFormen($request);
                break;

            default:
                # code...
                break;
        }

    })->name('.vehicle-appointment-assign');

    Route::get('/vehicle-assessment-list', function (Request $request) {

        $AssessmentAccidentVehicleDAO = new AssessmentAccidentVehicleDAO();
        $vehicleList = $AssessmentAccidentVehicleDAO->list($request);

        $assessment_accident_id = session()->get('accident_current_detail_id');
        $hasAssessmentAccidentDetail = AssessmentAccident::find($assessment_accident_id);

        return view('assessment.accident.ajax.assessment-accident-vehicle-assessment-list', [
            'hasAssessmentAccidentDetail' => $hasAssessmentAccidentDetail,
            'vehicleList' => $vehicleList->get(),
            'assessment_accident_id' => $assessment_accident_id
        ]);
    })->name('.vehicle-assessment.list');

    Route::get('/vehicle-assessment-damage-list', function (Request $request) {

        $AssessmentAccidentVehicleDAO = new AssessmentAccidentVehicleDAO();
        $damageList = $AssessmentAccidentVehicleDAO->damageList($request);
        $totalPriceList = 0;
        $totalPriceList2 = 0;
        foreach($damageList as $damage){
            $totalPriceList += ($damage->price_list + $damage->wages_cost);
            $totalPriceList2 += ($damage->price_list + $damage->spare_part_price);
        }

        $assessment_accident_id = session()->get('accident_current_detail_id');
        $hasAssessmentAccidentDetail = AssessmentAccident::find($assessment_accident_id);

        return view('assessment.accident.ajax.assessment-accident-vehicle-assessment-list', [
            'hasAssessmentAccidentDetail' => $hasAssessmentAccidentDetail,
            'damageList' => $damageList,
            'totalPriceList' => $totalPriceList,
            'totalPriceList2' => $totalPriceList2,
            'assessment_accident_id' => $assessment_accident_id
        ]);
    })->name('.vehicle-assessment-damage.list');

    Route::get('/vehicle-evaluation-damage-list', function (Request $request) {

        $AssessmentAccidentVehicleDAO = new AssessmentAccidentVehicleDAO();
        $damageList = $AssessmentAccidentVehicleDAO->damageList($request);
        $vehicleListFirst = $AssessmentAccidentVehicleDAO->vehicleListFirst($request);
        $totalPriceList = 0;
        foreach($damageList as $damage){
            $totalPriceList += ($damage->spare_part_price + $damage->wages_cost);
        }

        $assessment_accident_id = session()->get('accident_current_detail_id');
        Log::info('$assessment_accident_id => '.$assessment_accident_id);
        $hasAssessmentAccidentDetail = AssessmentAccident::find($assessment_accident_id);
        $foremenList = $AssessmentAccidentVehicleDAO->foremenList();

        Log::info($vehicleListFirst);

        return view('assessment.accident.ajax.assessment-accident-vehicle-evaluation-list', [
            'hasAssessmentAccidentDetail' => $hasAssessmentAccidentDetail,
            'damageList' => $damageList,
            'totalPriceList' => $totalPriceList,
            'vehicleList' => $vehicleListFirst,
            'foremenList' => $foremenList,
            'assessment_accident_id' => $assessment_accident_id
        ]);
    })->name('.vehicle-evaluation-damage.list');

    Route::get('/vehicle-approval-damage-list', function (Request $request) {

        $AssessmentAccidentVehicleDAO = new AssessmentAccidentVehicleDAO();
        $damageList = $AssessmentAccidentVehicleDAO->damageList($request);
        $vehicleListFirst = $AssessmentAccidentVehicleDAO->vehicleListFirst($request);
        $totalPriceList = 0;
        foreach($damageList as $damage){
            $totalPriceList += ($damage->spare_part_price + $damage->wages_cost);
        }

        $assessment_accident_id = session()->get('accident_current_detail_id');
        $hasAssessmentAccidentDetail = AssessmentAccident::find($assessment_accident_id);
        $foremenList = $AssessmentAccidentVehicleDAO->foremenList();
        $allowToUDAfterApprv = false;
        $querySetting = RefSetting::where('code', '04');

        $querySetting->whereHas('hasSub', function($q) use($hasAssessmentAccidentDetail){
            $q->where([
                'status' => 1,
                'value' => $hasAssessmentAccidentDetail->hasWorkshop->id
            ]);
        });

        if($querySetting->first()){
            $allowToUDAfterApprv = true;
        }

        Log::info($allowToUDAfterApprv);


        return view('assessment.accident.ajax.assessment-accident-vehicle-approval-list', [
            'hasAssessmentAccidentDetail' => $hasAssessmentAccidentDetail,
            'damageList' => $damageList,
            'vehicleList' => $vehicleListFirst,
            'totalPriceList' => $totalPriceList,
            'allowToUDAfterApprv' => $allowToUDAfterApprv,
            'assessment_accident_id' => $assessment_accident_id
        ]);
    })->name('.vehicle-approval-damage.list');

    Route::get('/vehicle-evaluation-list', function (Request $request) {

        $AssessmentAccidentVehicleDAO = new AssessmentAccidentVehicleDAO();
        $vehicleList = $AssessmentAccidentVehicleDAO->list($request);

        $assessment_accident_id = session()->get('accident_current_detail_id');
        $hasAssessmentAccidentDetail = AssessmentAccident::find($assessment_accident_id);

        return view('assessment.accident.ajax.assessment-accident-vehicle-evaluation-list', [
            'hasAssessmentAccidentDetail' => $hasAssessmentAccidentDetail,
            'vehicleList' => $vehicleList,
            'assessment_accident_id' => $assessment_accident_id
        ]);
    })->name('.vehicle-evaluation.list');

    Route::get('/vehicle-certificate-list', function (Request $request) {
        $AssessmentAccidentVehicleDAO = new AssessmentAccidentVehicleDAO();
        $vehicleList = $AssessmentAccidentVehicleDAO->list($request);

        $assessment_accident_id = session()->get('accident_current_detail_id');
        $hasAssessmentAccidentDetail = AssessmentAccident::find($assessment_accident_id);

        return view('assessment.accident.ajax.assessment-accident-vehicle-certificate-list', [
            'hasAssessmentAccidentDetail' => $hasAssessmentAccidentDetail,
            'vehicleList' => $vehicleList,
            'assessment_accident_id' => $assessment_accident_id
        ]);
    })->name('.vehicle-certificate.list');

    Route::get('/vehicle-certificate-checkGenuine', function (Request $request) {
        $AssessmentAccidentVehicleDAO = new AssessmentAccidentVehicleDAO();
        $detail = $AssessmentAccidentVehicleDAO->checkGenuine($request);
        return view('assessment.accident.accident-vehicle-certificate-check-genuine', [
            'detail' => $detail
        ]);
    })->name('.vehicle-certificate.checkGenuine');

    Route::post('/vehicle-assessment-generateForm', function(Request $request){
        $AssessmentAccidentVehicleDAO = new AssessmentAccidentVehicleDAO();
        // return $AssessmentAccidentVehicleDAO->generateForm($request);
    })->name('.vehicle-assessment.generateForm');

    Route::get('/vehicle-assessment-form', function(Request $request){
        $AssessmentAccidentVehicleDAO = new AssessmentAccidentVehicleDAO();
        $form = $AssessmentAccidentVehicleDAO->getForm($request);
        return view('assessment.accident.accident-vehicle-checklist-form',$form);
    })->name('.vehicle-assessment.form');

    Route::get('/vehicle-assessment-form-mockup', function(Request $request){
        $AssessmentAccidentVehicleDAO = new AssessmentAccidentVehicleDAO();
        $form = $AssessmentAccidentVehicleDAO->getForm($request);
        return view('assessment.accident.accident-vehicle-checklist-form-mockup',$form);
    })->name('.vehicle-assessment.form.mockup');

    Route::post('/vehicle-assessment-form-save', function(Request $request){
        $AssessmentAccidentVehicleDAO = new AssessmentAccidentVehicleDAO();
        return  $AssessmentAccidentVehicleDAO->saveForm($request);
    })->name('.vehicle-assessment.form.save');

    Route::get('/vehicle-assessment-viewCertificate', function(Request $request){
        $AssessmentAccidentVehicleDAO = new AssessmentAccidentVehicleDAO();
        $response = $AssessmentAccidentVehicleDAO->viewCertificate($request);
        return view('assessment.accident.accident-vehicle-certificate', $response);
    })->name('.vehicle-assessment.viewCertificate');

    Route::post('/vehicle-delete', function(Request $request){
        $AssessmentAccidentVehicleDAO = new AssessmentAccidentVehicleDAO();
        return  $AssessmentAccidentVehicleDAO->delete($request);
    })->name('.vehicle.delete');

    Route::post('/vehicle-damage-delete', function(Request $request){
        $AssessmentAccidentVehicleDAO = new AssessmentAccidentVehicleDAO();
        return  $AssessmentAccidentVehicleDAO->delete($request);
    })->name('.vehicle.damage.delete');

    Route::post('/vehicle-assessment-form-file-save', function(Request $request){
        $AssessmentSafetyVehicleDAO = new AssessmentAccidentVehicleDAO();
        return  $AssessmentSafetyVehicleDAO->saveFormFile($request);
    })->name('.vehicle-assessment.form-file.save');

    Route::post('/vehicle-updateStatus', function(Request $request){
        $AssessmentAccidentVehicleDAO = new AssessmentAccidentVehicleDAO();
        return  $AssessmentAccidentVehicleDAO->updateStatus($request);
    })->name('.vehicle.updateStatus');

    Route::get('/vehicle-getVehicleForm', function(Request $request){
        $AssessmentAccidentVehicleDAO = new AssessmentAccidentVehicleDAO();
        return $AssessmentAccidentVehicleDAO->getVehicleForm($request);
    })->name('.vehicle.getVehicleForm');

    Route::get('/vehicle-getStruckVehicleForm', function(Request $request){
        $AssessmentAccidentVehicleDAO = new AssessmentAccidentVehicleDAO();
        return $AssessmentAccidentVehicleDAO->getStruckVehicleForm($request);
    })->name('.vehicle.getStruckVehicleForm');

    Route::get('/vehicle-getDamageForm', function(Request $request){
        $AssessmentAccidentVehicleDAO = new AssessmentAccidentVehicleDAO();
        return $AssessmentAccidentVehicleDAO->getDamageForm($request);
    })->name('.vehicle.getDamageForm');

    Route::post('/vehicle-assignAppointment', function(Request $request){
        $AssessmentAccidentVehicleDAO = new AssessmentAccidentVehicleDAO();
        // $AssessmentAccidentVehicleDAO->assignAppointment($request);
    })->name('.vehicle.assignAppointment');

});



?>
