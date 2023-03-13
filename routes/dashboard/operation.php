<?php

use App\Http\Controllers\Report\ReportAssessmentDAO;
use App\Http\Controllers\Report\ReportMaintenanceDAO;
use App\Http\Controllers\Report\ReportSummonTrendDAO;
use App\Models\Assessment\AssessmentAccidentVehicle;
use App\Models\Assessment\AssessmentCurrvalueVehicle;
use App\Models\Assessment\AssessmentDisposalVehicle;
use App\Models\Assessment\AssessmentGovLoanVehicle;
use App\Models\Assessment\AssessmentNew;
use App\Models\Assessment\AssessmentNewVehicle;
use App\Models\Assessment\AssessmentSafety;
use App\Models\Assessment\AssessmentSafetyVehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Models\Fleet\FleetDepartment;
use App\Models\GeneralRecordCount;
use App\Models\Logistic\LogisticBooking;
use App\Models\Maintenance\MaintenanceEvaluationVehicle;
use App\Models\Maintenance\MaintenanceJobVehicle;
use App\Models\Maintenance\WaranType;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

Route::get('/operation', function (Request $request) {
    Log::info($request);
    if (Auth::user()->roleAccess()->code != '03') {
       return 'Somthing went wrong';
    }
    return view('dashboards.dashboard');



})->middleware(['auth'])->name('access.operation');

