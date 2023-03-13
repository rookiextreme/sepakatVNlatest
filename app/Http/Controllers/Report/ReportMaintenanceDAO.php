<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Fleet\FleetAudit;
use App\Models\Fleet\FleetDepartment;
use App\Models\Maintenance\MaintenanceJob;
use App\Models\RefCategory;
use App\Models\RefWorkshop;
use App\Models\Vehicle\Brand;
use App\Models\Vehicle\VehicleModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PHPJasper\PHPJasper;



class ReportMaintenanceDAO extends Controller
{
      public function getTotalMaintenanceByModule($module){
        switch ($module) {
            case 'evaluation':
                    $query = DB::select(DB::raw('
                    SELECT (SELECT coalesce(count(id),0) FROM maintenance.evaluation WHERE app_status_id = 3) AS total_new,
                    (SELECT coalesce(count(id),0) FROM maintenance.evaluation WHERE app_status_id = 7) AS total_cancelled,
                    (SELECT coalesce(count(id),0) FROM maintenance.evaluation WHERE app_status_id = 9) AS total_completed,
                    (SELECT coalesce(count(id),0) FROM maintenance.evaluation WHERE app_status_id IN (3,4,5,6)) AS total_in_progress
                    '));

                    Log::info($query);
                    return $query;

                break;

            case 'job':
                $query = DB::select(DB::raw('
                SELECT (SELECT coalesce(count(id),0) FROM maintenance.job WHERE app_status_id = 3) AS total_new,
                    (SELECT coalesce(count(id),0) FROM maintenance.job WHERE app_status_id = 7) AS total_cancelled,
                    (SELECT coalesce(count(id),0) FROM maintenance.job WHERE app_status_id = 9) AS total_completed,
                    (SELECT coalesce(count(id),0) FROM maintenance.job WHERE app_status_id IN (3,4,5,6)) AS total_in_progress
                    '));

                Log::info($query);
                return $query;

            break;

            default:
                # code...
                break;
        }
    }

    public function getWorkshop(Request $request){

        $query = DB::select(DB::raw('SELECT a.code, a.desc, a.id
        FROM public.ref_workshop AS a
        GROUP BY a.code, a.desc, a.id
        ORDER BY a.code'));
        return $query;
    }

    public function getAppointment(Request $request){

        $month = $request->month == null ? Carbon::now()->format('m') : $request->month ;
        $year = $request->year == null ? Carbon::now()->format('Y') :  $request->year;

        $filterMonth = "";

        if($year){
            $filterYear = 'AND date_part(\'year\', c.appointment_dt) = '.$year.'';
        }

        if($month){
            $filterMonth = 'AND date_part(\'month\', c.appointment_dt) = '.$month.'';
        }
        Log::info("get appointment");
        $query = DB::select(DB::raw('SELECT a.code, a.desc, a.id, c.id as jobid, COUNT(c.id) as appointment
            FROM public.ref_workshop AS a
            LEFT OUTER JOIN maintenance.job AS c ON a.id = c.workshop_id
            JOIN maintenance.application_status d ON d.id = c.app_status_id
            JOIN maintenance.job_vehicle AS e ON c.id = e.maintenance_job_id
            JOIN maintenance.job_vehicle_examination_form AS f ON e.id = f.vehicle_id
            JOIN maintenance.job_vehicle_status g ON g.id = f.job_vehicle_status_id
            WHERE f.job_vehicle_status_id = \'01\'
            AND d.code = \'03\'
            '.$filterYear.'
            '.$filterMonth.'
            GROUP BY a.code, a.desc, a.id, c.id, d.id
            ORDER BY a.code'));
            
            Log::info($query);
        return $query;
        
    }

    public function getExamination(Request $request){
        Log::info("get exam");
        $month = $request->month == null ? Carbon::now()->format('m') : $request->month ;
        $year = $request->year == null ? Carbon::now()->format('Y') :  $request->year;

        if($year){
            $filterYear = 'AND date_part(\'year\', c.appointment_dt) = '.$year.'';
        }

        if($month){
            $filterMonth = 'AND date_part(\'month\', c.appointment_dt) = '.$month.'';
        }
        $query = DB::select(DB::raw('SELECT a.code, a.desc, a.id, c.id as examid, COUNT(c.id) as exam
            FROM public.ref_workshop AS a
            LEFT OUTER JOIN maintenance.job AS c ON a.id = c.workshop_id
            JOIN maintenance.job_vehicle AS e ON c.id = e.maintenance_job_id
            JOIN maintenance.job_vehicle_examination_form AS f ON e.id = f.vehicle_id
            JOIN maintenance.job_vehicle_status g ON g.id = f.job_vehicle_status_id
            WHERE f.job_vehicle_status_id = \'03\'
            '.$filterYear.'
            '.$filterMonth.'
            GROUP BY a.code, a.desc, a.id, c.id
            ORDER BY a.code'));
        Log::info($query);
        return $query;
    }

    public function getResearchMarketVerification(Request $request){

        $month = $request->month == null ? Carbon::now()->format('m') : $request->month ;
        $year = $request->year == null ? Carbon::now()->format('Y') :  $request->year;

        if($year){
            $filterYear = 'AND date_part(\'year\', c.appointment_dt) = '.$year.'';
        }

        if($month){
            $filterMonth = 'AND date_part(\'month\', c.appointment_dt) = '.$month.'';
        }

        $query = DB::select(DB::raw('SELECT a.code, a.desc, a.id, c.id as researchmarketid, COUNT(c.id) as researchMarket
            FROM public.ref_workshop AS a
            LEFT OUTER JOIN maintenance.job AS c ON a.id = c.workshop_id
            JOIN maintenance.job_vehicle AS e ON c.id = e.maintenance_job_id
            JOIN maintenance.job_vehicle_examination_form AS f ON e.id = f.vehicle_id
            JOIN maintenance.job_vehicle_status g ON g.id = f.job_vehicle_status_id
            WHERE f.job_vehicle_status_id = \'06\'
            '.$filterYear.'
            '.$filterMonth.'
            GROUP BY a.code, a.desc, a.id, c.id
            ORDER BY a.code'));

        Log::info("get rmv");
        Log::info($query);
        return $query;
    }
        
    public function getProcurementVerification(Request $request){

        $month = $request->month == null ? Carbon::now()->format('m') : $request->month ;
        $year = $request->year == null ? Carbon::now()->format('Y') :  $request->year;
        if($year){
            $filterYear = 'AND date_part(\'year\', c.appointment_dt) = '.$year.'';
        }

        if($month){
            $filterMonth = 'AND date_part(\'month\', c.appointment_dt) = '.$month.'';
        }

            $query = DB::select(DB::raw('SELECT a.code, a.desc, a.id, c.id as researchmarketid, COUNT(c.id) as researchMarket
            FROM public.ref_workshop AS a
            LEFT OUTER JOIN maintenance.job AS c ON a.id = c.workshop_id
            JOIN maintenance.job_vehicle AS e ON c.id = e.maintenance_job_id
            JOIN maintenance.job_vehicle_examination_form AS f ON e.id = f.vehicle_id
            JOIN maintenance.job_vehicle_status g ON g.id = f.job_vehicle_status_id
            WHERE f.job_vehicle_status_id = \'10\'
            '.$filterYear.'
            '.$filterMonth.'
            GROUP BY a.code, a.desc, a.id, c.id
            ORDER BY a.code'));

        Log::info("get prov");
        Log::info($query);
        return $query;
        }

        public function getCompleted(Request $request){
            Log::info("selesai");
            $month = $request->month == null ? Carbon::now()->format('m') : $request->month ;
            $year = $request->year == null ? Carbon::now()->format('Y') :  $request->year;
            if($year){
                $filterYear = 'AND date_part(\'year\', c.appointment_dt) = '.$year.'';
            }
    
            if($month){
                $filterMonth = 'AND date_part(\'month\', c.appointment_dt) = '.$month.'';
            }
    
            $query = DB::select(DB::raw('SELECT a.code, a.desc, a.id, c.id as completedid, COUNT(c.id) as completed
                FROM public.ref_workshop AS a
                LEFT OUTER JOIN maintenance.job AS c ON a.id = c.workshop_id
                JOIN maintenance.application_status d ON d.id = c.app_status_id
                WHERE d.code = \'08\'
                '.$filterYear.'
                '.$filterMonth.' 
                GROUP BY a.code, a.desc, a.id, c.id 
                ORDER BY a.code'));
            Log::info($query);
            return $query;
        }

        public function getEvaluationAppointment(Request $request){

            $month = $request->month == null ? Carbon::now()->format('m') : $request->month ;
            $year = $request->year == null ? Carbon::now()->format('Y') :  $request->year;
    
            $filterMonth = "";
    
            if($year){
                $filterYear = 'AND date_part(\'year\', b.appointment_dt) = '.$year.'';
            }
    
            if($month){
                $filterMonth = 'AND date_part(\'month\', b.appointment_dt) = '.$month.'';
            }
            $query = DB::select(DB::raw('SELECT a.code, a.desc, a.id, b.id as evaluationid, COUNT(b.id) as evaluation_appointment
            FROM public.ref_workshop AS a
            LEFT OUTER JOIN maintenance.evaluation AS b ON a.id = b.workshop_id
            JOIN maintenance.application_status d ON d.id = b.app_status_id
            JOIN maintenance.evaluation_vehicle h ON b.id = h.maintenance_evaluation_id
            JOIN maintenance.vehicle_status g ON g.id = h.maintenance_vehicle_status_id
            WHERE h.maintenance_vehicle_status_id = 2
            AND d.code = \'03\'
                '.$filterYear.'
                '.$filterMonth.'
                GROUP BY a.code, a.desc, a.id, b.id, d.id, h.id, g.id
                ORDER BY a.code'));
            Log::info("evaluation appointment");
            Log::info($query);
            return $query;
        }

        public function getEvaluationVerification(Request $request){

            $month = $request->month == null ? Carbon::now()->format('m') : $request->month ;
            $year = $request->year == null ? Carbon::now()->format('Y') :  $request->year;
            if($year){
                $filterYear = 'AND date_part(\'year\', b.appointment_dt) = '.$year.'';
            }
    
            if($month){
                $filterMonth = 'AND date_part(\'month\', b.appointment_dt) = '.$month.'';
            }
    
                $query = DB::select(DB::raw('SELECT a.code, a.desc, a.id, b.id as verificationid, COUNT(b.id) as verification
                FROM public.ref_workshop AS a
                LEFT OUTER JOIN maintenance.evaluation AS b ON a.id = b.workshop_id
                JOIN maintenance.application_status d ON d.id = b.app_status_id
                JOIN maintenance.evaluation_vehicle h ON b.id = h.maintenance_evaluation_id
                JOIN maintenance.vehicle_status g ON g.id = h.maintenance_vehicle_status_id
                WHERE h.maintenance_vehicle_status_id = 8
                AND d.code = \'03\'
                '.$filterYear.'
                '.$filterMonth.'
                GROUP BY a.code, a.desc, a.id, b.id
                ORDER BY a.code'));
        
                Log::info("get evaluation verify");
                Log::info($query);
                return $query;
            }

            public function getCompletedEvaluation(Request $request){
                Log::info("selesai evaluation");
                $month = $request->month == null ? Carbon::now()->format('m') : $request->month ;
                $year = $request->year == null ? Carbon::now()->format('Y') :  $request->year;
                if($year){
                    $filterYear = 'AND date_part(\'year\', b.appointment_dt) = '.$year.'';
                }
        
                if($month){
                    $filterMonth = 'AND date_part(\'month\', b.appointment_dt) = '.$month.'';
                }
        
                $query = DB::select(DB::raw('SELECT a.code, a.desc, a.id, b.id as completedevaluationid, COUNT(b.id) as completedevaluation
                    FROM public.ref_workshop AS a
                    LEFT OUTER JOIN maintenance.evaluation AS b ON a.id = b.workshop_id
                    JOIN maintenance.application_status d ON d.id = b.app_status_id
                    WHERE d.code = \'08\'
                    '.$filterYear.'
                    '.$filterMonth.' 
                    GROUP BY a.code, a.desc, a.id, b.id 
                    ORDER BY a.code'));
                Log::info($query);
                return $query;
            }
            
            public function getEvaluationLetter(Request $request){
                Log::info("get letter evaluation");
                $month = $request->month == null ? Carbon::now()->format('m') : $request->month ;
                $year = $request->year == null ? Carbon::now()->format('Y') :  $request->year;

                if($year){
                    $filterYear = 'AND date_part(\'year\', b.appointment_dt) = '.$year.'';
                }
        
                if($month){
                    $filterMonth = 'AND date_part(\'month\', b.appointment_dt) = '.$month.'';
                }
        
                $query = DB::select(DB::raw('SELECT a.code, a.desc, a.id, b.id as completedevaluationid, COUNT(b.id) as completedevaluation
                    FROM public.ref_workshop AS a
                    LEFT OUTER JOIN maintenance.evaluation AS b ON a.id = b.workshop_id
                    JOIN maintenance.application_status d ON d.id = b.app_status_id
                    WHERE d.code = \'11\'
                    '.$filterYear.'
                    '.$filterMonth.' 
                    GROUP BY a.code, a.desc, a.id, b.id 
                    ORDER BY a.code'));
                Log::info($query);
                return $query;
            }
}
