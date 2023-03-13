<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Fleet\FleetAudit;
use App\Models\Fleet\FleetDepartment;
use App\Models\RefCategory;
use App\Models\Vehicle\Brand;
use App\Models\Vehicle\VehicleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PHPJasper\PHPJasper;



class ReportVehicleTrendDAO extends Controller
{

    public $categoryList;

    public function mount(){
        $this->categoryList = RefCategory::all();
    }

    public function getTrendOn($trend_on, $year){

        //$trend_on = $request->trend_on;
        // dd($composition_by);
        Log::info('trend_on --> '.$trend_on);
        Log::info('year --> '.$year);
        $something = 2021;
        $firstMonthOfTheYear = $year.'-01-01';
        $lastMonthOfTheYear = $year.'-12-01';

        Log::info("lastMonthOfTheYear : ".$lastMonthOfTheYear);
        //3 -> persekutuan
        //4 -> negeri
        //5 -> project
        switch ($trend_on) {
            case 'jabatan':
                    $query = DB::select(DB::raw('
                    select TO_CHAR(mon.mon, \'MON\') AS "month", mon.mon AS dateStamo, coalesce(subtotal, 0) as total
                    from generate_series(?::timestamp, ?::timestamp, interval \'1 month\'
                    ) as mon(mon) left join
                    (select date_trunc(\'Month\', updated_at) as mon,
                     count(fd.id) as subtotal
                    from  "fleet"."fleet_department" fd
                    where extract(year from fd.updated_at) = ? AND vapp_status_id = 7 AND owner_type_id IN (3,4)
                    group by mon
                    ) s
                     on mon.mon = s.mon
                    '),[$firstMonthOfTheYear, $lastMonthOfTheYear, $year]);

                    Log::info($query);
                    return $query;

                break;

            case 'projek':

                $query = DB::select(DB::raw('
                    select TO_CHAR(mon.mon, \'MON\') AS "month", mon.mon AS dateStamo, coalesce(subtotal, 0) as total
                    from generate_series(?::timestamp, ?::timestamp, interval \'1 month\'
                    ) as mon(mon) left join
                    (select date_trunc(\'Month\', updated_at) as mon,
                     count(fd.id) as subtotal
                    from  "fleet"."fleet_public" fd
                    where extract(year from fd.updated_at) = ? AND vapp_status_id = 7 AND owner_type_id IN (5)
                    group by mon
                    ) s
                     on mon.mon = s.mon
                    '),[$firstMonthOfTheYear, $lastMonthOfTheYear, $year]);

                    Log::info($query);
                    return $query;
                break;

            case 'lupus':


                $query = DB::select(DB::raw('
                    select TO_CHAR(mon.mon, \'MON\') AS "month", mon.mon AS dateStamo, coalesce(subtotal, 0) as total
                    from generate_series(?::timestamp, ?::timestamp, interval \'1 month\'
                    ) as mon(mon) left join
                    (select date_trunc(\'Month\', updated_at) as mon,
                     count(fd.id) as subtotal
                    from  "fleet"."fleet_disposal" fd
                    where extract(year from fd.updated_at) = ? AND vapp_status_id = 7 AND vehicle_status_id = 4
                    group by mon
                    ) s
                     on mon.mon = s.mon
                    '),[$firstMonthOfTheYear, $lastMonthOfTheYear, $year]);

                    Log::info($query);
                    return $query;
                break;


            default:
                # code...
                break;
        }
    }
}