Route::group(['prefix' => 'operation', 'as' => 'access.operation', 'middleware' => 'auth'], function(){

    Route::get('/dashboard', function () {

        $carbon = new Carbon();
        $carbon->setLocale('ms');


        if (Auth::user()->roleAccess()->code != '03') {
           return 'Somthing went wrong';
        }

        $dashboard_type = Request('dashboard_type') ? Request('dashboard_type') : 'assessment';

        //Pembantu Kemahiran Assessment

        $assessment_new_vehicle_list = AssessmentNewVehicle::whereHas('hasAssessmentDetail', function($q1){
            $q1->whereHas('hasStatus', function($q2){
                $q2->whereIn('code', ['03']);
            });
        })->whereHas('hasAssessmentVehicleStatus', function($q){
            $q->whereIn('code', ['03']);
        })->whereHas('hasAssessmentDetail', function($q2){
            $q2->whereHas('hasWorkshop', function($q3){
                $q3->where('id', Auth::user()->detail->hasWorkshop ? Auth::user()->detail->hasWorkshop->id : -1);
            });
        })->where('in_assessment', false);
        $assessment_new_vehicle_list->WhereRaw('( foremen_by IS NULL OR (foremen_by IS NOT NULL AND foremen_by = '.Auth::user()->id.'))');

        $assessment_safety_vehicle_list = AssessmentSafetyVehicle::whereHas('hasAssessmentDetail', function($q1){
                $q1->whereHas('hasStatus', function($q2){
                    $q2->whereIn('code', ['03']);
            });
        })->whereHas('hasAssessmentVehicleStatus', function($q){
            $q->whereIn('code', ['03']);
        })->whereHas('hasAssessmentDetail', function($q2){
            $q2->whereHas('hasWorkshop', function($q3){
                $q3->where('id', Auth::user()->detail->hasWorkshop ? Auth::user()->detail->hasWorkshop->id : -1);
            });
        })->where('in_assessment', false);
        $assessment_safety_vehicle_list->WhereRaw('( foremen_by IS NULL OR (foremen_by IS NOT NULL AND foremen_by = '.Auth::user()->id.'))');

        $assessment_accident_vehicle_list = AssessmentAccidentVehicle::whereHas('hasAssessmentDetail', function($q1){
                $q1->whereHas('hasStatus', function($q2){
                    $q2->whereIn('code', ['03']);
            });
        })->whereHas('hasAssessmentVehicleStatus', function($q){
            $q->whereIn('code', ['03']);
        })->whereHas('hasAssessmentDetail', function($q2){
            $q2->whereHas('hasWorkshop', function($q3){
                $q3->where('id', Auth::user()->detail->hasWorkshop ? Auth::user()->detail->hasWorkshop->id : -1);
            });
        })->where('in_assessment', false);
        $assessment_accident_vehicle_list->WhereRaw('( foremen_by IS NULL OR (foremen_by IS NOT NULL AND foremen_by = '.Auth::user()->id.'))');

        $assessment_gov_loan_vehicle_list = AssessmentGovLoanVehicle::whereHas('hasAssessmentDetail', function($q1){
                $q1->whereHas('hasStatus', function($q2){
                    $q2->whereIn('code', ['03']);
            });
        })->whereHas('hasAssessmentVehicleStatus', function($q){
            $q->whereIn('code', ['03']);
        })->whereHas('hasAssessmentDetail', function($q2){
            $q2->whereHas('hasWorkshop', function($q3){
                $q3->where('id', Auth::user()->detail->hasWorkshop ? Auth::user()->detail->hasWorkshop->id : -1);
            });
        })->where('in_assessment', false);
        $assessment_gov_loan_vehicle_list->WhereRaw('( foremen_by IS NULL OR (foremen_by IS NOT NULL AND foremen_by = '.Auth::user()->id.'))');

        $assessment_disposal_vehicle_list = AssessmentDisposalVehicle::whereHas('hasAssessmentDetail', function($q1){
                $q1->whereHas('hasStatus', function($q2){
                    $q2->whereIn('code', ['03']);
            });
        })->whereHas('hasAssessmentVehicleStatus', function($q){
            $q->whereIn('code', ['03']);
        })->whereHas('hasAssessmentDetail', function($q2){
            $q2->whereHas('hasWorkshop', function($q3){
                $q3->where('id', Auth::user()->detail->hasWorkshop ? Auth::user()->detail->hasWorkshop->id : -1);
            });
        })->where('in_assessment', false);
        $assessment_disposal_vehicle_list->WhereRaw('( foremen_by IS NULL OR (foremen_by IS NOT NULL AND foremen_by = '.Auth::user()->id.'))');

        $assessment_currvalue_vehicle_list = AssessmentCurrvalueVehicle::whereHas('hasAssessmentDetail', function($q1){
                $q1->whereHas('hasStatus', function($q2){
                    $q2->whereIn('code', ['03']);
            });
        })->whereHas('hasAssessmentVehicleStatus', function($q){
            $q->whereIn('code', ['03']);
        })->whereHas('hasAssessmentDetail', function($q2){
            $q2->whereHas('hasWorkshop', function($q3){
                $q3->where('id', Auth::user()->detail->hasWorkshop ? Auth::user()->detail->hasWorkshop->id : -1);
            });
        })->where('in_assessment', false);
        $assessment_currvalue_vehicle_list->WhereRaw('( foremen_by IS NULL OR (foremen_by IS NOT NULL AND foremen_by = '.Auth::user()->id.'))');

        Log::info(Auth::user()->id);

        //active
        $assessment_new_vehicle_active_list = AssessmentNewVehicle::whereHas('hasAssessmentDetail', function($q1){
            $q1->whereHas('hasStatus', function($q2){
                $q2->whereIn('code', ['03']);
            });
        })->whereHas('hasAssessmentVehicleStatus', function($q){
            $q->whereIn('code', ['03']);
        })->whereHas('foremenBy', function($q){
            $q->where('id', Auth::user()->id);
        })->where('in_assessment', true);

        $assessment_safety_vehicle_active_list = AssessmentSafetyVehicle::whereHas('hasAssessmentDetail', function($q1){
            $q1->whereHas('hasStatus', function($q2){
                $q2->whereIn('code', ['03']);
            });
        })->whereHas('hasAssessmentVehicleStatus', function($q){
            $q->whereIn('code', ['03']);
        })->whereHas('foremenBy', function($q){
            $q->where('id', Auth::user()->id);
        })->where('in_assessment', true);

        $assessment_accident_vehicle_active_list = AssessmentAccidentVehicle::whereHas('hasAssessmentDetail', function($q1){
            $q1->whereHas('hasStatus', function($q2){
                $q2->whereIn('code', ['03']);
            });
        })->whereHas('hasAssessmentVehicleStatus', function($q){
            $q->whereIn('code', ['03']);
        })->whereHas('foremenBy', function($q){
            $q->where('id', Auth::user()->id);
        })->where('in_assessment', true);

        $assessment_gov_loan_vehicle_active_list = AssessmentGovLoanVehicle::whereHas('hasAssessmentDetail', function($q1){
            $q1->whereHas('hasStatus', function($q2){
                $q2->whereIn('code', ['03']);
            });
        })->whereHas('hasAssessmentVehicleStatus', function($q){
            $q->whereIn('code', ['03']);
        })->whereHas('foremenBy', function($q){
            $q->where('id', Auth::user()->id);
        })->where('in_assessment', true);

        $assessment_disposal_vehicle_active_list = AssessmentDisposalVehicle::whereHas('hasAssessmentDetail', function($q1){
            $q1->whereHas('hasStatus', function($q2){
                $q2->whereIn('code', ['03']);
            });
        })->whereHas('hasAssessmentVehicleStatus', function($q){
            $q->whereIn('code', ['03']);
        })->whereHas('foremenBy', function($q){
            $q->where('id', Auth::user()->id);
        })->where('in_assessment', true);

        $assessment_currvalue_vehicle_active_list = AssessmentCurrvalueVehicle::whereHas('hasAssessmentDetail', function($q1){
            $q1->whereHas('hasStatus', function($q2){
                $q2->whereIn('code', ['03']);
            });
        })->whereHas('hasAssessmentVehicleStatus', function($q){
            $q->whereIn('code', ['03']);
        })->whereHas('foremenBy', function($q){
            $q->where('id', Auth::user()->id);
        })->where('in_assessment', true);

        Log::info($assessment_new_vehicle_list->toSql());
        Log::info($assessment_new_vehicle_active_list->toSql());

        // -------------------- //

        Log::info('Masuh Dashboard Pembantu Kemahiran');
        Log::info('formentBy '.Auth::user()->id);
        Log::info('Nama '.Auth::user()->name);
        if(Auth::user()->detail->hasWorkshop){
            Log::info('Workshop '. Auth::user()->detail->hasWorkshop->desc);
        }

        $maintenance_evaluation_vehicle_list = MaintenanceEvaluationVehicle::whereHas('hasMaintenanceDetail', function($q1){
            $q1->whereHas('hasStatus', function($q2){
                $q2->whereIn('code', ['03']);
            });
        })->whereHas('hasMaintenanceVehicleStatus', function($q){
            $q->whereIn('code', ['01']);
        })->whereHas('hasMaintenanceDetail', function($q2){
            $q2->whereHas('hasWorkshop', function($q3){
                $q3->where('id', Auth::user()->detail->hasWorkshop ? Auth::user()->detail->hasWorkshop->id : -1);
            });
        });

        // if foremen is not null. filter instead.
        $maintenance_evaluation_vehicle_list->WhereRaw('( foremen_by IS NULL OR (foremen_by IS NOT NULL AND foremen_by = '.Auth::user()->id.'))')
        ->orWhereRaw('(foremen_by IS NOT NULL AND foremen_by = '.Auth::user()->id.')')->whereHas('hasMaintenanceVehicleStatus', function($q){
            $q->whereIn('code', ['01']);
        });

        $maintenance_evaluation_vehicle_active_list = MaintenanceEvaluationVehicle::whereHas('hasMaintenanceDetail', function($q1){
            $q1->whereHas('hasStatus', function($q2){
                $q2->whereIn('code', ['03']);
            });
        })->whereHas('hasMaintenanceVehicleStatus', function($q){
            $q->whereIn('code', ['06']);
        })->whereHas('foremenBy', function($q){
            $q->where('id', Auth::user()->id);
        });

        //maintenance job

        $maintenance_job_vehicle_list = MaintenanceJobVehicle::whereHas('hasMaintenanceDetail', function($q1){
            $q1->whereHas('hasStatus', function($q2){
                $q2->whereIn('code', ['03']);
            });
        })->whereHas('hasMaintenanceVehicleStatus', function($q){
            $q->whereIn('code', ['01','06']);
        })->whereHas('hasMaintenanceDetail', function($q2){
            $q2->whereHas('hasWorkshop', function($q3){
                $q3->where('id', Auth::user()->detail->hasWorkshop ? Auth::user()->detail->hasWorkshop->id : -1);
            });
        });

        // if foremen is not null. filter instead.
        $maintenance_job_vehicle_list->WhereRaw('( foremen_by IS NULL OR (foremen_by IS NOT NULL AND foremen_by = '.Auth::user()->id.'))');

        $maintenance_job_vehicle_list->whereHas('hasExamform', function($q2){
            $q2->whereRaw('(
                (internal_repair_status_id is null AND job_vehicle_status_id = 1) OR
                (internal_repair_status_id is null AND ext_repair_status_id = 4 AND job_vehicle_status_id = 11) OR
                (internal_repair_status_id = 1 AND job_vehicle_status_id = 11) OR
                (internal_repair_status_id = 3 AND ext_repair_status_id = 4 AND job_vehicle_status_id = 11)
            )');
        });

        $maintenance_job_vehicle_list->orWhereRaw('(foremen_by IS NOT NULL AND foremen_by = '.Auth::user()->id.')')->whereHas('hasMaintenanceVehicleStatus', function($q){
            $q->whereIn('code', ['01']);
        });

        $maintenance_job_vehicle_active_list = MaintenanceJobVehicle::whereHas('hasMaintenanceDetail', function($q1){
            $q1->whereHas('hasStatus', function($q2){
                $q2->whereIn('code', ['03']);
            });
        })->whereHas('hasMaintenanceVehicleStatus', function($q){
            $q->whereIn('code', ['06']);
        })->whereHas('foremenBy', function($q){
            $q->where('id', Auth::user()->id);
        })->whereHas('hasExamform', function($q){
            $q->whereRaw('(
                (job_vehicle_status_id = 2) OR
                (internal_repair_status_id = 7 AND job_vehicle_status_id = 11) OR
                (internal_repair_status_id = 3 AND ext_repair_status_id = 8 AND job_vehicle_status_id = 11) OR
                (internal_repair_status_id is null AND ext_repair_status_id = 8 AND job_vehicle_status_id = 11)
            )');
        });

        Log::info($maintenance_job_vehicle_active_list->toSql());

        if(auth()->user()->isForemenAssessment() && auth()->user()->isForemenMaintenance()){
            return view('access_ops.foremen-dashboard', [
                'dashboard_type' => $dashboard_type,
                'assessment_new_vehicle_list' => $assessment_new_vehicle_list->get(),
                'assessment_safety_vehicle_list' => $assessment_safety_vehicle_list->get(),
                'assessment_accident_vehicle_list' => $assessment_accident_vehicle_list->get(),
                'assessment_gov_loan_vehicle_list' => $assessment_gov_loan_vehicle_list->get(),
                'assessment_disposal_vehicle_list' => $assessment_disposal_vehicle_list->get(),
                'assessment_currvalue_vehicle_list' => $assessment_currvalue_vehicle_list->get(),
                'assessment_new_vehicle_active_list' => $assessment_new_vehicle_active_list->get(),
                'assessment_accident_vehicle_active_list' => $assessment_accident_vehicle_active_list->get(),
                'assessment_safety_vehicle_active_list' => $assessment_safety_vehicle_active_list->get(),
                'assessment_gov_loan_vehicle_active_list' => $assessment_gov_loan_vehicle_active_list->get(),
                'assessment_disposal_vehicle_active_list' => $assessment_disposal_vehicle_active_list->get(),
                'assessment_currvalue_vehicle_active_list' => $assessment_currvalue_vehicle_active_list->get(),

                'maintenance_evaluation_vehicle_list' => $maintenance_evaluation_vehicle_list->get(),
                'maintenance_evaluation_vehicle_active_list' => $maintenance_evaluation_vehicle_active_list->get(),
                'maintenance_job_vehicle_list' => $maintenance_job_vehicle_list->get(),
                'maintenance_job_vehicle_active_list' => $maintenance_job_vehicle_active_list->get()

            ]);
        }

        else if(auth()->user()->isForemenAssessment()){

            return view('access_ops.foremen-dashboard', [
                'assessment_new_vehicle_list' => $assessment_new_vehicle_list->get(),
                'assessment_safety_vehicle_list' => $assessment_safety_vehicle_list->get(),
                'assessment_accident_vehicle_list' => $assessment_accident_vehicle_list->get(),
                'assessment_gov_loan_vehicle_list' => $assessment_gov_loan_vehicle_list->get(),
                'assessment_disposal_vehicle_list' => $assessment_disposal_vehicle_list->get(),
                'assessment_currvalue_vehicle_list' => $assessment_currvalue_vehicle_list->get(),
                'assessment_new_vehicle_active_list' => $assessment_new_vehicle_active_list->get(),
                'assessment_accident_vehicle_active_list' => $assessment_accident_vehicle_active_list->get(),
                'assessment_safety_vehicle_active_list' => $assessment_safety_vehicle_active_list->get(),
                'assessment_gov_loan_vehicle_active_list' => $assessment_gov_loan_vehicle_active_list->get(),
                'assessment_disposal_vehicle_active_list' => $assessment_disposal_vehicle_active_list->get(),
                'assessment_currvalue_vehicle_active_list' => $assessment_currvalue_vehicle_active_list->get(),
            ]);

        }
        else if(auth()->user()->isForemenMaintenance()){

            return view('access_ops.foremen-dashboard', [
                'maintenance_evaluation_vehicle_list' => $maintenance_evaluation_vehicle_list->get(),
                'maintenance_evaluation_vehicle_active_list' => $maintenance_evaluation_vehicle_active_list->get(),
                'maintenance_job_vehicle_list' => $maintenance_job_vehicle_list->get(),
                'maintenance_job_vehicle_active_list' => $maintenance_job_vehicle_active_list->get()
            ]);

        } else {

            $general_record_count_view = GeneralRecordCount::select('*')->first();

            $vehicleByCategoryList = FleetDepartment::select('ref_category.id AS id','ref_category.name AS name', DB::raw('count(*) as total'))
                     ->groupBy('ref_category.id','ref_category.name')
                     ->join('ref_category', 'ref_category.id', '=', 'category_id')
                     ->join('ref_vehicle_status', 'ref_vehicle_status.id', '=', 'vehicle_status_id')
                     ->where([
                        'ref_vehicle_status.code' => '01'
                     ])
                     ->orderBy('ref_category.name')
                     ->get();

                    // (SELECT COUNT(id) FROM fleet.fleet_department where owner_type_id = 3 and vehicle_status_id in (1,2,3)) AS total_vehicle_persekutuan,
                    // (SELECT COUNT(id) FROM fleet.fleet_department where owner_type_id = 4 and vehicle_status_id in (1,2,3)) AS total_vehicle_negeri,

            $vehicleBySubCategoryList = FleetDepartment::select('ref_sub_category.name AS name', DB::raw('count(*) as total'))
                     ->groupBy('ref_sub_category.name')
                     ->join('ref_sub_category', 'ref_sub_category.id', '=', 'sub_category_id')
                     ->join('ref_vehicle_status', 'ref_vehicle_status.id', '=', 'vehicle_status_id')
                     ->where('ref_vehicle_status.code', '01')
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
            $warants = WaranType::all();

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
            'booking_logistic_percent' => round($booking_logistic_percent, 2)
        ];

            return view('access_ops.dashboard', $object);
        }
        //return view('vehicle.vehicle-overview');


    })->middleware(['auth'])->name('.dashboard');

});
