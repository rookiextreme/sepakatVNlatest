<?php

use App\Http\Controllers\Assessment\AssessmentDAO;
use App\Http\Controllers\Assessment\AssessmentOverviewDAO;
use App\Http\Controllers\Assessment\Calendar\AssessmentCalendarDAO;
use App\Http\Controllers\User\Detail\UserDetail;
use App\Http\Controllers\Assessment\Depreciation\VehicleDepreciationDAO;
use App\Models\Assessment\AssessmentVehicleImage;
use App\Models\Maintenance\MaintenanceJob;
use App\Models\Vehicle\Brand;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::group(['prefix' => 'assessment', 'as' => 'assessment', 'middleware' => 'auth'], function(){

    Route::get('/overview', function(Request $request){

        $AssessmentOverviewDAO = new AssessmentOverviewDAO();
        $TotalAssessmentNew = $AssessmentOverviewDAO->New($request);
        $TotalAssessmentSafety = $AssessmentOverviewDAO->Safety($request);
        $TotalAssessmentCurrvalue = $AssessmentOverviewDAO->Currvalue($request);
        $TotalAssessmentAccident = $AssessmentOverviewDAO->Accident($request);
        $TotalAssessmentGovLoan = $AssessmentOverviewDAO->GovLoan($request);
        $TotalAssessmentDisposal = $AssessmentOverviewDAO->Disposal($request);

        return view('assessment.assessment-overview', [
            'TotalAssessmentNew' => $TotalAssessmentNew,
            'TotalAssessmentSafety' => $TotalAssessmentSafety,
            'TotalAssessmentCurrvalue' => $TotalAssessmentCurrvalue,
            'TotalAssessmentAccident' => $TotalAssessmentAccident,
            'TotalAssessmentGovLoan' => $TotalAssessmentGovLoan,
            'TotalAssessmentDisposal' => $TotalAssessmentDisposal,
        ]);
    })->name('.overview');

    Route::get('/newentry', function(){
        return view('assessment.newentry');
    })->name('.newentry');

    Route::get('/calendar', function(Request $request){


        $user_id = auth()->user()->id;
        Log::info("userId : ".$user_id);

        $userDetail = new UserDetail();
        $workshop_id = $userDetail->getWorkshopIdByUserId($user_id)[0]->workshop_id;
        Log::info("workshop_id : ".$workshop_id);

        $assessmentCalendarDAO = new AssessmentCalendarDAO();

        $listAppoinments = $assessmentCalendarDAO->getAppoimentByWorkshopId($workshop_id);
        Log::info("totalList : ".count($listAppoinments));

         //Log::info('appointment_dt d-m-Y: '.date('d-m-Y', strtotime($listAppoinments[0]->appointmentdate)));
        // Log::info('appointment_dt d: '.date('d', strtotime($listAppoinments[0]->appointmentdate)));
        // Log::info('appointment_dt m: '.date('m', strtotime($listAppoinments[0]->appointmentdate)));

        return view('assessment.calendar',[

               'listAppoinments' => $listAppoinments
        ]);

    })->name('.calendar');

    Route::get('/report', function(){
        return view('assessment.assessment-report');
    })->name('.report');

    Route::get('/evaluation-record', function(){
        if(Auth::user()->isAdmin() || Auth::user()->detail->register_purpose !== 'is_jkr'){
            $user_id = auth()->user()->id;
            $maintenance_job_list = MaintenanceJob::select('*')
                                    ->join('fleet.fleet_public', 'fleet_public.id', '=', 'maintenance.job.vehicle_id')
                                    ->paginate(5);
            Log::info($maintenance_job_list);
            return view('assessment.evaluation-record', [
                'maintenance_job_list' => $maintenance_job_list
            ]);
        } else {
            return 'dont bypass';
        }
    })->name('.evaluation_record');

    Route::get('/assessment', function(){
        if(Auth::user()->isAdmin() || Auth::user()->detail->register_purpose !== 'is_jkr'){
            return view('assessment.evaluation-register');
        }else {
            return 'dont bypass';
        }
    })->name('.nonjkr.register.evaluation');

    Route::get('/calendarmonth', function(){
        Log::info("calendarmonth");
        $selectedMonth = request('selectedMonth') ? request('selectedMonth') : '';
        $selectedYear = request('selectedYear') ? request('selectedYear') : '';

        $user_id = auth()->user()->id;
        Log::info("userId : ".$user_id);

        $userDetail = new UserDetail();
        $workshop_id = $userDetail->getWorkshopIdByUserId($user_id)[0]->workshop_id;

        $assessmentCalendarDAO = new AssessmentCalendarDAO();

        $listAppoinments = $assessmentCalendarDAO->getAppoimentByWorkshopId($workshop_id);

        return view('assessment.calendarmonth',[
            'selectedMonth'=>$selectedMonth,
            'selectedYear'=>$selectedYear,
            'listAppoinments' => $listAppoinments]);
    })->name('.calendarmonth');


    Route::post('/vehicle-assessment-generateForm', function(Request $request){
        $AssessmentDAO = new AssessmentDAO();
        return $AssessmentDAO->generateForm($request);
    })->name('.vehicle-assessment.generateForm');

    Route::post('/vehicle-assessment-govloan-generateForm', function(Request $request){
        $AssessmentDAO = new AssessmentDAO();
        return $AssessmentDAO->generateFormGovloan($request);
    })->name('.vehicle-assessment-govloan.generateForm');

    Route::post('/vehicle-assessment-currvalue-generateForm', function(Request $request){
        $AssessmentDAO = new AssessmentDAO();
        return $AssessmentDAO->generateFormCurrvalue($request);
    })->name('.vehicle-assessment-currvalue.generateForm');

    Route::get('/checklist-report', function(Request $request){
        $AssessmentDAO = new AssessmentDAO();
        $obj = $AssessmentDAO->getCheckList($request);
        return view('assessment.assessment-checklist', $obj);
    })->name('.checklist-report');

    Route::get('/checklist-disposal-report', function(Request $request){
        Log::info("masuk sini");
        $AssessmentDAO = new AssessmentDAO();
        $obj = $AssessmentDAO->getDisposalCheckList($request);
        Log::info("return");
        return view('assessment.assessment-disposal-checklist', $obj);
    })->name('.checklist-disposal-report');

    Route::post('/vehicle-assessment-reset', function(Request $request){
        $AssessmentDAO = new AssessmentDAO();
        return $AssessmentDAO->resetAssessment($request);
    })->name('.vehicle.assessment.reset');

    Route::get('/vehicle-getVehicleDetail', function(Request $request){
        $AssessmentDAO = new AssessmentDAO();
        return $AssessmentDAO->getVehicleDetail($request);
    })->name('.getVehicleDetail');

    Route::post('/vehicle-editVehicle-save', function(Request $request){
        $AssessmentDAO = new AssessmentDAO();
        return $AssessmentDAO->editVehicleSave($request);
    })->name('.editVehicle.save');

    Route::get('/ajax/getModalVehicleImages', function(Request $request){
        // $fleetView = $request->fleet_view ? $request->fleet_view : 'department';
        // $vehicleId = $request->vehicle_id ? $request->vehicle_id : session()->get('vehicle_current_detail_id');
        $vehicle_id = $request->vehicle_id ? $request->vehicle_id : -1;
        $assessment_code = $request->assessment_code ? $request->assessment_code : -1;
        Log::info($vehicle_id);
        Log::info($assessment_code);
        $vehicleImages = AssessmentVehicleImage::where('vehicle_id', $vehicle_id)
                        ->whereHas('hasAssessmentType', function($q) use ($assessment_code){
                            $q->where('code', $assessment_code);
                        })->get();
        Log::info($vehicleImages);
        // switch ($fleetView) {
        //     case 'department':
        //         $vehicleImages = DB::select(DB::raw("select b.id, b.fleet_department_id AS vehicle_id, b.doc_name, b.doc_desc, b.doc_path, b.doc_path_thumbnail AS thumb_url, b.is_primary from fleet.fleet_department a
        //         join kenderaans.dokumens b ON b.fleet_department_id = a.id
        //         where a.id = ".$vehicleId." and b.doc_type = '".$doc_type."' order by b.is_primary desc"));
        //         break;
        //     case 'public':
        //         $vehicleImages = DB::select(DB::raw("select b.id, b.fleet_public_id AS vehicle_id, b.doc_name, b.doc_desc, b.doc_path, b.doc_path_thumbnail AS thumb_url, b.is_primary from fleet.fleet_public a
        //         join kenderaans.dokumens b ON b.fleet_public_id = a.id
        //         where a.id = ".$vehicleId." and b.doc_type = '".$doc_type."' order by b.is_primary desc"));
        //         break;
        // }
        return view('vehicle.vehicle-images', [
            'vehicleImages' => $vehicleImages
        ]);
    })->name('.ajax.getModalVehicleImages');

    require __DIR__.'/module-assessment-accident.php';
    require __DIR__.'/module-assessment-currvalue.php';
    require __DIR__.'/module-assessment-gov-loan.php';
    require __DIR__.'/module-assessment-disposal.php';
    require __DIR__.'/module-assessment-new.php';
    require __DIR__.'/module-assessment-safety.php';

    Route::get('/govloan', function(){
        return view('assessment.govloan');
    })->name('.govloan');

    Route::get('/disposal', function(){
        return view('assessment.disposal');
    })->name('.disposal');

    Route::get('/depreciation', function(){
        $vehicleDepreciationDAO = new VehicleDepreciationDAO();
        $listKelas = $vehicleDepreciationDAO->getKelas();
        $listArrayKelas = [];
        foreach($listKelas as $kelas){
            Log::info("kelas->kelas_id : ".$kelas->kelas_id);
            $listDataKelas = $vehicleDepreciationDAO->getDataByKelas($kelas->kelas_id);
//            $listArrayKelas->
            array_push($listArrayKelas, $listDataKelas);
        }

        Log::info("listArrayKelas size : ".count($listArrayKelas));

        $listKenderaan = $vehicleDepreciationDAO->getKenderaan();
        $listArrayKenderaan = [];
        foreach($listKenderaan as $kenderaan){
            Log::info("kenderaan->brand_id : ".$kenderaan->brand_id);
            $listKelasKenderaan = $vehicleDepreciationDAO->getKelasKenderaan($kenderaan->brand_id);

            array_push($listArrayKenderaan, $listKelasKenderaan);
        }

        $listKenderaanNotYetDefined = $vehicleDepreciationDAO->getKenderaanNotYetDefined();
        $listAllKenderaan = $vehicleDepreciationDAO->getAllKenderaan();
        $highestClass = $vehicleDepreciationDAO->getCurrentHighestClass();

        $highestClassInRoman = $vehicleDepreciationDAO->numberToRomanRepresentation($highestClass);

        $listBrand = Brand::orderBy('name', 'ASC')->get();

        Log::info("highestClassInRoman : ".$highestClassInRoman);

        return view('assessment.assessment-depreciation', [
            'listArrayKenderaan' => $listArrayKenderaan,
            'listArrayKelas' => $listArrayKelas,
            'listKenderaanNotYetDefined' => $listKenderaanNotYetDefined,
            'highestClassInRoman' => $highestClassInRoman,
            'highestClass' => $highestClass,
            'listKelas' => $listKelas,
            'listAllKenderaan' => $listAllKenderaan,
            'listBrand' => $listBrand


        ]);
    })->name('.depreciation');


    //////////

    Route::get('/report/overall', function(Request $request){

        $AssessmentDAO = new AssessmentDAO();

        $obj = $AssessmentDAO->reportOverall($request);

        return view('assessment.assessment-report-overall', $obj);

    })->name('.report.overall');

    Route::get('/report/agency/month', function(Request $request){

        $AssessmentDAO = new AssessmentDAO();

        $obj = $AssessmentDAO->reportAgencyByMonth($request);

        return view('assessment.assessment-report-agency-month', $obj);

    })->name('.report.agency.month');

    Route::get('/report/branch/month', function(Request $request){

        $AssessmentDAO = new AssessmentDAO();

        $obj = $AssessmentDAO->reportBranchByMonth($request);

        return view('assessment.assessment-report-branch-month', $obj);

    })->name('.report.branch.month');

    Route::get('/report/branch/year', function(Request $request){

        $AssessmentDAO = new AssessmentDAO();

        $obj = $AssessmentDAO->reportBranchByYear($request);

        return view('assessment.assessment-report-branch-year', $obj);

    })->name('.report.branch.year');

    Route::get('/report/vtl_ckmn', [AssessmentDAO::class, 'reportVtlCkmn'])->name('.report.vtl_ckmn');

    Route::get('/report/vtl_cwgn', [AssessmentDAO::class, 'reportVtlCwgn'])->name('.report.vtl_cwgn');


    //////////

    Route::get('/report/placement/state/assessment', function(Request $request){

        $AssessmentDAO = new AssessmentDAO();

        $obj = $AssessmentDAO->reportPlacementStateByAssessment($request);

        return view('assessment.assessment-report-placement-state-assessment', $obj);

    })->name('.report.placement.state.assessment');

    Route::get('/report/branch/assessment', function(Request $request){

        $AssessmentDAO = new AssessmentDAO();

        $obj = $AssessmentDAO->reportBranchByAssessment($request);

        return view('assessment.assessment-report-branch-assessment', $obj);

    })->name('.report.branch.assessment');

});


