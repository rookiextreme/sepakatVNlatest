<?php

use App\Exports\ReportDisasterReadyExportView;
use App\Http\Controllers\Assessment\Disposal\AssessmentDisposalDAO;
use App\Http\Controllers\Report\ReportAssessmentDAO;
use App\Http\Controllers\Report\ReportDetailMaintenanceDAO;
use App\Http\Controllers\Report\ReportDisasterReadyDAO;
use App\Http\Controllers\Report\ReportLogisticCompositionDAO;
use App\Http\Controllers\Report\ReportMaintenanceDAO;
use App\Http\Controllers\Report\ReportVehicleCompositionDAO;
use App\Http\Controllers\Report\ReportSummonsCompositionDAO;
use App\Http\Controllers\Report\ReportVehicleTrendDAO;
use App\Http\Controllers\Report\ReportSummonTrendDAO;
use App\Http\Controllers\Report\ReportMapPeninsularDAO;
use App\Http\Controllers\Report\ReportSummonDAO;
use App\Http\Controllers\Report\ReportVehicleDAO;
use App\Http\Controllers\Report\ReportWarrantDAO;
use App\Http\Controllers\Vehicle\VehicleDAO;
use App\Models\Fleet\FleetDepartment;
use App\Models\FleetPlacement;
use App\Models\GeneralRecordCount;
use App\Models\MaintenanceRepairInOutReport2021;
use App\Models\MaintenanceRepairReportCount;
use App\Models\MaintenanceRepairReportCount2021;
use App\Models\MaintenanceServiceInOutReport2021;
use App\Models\MaintenanceServiceReportCount;
use App\Models\RefComponentChecklistLvl1;
use App\Models\RefComponentLvl1;
use App\Models\RefMap;
use App\Models\RefMapPosition;
use App\Models\RefMonth;
use App\Models\RefOwner;
use App\Models\RefState;
use App\Models\RefWorkshop;
use App\Models\ReportMaintenanceEvaluation;
use App\Models\Saman\MaklumatSaman;
use App\Models\Saman\MaklumatKenderaanSaman;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

