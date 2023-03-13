<?php

use App\Http\Controllers\Log\LogDAO;
use App\Http\Controllers\Report\ReportSummonTrendDAO;
use App\Http\Controllers\Report\ReportAssessmentDAO;
use App\Http\Controllers\Report\ReportMaintenanceDAO;
use App\Models\Fleet\FleetDepartment;
use App\Models\GeneralRecordCount;
use App\Models\Logistic\LogisticBooking;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

Route::get('/admin', function () {
    if (Auth::user()->roleAccess()->code != '01') {
       return 'Somthing went wrong';
    }
    return view('dashboards.dashboard');
})->middleware(['auth'])->name('access.admin');

Route::group(['prefix' => 'admin', 'as' => 'access.admin', 'middleware' => 'auth'], function(){

    Route::get('/dashboard', function () {

        $carbon = new Carbon();
        $carbon->setLocale('ms');
        
        if (Auth::user()->roleAccess()->code != '01') {
           return 'Somthing went wrong';
        }

        $general_record_count_view = GeneralRecordCount::select('*')->first();

        $vehicleByCategoryList = FleetDepartment::select('ref_category.id AS id','ref_category.name AS name', DB::raw('count(*) as total'))
                 ->groupBy('ref_category.id','ref_category.name')
                 ->join('ref_category', 'ref_category.id', '=', 'category_id')
                 ->join('ref_vehicle_status', 'ref_vehicle_status.id', '=', 'vehicle_status_id')
                 ->whereIn('ref_vehicle_status.code', ['01','02','03','04','05','06','07','08'])
                 ->orderBy('ref_category.name')
                 ->get();

        $vehicleBySubCategoryList = FleetDepartment::select('ref_sub_category.name AS name', DB::raw('count(*) as total'))
                 ->groupBy('ref_sub_category.name')
                 ->join('ref_sub_category', 'ref_sub_category.id', '=', 'sub_category_id')
                 ->join('ref_vehicle_status', 'ref_vehicle_status.id', '=', 'vehicle_status_id')
                 ->where('ref_vehicle_status.code', ['01','02','03','04','05','06','07','08'])
                 ->orderBy('ref_sub_category.name')
                 ->get();

        $totalLastMonth = LogisticBooking::whereRaw("start_datetime >= date_trunc('month', current_date - interval '12' month) and start_datetime < date_trunc('month', current_date)")->count();
        $totalThisMonth = LogisticBooking::whereRaw("start_datetime >= date_trunc('month', current_date)")->count();

        Log::info('totalLastMonth '.$totalLastMonth);
        Log::info('totalThisMonth '.$totalThisMonth);
        $booking_logistic_percent = 0;
        if($totalLastMonth > $totalThisMonth){
            $booking_logistic_percent = ($totalThisMonth / $totalLastMonth) * 100;
        } else if($totalThisMonth>$totalLastMonth){
            $booking_logistic_percent = $totalThisMonth;
        }

        $repostSummondTotal = new ReportSummonTrendDAO();
        $resultPaid = $repostSummondTotal -> getSamanUltimateFigure('paid');
        $resultUnpaid = $repostSummondTotal -> getSamanUltimateFigure('unpaid');
        $resultTransfered = $repostSummondTotal -> getSamanUltimateFigure('transfered');
        $resultDiscounted = $repostSummondTotal -> getSamanUltimateFigure('discounted');

        $reportAssessmentDAO = new ReportAssessmentDAO();
        $resultNew = $reportAssessmentDAO->getTotalAssessmentByModule('new');
        Log::info("resultnew totalnew : ".$resultNew[0]->total_new);
        $resultSafety = $reportAssessmentDAO->getTotalAssessmentByModule('safety');
        $resultAccident = $reportAssessmentDAO->getTotalAssessmentByModule('accident');
        $resultCurrvalue = $reportAssessmentDAO->getTotalAssessmentByModule('currvalue');
        $resultLoan = $reportAssessmentDAO->getTotalAssessmentByModule('loan');
        $resultDisposal = $reportAssessmentDAO->getTotalAssessmentByModule('disposal');

        $reportMaintenanceDAO = new ReportMaintenanceDAO();
        $resultMaintenanceEvaluation = $reportMaintenanceDAO->getTotalMaintenanceByModule('evaluation');
        $resultMaintenanceJob = $reportMaintenanceDAO->getTotalMaintenanceByModule('job');

        $total_online_now = User::where('is_login', 1)->count();

        $object = [
            'general_record_count_view' => $general_record_count_view,
            'vehicleByCategoryList' => $vehicleByCategoryList,
            'vehicleBySubCategoryList' => $vehicleBySubCategoryList,
            'totalSummonPaid' => $resultPaid[0]->total_paid,
            'totalSummonUnpaid' =>  $resultUnpaid[0]->total_unpaid,
            'totalSummonTransfered' => $resultTransfered[0]->total_transfered,
            'totalSummonDiscounted' => $resultDiscounted[0]->total_discounted,
            'resultNew' => $resultNew[0],
            'resultSafety' => $resultSafety[0],
            'resultAccident' => $resultAccident[0],
            'resultCurrvalue' => $resultCurrvalue[0],
            'resultLoan' => $resultLoan[0],
            'resultDisposal' => $resultDisposal[0],
            'resultMaintenanceEvaluation' => $resultMaintenanceEvaluation[0],
            'resultMaintenanceJob' => $resultMaintenanceJob[0],
            'booking_logistic_percent' => round($booking_logistic_percent, 2),
            'total_online_now' => $total_online_now,
        ];

        return view('access_admin.dashboard', $object);
    })->middleware(['auth'])->name('.dashboard');

    Route::get('/syslog', function (Request $request) {

        $LogDAO = new LogDAO();

        return view('access_admin.syslog', $LogDAO->sysLog($request));

    })->middleware(['auth'])->name('.syslog');

    Route::get('/syslog/detail', function (Request $request) {

        $LogDAO = new LogDAO();

        return view('access_admin.syslog-detail', $LogDAO->sysLogDetail($request));

    })->middleware(['auth'])->name('.syslog.detail');

});
