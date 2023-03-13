<?php

namespace App\Http\Controllers\Report;

use App\Exports\ReportAssessmentExportView;
use App\Http\Controllers\Controller;
use App\Models\Assessment\AssessmentAccident;
use App\Models\Assessment\AssessmentCurrvalue;
use App\Models\Assessment\AssessmentDisposal;
use App\Models\Assessment\AssessmentGovLoan;
use App\Models\Assessment\AssessmentNew;
use App\Models\Assessment\AssessmentSafety;
use App\Models\Fleet\FleetAudit;
use App\Models\Fleet\FleetDepartment;
use App\Models\RefCategory;
use App\Models\RefWorkshop;
use App\Models\Vehicle\Brand;
use App\Models\Vehicle\VehicleModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PHPJasper\PHPJasper;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ReportAssessmentDAO extends Controller
{

    public $categoryList;

    public function mount(){
        $this->categoryList = RefCategory::all();
    }

    public function getTotalAssessmentByModule($module){

        $mydate = Carbon::now()->format('Y');

        switch ($module) {
            case 'new':
                    $query = DB::select(DB::raw('
                    SELECT (SELECT coalesce(count(id),0) FROM assessment.assessment_new WHERE app_status_id = 3 AND date_part(\'year\', created_at) = '.$mydate.') AS total_new,
                    (SELECT coalesce(count(id),0) FROM assessment.assessment_new WHERE app_status_id = 7 AND date_part(\'year\', created_at) = '.$mydate.') AS total_cancelled,
                    (SELECT coalesce(count(id),0) FROM assessment.assessment_new WHERE app_status_id = 9 AND date_part(\'year\', created_at) = '.$mydate.') AS total_completed,
                    (SELECT coalesce(count(id),0) FROM assessment.assessment_new WHERE app_status_id IN (4,5,6) AND date_part(\'year\', created_at) = '.$mydate.') AS total_in_progress,
                    (SELECT coalesce(count(id),0) FROM assessment.assessment_new WHERE app_status_id IN (3,4,5,6,7,8,9) AND date_part(\'year\', created_at) = '.$mydate.') AS total_all_new
                    '));

                    Log::info($query);
                    return $query;
                break;

            case 'safety':
                $query = DB::select(DB::raw('
                SELECT (SELECT coalesce(count(id),0) FROM assessment.assessment_safety WHERE app_status_id = 3 AND date_part(\'year\', created_at) = '.$mydate.') AS total_new,
                    (SELECT coalesce(count(id),0) FROM assessment.assessment_safety WHERE app_status_id = 7 AND date_part(\'year\', created_at) = '.$mydate.') AS total_cancelled,
                    (SELECT coalesce(count(id),0) FROM assessment.assessment_safety WHERE app_status_id = 9 AND date_part(\'year\', created_at) = '.$mydate.') AS total_completed,
                    (SELECT coalesce(count(id),0) FROM assessment.assessment_safety WHERE app_status_id IN (4,5,6) AND date_part(\'year\', created_at) = '.$mydate.') AS total_in_progress,
                    (SELECT coalesce(count(id),0) FROM assessment.assessment_safety WHERE app_status_id IN (3,4,5,6,7,8,9) AND date_part(\'year\', created_at) = '.$mydate.') AS total_all_safety
                    '));

                Log::info($query);
                return $query;

            break;

            case 'accident':
                $query = DB::select(DB::raw('
                SELECT (SELECT coalesce(count(id),0) FROM assessment.assessment_accident WHERE app_status_id = 3 AND date_part(\'year\', created_at) = '.$mydate.') AS total_new,
                    (SELECT coalesce(count(id),0) FROM assessment.assessment_accident WHERE app_status_id = 7 AND date_part(\'year\', created_at) = '.$mydate.') AS total_cancelled,
                    (SELECT coalesce(count(id),0) FROM assessment.assessment_accident WHERE app_status_id = 9 AND date_part(\'year\', created_at) = '.$mydate.') AS total_completed,
                    (SELECT coalesce(count(id),0) FROM assessment.assessment_accident WHERE app_status_id IN (4,5,6) AND date_part(\'year\', created_at) = '.$mydate.') AS total_in_progress,
                    (SELECT coalesce(count(id),0) FROM assessment.assessment_accident WHERE app_status_id IN (3,4,5,6,7,8,9) AND date_part(\'year\', created_at) = '.$mydate.') AS total_all_accident
                    '));

                Log::info($query);
                return $query;

            break;

            case 'loan':
                $query = DB::select(DB::raw('
                SELECT (SELECT coalesce(count(id),0) FROM assessment.assessment_gov_loan WHERE app_status_id = 3 AND date_part(\'year\', created_at) = '.$mydate.') AS total_new,
                    (SELECT coalesce(count(id),0) FROM assessment.assessment_gov_loan WHERE app_status_id = 7 AND date_part(\'year\', created_at) = '.$mydate.') AS total_cancelled,
                    (SELECT coalesce(count(id),0) FROM assessment.assessment_gov_loan WHERE app_status_id = 9 AND date_part(\'year\', created_at) = '.$mydate.') AS total_completed,
                    (SELECT coalesce(count(id),0) FROM assessment.assessment_gov_loan WHERE app_status_id IN (4,5,6) AND date_part(\'year\', created_at) = '.$mydate.') AS total_in_progress,
                    (SELECT coalesce(count(id),0) FROM assessment.assessment_gov_loan WHERE app_status_id IN (3,4,5,6,7,8,9) AND date_part(\'year\', created_at) = '.$mydate.') AS total_all_gov_loan
                    '));

                Log::info($query);
                return $query;

            break;


            case 'disposal':
                $query = DB::select(DB::raw('
                SELECT (SELECT coalesce(count(id),0) FROM assessment.assessment_disposal WHERE app_status_id = 3 AND date_part(\'year\', created_at) = '.$mydate.') AS total_new,
                    (SELECT coalesce(count(id),0) FROM assessment.assessment_disposal WHERE app_status_id = 7 AND date_part(\'year\', created_at) = '.$mydate.') AS total_cancelled,
                    (SELECT coalesce(count(id),0) FROM assessment.assessment_disposal WHERE app_status_id = 9 AND date_part(\'year\', created_at) = '.$mydate.') AS total_completed,
                    (SELECT coalesce(count(id),0) FROM assessment.assessment_disposal WHERE app_status_id IN (4,5,6) AND date_part(\'year\', created_at) = '.$mydate.') AS total_in_progress,
                    (SELECT coalesce(count(id),0) FROM assessment.assessment_disposal WHERE app_status_id IN (3,4,5,6,7,8,9) AND date_part(\'year\', created_at) = '.$mydate.') AS total_all_disposal
                    '));

                Log::info($query);
                return $query;

            break;

            case 'currvalue':
                $query = DB::select(DB::raw('
                SELECT (SELECT coalesce(count(id),0) FROM assessment.assessment_currvalue WHERE app_status_id = 3 AND date_part(\'year\', created_at) = '.$mydate.') AS total_new,
                    (SELECT coalesce(count(id),0) FROM assessment.assessment_currvalue WHERE app_status_id = 7 AND date_part(\'year\', created_at) = '.$mydate.') AS total_cancelled,
                    (SELECT coalesce(count(id),0) FROM assessment.assessment_currvalue WHERE app_status_id = 9 AND date_part(\'year\', created_at) = '.$mydate.') AS total_completed,
                    (SELECT coalesce(count(id),0) FROM assessment.assessment_currvalue WHERE app_status_id IN (4,5,6) AND date_part(\'year\', created_at) = '.$mydate.') AS total_in_progress,
                    (SELECT coalesce(count(id),0) FROM assessment.assessment_currvalue WHERE app_status_id IN (3,4,5,6,7,8,9) AND date_part(\'year\', created_at) = '.$mydate.') AS total_all_currvalue
                    '));

                Log::info($query);
                return $query;

            break;









            default:
                # code...
                break;
        }
    }

    public function getNew(Request $request){

        $month = $request->month == null ? Carbon::now()->format('m') : $request->month ;
        $year = $request->year == null ? Carbon::now()->format('Y') :  $request->year;
        if($month == "00"){
            $query = DB::select(DB::raw('SELECT a.code, a.desc, a.id, b.id as newid, COUNT(b.id) as new
            FROM public.ref_workshop AS a
            LEFT OUTER JOIN assessment.assessment_new AS b ON a.id = b.workshop_id
            WHERE date_part(\'year\', b.appointment_dt) = '.$year.'
            GROUP BY a.code, a.desc, a.id, b.id
            ORDER BY a.code'));
        }else{
            $query = DB::select(DB::raw('SELECT a.code, a.desc, a.id, b.id as newid, COUNT(b.id) as new
            FROM public.ref_workshop AS a
            LEFT OUTER JOIN assessment.assessment_new AS b ON a.id = b.workshop_id
            WHERE date_part(\'year\', b.appointment_dt) = '.$year.'
            AND date_part(\'month\', b.appointment_dt) = '.$month.'
            GROUP BY a.code, a.desc, a.id, b.id
            ORDER BY a.code'));

        }
        return $query;
    }

    public function getAcc(Request $request){

        $month = $request->month == null ? Carbon::now()->format('m') : $request->month ;
        $year = $request->year == null ? Carbon::now()->format('Y') :  $request->year;

        if($month == "00"){
            $query = DB::select(DB::raw('SELECT a.code, a.desc, a.id, c.id as accid, COUNT(c.id) as acc
            FROM public.ref_workshop AS a
            LEFT OUTER JOIN assessment.assessment_accident AS c ON a.id = c.workshop_id
            WHERE date_part(\'year\', c.appointment_dt) = '.$year.'
            GROUP BY a.code, a.desc, a.id, c.id
            ORDER BY a.code'));
        }else{
            $query = DB::select(DB::raw('SELECT a.code, a.desc, a.id, c.id as accid, COUNT(c.id) as acc
            FROM public.ref_workshop AS a
            LEFT OUTER JOIN assessment.assessment_accident AS c ON a.id = c.workshop_id
            WHERE date_part(\'year\', c.appointment_dt) = '.$year.'
            AND date_part(\'month\', c.appointment_dt) = '.$month.'
            GROUP BY a.code, a.desc, a.id, c.id
            ORDER BY a.code'));
        }
        return $query;
    }

    public function getCurr(Request $request){

        $month = $request->month == null ? Carbon::now()->format('m') : $request->month ;
        $year = $request->year == null ? Carbon::now()->format('Y') :  $request->year;

        if($month == "00"){
            $query = DB::select(DB::raw('SELECT a.code, a.desc, a.id, d.id as currid, COUNT(d.id) as curr
            FROM public.ref_workshop AS a
            LEFT OUTER JOIN assessment.assessment_currvalue AS d ON a.id = d.workshop_id
            WHERE date_part(\'year\', d.appointment_dt) = '.$year.'
            GROUP BY a.code, a.desc, a.id, d.id
            ORDER BY a.code'));
        }else{
            $query = DB::select(DB::raw('SELECT a.code, a.desc, a.id, d.id as currid, COUNT(d.id) as curr
            FROM public.ref_workshop AS a
            LEFT OUTER JOIN assessment.assessment_currvalue AS d ON a.id = d.workshop_id
            WHERE date_part(\'year\', d.appointment_dt) = '.$year.'
            AND date_part(\'month\', d.appointment_dt) = '.$month.'
            GROUP BY a.code, a.desc, a.id, d.id
            ORDER BY a.code'));
        }
        return $query;
    }

    public function getDis(Request $request){

        $month = $request->month == null ? Carbon::now()->format('m') : $request->month ;
        $year = $request->year == null ? Carbon::now()->format('Y') :  $request->year;
        if($month == "00"){
            $query = DB::select(DB::raw('SELECT a.code, a.desc, a.id, e.id as disid, COUNT(e.id) as dis
            FROM public.ref_workshop AS a
            LEFT OUTER JOIN assessment.assessment_disposal AS e ON a.id = e.workshop_id
            WHERE date_part(\'year\', e.appointment_dt) = '.$year.'
            GROUP BY a.code, a.desc, a.id, e.id
            ORDER BY a.code'));
        }else{
            $query = DB::select(DB::raw('SELECT a.code, a.desc, a.id, e.id as disid, COUNT(e.id) as dis
            FROM public.ref_workshop AS a
            LEFT OUTER JOIN assessment.assessment_disposal AS e ON a.id = e.workshop_id
            WHERE date_part(\'year\', e.appointment_dt) = '.$year.'
            AND date_part(\'month\', e.appointment_dt) = '.$month.'
            GROUP BY a.code, a.desc, a.id, e.id
            ORDER BY a.code'));
        }
        return $query;
    }

    public function getSaf(Request $request){

        $month = $request->month == null ? Carbon::now()->format('m') : $request->month ;
        $year = $request->year == null ? Carbon::now()->format('Y') :  $request->year;
        if($month == "00"){
            $query = DB::select(DB::raw('SELECT a.code, a.desc, a.id, f.id as safid, COUNT(f.id) as saf
            FROM public.ref_workshop AS a
            LEFT OUTER JOIN assessment.assessment_safety AS f ON a.id = f.workshop_id
            WHERE date_part(\'year\', f.appointment_dt) = '.$year.'
            GROUP BY a.code, a.desc, a.id, f.id
            ORDER BY a.code'));
        }else{
            $query = DB::select(DB::raw('SELECT a.code, a.desc, a.id, f.id as safid, COUNT(f.id) as saf
            FROM public.ref_workshop AS a
            LEFT OUTER JOIN assessment.assessment_safety AS f ON a.id = f.workshop_id
            WHERE date_part(\'year\', f.appointment_dt) = '.$year.'
            AND date_part(\'month\', f.appointment_dt) = '.$month.'
            GROUP BY a.code, a.desc, a.id, f.id
            ORDER BY a.code'));
        }
        return $query;
    }

    public function getGov(Request $request){

        $month = $request->month == null ? Carbon::now()->format('m') : $request->month ;
        $year = $request->year == null ? Carbon::now()->format('Y') :  $request->year;
        if($month == "00"){
            $query = DB::select(DB::raw('SELECT a.code, a.desc, a.id, g.id as govid, COUNT(g.id) as gov
            FROM public.ref_workshop AS a
            LEFT OUTER JOIN assessment.assessment_gov_loan AS g ON a.id = g.workshop_id
            WHERE date_part(\'year\', g.appointment_dt) = '.$year.'
            GROUP BY a.code, a.desc, a.id, g.id
            ORDER BY a.code'));
        }else{
            $query = DB::select(DB::raw('SELECT a.code, a.desc, a.id, g.id as govid, COUNT(g.id) as gov
            FROM public.ref_workshop AS a
            LEFT OUTER JOIN assessment.assessment_gov_loan AS g ON a.id = g.workshop_id
            WHERE date_part(\'year\', g.appointment_dt) = '.$year.'
            AND date_part(\'month\', g.appointment_dt) = '.$month.'
            GROUP BY a.code, a.desc, a.id, g.id
            ORDER BY a.code'));
        }
        return $query;
    }


    public function getWorkshop(Request $request){

        $query = DB::select(DB::raw('SELECT a.code, a.desc, a.id
        FROM public.ref_workshop AS a
        GROUP BY a.code, a.desc, a.id
        ORDER BY a.code'));
        return $query;
    }
    public function getByWsp(Request $request){

        $month = $request->month ? $request->month : '00';
        $year = $request->year ? $request->year : Carbon::now()->format('Y');
        $workshop_id = $request->workshop_id;
        $assessment_type = $request->assessment_type ? $request->assessment_type : 'new';
        $filterByYearMonth = $year.'-'.$month;
        $queryByYearMonth = "";

        if($year && ($month && $month !== '00')){
            $queryByYearMonth = "appointment_dt::text LIKE '".$filterByYearMonth."-%'";
        } else if($year){
            $queryByYearMonth = "appointment_dt::text LIKE '".$year."-%'";
        } else if($month && $month !== '00'){
            $queryByYearMonth = "appointment_dt::text LIKE '%-".$month."-%'";
        }

        Log::info($queryByYearMonth);

        $tableMap = [
            'new' => AssessmentNew::class,
            'accident' => AssessmentAccident::class,
            'safety' => AssessmentSafety::class,
            'currvalue' => AssessmentCurrvalue::class,
            'gov' => AssessmentGovLoan::class,
            'disposal' => AssessmentDisposal::class,
        ];

        $query = $tableMap[$assessment_type]::whereHas('hasWorkShop', function($q) use($workshop_id){
            $q->where('id', $workshop_id);
        })->whereNotNull('appointment_dt');

        if($queryByYearMonth){
            $query->whereRaw($queryByYearMonth);
        }

        Log::info($query->toSql());

        return $query->paginate(5);
    }

    public function getAssmtStmt(Request $request){

        $month = $request->month ? $request->month : Carbon::now()->format('F');
        $year = $request->year ? $request->year : Carbon::now()->format('Y');
        $code = $request->code;
        // dd($request->all());
        switch ($request->assessment_type) {
            case 'new':
                $query = AssessmentNew::findOrfail($request->id);
                break;
            case 'accident':
                $query = AssessmentAccident::findOrfail($request->id);
                break;
            case 'safety':
                $query = AssessmentSafety::findOrfail($request->id);
                break;
            case 'currvalue':
                $query = AssessmentCurrvalue::findOrfail($request->id);
                break;
            case 'gov':
                $query = AssessmentGovLoan::findOrfail($request->id);
                break;
            case 'disposal':
                $query = AssessmentDisposal::findOrfail($request->id);
                break;
            default:
                return back();
                break;
        }
        return $query;
    }

    /*private function getDistrictId($opt){
        $sql = "select id from fleet.fleet_placement where UPPER(\"desc\") LIKE '%".Str::upper($opt)."%' ";
        Log::info($sql);
        return DB::select(DB::raw($sql));
    }*/
    private function getDistrictId($opt){
        $sql = "select id from fleet.fleet_placement where id = ".$opt;
        Log::info($sql);
        return DB::select(DB::raw($sql));
    }

    public function getDistrictList(Request $request){

        if($request->opt){
            $queryGetDistrict = $this->getDistrictId($request->opt);

            $district_id = -1;
            if($queryGetDistrict){
                $district_id = $queryGetDistrict[0]->id;
            }

            // $query = DB::select(DB::raw('
            // SELECT *
            // FROM fleet.fleet_department fd
            // WHERE  fd.placement_id = '.$district_id.'
            // '));
            $query = FleetDepartment::where('placement_id', $district_id)
            ->whereHas('hasFleetPlacement', function($q)use($request){
                $q->where('ref_state_id', $request->state_id);
            })
            ->get();

            return $query;
        } else {
            return [];
        }

    }

    public function excel(Request $request){
        $date = Carbon::now()->format('DFY-h:m:s');
        return Excel::download(new ReportAssessmentExportView($request), $request->view.'-'.$date.'.xlsx');
    }

}
