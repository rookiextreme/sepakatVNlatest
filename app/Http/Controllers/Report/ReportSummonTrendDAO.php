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



class ReportSummonTrendDAO extends Controller
{

    public $categoryList;

    public function mount(){
        $this->categoryList = RefCategory::all();
    }

    public function getTrendOn($trend_on, $year, $month, $status){

        //$trend_on = $request->trend_on;
        // dd($composition_by);
        Log::info('trend_on --> '.$trend_on);
        Log::info('year --> '.$year);
        Log::info('status --> '.$status);
        Log::info('month --> '.$month);
        //$something = 2021;
        $firstMonthOfTheYear = $year.'-01-01';
        $lastMonthOfTheYear = $year.'-12-01';

//        Log::info("lastMonthOfTheYear : ".$lastMonthOfTheYear);
        //3 -> persekutuan
        //4 -> negeri
        //5 -> project

        switch ($status) {
            case 'paid':
                    $sql = '
                    SELECT rs.desc AS name, coalesce(count(ms.id),0) AS total, \'paid\' AS status
                    FROM public.ref_state rs
                    LEFT JOIN saman.maklumat_saman ms ON ms.id IN (
                        SELECT msx.id FROM saman.maklumat_saman msx 
                        JOIN saman.maklumat_kenderaan_saman mks ON mks.id = msx.maklumat_kenderaan_saman_id
                        JOIN fleet.fleet_lookup_vehicle_view lvv ON lvv.id = mks.pendaftaran_id
                        WHERE mks.status_saman_id = 4 AND extract(year from msx.updated_at) = ? '.($month==0 ? '' : 'AND extract(month from msx.updated_at) = ?') .'
                        AND lvv.state_id = rs.id
                        )
                    GROUP BY rs.desc
                    ORDER BY rs.desc ASC
                    ';
                    $query = DB::select(DB::raw($sql),[$year, $month]);

                    Log::info('paid => sql'. $sql);
                    return $query;

                break;

            case 'unpaid':
                $sql = '
                SELECT rs.desc AS name, coalesce(count(ms.id),0) AS total, \'unpaid\' AS status
                FROM public.ref_state rs
                LEFT JOIN saman.maklumat_saman ms ON ms.id IN (
                    SELECT msx.id FROM saman.maklumat_saman msx 
                    JOIN saman.maklumat_kenderaan_saman mks ON mks.id = msx.maklumat_kenderaan_saman_id
                    JOIN fleet.fleet_lookup_vehicle_view lvv ON lvv.id = mks.pendaftaran_id
                    WHERE mks.status_saman_id = 4 AND extract(year from msx.updated_at) = ? '.($month==0 ? '' : 'AND extract(month from msx.updated_at) = ?') .'
                    AND lvv.state_id = rs.id
                    )
                GROUP BY rs.desc
                ORDER BY rs.desc ASC
                ';
                $query = DB::select(DB::raw($sql),[$year, $month]);

                Log::info('unpaid => sql'. $sql);
                return $query;

            break;

            case 'all':
                $query = DB::select(DB::raw('
                SELECT rs.desc AS name, coalesce(count(ms.id),0) AS total, \'unpaid\' AS status
                FROM public.ref_state rs
                LEFT JOIN saman.maklumat_saman ms ON ms.id IN (
                    SELECT msx.id FROM saman.maklumat_saman msx 
                    JOIN saman.maklumat_kenderaan_saman mks ON mks.id = msx.maklumat_kenderaan_saman_id
                    JOIN fleet.fleet_lookup_vehicle_view lvv ON lvv.id = mks.pendaftaran_id
                    AND extract(year from msx.updated_at) = ? '.($month==0 ? '' : 'AND extract(month from msx.updated_at) = ?') .'
                    AND lvv.state_id = rs.id
                    )
                GROUP BY rs.desc
                ORDER BY rs.desc ASC
                '),[$year, $month]);

                Log::info($query);
                return $query;

            break;










            default:
                # code...
                break;
        }



    }

    public function getTrendYearly($year, $type){

        //$trend_on = $request->trend_on;
        // dd($composition_by);
        Log::info('year --> '.$year);

        //$something = 2021;
        $firstMonthOfTheYear = $year.'-01-01';
        $lastMonthOfTheYear = $year.'-12-01';

        if($type == 'paid'){

            $query = DB::select(DB::raw('
            select TO_CHAR(mon.mon, \'MON\') AS "name", mon.mon AS dateStamp, coalesce(subtotal, 0) as total
            from generate_series(?::timestamp, ?::timestamp, interval \'1 month\'
            ) as mon(mon) left join
            (select date_trunc(\'Month\', ms.updated_at) as mon,
            count(ms.id) as subtotal
            from  saman.maklumat_saman ms
            JOIN saman.maklumat_kenderaan_saman mks ON mks.id = ms.maklumat_kenderaan_saman_id
            where extract(year from ms.updated_at) = ? AND mks.status_saman_id = 3
            group by mon
            ) s
            on mon.mon = s.mon
            '),[$firstMonthOfTheYear, $lastMonthOfTheYear, $year]);

            Log::info($query);
            return $query;


        }else{

            $query = DB::select(DB::raw('
            select TO_CHAR(mon.mon, \'MON\') AS "name", mon.mon AS dateStamp, coalesce(subtotal, 0) as total
            from generate_series(?::timestamp, ?::timestamp, interval \'1 month\'
            ) as mon(mon) left join
            (select date_trunc(\'Month\', ms.updated_at) as mon,
            count(ms.id) as subtotal
            from  saman.maklumat_saman ms
            JOIN saman.maklumat_kenderaan_saman mks ON mks.id = ms.maklumat_kenderaan_saman_id
            where extract(year from ms.updated_at) = ?
            group by mon
            ) s
            on mon.mon = s.mon
            '),[$firstMonthOfTheYear, $lastMonthOfTheYear, $year]);

            Log::info($query);
            return $query;

        }



    }

    public function getSamanUltimateFigure($status){

        switch ($status) {
            case 'paid':
                    $query = DB::select(DB::raw('
                    SELECT coalesce(count(mks.id),0) AS total_paid
                    FROM saman.maklumat_kenderaan_saman mks
                    WHERE mks.status_saman_id = 4
                    '));

                    Log::info($query);
                    return $query;

                break;

            case 'unpaid':
                $query = DB::select(DB::raw('
                SELECT coalesce(count(mks.id),0) AS total_unpaid
                FROM saman.maklumat_kenderaan_saman mks
                WHERE mks.status_saman_id = 3
                '));

                Log::info($query);
                return $query;

            break;

            case 'transfered':
                $query = DB::select(DB::raw('
                SELECT coalesce(count(mks.id),0) AS total_transfered
                FROM saman.maklumat_kenderaan_saman mks
                WHERE mks.status_saman_id = 5
                '));

                Log::info($query);
                return $query;
            case 'discounted':
                $query = DB::select(DB::raw('
                SELECT coalesce(count(mks.id),0) AS total_discounted
                FROM saman.maklumat_kenderaan_saman mks
                WHERE mks.status_saman_id = 6
                '));

                Log::info($query);
                return $query;

            break;

            default:
                # code...
                break;
        }


    }
}

