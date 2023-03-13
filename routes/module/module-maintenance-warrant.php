<?php

use App\Http\Controllers\Maintenance\MaintenanceDAO;
use App\Http\Controllers\Maintenance\Warrant\WarrantDistributionDAO;
use App\Models\Maintenance\WarrantDetail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

Route::group(['prefix' => 'warrant', 'as' => '.warrant', 'middleware' => 'auth'], function(){

    Route::get('/table', function(Request $request){

        $goToTab = $request->goToTab;
        $selectedYear = $request->selectedYear;
        $selectedMonth = $request->selectedMonth;
        $selectedWorkshop = $request->selectedWorkshop;
        $selectedWaran = $request->selectedWaran;
        $selectedWorkshopId = $request->selectedWorkshopId;
        $selectedWaranId = $request->selectedWaranId;
        $selectedOsol = $request->selectedOsol;
        $selectedOsolId = $request->selectedOsolId;

        if($selectedYear == null || $selectedYear == ''){
            $selectedYear = date("Y");
            //$selectedYear = 2022;
        }

        if($selectedMonth == null || $selectedMonth == ''){
            if ($selectedYear == date("Y")) {
                $selectedMonth = date('m');
            }else {
                $selectedMonth = 1;
            }
        }

        if($selectedWorkshop == null || $selectedWorkshop == ''){
            $selectedWorkshop = "PENYATA";
        }

        if($selectedWaran == null || $selectedWaran == ''){
            $selectedWaran = "WARAN";
        }

        if($selectedOsol == null || $selectedOsol == ''){
            $selectedOsol = "OSOL";
        }

        if($selectedWorkshopId == null || $selectedWorkshopId == ''){
            $selectedWorkshopId = 0;
        }

        if($selectedWaranId == null || $selectedWaranId == ''){
            $selectedWaranId = 0;
        }

        if($selectedOsolId == null || $selectedOsolId == '' || ($selectedWaranId == 2 || $selectedWaranId == 3)){
            $selectedOsolId = 0;
        }

        if($goToTab == null || $goToTab == ''){
            $goToTab = 0;
        }

         Log::info("selectedWorkshop : ".$selectedWorkshop);
         Log::info("selectedWorkshopId : ".$selectedWorkshopId);
         Log::info("selectedWaran : ".$selectedWaran);
         Log::info("selectedWaranId : ".$selectedWaranId);
         Log::info("selectedOsolId : ".$selectedOsolId);
         Log::info("selectedOsol : ".$selectedOsol);
         Log::info("goToTab : ".$goToTab);
         //Log::info($listStatement);


        $vehicleDepreciationDAO = new WarrantDistributionDAO();

        $vehicleDepreciationDAO->generateFirstData($selectedYear);

        //CALCULATE BACK WARRANT
         $calculateOsol26 = $vehicleDepreciationDAO->getWarrantDataByOsolType(1,$selectedYear,$selectedMonth);
         $calculateOsol28 = $vehicleDepreciationDAO->getWarrantDataByOsolType(2,$selectedYear,$selectedMonth);
         $calculateOsolKKR = $vehicleDepreciationDAO->getWarrantDataByWaranType(2,$selectedYear,$selectedMonth);
         $calculateOsolExternal = $vehicleDepreciationDAO->getWarrantDataByWaranType(3,$selectedYear,$selectedMonth);
         $vehicleDepreciationDAO->updateCalculateWarrant($calculateOsol26);
         $vehicleDepreciationDAO->updateCalculateWarrant($calculateOsol28);
         $vehicleDepreciationDAO->updateCalculateWarrant($calculateOsolKKR);
         $vehicleDepreciationDAO->updateCalculateWarrant($calculateOsolExternal);

        $listYear = $vehicleDepreciationDAO-> getYear();
        $listWorkshop = $vehicleDepreciationDAO->getWorkshop();
        $listWaranType = $vehicleDepreciationDAO->getWarrantType();
        $listOsolType = $vehicleDepreciationDAO->getOsolType();

        $osol26 = $vehicleDepreciationDAO->getWarrantDataByOsolType(1,$selectedYear,$selectedMonth);
        $osol28 = $vehicleDepreciationDAO->getWarrantDataByOsolType(2,$selectedYear,$selectedMonth);

        $osolSum26 = $vehicleDepreciationDAO->getWarrantSumMHPV('01',$selectedYear,$selectedMonth);
        $osolSum28 = $vehicleDepreciationDAO->getWarrantSumMHPV('02',$selectedYear,$selectedMonth);
        $osolTotal = $vehicleDepreciationDAO->getWarrantTotalSumAll($selectedYear,$selectedMonth);

        $osolKKR = $vehicleDepreciationDAO->getWarrantDataByWaranType(2,$selectedYear,$selectedMonth);
        $osolSumKKR = $vehicleDepreciationDAO->getWarrantSum('02',$selectedYear,$selectedMonth);

        $osolExternal = $vehicleDepreciationDAO->getWarrantDataByWaranType(3,$selectedYear,$selectedMonth);
        $osolSumExternal = $vehicleDepreciationDAO->getWarrantSum('03',$selectedYear,$selectedMonth);

        $osolProjectionSet = $vehicleDepreciationDAO->getOsolProjectionSet();
        $osol26Projectionpercent = $vehicleDepreciationDAO->getOsolProjectionPercent('01',$selectedYear);
        $osol28Projectionpercent = $vehicleDepreciationDAO->getOsolProjectionPercent('02',$selectedYear);

        $totalStatement = 0;

        if ($selectedWorkshopId != 0 && $selectedWaranId != 0 ) {
            $totalStatement = $vehicleDepreciationDAO->getStatement($request, 'total');
            Log::info('selectedWorkshopId => '.$selectedWorkshopId);
            $listStatement = $vehicleDepreciationDAO->getStatement($request, null);
        }else {
            $listStatement = [];
        }

        $unlistedKKRState = DB::select('
        select aa.id AS workshop_id, bb.code, bb.desc AS state_name from ref_workshop aa
		join ref_state bb on bb.id = aa.state_id
		where aa.code not in (
            SELECT b.code FROM "maintenance"."warrant_detail" A 
            JOIN ref_workshop b ON b.ID=A.workshop_id 
            JOIN ref_state C ON C.ID=b.state_id 
            WHERE A.waran_type_id=2 AND A.year='.$selectedYear.' AND A."month"='.$selectedMonth.' ORDER BY A.workshop_id ASC
        )');

        $unlistedAgencyState = DB::select('
        select aa.id AS workshop_id, bb.code, bb.desc AS state_name from ref_workshop aa
		join ref_state bb on bb.id = aa.state_id
		where aa.code not in (
            SELECT b.code FROM "maintenance"."warrant_detail" A 
            JOIN ref_workshop b ON b.ID=A.workshop_id 
            JOIN ref_state C ON C.ID=b.state_id 
            WHERE A.waran_type_id=3 AND A.year='.$selectedYear.' AND A."month"='.$selectedMonth.' ORDER BY A.workshop_id ASC
        )');

        $AccessWarrant = auth()->user()->vehicle('03', '01');
        $is_preview = 0;

        if($AccessWarrant->mod_fleet_u == 0){
            $is_preview = 1;
        }

        $limit = $request->limit ? $request->limit : 10;
        $page = $request->page ? $request->page : 0;
        $offset = $page > 0 ? $limit * $page: 0;

        //Log::info($res);
        return view('maintenance.warrant.warrant-table', [

            'is_preview' => $is_preview,
            'listYear' => $listYear,
            'listWorkshop' => $listWorkshop,
            'listWaranType' => $listWaranType,
            'listOsolType' => $listOsolType,
            'selectedMonth' => $selectedMonth,
            'selectedYear' => $selectedYear,
            'selectedWorkshopId' => $selectedWorkshopId,
            'selectedWorkshop' => $selectedWorkshop,
            'selectedWaran' => $selectedWaran,
            'selectedWaranId' => $selectedWaranId,
            'selectedOsol' => $selectedOsol,
            'selectedOsolId' => $selectedOsolId,
            'osolKKR' => $osolKKR,
            'osolSumKKR' => $osolSumKKR,
            'osolExternal' => $osolExternal,
            'osolSumExternal' => $osolSumExternal,
            'osol26' => $osol26,
            'osol28' => $osol28,
            'osolSum26' => $osolSum26,
            'osolSum28' => $osolSum28,
            'osolTotal' => $osolTotal,
            'osolProjectionSet' => $osolProjectionSet,
            'osol26Projectionpercent' => $osol26Projectionpercent,
            'osol28Projectionpercent' => $osol28Projectionpercent,
            'listStatement' => $listStatement,
            'goToTab' => $goToTab,
            'unlistedKKRState' => $unlistedKKRState,
            'unlistedAgencyState' => $unlistedAgencyState,
            'limit' => $limit,
            'page' => $page,
            'offset' => $offset,
            'totalStatement' => $totalStatement,
        ]);

    })->name('.table');

    Route::post('/add-warrant-state-kkr', function(Request $request){

        $warrantDistributionDAO = new WarrantDistributionDAO();
        $res = $warrantDistributionDAO->addKKRWarantState($request);
        return $res;

    })->name('.add.warrant.state.kkr');

    Route::post('/add-warrant-state-agency', function(Request $request){

        $warrantDistributionDAO = new WarrantDistributionDAO();
        $res = $warrantDistributionDAO->addAgencyWarantState($request);
        return $res;

    })->name('.add.warrant.state.agency');

    Route::get('/update-warrant', function(Request $request){

        $warrantDistributionDAO = new WarrantDistributionDAO();
        $res = $warrantDistributionDAO->updateWarrant($request);
        return $res;

    })->name('.update-warrant');


    Route::get('/update-projection', function(Request $request){

        $warrantDistributionDAO = new WarrantDistributionDAO();
        $res = $warrantDistributionDAO->updateProjection($request);
        return $res;

    })->name('.update-projection');


    Route::get('/get-warrant', function(Request $request){

        // $vehicleDepreciationDAO = new WarrantDistributionDAO();
        // $res = $vehicleDepreciationDAO->getWarrant($request);
        // return $res;

    })->name('.get-warrant');

    Route::post('/add-warrant-adjustment', function(Request $request){

        $warrantDistributionDAO = new WarrantDistributionDAO();
        if($request->adjust_mode == 'add'){
            $res = $warrantDistributionDAO->addWarrantAdjustment($request);
        } elseif($request->adjust_mode == 'update'){
            $res = $warrantDistributionDAO->updateWarrantAdjustment($request);
        }
        return $res;

    })->name('.add-warrant-adjustment');

    Route::get('/get-statement', function(Request $request){

        $warrantDistributionDAO = new WarrantDistributionDAO();
        $res = $warrantDistributionDAO->getStatement($request, null);
        return $res;

    })->name('.get-statement');

    Route::get('/export/excel', function(Request $request){
        $warrantDistributionDAO = new WarrantDistributionDAO();
        return $warrantDistributionDAO->exportExcel($request);
    })->name('.export.excel');

});