Route::group(['prefix' => 'report', 'as' => 'report', 'middleware' => 'auth'], function(){

    Route::get('/report_compositions', function(Request $request){

        $ReportVehicleCompositionDAO = new ReportVehicleCompositionDAO();
        $data = $ReportVehicleCompositionDAO->getCompositionBy($request);
        $composition_by = $request->composition_by;
        $graph_type = $request->graph_type;
        Log::info("composition by : ".$composition_by);
        Log::info("graph_type : ".$graph_type);

        return view('report.report_compositions', [
            'data' => $data,
            'composition_by'=>$composition_by,
            'graph_type'=>$graph_type
        ]);
    })->name('.report_compositions');

    Route::get('/report_map_peninsular', function(){

        $obj = [
            'johor' => RefMapPosition::whereHas('hasMap.hasState', function($q){
                $q->where('code', '01');
            })->get(),
            'kedah' => RefMapPosition::whereHas('hasMap.hasState', function($q){
                $q->where('code', '02');
            })->get(),
            'kelantan' => RefMapPosition::whereHas('hasMap.hasState', function($q){
                $q->where('code', '03');
            })->get(),
            'melaka' => RefMapPosition::whereHas('hasMap.hasState', function($q){
                $q->where('code', '04');
            })->get(),
            'n9' => RefMapPosition::whereHas('hasMap.hasState', function($q){
                $q->where('code', '05');
            })->get(),
            'pahang' => RefMapPosition::whereHas('hasMap.hasState', function($q){
                $q->where('code', '06');
            })->get(),
            'perak' => RefMapPosition::whereHas('hasMap.hasState', function($q){
                $q->where('code', '07');
            })->get(),
            'perlis' => RefMapPosition::whereHas('hasMap.hasState', function($q){
                $q->where('code', '08');
            })->get(),
            'penang' => RefMapPosition::whereHas('hasMap.hasState', function($q){
                $q->where('code', '09');
            })->get(),
            'sabah' => RefMapPosition::whereHas('hasMap.hasState', function($q){
                $q->where('code', '10');
            })->get(),
            'sarawak' => RefMapPosition::whereHas('hasMap.hasState', function($q){
                $q->where('code', '11');
            })->get(),
            'selangor' => RefMapPosition::whereHas('hasMap.hasState', function($q){
                $q->where('code', '12');
            })->get(),
            'terengganu' => RefMapPosition::whereHas('hasMap.hasState', function($q){
                $q->where('code', '13');
            })->get(),
            'kl' => RefMapPosition::whereHas('hasMap.hasState', function($q){
                $q->where('code', '14');
            })->get(),
            'wilayah' => RefMapPosition::whereHas('hasMap.hasState', function($q){
                $q->whereIn('code', ['14','15','16']);
            })->get(),
        ];

        return view('report.report_map_peninsular', $obj);
    })->name('.report_map_peninsular');

    Route::post('/update_map_position', function(Request $request){

        // Log::info($request->map_position);
        foreach ($request->map_position as $index => $key) {

            try {
                // Log::info($key);
                $placement = FleetPlacement::find($key['placement_id']);
                $refMap = RefMap::where('state_id', $placement->ref_state_id)->first();
                $data = [];
                $data['map_position_left'] = $key['map_position_left'];
                $data['map_position_right'] = $key['map_position_right'];
                $data['map_position_top'] = $key['map_position_top'];
                $data['placement_id'] = $key['placement_id'];
                $data['desc_bm'] = $key['desc_bm'];
                $data['desc_en'] = $key['desc_bm'];
                $data['map_id'] = $refMap->id;
                RefMapPosition::create($data);
            } catch (\Throwable $th) {
                Log::info($th);
                //throw $th;
            }

        }

    })->name('.update_map_position');


    // start report latest
    //report_appl_map
    Route::get('/report_appl_map_assessment', function(Request $request){
        return view('report.report_appl_map_assessment');
    })->name('.report_assessment_map');

    //report_appl_by_mth
    Route::get('/report_appl_by_mth', function(Request $request){
        $reportComposition = new ReportAssessmentDAO();
        $workshop = $reportComposition->getWorkshop($request);
        $new = $reportComposition->getNew($request);
        $acc = $reportComposition->getAcc($request);
        $curr = $reportComposition->getCurr($request);
        $dis = $reportComposition->getDis($request);
        $saf = $reportComposition->getSaf($request);
        $gov = $reportComposition->getGov($request);
        $month = $request->month ? $request->month : Carbon::now()->format('F');
        $year = $request->year ? $request->year : Carbon::now()->format('Y');

        return view('report.report_appl_by_mth', [
            'month' => $month,
            'year' => $year,
            'workshop' => $workshop,
            'data' => $new,
            'acc' => $acc,
            'curr' => $curr,
            'dis' => $dis,
            'saf' => $saf,
            'gov' => $gov,
        ]);
    })->name('.report_appl_by_mth');

    //report_appl_by_wsp
    Route::get('/report_appl_by_wsp', function(Request $request){
        $reportComposition = new ReportAssessmentDAO();
        $workshop_id = $request->workshop_id ? $request->workshop_id : 1;
        $data = $reportComposition->getByWsp($request);
        $assessment_type = $request->assessment_type ? $request->assessment_type : 'new';
        $month = $request->month ? $request->month : '00';
        $year = $request->year ? $request->year : Carbon::now()->format('Y');

        return view('report.report_appl_by_wsp', [
            'workshop_id' => $workshop_id,
            'assessment_type' => $assessment_type,
            'month' => $month,
            'year' => $year,
            'data' => $data,
            'workshop_list' => RefWorkshop::all(),
        ]);
    })->name('.report_appl_by_wsp');

    //report_assessment_stmt
    Route::get('/report_assessment_stmt', function(Request $request){

        $carbon = new Carbon();
        $carbon->setLocale('ms');

        $assessment_type = $request->assessment_type ? $request->assessment_type : 'new';
        $reportComposition = new ReportAssessmentDAO();
        $data = $reportComposition->getAssmtStmt($request);
        $month = $request->month ? $request->month : Carbon::now()->format('F');
        $year = $request->year ? $request->year : Carbon::now()->format('Y');

        return view('report.report_assessment_stmt', [
            'assessment_type' => $assessment_type,
            'month' => $month,
            'year' => $year,
            'data' => $data,
        ]);
    })->name('.report_assessment_stmt');

    //report_maintenance_stmt
    Route::get('/report_maintenance_stmt', function(Request $request){
        $reportComposition = new ReportVehicleCompositionDAO();
        $data = $reportComposition->getMtntStmt($request);
        $month = $request->month ? $request->month : Carbon::now()->format('F');
        $year = $request->year ? $request->year : Carbon::now()->format('Y');

        return view('report.report_maintenance_stmt', [
            'month' => $month,
            'year' => $year,
            'data' => $data,
        ]);
    })->name('.report_maintenance_stmt');


    //assessment_compositions
    Route::get('/assessment_compositions', function(Request $request){
        $reportComposition = new ReportVehicleCompositionDAO();
        $data = $reportComposition->getMtntStmt($request);
        $month = $request->month ? $request->month : Carbon::now()->format('F');
        $year = $request->year ? $request->year : Carbon::now()->format('Y');

        return view('report.assessment_compositions', [
            'month' => $month,
            'year' => $year,
            'data' => $data,
        ]);
    })->name('.assessment_compositions');
    //end report latest

    Route::get('/report_district_details', function(Request $request){


        $stateCode = $request -> stateCode;
        Log::info("stateCode : ".$stateCode);

        $reportMapPeninsularDAO = new ReportMapPeninsularDAO();
        $listDistrictAsset = $reportMapPeninsularDAO->getTotalDistrictByStateCode($stateCode);



        return $listDistrictAsset;
    })->name('.report_district_details');

    Route::get('/report_map_state', function(){
        return view('report.report_map_state');
    })->name('.report_map_state');

    Route::get('/report_timeline', function(){
        return view('report.report_timeline');
    })->name('.report_timeline');



    Route::get('/report_trend_analysis', function(Request $request){

        $trend_on = $request->trend_on;
        $current_year = $request->current_year;
        // Log::info("trend_on : "+$trend_on);

        if($current_year == null || $current_year == ''){

            $current_year = date("Y");
        }

         $ReportVehicleTrendDAO = new ReportVehicleTrendDAO();
         $data = $ReportVehicleTrendDAO->getTrendOn($trend_on, $current_year);

         $differences = [];
         $difference = 0;
         foreach ($data as $index=>$item){

            if ($index >1 && $index<(count($data))){

                //$handleZero = $data[$index]->total == 0 ? 1 : $data[$index]->total;
                $newValue = ($data[$index])->total;
                $oldValue = ($data[$index-1])->total;


                if($oldValue==0){
                    $difference =$newValue;
                }else{

                    $difference = ($newValue - $oldValue )/$oldValue*100;

                }

                //Log::info("$index : ".$index." -newValue  ".$newValue." - oldvalue : ".$oldValue." - diference : ".$difference);

            }
            //Log::info("differences value : ".$difference);
            array_push($differences, $difference);
         }






        Log::info("differences size = ".count($differences));

        //return view('report.report_trend_analysis');
        return view('report.report_trend_analysis', [
            'data' => $data,
            'trendOn'=>$trend_on,
            'currentYear'=>$current_year,
            'differences'=>$differences
        ]);
    })->name('.report_trend_analysis');

    Route::get('/report_summons', function(Request $request){

        $ReportSummonsCompositionDAO = new ReportSummonsCompositionDAO();
        $data = $ReportSummonsCompositionDAO->getIssuedBy($request);
        $issued_by = $request->issued_by;
        $graph_type = $request->graph_type;
        Log::info("issued by : ".$issued_by);

        Log::info("graph_type : ".$graph_type);
        return view('report.report_summons', [
            'data' => $data,
            'issued_by'=>$issued_by,
            'graph_type'=>$graph_type
        ]);
    })->name('.report_summons');



    Route::get('/report_completion', function(Request $request){

        $year = $request->year;
        $month = $request->month;
        // Log::info("trend_on : "+$trend_on);

        if($year == null || $year == ''){

            $year = date("Y");
        }

        if($month == null || $month == ''){

            $month = date("n");
        }

        $trend_on = 'issuance';

        $ReportSummonTrendDAO = new ReportSummonTrendDAO();
        $data_paid = $ReportSummonTrendDAO->getTrendOn($trend_on, $year, $month, 'paid');
        $data_unpaid = $ReportSummonTrendDAO->getTrendOn($trend_on, $year,  $month, 'unpaid');
        $data_all = $ReportSummonTrendDAO->getTrendOn($trend_on, $year,  $month, 'all');
        //$data_paid_yearly = $ReportSummonTrendDAO->getTrendYearly($year, 'paid');
        //$data_all_yearly = $ReportSummonTrendDAO->getTrendYearly($year, 'all');


        return view('report.report_completion', [
            'data_paid' => $data_paid,
            'data_all' => $data_all,
            'data_unpaid' => $data_unpaid,
            //'data_paid_yearly' => $data_paid_yearly,
            //'data_all_yearly' => $data_all_yearly,
            'year' => $year,
            'month' => $month


        ]);
    })->name('.report_completion');

    Route::get('/report_custom_list', function(){
        return view('report.report_custom');
    })->name('.report_custom');

    Route::get('/report_custom_data', function(){
        return view('report.report_custom_data');
    })->name('.report_custom_data');

    Route::get('/report_custom_details', function(){
        return view('report.report_custom_details');
    })->name('.report_custom_details');

    Route::get('/report_summons_summary', function(){
        $samanCount = MaklumatKenderaanSaman::select(
            'pendaftaran_id AS pendaftaran_id',
            'fleet.fleet_lookup_vehicle_view.placement_id AS placement_id',
            'saman.maklumat_saman.summon_agency_id AS summon_agency_id',
            'fleet.fleet_placement.is_district_of_state AS is_district_of_state',
            'status_saman_id AS status_saman_id'
        )
        ->leftJoin('saman.maklumat_saman','saman.maklumat_saman.maklumat_kenderaan_saman_id','=','saman.maklumat_kenderaan_saman.id')
        ->leftJoin('fleet.fleet_lookup_vehicle_view','fleet.fleet_lookup_vehicle_view.id','=','saman.maklumat_kenderaan_saman.pendaftaran_id')
        ->leftJoin('fleet.fleet_placement','fleet.fleet_placement.id','=','fleet.fleet_lookup_vehicle_view.placement_id')
        ->where('status_saman_id','>','1')
        ->where('placement_id','>','0');



        $total_summon = MaklumatKenderaanSaman::select(
            'pendaftaran_id AS pendaftaran_id',
            'fleet.fleet_lookup_vehicle_view.placement_id AS placement_id',
            'saman.maklumat_saman.summon_agency_id AS summon_agency_id',
            'fleet.fleet_placement.is_district_of_state AS is_district_of_state',
            'status_saman_id AS status_saman_id'
        )
        ->leftJoin('saman.maklumat_saman','saman.maklumat_saman.maklumat_kenderaan_saman_id','=','saman.maklumat_kenderaan_saman.id')
        ->leftJoin('fleet.fleet_lookup_vehicle_view','fleet.fleet_lookup_vehicle_view.id','=','saman.maklumat_kenderaan_saman.pendaftaran_id')
        ->leftJoin('fleet.fleet_placement','fleet.fleet_placement.id','=','fleet.fleet_lookup_vehicle_view.placement_id')
        ->where('status_saman_id','>','1')
        ->where('placement_id','>','0')->count();

        $total_pdrm_summon = MaklumatKenderaanSaman::select(
            'pendaftaran_id AS pendaftaran_id',
            'fleet.fleet_lookup_vehicle_view.placement_id AS placement_id',
            'saman.maklumat_saman.summon_agency_id AS summon_agency_id',
            'fleet.fleet_placement.is_district_of_state AS is_district_of_state',
            'status_saman_id AS status_saman_id'
        )
        ->leftJoin('saman.maklumat_saman','saman.maklumat_saman.maklumat_kenderaan_saman_id','=','saman.maklumat_kenderaan_saman.id')
        ->leftJoin('fleet.fleet_lookup_vehicle_view','fleet.fleet_lookup_vehicle_view.id','=','saman.maklumat_kenderaan_saman.pendaftaran_id')
        ->leftJoin('fleet.fleet_placement','fleet.fleet_placement.id','=','fleet.fleet_lookup_vehicle_view.placement_id')
        ->where('status_saman_id','>','1')
        ->where('placement_id','>','0')->Where('summon_agency_id','=','1')->count();


        $total_jpj_summon = MaklumatKenderaanSaman::select(
            'pendaftaran_id AS pendaftaran_id',
            'fleet.fleet_lookup_vehicle_view.placement_id AS placement_id',
            'saman.maklumat_saman.summon_agency_id AS summon_agency_id',
            'fleet.fleet_placement.is_district_of_state AS is_district_of_state',
            'status_saman_id AS status_saman_id'
        )
        ->leftJoin('saman.maklumat_saman','saman.maklumat_saman.maklumat_kenderaan_saman_id','=','saman.maklumat_kenderaan_saman.id')
        ->leftJoin('fleet.fleet_lookup_vehicle_view','fleet.fleet_lookup_vehicle_view.id','=','saman.maklumat_kenderaan_saman.pendaftaran_id')
        ->leftJoin('fleet.fleet_placement','fleet.fleet_placement.id','=','fleet.fleet_lookup_vehicle_view.placement_id')
        ->where('status_saman_id','>','1')
        ->where('placement_id','>','0')->Where('summon_agency_id','=','2')->count();

        $total_pbt_summon = MaklumatKenderaanSaman::select(
            'pendaftaran_id AS pendaftaran_id',
            'fleet.fleet_lookup_vehicle_view.placement_id AS placement_id',
            'saman.maklumat_saman.summon_agency_id AS summon_agency_id',
            'fleet.fleet_placement.is_district_of_state AS is_district_of_state',
            'status_saman_id AS status_saman_id'
        )
        ->leftJoin('saman.maklumat_saman','saman.maklumat_saman.maklumat_kenderaan_saman_id','=','saman.maklumat_kenderaan_saman.id')
        ->leftJoin('fleet.fleet_lookup_vehicle_view','fleet.fleet_lookup_vehicle_view.id','=','saman.maklumat_kenderaan_saman.pendaftaran_id')
        ->leftJoin('fleet.fleet_placement','fleet.fleet_placement.id','=','fleet.fleet_lookup_vehicle_view.placement_id')
        ->where('status_saman_id','>','1')
        ->where('placement_id','>','0')->where('summon_agency_id','=','3')->count();

        $total_paid_summon = MaklumatKenderaanSaman::select(
            'pendaftaran_id AS pendaftaran_id',
            'fleet.fleet_lookup_vehicle_view.placement_id AS placement_id',
            'saman.maklumat_saman.summon_agency_id AS summon_agency_id',
            'fleet.fleet_placement.is_district_of_state AS is_district_of_state',
            'status_saman_id AS status_saman_id'
        )
        ->leftJoin('saman.maklumat_saman','saman.maklumat_saman.maklumat_kenderaan_saman_id','=','saman.maklumat_kenderaan_saman.id')
        ->leftJoin('fleet.fleet_lookup_vehicle_view','fleet.fleet_lookup_vehicle_view.id','=','saman.maklumat_kenderaan_saman.pendaftaran_id')
        ->leftJoin('fleet.fleet_placement','fleet.fleet_placement.id','=','fleet.fleet_lookup_vehicle_view.placement_id')
        ->where('status_saman_id','>','1')
        ->where('placement_id','>','0')->where('status_saman_id','=','3')->count();

        $total_unpaid_summon = MaklumatKenderaanSaman::select(
            'pendaftaran_id AS pendaftaran_id',
            'fleet.fleet_lookup_vehicle_view.placement_id AS placement_id',
            'saman.maklumat_saman.summon_agency_id AS summon_agency_id',
            'fleet.fleet_placement.is_district_of_state AS is_district_of_state',
            'status_saman_id AS status_saman_id'
        )
        ->leftJoin('saman.maklumat_saman','saman.maklumat_saman.maklumat_kenderaan_saman_id','=','saman.maklumat_kenderaan_saman.id')
        ->leftJoin('fleet.fleet_lookup_vehicle_view','fleet.fleet_lookup_vehicle_view.id','=','saman.maklumat_kenderaan_saman.pendaftaran_id')
        ->leftJoin('fleet.fleet_placement','fleet.fleet_placement.id','=','fleet.fleet_lookup_vehicle_view.placement_id')
        ->where('status_saman_id','>','1')
        ->where('placement_id','>','0')->where('status_saman_id','=','4')->count();

        $total_paid_summon_pctg = 0 ;
        $total_unpaid_summon_pctg = 0 ;

        if($total_summon != 0){
            $total_paid_summon_pctg = $total_paid_summon / $total_summon * 100 ;
            $total_unpaid_summon_pctg = $total_unpaid_summon / $total_summon * 100 ;
            $total_paid_summon_pctg = number_format($total_paid_summon_pctg,2);
            $total_unpaid_summon_pctg = number_format($total_unpaid_summon_pctg,2);
        }

        $total_summon_hq = MaklumatKenderaanSaman::select(
            'pendaftaran_id AS pendaftaran_id',
            'fleet.fleet_lookup_vehicle_view.placement_id AS placement_id',
            'saman.maklumat_saman.summon_agency_id AS summon_agency_id',
            'fleet.fleet_placement.is_district_of_state AS is_district_of_state',
            'status_saman_id AS status_saman_id'
        )
        ->leftJoin('saman.maklumat_saman','saman.maklumat_saman.maklumat_kenderaan_saman_id','=','saman.maklumat_kenderaan_saman.id')
        ->leftJoin('fleet.fleet_lookup_vehicle_view','fleet.fleet_lookup_vehicle_view.id','=','saman.maklumat_kenderaan_saman.pendaftaran_id')
        ->leftJoin('fleet.fleet_placement','fleet.fleet_placement.id','=','fleet.fleet_lookup_vehicle_view.placement_id')
        ->where('status_saman_id','>','1')
        ->where('placement_id','>','0')->where('is_district_of_state','=','false')->count();

        $total_summon_hq_pdrm = MaklumatKenderaanSaman::select(
            'pendaftaran_id AS pendaftaran_id',
            'fleet.fleet_lookup_vehicle_view.placement_id AS placement_id',
            'saman.maklumat_saman.summon_agency_id AS summon_agency_id',
            'fleet.fleet_placement.is_district_of_state AS is_district_of_state',
            'status_saman_id AS status_saman_id'
        )
        ->leftJoin('saman.maklumat_saman','saman.maklumat_saman.maklumat_kenderaan_saman_id','=','saman.maklumat_kenderaan_saman.id')
        ->leftJoin('fleet.fleet_lookup_vehicle_view','fleet.fleet_lookup_vehicle_view.id','=','saman.maklumat_kenderaan_saman.pendaftaran_id')
        ->leftJoin('fleet.fleet_placement','fleet.fleet_placement.id','=','fleet.fleet_lookup_vehicle_view.placement_id')
        ->where('status_saman_id','>','1')
        ->where('placement_id','>','0')->where('is_district_of_state','=','false')->where('summon_agency_id','=','1')->count();

        $total_summon_hq_jpj = MaklumatKenderaanSaman::select(
            'pendaftaran_id AS pendaftaran_id',
            'fleet.fleet_lookup_vehicle_view.placement_id AS placement_id',
            'saman.maklumat_saman.summon_agency_id AS summon_agency_id',
            'fleet.fleet_placement.is_district_of_state AS is_district_of_state',
            'status_saman_id AS status_saman_id'
        )
        ->leftJoin('saman.maklumat_saman','saman.maklumat_saman.maklumat_kenderaan_saman_id','=','saman.maklumat_kenderaan_saman.id')
        ->leftJoin('fleet.fleet_lookup_vehicle_view','fleet.fleet_lookup_vehicle_view.id','=','saman.maklumat_kenderaan_saman.pendaftaran_id')
        ->leftJoin('fleet.fleet_placement','fleet.fleet_placement.id','=','fleet.fleet_lookup_vehicle_view.placement_id')
        ->where('status_saman_id','>','1')
        ->where('placement_id','>','0')->where('is_district_of_state','=','false')->where('summon_agency_id','=','2')->count();

        $total_summon_hq_pbt =MaklumatKenderaanSaman::select(
            'pendaftaran_id AS pendaftaran_id',
            'fleet.fleet_lookup_vehicle_view.placement_id AS placement_id',
            'saman.maklumat_saman.summon_agency_id AS summon_agency_id',
            'fleet.fleet_placement.is_district_of_state AS is_district_of_state',
            'status_saman_id AS status_saman_id'
        )
        ->leftJoin('saman.maklumat_saman','saman.maklumat_saman.maklumat_kenderaan_saman_id','=','saman.maklumat_kenderaan_saman.id')
        ->leftJoin('fleet.fleet_lookup_vehicle_view','fleet.fleet_lookup_vehicle_view.id','=','saman.maklumat_kenderaan_saman.pendaftaran_id')
        ->leftJoin('fleet.fleet_placement','fleet.fleet_placement.id','=','fleet.fleet_lookup_vehicle_view.placement_id')
        ->where('status_saman_id','>','1')
        ->where('placement_id','>','0')->where('is_district_of_state','=','false')->where('summon_agency_id','=','3')->count();

        $total_summon_hq_paid = MaklumatKenderaanSaman::select(
            'pendaftaran_id AS pendaftaran_id',
            'fleet.fleet_lookup_vehicle_view.placement_id AS placement_id',
            'saman.maklumat_saman.summon_agency_id AS summon_agency_id',
            'fleet.fleet_placement.is_district_of_state AS is_district_of_state',
            'status_saman_id AS status_saman_id'
        )
        ->leftJoin('saman.maklumat_saman','saman.maklumat_saman.maklumat_kenderaan_saman_id','=','saman.maklumat_kenderaan_saman.id')
        ->leftJoin('fleet.fleet_lookup_vehicle_view','fleet.fleet_lookup_vehicle_view.id','=','saman.maklumat_kenderaan_saman.pendaftaran_id')
        ->leftJoin('fleet.fleet_placement','fleet.fleet_placement.id','=','fleet.fleet_lookup_vehicle_view.placement_id')
        ->where('status_saman_id','>','1')
        ->where('placement_id','>','0')->where('is_district_of_state','=','false')->where('status_saman_id','=','3')->count();

        $total_summon_hq_unpaid = MaklumatKenderaanSaman::select(
            'pendaftaran_id AS pendaftaran_id',
            'fleet.fleet_lookup_vehicle_view.placement_id AS placement_id',
            'saman.maklumat_saman.summon_agency_id AS summon_agency_id',
            'fleet.fleet_placement.is_district_of_state AS is_district_of_state',
            'status_saman_id AS status_saman_id'
        )
        ->leftJoin('saman.maklumat_saman','saman.maklumat_saman.maklumat_kenderaan_saman_id','=','saman.maklumat_kenderaan_saman.id')
        ->leftJoin('fleet.fleet_lookup_vehicle_view','fleet.fleet_lookup_vehicle_view.id','=','saman.maklumat_kenderaan_saman.pendaftaran_id')
        ->leftJoin('fleet.fleet_placement','fleet.fleet_placement.id','=','fleet.fleet_lookup_vehicle_view.placement_id')
        ->where('status_saman_id','>','1')
        ->where('placement_id','>','0')->where('is_district_of_state','=','false')->where('status_saman_id','=','4')->count();

        $total_summon_hq_paid_pctg = 0;
        $total_summon_hq_unpaid_pctg = 0 ;

        if($total_summon_hq != 0){
            $total_summon_hq_paid_pctg = $total_summon_hq_paid / $total_summon_hq * 100 ;
            $total_summon_hq_unpaid_pctg = $total_summon_hq_unpaid / $total_summon_hq * 100 ;
            $total_summon_hq_paid_pctg = number_format($total_summon_hq_paid_pctg,2);
            $total_summon_hq_unpaid_pctg = number_format($total_summon_hq_unpaid_pctg,2);
        }

        $total_summon_negeri = MaklumatKenderaanSaman::select(
            'pendaftaran_id AS pendaftaran_id',
            'fleet.fleet_lookup_vehicle_view.placement_id AS placement_id',
            'saman.maklumat_saman.summon_agency_id AS summon_agency_id',
            'fleet.fleet_placement.is_district_of_state AS is_district_of_state',
            'status_saman_id AS status_saman_id'
        )
        ->leftJoin('saman.maklumat_saman','saman.maklumat_saman.maklumat_kenderaan_saman_id','=','saman.maklumat_kenderaan_saman.id')
        ->leftJoin('fleet.fleet_lookup_vehicle_view','fleet.fleet_lookup_vehicle_view.id','=','saman.maklumat_kenderaan_saman.pendaftaran_id')
        ->leftJoin('fleet.fleet_placement','fleet.fleet_placement.id','=','fleet.fleet_lookup_vehicle_view.placement_id')
        ->where('status_saman_id','>','1')
        ->where('placement_id','>','0')->where('is_district_of_state','=','true')->count();

        $total_summon_negeri_pdrm = MaklumatKenderaanSaman::select(
            'pendaftaran_id AS pendaftaran_id',
            'fleet.fleet_lookup_vehicle_view.placement_id AS placement_id',
            'saman.maklumat_saman.summon_agency_id AS summon_agency_id',
            'fleet.fleet_placement.is_district_of_state AS is_district_of_state',
            'status_saman_id AS status_saman_id'
        )
        ->leftJoin('saman.maklumat_saman','saman.maklumat_saman.maklumat_kenderaan_saman_id','=','saman.maklumat_kenderaan_saman.id')
        ->leftJoin('fleet.fleet_lookup_vehicle_view','fleet.fleet_lookup_vehicle_view.id','=','saman.maklumat_kenderaan_saman.pendaftaran_id')
        ->leftJoin('fleet.fleet_placement','fleet.fleet_placement.id','=','fleet.fleet_lookup_vehicle_view.placement_id')
        ->where('status_saman_id','>','1')
        ->where('placement_id','>','0')->where('is_district_of_state','=','true')->where('summon_agency_id','=','1')->count();

        $total_summon_negeri_jpj = MaklumatKenderaanSaman::select(
            'pendaftaran_id AS pendaftaran_id',
            'fleet.fleet_lookup_vehicle_view.placement_id AS placement_id',
            'saman.maklumat_saman.summon_agency_id AS summon_agency_id',
            'fleet.fleet_placement.is_district_of_state AS is_district_of_state',
            'status_saman_id AS status_saman_id'
        )
        ->leftJoin('saman.maklumat_saman','saman.maklumat_saman.maklumat_kenderaan_saman_id','=','saman.maklumat_kenderaan_saman.id')
        ->leftJoin('fleet.fleet_lookup_vehicle_view','fleet.fleet_lookup_vehicle_view.id','=','saman.maklumat_kenderaan_saman.pendaftaran_id')
        ->leftJoin('fleet.fleet_placement','fleet.fleet_placement.id','=','fleet.fleet_lookup_vehicle_view.placement_id')
        ->where('status_saman_id','>','1')
        ->where('placement_id','>','0')->where('is_district_of_state','=','true')->where('summon_agency_id','=','2')->count();

        $total_summon_negeri_pbt = MaklumatKenderaanSaman::select(
            'pendaftaran_id AS pendaftaran_id',
            'fleet.fleet_lookup_vehicle_view.placement_id AS placement_id',
            'saman.maklumat_saman.summon_agency_id AS summon_agency_id',
            'fleet.fleet_placement.is_district_of_state AS is_district_of_state',
            'status_saman_id AS status_saman_id'
        )
        ->leftJoin('saman.maklumat_saman','saman.maklumat_saman.maklumat_kenderaan_saman_id','=','saman.maklumat_kenderaan_saman.id')
        ->leftJoin('fleet.fleet_lookup_vehicle_view','fleet.fleet_lookup_vehicle_view.id','=','saman.maklumat_kenderaan_saman.pendaftaran_id')
        ->leftJoin('fleet.fleet_placement','fleet.fleet_placement.id','=','fleet.fleet_lookup_vehicle_view.placement_id')
        ->where('status_saman_id','>','1')
        ->where('placement_id','>','0')->where('is_district_of_state','=','true')->where('summon_agency_id','=','3')->count();

        $total_summon_negeri_paid = MaklumatKenderaanSaman::select(
            'pendaftaran_id AS pendaftaran_id',
            'fleet.fleet_lookup_vehicle_view.placement_id AS placement_id',
            'saman.maklumat_saman.summon_agency_id AS summon_agency_id',
            'fleet.fleet_placement.is_district_of_state AS is_district_of_state',
            'status_saman_id AS status_saman_id'
        )
        ->leftJoin('saman.maklumat_saman','saman.maklumat_saman.maklumat_kenderaan_saman_id','=','saman.maklumat_kenderaan_saman.id')
        ->leftJoin('fleet.fleet_lookup_vehicle_view','fleet.fleet_lookup_vehicle_view.id','=','saman.maklumat_kenderaan_saman.pendaftaran_id')
        ->leftJoin('fleet.fleet_placement','fleet.fleet_placement.id','=','fleet.fleet_lookup_vehicle_view.placement_id')
        ->where('status_saman_id','>','1')
        ->where('placement_id','>','0')->where('is_district_of_state','=','true')->where('status_saman_id','=','3')->count();

        $total_summon_negeri_unpaid = MaklumatKenderaanSaman::select(
            'pendaftaran_id AS pendaftaran_id',
            'fleet.fleet_lookup_vehicle_view.placement_id AS placement_id',
            'saman.maklumat_saman.summon_agency_id AS summon_agency_id',
            'fleet.fleet_placement.is_district_of_state AS is_district_of_state',
            'status_saman_id AS status_saman_id'
        )
        ->leftJoin('saman.maklumat_saman','saman.maklumat_saman.maklumat_kenderaan_saman_id','=','saman.maklumat_kenderaan_saman.id')
        ->leftJoin('fleet.fleet_lookup_vehicle_view','fleet.fleet_lookup_vehicle_view.id','=','saman.maklumat_kenderaan_saman.pendaftaran_id')
        ->leftJoin('fleet.fleet_placement','fleet.fleet_placement.id','=','fleet.fleet_lookup_vehicle_view.placement_id')
        ->where('status_saman_id','>','1')
        ->where('placement_id','>','0')->where('is_district_of_state','=','true')->where('status_saman_id','=','4')->count();

        $total_summon_negeri_paid_pctg = 0 ;
        $total_summon_negeri_unpaid_pctg = 0 ;

        if($total_summon_negeri != 0){
            $total_summon_negeri_paid_pctg = $total_summon_negeri_paid / $total_summon_negeri * 100 ;
            $total_summon_negeri_unpaid_pctg = $total_summon_negeri_unpaid / $total_summon_negeri * 100 ;
            $total_summon_negeri_paid_pctg = number_format($total_summon_negeri_paid_pctg,2);
            $total_summon_negeri_unpaid_pctg = number_format($total_summon_negeri_unpaid_pctg,2);
        }

        return view('report.report_summons_summary',[
            'total_summon_hq_pdrm' => $total_summon_hq_pdrm,
            'total_summon_hq_jpj' => $total_summon_hq_jpj,
            'total_summon_hq_pbt' => $total_summon_hq_pbt,
            'total_summon_hq' => $total_summon_hq,
            'samanCount' => $samanCount,
            'total_summon_hq_paid' => $total_summon_hq_paid,
            'total_summon_hq_paid_pctg' => $total_summon_hq_paid_pctg,
            'total_summon_hq_unpaid' => $total_summon_hq_unpaid,
            'total_summon_hq_pdrm' => $total_summon_hq_pdrm,
            'total_summon_hq_jpj' => $total_summon_hq_jpj,
            'total_summon_hq_pbt' => $total_summon_hq_pbt,
            'total_summon_hq_unpaid_pctg' => $total_summon_hq_unpaid_pctg,
            'total_summon_negeri_pdrm' => $total_summon_negeri_pdrm,
            'total_summon_negeri_jpj' => $total_summon_negeri_jpj,
            'total_summon_negeri_pbt' => $total_summon_negeri_pbt,
            'total_summon_negeri' => $total_summon_negeri,
            'total_summon_negeri_paid' => $total_summon_negeri_paid,
            'total_summon_negeri_paid_pctg' => $total_summon_negeri_paid_pctg,

            'total_summon_negeri_unpaid' => $total_summon_negeri_unpaid,
            'total_summon_negeri_unpaid_pctg' => $total_summon_negeri_unpaid_pctg,
            'total_pdrm_summon' => $total_pdrm_summon,
            'total_jpj_summon' => $total_jpj_summon,
            'total_pbt_summon' => $total_pbt_summon,
            'total_summon' => $total_summon,
            'total_paid_summon' => $total_paid_summon,
            'total_paid_summon_pctg' => $total_paid_summon_pctg,
            'total_unpaid_summon' => $total_unpaid_summon,
            'total_unpaid_summon_pctg' => $total_unpaid_summon_pctg

        ]);






    })->name('.report_summons_summary');

    Route::get('/report_vehicle_jkr_by_workshop', function(){

        $ReportVehicleDAO = new ReportVehicleDAO();

        $object = $ReportVehicleDAO->reportVehicleByWorkshop();

        return view('report.report_vehicle_jkr_by_workshop',$object);
    })->name('.report_vehicle_jkr_by_workshop');

    Route::get('/report_vehicle_jkr_by_workshop_ownership', function(){

        $ReportVehicleDAO = new ReportVehicleDAO();

        $object = $ReportVehicleDAO->reportVehicleByWorkshopOwnership();

        return view('report.report_vehicle_jkr_by_workshop_ownership',$object);
    })->name('.report_vehicle_jkr_by_workshop_ownership');

    Route::get('/report_vehicle_jkr_by_cat_type', function(Request $request){

        $ReportVehicleDAO = new ReportVehicleDAO();

        $object = $ReportVehicleDAO->reportVehicleByCatType($request);

        return view('report.report_vehicle_jkr_by_cat_type',$object);
    })->name('.report_vehicle_jkr_by_cat_type');

    Route::get('/report_summons_summary_branch', function(){

        $ReportSummonDAO = new ReportSummonDAO();

        $obj = $ReportSummonDAO->reportSummonSummaryByBranch();

        return view('report.report_summons_summary_branch',$obj);

    })->name('.report_summons_summary.branch');

    Route::post('/report_summons_summary_branch_update_sorting', function(Request $request){

        if(Auth::user()->isAdmin()){
            $list = RefOwner::whereHas('hasOwnerType', function($q){
                $q->where([
                    'code' => '01',
                    'display_for' => 'vehicle_register'
                ]);
            })->get();
            foreach ($list as $key) {
                $value = $request['id_'.$key->id];
                Log::info($value);
                $key->update([
                    'rps_branch_sort' => $value
                ]);
            }
        }

    })->name('.report_summons_summary.update_sorting');

    Route::get('/report_summons_jkr_hq', function(){

        $samanList = MaklumatSaman::select(
            'maklumat_kenderaan_saman_id AS maklumat_kenderaan_saman_id',
            'summon_agency_id AS summon_agency_id',
            'summon_notice_no AS summon_notice_no',
            'notice_date AS notice_date',
            'mistake_date AS mistake_date',
            'fleet_lookup_vehicle_view.no_pendaftaran AS plate_no',
            'fleet.fleet_placement.desc AS placement_id',
            'fleet.fleet_placement.desc AS placement',
            'public.ref_state.desc AS state_desc',
            'public.ref_summon_agency.desc AS summon_agency_desc'
        )
        ->leftJoin('saman.maklumat_kenderaan_saman','saman.maklumat_kenderaan_saman.id','=','saman.maklumat_saman.maklumat_kenderaan_saman_id')
        ->leftJoin('fleet.fleet_lookup_vehicle_view','fleet.fleet_lookup_vehicle_view.id','=','saman.maklumat_kenderaan_saman.pendaftaran_id')
        ->leftJoin('fleet.fleet_placement','fleet.fleet_placement.id','=','fleet.fleet_lookup_vehicle_view.placement_id')
        ->leftJoin('public.ref_state','public.ref_state.id','=','fleet.fleet_placement.ref_state_id')
        ->leftJoin('public.ref_summon_agency','public.ref_summon_agency.id','=','saman.maklumat_saman.summon_agency_id')
        ->where('saman.maklumat_kenderaan_saman.status_saman_id','=','3')
        ->where('fleet.fleet_placement.is_district_of_state','=',false);

        $object = ['samanList' => $samanList->get()];
        return view('report.report_summons_jkr_hq',$object);
    })->name('.report_summons_jkr_hq');

    Route::get('/report_summons_jkr_branch', function(){

        $ReportSummonDAO = new ReportSummonDAO();

        $object = $ReportSummonDAO->reportSummonByBranch();

        return view('report.report_summons_jkr_branch',$object);
    })->name('.report_summons_jkr_branch');

    Route::get('/report_summons_jkr_state', function(){

        $samanList = MaklumatSaman::select(

            'maklumat_kenderaan_saman_id AS maklumat_kenderaan_saman_id',
            'summon_agency_id AS summon_agency_id',
            'summon_notice_no AS summon_notice_no',
            'notice_date AS notice_date',
            'mistake_date AS mistake_date',
            'fleet_lookup_vehicle_view.no_pendaftaran AS plate_no',
            'fleet.fleet_placement.id AS placement_id',
            'fleet.fleet_placement.desc AS placement',
            'fleet.fleet_placement.ref_state_id as state_id',
            'public.ref_summon_agency.desc AS summon_agency_desc',
            'public.ref_state.desc as state'
        )
        ->leftJoin('saman.maklumat_kenderaan_saman','saman.maklumat_kenderaan_saman.id','=','saman.maklumat_saman.maklumat_kenderaan_saman_id')
        ->leftJoin('fleet.fleet_lookup_vehicle_view','fleet.fleet_lookup_vehicle_view.id','=','saman.maklumat_kenderaan_saman.pendaftaran_id')
        ->leftJoin('fleet.fleet_placement','fleet.fleet_placement.id','=','fleet.fleet_lookup_vehicle_view.placement_id')
        ->leftJoin('public.ref_summon_agency','public.ref_summon_agency.id','=','saman.maklumat_saman.summon_agency_id')
        ->leftJoin('public.ref_state', 'public.ref_state.id', '=', 'fleet.fleet_placement.ref_state_id')
        ->where('saman.maklumat_kenderaan_saman.status_saman_id','=','3')
        ->where('fleet.fleet_placement.is_district_of_state','=',true);

        $object = ['samanList' => $samanList->get()];
        return view('report.report_summons_jkr_state',$object);
    })->name('.report_summons_jkr_state');

    Route::get('/report_maintenance_evaluation', function(){

        $list = DB::select(DB::raw('select comp_id, component, EXTRACT(MONTH FROM comp_updated_at) as month, count(*) FROM
            (
                select d.id as comp_id, d.component as component, a.updated_at as comp_updated_at from maintenance.form_checklist_lvl3 a
                join maintenance.form_checklist_lvl2 b on b.id = a.formchecklistlvl2_id
                join maintenance.form_checklist_lvl1 c on c.id = b.formchecklistlvl1_id
                join ref_component_checklist_lvl1 d on d.id = c.checklistlvl1_id
                where a.is_pass = true
                union
                select c.id as comp_id, c.component as component, a.updated_at as comp_updated_at from maintenance.form_checklist_lvl2 a
                join maintenance.form_checklist_lvl1 b on b.id = a.formchecklistlvl1_id
                join ref_component_checklist_lvl1 c on c.id = b.checklistlvl1_id
                where a.is_pass = true
            ) as ssssssss
            GROUP BY comp_id,component, EXTRACT(MONTH FROM comp_updated_at)
            ORDER BY comp_id, EXTRACT(MONTH FROM comp_updated_at)

        '));
        $ref_component_lvl1_list = RefComponentChecklistLvl1::where('status', 1)
        ->whereHas('hasAssessmentType');
        $ref_month_list = RefMonth::query();
        $obj = [
            'list' => $list,
            'ref_component_lvl1_list' => $ref_component_lvl1_list->get(),
            'ref_month_list' => $ref_month_list->get(),
        ];

        return view('report.report_maintenance_evaluation', $obj);
    })->name('.report_maintenance_evaluation');

    Route::get('/report_scheduled_maintenance_performance', function(){

        $ref_component_lvl1_list = RefComponentLvl1::where('status', 1);
        $ref_month_list = RefMonth::query();
        $obj = [
            'ref_component_lvl1_list' => $ref_component_lvl1_list->get(),
            'ref_month_list' => $ref_month_list->get(),
        ];
        return view('report.report_scheduled_maintenance_performance', $obj);
    })->name('.report_scheduled_maintenance_performance');

    Route::get('/report_scheduled_repair_performance', function(){

        $maintenance_repair_report_view = MaintenanceRepairReportCount2021::select('*')->first();
        $maintenance_repair_inout_view = MaintenanceRepairInOutReport2021::select('*')->first();

        $total_component_allmonth_by_enjine =
        $maintenance_repair_report_view->total_component_enjine_1 +
        $maintenance_repair_report_view->total_component_enjine_2 +
        $maintenance_repair_report_view->total_component_enjine_3 +
        $maintenance_repair_report_view->total_component_enjine_4 +
        $maintenance_repair_report_view->total_component_enjine_5 +
        $maintenance_repair_report_view->total_component_enjine_6 +
        $maintenance_repair_report_view->total_component_enjine_7 +
        $maintenance_repair_report_view->total_component_enjine_8 +
        $maintenance_repair_report_view->total_component_enjine_9 +
        $maintenance_repair_report_view->total_component_enjine_10 +
        $maintenance_repair_report_view->total_component_enjine_11 +
        $maintenance_repair_report_view->total_component_enjine_12;

        $total_component_allmonth_by_steering =
        $maintenance_repair_report_view->total_component_steering_1 +
        $maintenance_repair_report_view->total_component_steering_2 +
        $maintenance_repair_report_view->total_component_steering_3 +
        $maintenance_repair_report_view->total_component_steering_4 +
        $maintenance_repair_report_view->total_component_steering_5 +
        $maintenance_repair_report_view->total_component_steering_6 +
        $maintenance_repair_report_view->total_component_steering_7 +
        $maintenance_repair_report_view->total_component_steering_8 +
        $maintenance_repair_report_view->total_component_steering_9 +
        $maintenance_repair_report_view->total_component_steering_10 +
        $maintenance_repair_report_view->total_component_steering_11 +
        $maintenance_repair_report_view->total_component_steering_12;

        $total_component_allmonth_by_brake =
        $maintenance_repair_report_view->total_component_brake_1 +
        $maintenance_repair_report_view->total_component_brake_2 +
        $maintenance_repair_report_view->total_component_brake_3 +
        $maintenance_repair_report_view->total_component_brake_4 +
        $maintenance_repair_report_view->total_component_brake_5 +
        $maintenance_repair_report_view->total_component_brake_6 +
        $maintenance_repair_report_view->total_component_brake_7 +
        $maintenance_repair_report_view->total_component_brake_8 +
        $maintenance_repair_report_view->total_component_brake_9 +
        $maintenance_repair_report_view->total_component_brake_10 +
        $maintenance_repair_report_view->total_component_brake_11 +
        $maintenance_repair_report_view->total_component_brake_12;

        $total_component_allmonth_by_transmission =
        $maintenance_repair_report_view->total_component_transmission_1 +
        $maintenance_repair_report_view->total_component_transmission_2 +
        $maintenance_repair_report_view->total_component_transmission_3 +
        $maintenance_repair_report_view->total_component_transmission_4 +
        $maintenance_repair_report_view->total_component_transmission_5 +
        $maintenance_repair_report_view->total_component_transmission_6 +
        $maintenance_repair_report_view->total_component_transmission_7 +
        $maintenance_repair_report_view->total_component_transmission_8 +
        $maintenance_repair_report_view->total_component_transmission_9 +
        $maintenance_repair_report_view->total_component_transmission_10 +
        $maintenance_repair_report_view->total_component_transmission_11 +
        $maintenance_repair_report_view->total_component_transmission_12;

        $total_component_allmonth_by_electronics =
        $maintenance_repair_report_view->total_component_electronics_1 +
        $maintenance_repair_report_view->total_component_electronics_2 +
        $maintenance_repair_report_view->total_component_electronics_3 +
        $maintenance_repair_report_view->total_component_electronics_4 +
        $maintenance_repair_report_view->total_component_electronics_5 +
        $maintenance_repair_report_view->total_component_electronics_6 +
        $maintenance_repair_report_view->total_component_electronics_7 +
        $maintenance_repair_report_view->total_component_electronics_8 +
        $maintenance_repair_report_view->total_component_electronics_9 +
        $maintenance_repair_report_view->total_component_electronics_10 +
        $maintenance_repair_report_view->total_component_electronics_11 +
        $maintenance_repair_report_view->total_component_electronics_12;

        $total_component_allmonth_by_tyre =
        $maintenance_repair_report_view->total_component_tyre_1 +
        $maintenance_repair_report_view->total_component_tyre_2 +
        $maintenance_repair_report_view->total_component_tyre_3 +
        $maintenance_repair_report_view->total_component_tyre_4 +
        $maintenance_repair_report_view->total_component_tyre_5 +
        $maintenance_repair_report_view->total_component_tyre_6 +
        $maintenance_repair_report_view->total_component_tyre_7 +
        $maintenance_repair_report_view->total_component_tyre_8 +
        $maintenance_repair_report_view->total_component_tyre_9 +
        $maintenance_repair_report_view->total_component_tyre_10 +
        $maintenance_repair_report_view->total_component_tyre_11 +
        $maintenance_repair_report_view->total_component_tyre_12;

        $total_component_allmonth_by_acsystem =
        $maintenance_repair_report_view->total_component_acsystem_1 +
        $maintenance_repair_report_view->total_component_acsystem_2 +
        $maintenance_repair_report_view->total_component_acsystem_3 +
        $maintenance_repair_report_view->total_component_acsystem_4 +
        $maintenance_repair_report_view->total_component_acsystem_5 +
        $maintenance_repair_report_view->total_component_acsystem_6 +
        $maintenance_repair_report_view->total_component_acsystem_7 +
        $maintenance_repair_report_view->total_component_acsystem_8 +
        $maintenance_repair_report_view->total_component_acsystem_9 +
        $maintenance_repair_report_view->total_component_acsystem_10 +
        $maintenance_repair_report_view->total_component_acsystem_11 +
        $maintenance_repair_report_view->total_component_acsystem_12;

        $total_component_allmonth_by_body =
        $maintenance_repair_report_view->total_component_body_1 +
        $maintenance_repair_report_view->total_component_body_2 +
        $maintenance_repair_report_view->total_component_body_3 +
        $maintenance_repair_report_view->total_component_body_4 +
        $maintenance_repair_report_view->total_component_body_5 +
        $maintenance_repair_report_view->total_component_body_6 +
        $maintenance_repair_report_view->total_component_body_7 +
        $maintenance_repair_report_view->total_component_body_8 +
        $maintenance_repair_report_view->total_component_body_9 +
        $maintenance_repair_report_view->total_component_body_10 +
        $maintenance_repair_report_view->total_component_body_11 +
        $maintenance_repair_report_view->total_component_body_12;


        //internal / external repair
        $total_internal_repair_allmonth =
        $maintenance_repair_inout_view->total_internal_repair_1 +
        $maintenance_repair_inout_view->total_internal_repair_2 +
        $maintenance_repair_inout_view->total_internal_repair_3 +
        $maintenance_repair_inout_view->total_internal_repair_4 +
        $maintenance_repair_inout_view->total_internal_repair_5 +
        $maintenance_repair_inout_view->total_internal_repair_6 +
        $maintenance_repair_inout_view->total_internal_repair_7 +
        $maintenance_repair_inout_view->total_internal_repair_8 +
        $maintenance_repair_inout_view->total_internal_repair_9 +
        $maintenance_repair_inout_view->total_internal_repair_10 +
        $maintenance_repair_inout_view->total_internal_repair_11 +
        $maintenance_repair_inout_view->total_internal_repair_12;

        $total_external_repair_allmonth =
        $maintenance_repair_inout_view->total_external_repair_1 +
        $maintenance_repair_inout_view->total_external_repair_2 +
        $maintenance_repair_inout_view->total_external_repair_3 +
        $maintenance_repair_inout_view->total_external_repair_4 +
        $maintenance_repair_inout_view->total_external_repair_5 +
        $maintenance_repair_inout_view->total_external_repair_6 +
        $maintenance_repair_inout_view->total_external_repair_7 +
        $maintenance_repair_inout_view->total_external_repair_8 +
        $maintenance_repair_inout_view->total_external_repair_9 +
        $maintenance_repair_inout_view->total_external_repair_10 +
        $maintenance_repair_inout_view->total_external_repair_11 +
        $maintenance_repair_inout_view->total_external_repair_12;

        $total_inout_repair1 = $maintenance_repair_inout_view->total_internal_repair_1 + $maintenance_repair_inout_view->total_external_repair_1 ;
        $total_inout_repair2 = $maintenance_repair_inout_view->total_internal_repair_2 + $maintenance_repair_inout_view->total_external_repair_2 ;
        $total_inout_repair3 = $maintenance_repair_inout_view->total_internal_repair_3 + $maintenance_repair_inout_view->total_external_repair_3 ;
        $total_inout_repair4 = $maintenance_repair_inout_view->total_internal_repair_4 + $maintenance_repair_inout_view->total_external_repair_4 ;
        $total_inout_repair5 = $maintenance_repair_inout_view->total_internal_repair_5 + $maintenance_repair_inout_view->total_external_repair_5 ;
        $total_inout_repair6 = $maintenance_repair_inout_view->total_internal_repair_6 + $maintenance_repair_inout_view->total_external_repair_6 ;
        $total_inout_repair7 = $maintenance_repair_inout_view->total_internal_repair_7 + $maintenance_repair_inout_view->total_external_repair_7 ;
        $total_inout_repair8 = $maintenance_repair_inout_view->total_internal_repair_8 + $maintenance_repair_inout_view->total_external_repair_8 ;
        $total_inout_repair9 = $maintenance_repair_inout_view->total_internal_repair_9 + $maintenance_repair_inout_view->total_external_repair_9 ;
        $total_inout_repair10 = $maintenance_repair_inout_view->total_internal_repair_10 + $maintenance_repair_inout_view->total_external_repair_10 ;
        $total_inout_repair11 = $maintenance_repair_inout_view->total_internal_repair_11 + $maintenance_repair_inout_view->total_external_repair_11 ;
        $total_inout_repair12 = $maintenance_repair_inout_view->total_internal_repair_12 + $maintenance_repair_inout_view->total_external_repair_12 ;

        $total_inout_repair_allmonth = $total_internal_repair_allmonth + $total_external_repair_allmonth;

        if( $total_inout_repair1 != 0 ){$percent_internal_1 = $maintenance_repair_inout_view-> total_internal_repair_1 / $total_inout_repair1 * 100 ;}else{$percent_internal_1 = 0;}
        if( $total_inout_repair2 != 0 ){$percent_internal_2 = $maintenance_repair_inout_view-> total_internal_repair_2 / $total_inout_repair2 * 100 ;}else{$percent_internal_2 = 0;}
        if( $total_inout_repair3 != 0 ){$percent_internal_3 = $maintenance_repair_inout_view-> total_internal_repair_3 / $total_inout_repair3 * 100 ;}else{$percent_internal_3 = 0;}
        if( $total_inout_repair4 != 0 ){$percent_internal_4 = $maintenance_repair_inout_view-> total_internal_repair_4 / $total_inout_repair4 * 100 ;}else{$percent_internal_4 = 0;}
        if( $total_inout_repair5 != 0 ){$percent_internal_5 = $maintenance_repair_inout_view-> total_internal_repair_5 / $total_inout_repair5 * 100 ;}else{$percent_internal_5 = 0;}
        if( $total_inout_repair6 != 0 ){$percent_internal_6 = $maintenance_repair_inout_view-> total_internal_repair_6 / $total_inout_repair6 * 100 ;}else{$percent_internal_6 = 0;}
        if( $total_inout_repair7 != 0 ){$percent_internal_7 = $maintenance_repair_inout_view-> total_internal_repair_7 / $total_inout_repair7 * 100 ;}else{$percent_internal_7 = 0;}
        if( $total_inout_repair8 != 0 ){$percent_internal_8 = $maintenance_repair_inout_view-> total_internal_repair_8 / $total_inout_repair8 * 100 ;}else{$percent_internal_8 = 0;}
        if( $total_inout_repair9 != 0 ){$percent_internal_9 = $maintenance_repair_inout_view-> total_internal_repair_9 / $total_inout_repair9 * 100 ;}else{$percent_internal_9 = 0;}
        if( $total_inout_repair10 != 0 ){$percent_internal_10 = $maintenance_repair_inout_view-> total_internal_repair_10 / $total_inout_repair10 * 100 ;}else{$percent_internal_10 = 0;}
        if( $total_inout_repair11 != 0 ){$percent_internal_11 = $maintenance_repair_inout_view-> total_internal_repair_11 / $total_inout_repair11 * 100 ;}else{$percent_internal_11 = 0;}
        if( $total_inout_repair12 != 0 ){$percent_internal_12 = $maintenance_repair_inout_view-> total_internal_repair_12 / $total_inout_repair12 * 100 ;}else{$percent_internal_12 = 0;}

        if( $total_inout_repair_allmonth != 0 ){$percent_internal_allmonth =  $total_internal_repair_allmonth / $total_inout_repair_allmonth * 100 ;}else{$percent_internal_allmonth = 0;}

        $object = [
        'maintenance_repair_report_view' => $maintenance_repair_report_view,
        'maintenance_repair_inout_view' => $maintenance_repair_inout_view,
        'total_component_allmonth_by_enjine' => $total_component_allmonth_by_enjine,
        'total_component_allmonth_by_transmission' => $total_component_allmonth_by_transmission,
        'total_component_allmonth_by_steering' => $total_component_allmonth_by_steering,
        'total_component_allmonth_by_electronics' => $total_component_allmonth_by_electronics,
        'total_component_allmonth_by_brake' => $total_component_allmonth_by_brake,
        'total_component_allmonth_by_tyre' => $total_component_allmonth_by_tyre,
        'total_component_allmonth_by_acsystem' => $total_component_allmonth_by_acsystem,
        'total_component_allmonth_by_body' => $total_component_allmonth_by_body,
        'total_internal_repair_allmonth' => $total_internal_repair_allmonth,
        'total_external_repair_allmonth' => $total_external_repair_allmonth,
        'percent_internal_1' => $percent_internal_1,
        'percent_internal_2' => $percent_internal_2,
        'percent_internal_3' => $percent_internal_3,
        'percent_internal_4' => $percent_internal_4,
        'percent_internal_5' => $percent_internal_5,
        'percent_internal_6' => $percent_internal_6,
        'percent_internal_7' => $percent_internal_7,
        'percent_internal_8' => $percent_internal_8,
        'percent_internal_9' => $percent_internal_9,
        'percent_internal_10' => $percent_internal_10,
        'percent_internal_11' => $percent_internal_11,
        'percent_internal_12' => $percent_internal_12,
        'percent_internal_allmonth' => $percent_internal_allmonth
        ];

        return view('report.report_scheduled_repair_performance', $object);
    })->name('.report_scheduled_repair_performance');

    Route::get('/maintenance-trends', function(Request $request){
        //$maintenance_service_report_view = MaintenanceServiceReportCount::select('*')->first();
        //$maintenance_repair_report_view = MaintenanceRepairReportCount2021::select('*')->first();

        $year = $request->year ? $request->year : date('Y');

        $queryRepair = "";

        for ($month=1; $month <= 12; $month++) {
            $queryRepair .= '(select  count(*) as "month_'.$month.'" from maintenance.job_vehicle a
                join maintenance.job_vehicle_examination_form b ON b.vehicle_id = a.id
                join maintenance.job_ve_form_checklist c ON c.form_id = b.id AND c.is_pass = true
                join public.ref_component_lvl1 d ON d.id = c.component_lvl1_id
                join maintenance.job_vehicle_examination_form_repair e ON e.jve_form_id = b.id
                where e.repair_method_id = 1 and d.component is not null
                and EXTRACT(YEAR from b.created_at) = '.$year.'
                and EXTRACT(MONTH from b.created_at) = '.$month.'
                and d.id = aa.id
                )';

            if($month == 12){
            } else {
                $queryRepair .= ',';
            }
        }

        $maintenance_repair_report = DB::select('select aa.id, aa.component ,
        '.$queryRepair.'
        from ref_component_lvl1 aa');

        $queryService = "";

        for ($month=1; $month <= 12; $month++) {
            $queryService .= '(select  count(*) as "month_'.$month.'" from maintenance.job_vehicle a
                join maintenance.job_vehicle_examination_form b ON b.vehicle_id = a.id
                join maintenance.job_ve_form_checklist c ON c.form_id = b.id AND c.is_pass = true
                join public.ref_component_lvl1 d ON d.id = c.component_lvl1_id
                join maintenance.job_vehicle_examination_form_repair e ON e.jve_form_id = b.id
                where e.repair_method_id = 2 and d.component is not null
                and EXTRACT(YEAR from b.created_at) = '.$year.'
                and EXTRACT(MONTH from b.created_at) = '.$month.'
                and d.id = aa.id
                )';

            if($month == 12){
            } else {
                $queryService .= ',';
            }
        }

        $maintenance_service_report = DB::select('select aa.id, aa.component ,
        '.$queryService.'
        from ref_component_lvl1 aa');

        $object = [
            'year' => $year,
            'maintenance_service_report_view' => $maintenance_service_report,
            'maintenance_repair_report_view' => $maintenance_repair_report,
        ];

        // [
        //     'engine' => [
        //         'jan' => 10,
        //         'feb' => 11
        //     ],
        //     'ac' => [

        //     ]
        // ]

        Log::info($object);

        return view('maintenance.maintenance-trends', $object);
    })->name('.maintenance-trends');

    Route::get('/report_service', function(){
        return view('report.report_service');
    })->name('.report_service');

    Route::get('/report_spend', function(){
        return view('report.report_spend');
    })->name('.report_spend');

    Route::get('/report_detail_maintenance', function(Request $request){

        $selectedYear = $request->selectedYear;
        $selectedMonth = $request->selectedMonth;
        $selectedWorkshop = $request->selectedWorkshop;
        $selectedWorkshopId = $request->selectedWorkshopId;

        if($selectedYear == null || $selectedYear == ''){
            $selectedYear = date("Y");
            //$selectedYear = 2022;
        }

        if($selectedMonth == null || $selectedMonth == ''){
            if ($selectedYear == date("Y")) {
                $selectedMonth = 10;
            }else {
                $selectedMonth = 1;
            }
        }

        if($selectedWorkshop == null || $selectedWorkshop == ''){
            $selectedWorkshop = "PENYATA";
        }

        if($selectedWorkshopId == null || $selectedWorkshopId == ''){
            $selectedWorkshopId = 1;
        }

        $reportDetailMaintenanceDAO = new ReportDetailMaintenanceDAO();
        $listYear = $reportDetailMaintenanceDAO->getYear();
        $listReport = $reportDetailMaintenanceDAO->getListReport($request, $selectedYear, $selectedMonth,$selectedWorkshopId);
        $listWorkshop = $reportDetailMaintenanceDAO->getWorkshop();
        $listCustomer = $reportDetailMaintenanceDAO->getCustomer('based_on_record', $request);
        $selectedCustomer = $reportDetailMaintenanceDAO->getCustomer('selected_customer', $request);
        $selectedWorkshop = RefWorkshop::find($selectedWorkshopId);

       $methodMappingDesc = [
           1 => 'Perkhidmatan & Bekalan',
           2 => 'Perkhidmatan',
           3 => 'Bekalan'
       ];

        return view('report.report_detail_maintenance', [
            'listYear' => $listYear,
            'selectedMonth' => $selectedMonth,
            'selectedYear' => $selectedYear,
            'listReport' => $listReport,
            'listWorkshop' => $listWorkshop,
            'listCustomer' => $listCustomer,
            'customer_id' => $request->customer_id,
            'selectedCustomer' => $selectedCustomer ? $selectedCustomer->desc : 'Semua',
            'selectedWorkshop' => $selectedWorkshop->desc,
            'selectedWorkshopId' => $selectedWorkshopId,
            'repair_method' => $request->repair_method,
            'repair_method_desc' => $request->repair_method ? $methodMappingDesc[$request->repair_method] : 'Semua'
        ]);
    })->name('.report_detail_maintenance');

    Route::get('/report_appl_map_maintenance', function(Request $request){
        return view('report.report_appl_map_maintenance');
    })->name('.report_appl_map_maintenance');

    Route::get('/report_maintenance_summary', function(Request    $request){
        $reportComposition = new ReportMaintenanceDAO();
        $workshop = $reportComposition->getWorkshop($request);
        $appointment = $reportComposition->getAppointment($request);
        $exam = $reportComposition->getExamination($request);
        $researchMarket = $reportComposition->getResearchMarketVerification($request);
        $procurement = $reportComposition->getProcurementVerification($request);
        $completed = $reportComposition->getCompleted($request);

        $month = $request->month ? $request->month : Carbon::now()->format('F');
        $year = $request->year ? $request->year : Carbon::now()->format('Y');

        return view('report.report_maintenance_summary_table', [
            'month' => $month,
            'year' => $year,
            'workshop' => $workshop,
            'appointment' => $appointment,
            'exam' => $exam,
            'researchMarket' => $researchMarket,
            'procurement' => $procurement,
            'completed' => $completed,
        ]);

    })->name('.report_maintenance_summary');

    Route::get('/report_evaluation_summary', function(Request    $request){
        $reportComposition = new ReportMaintenanceDAO();
        $workshop = $reportComposition->getWorkshop($request);
        $appointment = $reportComposition->getEvaluationAppointment($request);
        $verification = $reportComposition->getEvaluationVerification($request);
        $letter = $reportComposition->getEvaluationLetter($request);
        $completed = $reportComposition->getCompletedEvaluation($request);

        $month = $request->month ? $request->month : Carbon::now()->format('F');
        $year = $request->year ? $request->year : Carbon::now()->format('Y');

        return view('report.report_evaluation_summary_table', [
            'month' => $month,
            'year' => $year,
            'workshop' => $workshop,
            'appointment' => $appointment,
            'verification' => $verification,
            'letter' => $letter,
            'completed' => $completed,
        ]);

    })->name('.report_evaluation_summary');

    Route::get('/vehicle-list', function(Request $request){

        $getDepartment = new ReportVehicleCompositionDAO();
        $department = $getDepartment->getFleet($request);
        return view('vehicle.vehicle-report-list', [
            'department' => $department,
        ]);

    })->name('.vehicle-list');

    Route::get('/vehicle-district-list', function(Request $request){

        $fleet_view = $request->fleet_view;
        $search = $request->search;
        $offset = $request->offset;
        $limit = $request->limit;
        $xid = $request->xid;
        $status = $request->status ? $request->status: 'approved';
        $opt = $request->opt;

        if($fleet_view == null){
            $fleet_view = 'department';
        }

        if($offset == null){
            $offset = 0;
        }

        if($limit == null){
            $limit = 10;
        }


        if($search == null || $search == ''){

            $search = '';
        }

        $vehicleDAO = new VehicleDAO();
        $listFleets = $vehicleDAO->getTotalVehicleDistrict($status,$search,$fleet_view,$offset,$limit, $xid, $opt);
        $totalFleet = $vehicleDAO->getTotalVehicleNoOffset($status,$search,$fleet_view, $xid, null, $request);

        Log::info("search param : ".$search);

        return view('vehicle.vehicle-district-report-list', [
            'searchParam' => $search,
            'listFleets' => $listFleets,
            'offset'=> $offset,
            'limit'=> $limit,
            'fleet_view' => $fleet_view,
            'total_fleet' => count($totalFleet)
        ]);
    })->name('.vehicle-district-list');

    Route::get('/vehicle-by-district-list', function(Request $request){
        $ReportAssessment = new ReportAssessmentDAO();
        $getDistrictList = $ReportAssessment->getDistrictList($request);

        return view('vehicle.vehicle-by-district-report-list', [
            'getDistrictList' => $getDistrictList,
        ]);
    })->name('.vehicle-by-district-list');

    Route::get('/vehicle-export/excel', function(Request $request){
        $downloadExcel = new ReportVehicleCompositionDAO();
        return $downloadExcel->exportExcel($request);
    })->name('.vehicle-export.excel');

    Route::get('/report_logistic_booking_list', function(){
        return view('report.report_logistic_booking_list');
    })->name('.report-logistic-booking-list');

    Route::get('/booking-export/excel', function(Request $request){
        $downloadExcel = new ReportLogisticCompositionDAO();
        return $downloadExcel->exportExcelCarBooking($request);
    })->name('.booking-export.excel');

    Route::get('/report_logistic_disaster_list', function(){
        return view('report.report_logistic_disaster_list');
    })->name('.report-logistic-disaster-list');

    Route::get('/report_mhpv_budget_expenditure_by_month', function(Request $request){
        $selectedYear = $request->selectedYear;
        $selectedMonth = $request->selectedMonth;

        if($selectedYear == null || $selectedYear == ''){
            $selectedYear = date("Y");
            //$selectedYear = 2022;
        }

        if($selectedMonth == null || $selectedMonth == ''){
            if ($selectedYear == date("Y")) {
                $selectedMonth = 10;
            }else {
                $selectedMonth = 1;
            }
        }
        $reportWarrantDAO = new ReportWarrantDAO();

        $listYear = $reportWarrantDAO-> getYear();

        $osol26 = $reportWarrantDAO->getWarrantDataByOsolType(1,$selectedYear,$selectedMonth);
        $osolSum26 = $reportWarrantDAO->getWarrantSumMHPV('01',$selectedYear,$selectedMonth);

        $osol28 = $reportWarrantDAO->getWarrantDataByOsolType(2,$selectedYear,$selectedMonth);
        $osolSum28 = $reportWarrantDAO->getWarrantSumMHPV('02',$selectedYear,$selectedMonth);

        $osolTotal = $reportWarrantDAO->getWarrantTotalSumAll($selectedYear,$selectedMonth);

        $mhpvTargetPercent = $reportWarrantDAO->getOsolProjectionSetByMonth($selectedMonth);

        return view('report.report_mhpv_budget_expenditure_by_month', [

            'listYear' => $listYear,
            'selectedMonth' => $selectedMonth,
            'selectedYear' => $selectedYear,
            'osol26' => $osol26,
            'osol28' => $osol28,
            'osolSum26' => $osolSum26,
            'osolSum28' => $osolSum28,
            'osolTotal' => $osolTotal,
            'mhpvTargetPercent' => $mhpvTargetPercent
            // 'goToTab' => $goToTab
        ]);
    })->name('.report-mhpv-budget-expenditure-by-month');


    Route::get('/report_detail_maintenance_export/excel', function(Request $request){
        $reportDetailMaintenanceDAO = new ReportDetailMaintenanceDAO();
        return $reportDetailMaintenanceDAO->exportExcel($request);
    })->name('.report_detail_maintenance_export.excel');

    Route::get('/report_disaster_ready_by_state_vtype', function(Request $request){

        $ReportDisasterReadyDAO = new ReportDisasterReadyDAO();
        return view('report.report_vehicle_summary_vtype', $ReportDisasterReadyDAO->reportDisasterReadyByStateVType());

    })->name('.report.disaster_ready.by_state_vtype');

    Route::get('/report_disaster_ready_by_state_vcategories', function(Request $request){

        $ReportDisasterReadyDAO = new ReportDisasterReadyDAO();
        return view('report.report_vehicle_summary_vcategories', $ReportDisasterReadyDAO->reportDisasterReadyByStateVcategories());

    })->name('.report.disaster_ready.by_state_vcategories');

    Route::get('/report_disaster_ready_by_state_vtypes', function(Request $request){

        $ReportDisasterReadyDAO = new ReportDisasterReadyDAO();
        return view('report.report_vehicle_summary_vtypes', $ReportDisasterReadyDAO->reportDisasterReadyByStateVtypes());

    })->name('.report.disaster_ready.by_state_vtypes');

    Route::get('/report/disaster_ready/export/excel', function(Request $request){

        $view = $request->view;
        $ReportDisasterReadyDAO = new ReportDisasterReadyDAO();

        return $ReportDisasterReadyDAO->excel($view, $request);
    })->name('.report.disaster_ready.export.excel');

    Route::get('/report/vehicle/export/excel', function(Request $request){

        $ReportVehicleDAO = new ReportVehicleDAO();

        return $ReportVehicleDAO->excel($request);
    })->name('.report.vehicle.export.excel');

    Route::get('/report/summon/export/excel', function(Request $request){

        $view = $request->view;
        $ReportSummonDAO = new ReportSummonDAO();

        return $ReportSummonDAO->excel($view);
    })->name('.report.summon.export.excel');

    Route::get('/report/assessment/export/excel', function(Request $request){

        $ReportAssessmentDAO = new ReportAssessmentDAO();

        return $ReportAssessmentDAO->excel($request);
    })->name('.report.assessment.export.excel');


});
