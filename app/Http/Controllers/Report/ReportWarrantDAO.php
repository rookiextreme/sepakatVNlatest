<?php

namespace App\Http\Controllers\Report;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReportWarrantDAO extends Controller
{


    public function getYear() {

        $query = DB::select(DB::raw('
        select DISTINCT year from maintenance.warrant_detail 
        where year is not null
        order by year
        '));

        $years = [];
        foreach ($query as $key) {
            array_push($years, $key->year);
        }

        $lastValue = end($years);
        if(Carbon::now()->format('Y') == $lastValue){
            $lastValue += 1;
            array_push($years, $lastValue);
        }
        //Log::info($years);
        return $years;
    }

    public function getOsolProjectionSetByMonth($selectedMonth) {
        try {
            
            $query = DB::table('maintenance.warrant_projection')
            ->select('percent')
            ->where([
                'value' => $selectedMonth,
            ])->first();
           // Log::info(dd($query->percent));
            return $query->percent;
        }catch (\Throwable $th) {
            $response = false;
            return $response;
        }

    }


    public function getWarrantDataByOsolType($osolType, $year,$month){

        if ($year == 2021 && $month < 10 && $month > 0) {
            return [];
        }

        $rangeMonth = "";
        for ($i = 1; $i <= $month; $i++) {
            if($i == $month ) {
                $rangeMonth .= $i;
            }else {
                $rangeMonth .= $i.',';
            }
           
          }

       // Log::info('rangeMonth->'.$rangeMonth);
        
             $query = DB::select(DB::raw('
             WITH tbl1 AS (
                select  sum(addition) as carry_addition , sum(deduct) as carry_deduct , sum(total_allocation) as carry_total_allocation ,sum(expense) as carry_expense ,sum(advance) as carry_advance, sum(total_expense) as carry_total_expense , sum(balance) as carry_balance ,workshop_id as wd_id_sum
                from maintenance.warrant_detail 
                where waran_type_id = 1 
                and osol_type_id= ?
                and year = ?
                and month in ('.$rangeMonth.')
                group by workshop_id
            )
            , tbl2 AS (
                select id, workshop_id , waran_type_id, osol_type_id , state, allocation , addition, deduct, total_allocation, expense , advance, total_expense ,balance, COALESCE(percent_expense,0) AS percent_expense, COALESCE(percent_advance,0) AS percent_advance, COALESCE(percent_financial,0) AS percent_financial  
                from maintenance.warrant_detail
                where waran_type_id = 1 
                and osol_type_id= ?
                and year = ?
                and month = ?
            )
                select * from
                tbl1 t1
                right join tbl2 t2
                on t1.wd_id_sum =  t2.workshop_id
                order by workshop_id ASC
    
        '),[$osolType,$year,$osolType,$year,$month]);

        //sort object based on percentage
        $percent_financial = array_column($query, 'percent_financial');
        array_multisort($percent_financial, SORT_DESC, $query);
        //rsort($cars);
        //Log::info(dd($query));
        return $query;
    }
    

    public function getWarrantSumMHPV($osolCode,$year,$month){

        $percentExpense2Deci = 0;
        $percentAdvance2Deci = 0;
        $percentTotalExpense2Deci = 0;
        $rangeMonth = "";
        for ($i = 1; $i <= 12; $i++) {
            if($i <= $month ) {
                if($i == $month ) {
                    $rangeMonth .= $i;
                }else {
                    $rangeMonth .= $i.',';
                }
            }

        }
        
        $query = DB::select(DB::raw('
        WITH tbl1 AS (
            select  sum(wd.expense) as carry_expense ,sum(wd.advance) as carry_advance , sum(wd.total_expense) as carry_total_expense , ot.desc as osol_type
            from maintenance.warrant_detail wd
            join maintenance.osol_type as ot on ot.id = wd.osol_type_id
            where ot.code = ?
            and year = ?
            and month in ('.$rangeMonth.')
            group by  ot.desc
            )
            , tbl2 AS (
            select SUM(wd.allocation) as sum_allocation, SUM(wd.addition)as sum_addition, SUM(wd.deduct) as sum_deduct, SUM(wd.total_allocation) as sum_total_allocation,
            SUM(wd.expense) as sum_expense, SUM(wd.advance) as sum_advance, SUM(wd.total_expense) as sum_total_expense,
            SUM(wd.balance) as sum_balance, ot.desc as osol_type
            from maintenance.warrant_detail as wd
            join maintenance.osol_type as ot on ot.id = wd.osol_type_id
            where ot.code = ?
            and wd.year = ?
            and wd.month = ?
            GROUP BY ot.desc
            )
            select * from
            tbl1 t1
            RIGHT JOIN tbl2 t2
            ON t1.osol_type =  t2.osol_type

   '),[$osolCode,$year ,$osolCode,$year,$month]);

        $arr = [];
        $obj = new WarrantObjectSum;
        if ($query) {
            $sumTotalAllocation =  $query[0]->sum_total_allocation;
            
            if (is_numeric($query[0]->carry_expense) && is_numeric($sumTotalAllocation) && $sumTotalAllocation != 0) {
                $sumExpense =  $query[0]->carry_expense;
                $percentExpense =  ($sumExpense / $sumTotalAllocation) * 100;
                $percentExpense2Deci = number_format((float)$percentExpense, 2, '.', '');

            }

            if (is_numeric($query[0]->carry_advance) && is_numeric($sumTotalAllocation) && $sumTotalAllocation != 0) {
                $sumAdvance =  $query[0]->carry_advance;
                $percentExpense =  ($sumAdvance / $sumTotalAllocation) * 100;
                $percentAdvance2Deci = number_format((float)$percentExpense, 2, '.', '');
            }

            if (is_numeric($query[0]->carry_total_expense) && is_numeric($sumTotalAllocation) && $sumTotalAllocation != 0) {
                $sumTotalExpense =  $query[0]->carry_total_expense;
                $percentExpense =  ($sumTotalExpense / $sumTotalAllocation) * 100;
                $percentTotalExpense2Deci = number_format((float)$percentExpense, 2, '.', '');

            }

            $obj->carry_expense = $query[0]->carry_expense;
            $obj->carry_advance = $query[0]->carry_advance;
            $obj->carry_total_expense = $query[0]->carry_total_expense;
            $obj->osol_type = $query[0]->osol_type;
            $obj->sum_allocation = $query[0]->sum_allocation;
            $obj->sum_addition = $query[0]->sum_addition;
            $obj->sum_deduct = $query[0]->sum_deduct;
            $obj->sum_total_allocation = $query[0]->sum_total_allocation;
            $obj->sum_advance = $query[0]->sum_advance;
            $obj->sum_expense = $query[0]->sum_expense;
            $obj->sum_total_expense = $query[0]->sum_total_expense;
            $obj->sum_balance = $query[0]->sum_balance;
            $obj->sum_percent_expense = $percentExpense2Deci;
            $obj->sum_percent_advance = $percentAdvance2Deci;
            $obj->sum_percent_financial = $percentTotalExpense2Deci;
            
            array_push($arr, $obj);

        }
 
        return $arr;
    }

    public function getWarrantTotalSumAll($year, $month){

        if ($year == 2021 && $month < 10 ) {
            return [];
        }
    
        $rangeMonth = "";
        for ($i = 1; $i <= 12; $i++) {
            if($i <= $month ) {
                if($i == $month ) {
                    $rangeMonth .= $i;
                }else {
                    $rangeMonth .= $i.',';
                }
            }

        }
        $query = DB::select(DB::raw('
        WITH tbl1 AS (
            select  sum(wd.expense) as carry_expense ,sum(wd.advance) as carry_advance , sum(wd.total_expense) as carry_total_expense , ot.desc as osol_type ,wd.osol_type_id
            from maintenance.warrant_detail wd 
            join maintenance.osol_type as ot on ot.id = wd.osol_type_id
            where  
            wd.year = ?
            and month in ('.$rangeMonth.')
            group by wd.osol_type_id, ot.desc
            )
            , tbl2 AS (
            select SUM(wd.allocation) as sum_allocation, SUM(wd.addition)as sum_addition, SUM(wd.deduct) as sum_deduct, SUM(wd.total_allocation) as sum_total_allocation,
            SUM(wd.expense) as sum_expense, SUM(wd.advance) as sum_advance, SUM(wd.total_expense) as sum_total_expense,
            SUM(wd.balance) as sum_balance, ot.desc as osol_type , wd.osol_type_id ,ot.value AS osol_value, ot.desc AS osol_name  
            from maintenance.warrant_detail as wd
            join maintenance.osol_type as ot on ot.id = wd.osol_type_id
            where 
            wd.year = ?
            and wd.month = ?
            GROUP BY wd.osol_type_id, ot.id
            )
            select * from
            tbl1 t1
            RIGHT JOIN tbl2 t2
            ON t1.osol_type_id =  t2.osol_type_id
            ORDER BY t1.osol_type_id

        '),[$year,$year,$month]);

        if ($query) {

            $arr = [];
            foreach ($query as $item) {
                $percentExpense2Deci = 0;
                $percentAdvance2Deci = 0;
                $percentTotalExpense2Deci = 0;
        
                $sumPercentExpense2Deci = 0;
                $sumPercentAdvance2Deci = 0;
                $sumPercentTotalExpense2Deci = 0;
        
                $obj = new WarrantObject;
                $sumTotalAllocation =  $item->sum_total_allocation;
   
                if (is_numeric($item->carry_expense) && is_numeric($sumTotalAllocation) && $sumTotalAllocation != 0) {
                    $sumExpense =  $item->carry_expense;
                    $percentExpense =  ($sumExpense / $sumTotalAllocation) * 100;
                    $percentExpense2Deci = number_format((float)$percentExpense, 2, '.', '');

                }

                if (is_numeric($item->carry_advance) && is_numeric($sumTotalAllocation) && $sumTotalAllocation != 0) {
                    $sumAdvance =  $item->carry_advance;
                    $percentAdvance =  ($sumAdvance / $sumTotalAllocation) * 100;
                    $percentAdvance2Deci = number_format((float)$percentAdvance, 2, '.', '');
                }

                if (is_numeric($item->carry_total_expense) && is_numeric($sumTotalAllocation) && $sumTotalAllocation != 0) {
                    $sumTotalExpense =  $item->carry_total_expense;
                    $percentTotalExpense =  ($sumTotalExpense / $sumTotalAllocation) * 100;
                    $percentTotalExpense2Deci = number_format((float)$percentTotalExpense, 2, '.', '');
                }

                $obj->sum_allocation = $item->sum_allocation;
                $obj->sum_addition = $item->sum_addition;
                $obj->sum_deduct = $item->sum_deduct;
                $obj->sum_total_allocation = $item->sum_total_allocation;
                $obj->sum_expense = $item->sum_expense;
                $obj->sum_advance = $item->sum_advance;
                $obj->sum_total_expense = $item->sum_total_expense;
                $obj->carry_sum_expense = $item->carry_expense;
                $obj->carry_sum_advance = $item->carry_advance;
                $obj->carry_sum_total_expense = $item->carry_total_expense;
                $obj->sum_balance = $item->sum_balance;
                $obj->sum_percent_expense = $percentExpense2Deci;
                $obj->sum_percent_advance = $percentAdvance2Deci;
                $obj->sum_percent_financial = $percentTotalExpense2Deci;
                $obj->osol_value = $item->osol_value;
                $obj->osol_name = $item->osol_name;
                $obj->osol_type_id = $item->osol_type_id;
                array_push($arr, $obj);

            }
        }
        //Log::info(dd($arr));
       $sumTotalAllocation2628 =  array_sum(array_column($arr, 'sum_allocation'));
       $sumExpense2628 =  array_sum(array_column($arr, 'carry_sum_expense'));
       $sumAdvance2628 =  array_sum(array_column($arr, 'carry_sum_advance'));
       $sumTotalExpense2628 =  array_sum(array_column($arr, 'carry_sum_total_expense'));

       if (!is_null($sumExpense2628) && !empty($sumExpense2628) && $sumExpense2628 != 0 && $sumTotalAllocation2628 != 0) {

        $percentExpense =  ($sumExpense2628 / $sumTotalAllocation2628) * 100;
        $sumPercentExpense2Deci = number_format((float)$percentExpense, 2, '.', '');

        }


        if (!is_null($sumAdvance2628) && !empty($sumAdvance2628) && $sumAdvance2628 != 0 && $sumTotalAllocation2628 != 0) {
            $percentAdance =  ($sumAdvance2628 / $sumTotalAllocation2628) * 100;
            $sumPercentAdvance2Deci = number_format((float)$percentAdance, 2, '.', '');
        }

        if (!is_null($sumTotalExpense2628) && !empty($sumTotalExpense2628 && $sumTotalExpense2628 != 0 && $sumTotalAllocation2628 != 0)) {
            $percentTotalExpense =  ($sumTotalExpense2628 / $sumTotalAllocation2628) * 100;
            $sumPercentTotalExpense2Deci = number_format((float)$percentTotalExpense, 2, '.', '');

        }
        $response = [
            'list_total' => $arr,
            'sum_percent_expense' => $sumPercentExpense2Deci,
            'sum_percent_advance' => $sumPercentAdvance2Deci,
            'sum_percent_financial' => $sumPercentTotalExpense2Deci
        ];
        //Log::info(dd($response));
        return $response;
    }

}


class WarrantObject
{
    public $sum_allocation;
    public $sum_addition;
    public $sum_total_allocation;
    public $sum_expense;
    public $sum_advance;
    public $sum_total_expense;
    public $carry_sum_expense;
    public $carry_sum_advance;
    public $carry_sum_total_expense;
    public $sum_balance;
    public $sum_percent_expense;
    public $sum_percent_advance;
    public $sum_percent_financial;
    public $osol_value;
    public $osol_name;
    public $osol_type_id;
}

class WarrantObjectSum
{
    public $carry_expense;
    public $carry_advance;
    public $carry_total_expense;
    public $osol_type;
    public $sum_allocation;
    public $sum_addition;
    public $sum_deduct;
    public $sum_total_allocation;
    public $sum_expense;
    public $sum_advance;
    public $sum_total_expense;
    public $sum_balance;
    public $sum_percent_expense;
    public $sum_percent_advance;
    public $sum_percent_financial;
}