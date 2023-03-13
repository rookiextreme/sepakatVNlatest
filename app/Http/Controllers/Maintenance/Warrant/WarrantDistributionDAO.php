<?php

namespace App\Http\Controllers\Maintenance\Warrant;

use App\Exports\WarrantExport;
use App\Exports\WarrantExportView;
use App\Http\Controllers\Controller;
use App\Models\Fleet\FleetAudit;
use App\Models\Fleet\FleetDepartment;
use App\Models\Maintenance\OsolType;
use App\Models\Maintenance\WaranType;
use App\Models\Maintenance\WarrantDetail;
use App\Models\Maintenance\WarrantDetailStatement;
use App\Models\Maintenance\WarrantProjection;
use App\Models\RefCategory;
use App\Models\RefWorkshop;
use App\Models\Vehicle\Brand;
use App\Models\Vehicle\VehicleModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use PHPJasper\PHPJasper;
use PhpParser\Node\Stmt\TryCatch;
use Psr\Log\LogLevel;

class WarrantDistributionDAO extends Controller
{

    public function updateCalculateWarrant($query) {

        foreach ($query as $item) {

            $percentExpense2Deci = null;
            $percentAdvance2Deci = null;
            $percentTotalExpense2Deci = null;
            $totalExpense = null;
            $totalAllocation = null;
            $balance = 0;

            $totalAllocation =  $item->allocation + $item->addition - $item->deduct;    
            $totalExpense =  $item->expense + $item->advance;
            $carryTotalExpense =  $item->carry_expense + $item->carry_advance;
            $balance = $totalAllocation - $carryTotalExpense;
            // if($totalAllocation > 0){
            //     $balance = $totalAllocation - $carryTotalExpense;
            // } elseif($item->advance == 0){
            //     $balance = $carryTotalExpense - $totalExpense; 
            // } else {
            //     $balance = $item->expense - $totalExpense;
            // }
            
            if (is_numeric($item->carry_expense) && is_numeric($totalAllocation) && $totalAllocation != 0) {
                $expense =  $item->carry_expense;
                $percentExpense =  ($expense / $totalAllocation) * 100;
                $percentExpense2Deci = number_format((float)$percentExpense, 2, '.', '');

            }

            if (is_numeric($item->carry_advance) && is_numeric($totalAllocation) && $totalAllocation != 0) {
                $advance =  $item->carry_advance;
                $percentAdvance =  ($advance / $totalAllocation) * 100;
                $percentAdvance2Deci = number_format((float)$percentAdvance, 2, '.', '');
            }

            if (is_numeric($carryTotalExpense) && is_numeric($totalAllocation) && $totalAllocation != 0) {
                $percentTotalExpense =  ($carryTotalExpense / $totalAllocation) * 100;
                $percentTotalExpense2Deci = number_format((float)$percentTotalExpense, 2, '.', '');
            }

           
            $data = [
                'total_allocation' => $totalAllocation,
                'balance' => $balance,
                'total_expense' => $totalExpense,
                'percent_expense' => $percentExpense2Deci, 
                'percent_advance' => $percentAdvance2Deci,
                'percent_financial' => $percentTotalExpense2Deci
            ];

            $queryupdate = WarrantDetail::find($item->id);
            $queryupdate->update($data);
        }
    }

    public function generateFirstData($year) {

        $query = DB::select(DB::raw('
        select count(*) from maintenance.warrant_detail where year = ?
        '),[$year]);

        if ($query[0]->count == 0){
            Log::info('xda data kena generate with func generateWarrantData()');
            $this->generateWarrantData($year); 
        }
    }

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

    public function getWorkshop() {

        $query  = RefWorkshop::get();
        //Log::info($query);
        return $query;
    }

    public function getWarrantType() {

        $query  = WaranType::get();
       // Log::info($query);
        return $query;
    }

    public function getOsolType() {

        $query  = OsolType::get();
        //Log::info($query);
        return $query;
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

       Log::info('rangeMonth->'.$rangeMonth);
        
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

        // Log::info($query);
        return $query;
    }


    public function getWarrantDataByWaranType($waranType,$year,$month){

        if ($year == 2021 && $month < 10 ) {
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

        $query = DB::select(DB::raw('
        WITH tbl1 AS (
            select  sum(addition) as carry_addition , sum(deduct) as carry_deduct , sum(total_allocation) as carry_total_allocation ,sum(expense) as carry_expense ,sum(advance) as carry_advance, sum(total_expense) as carry_total_expense , sum(balance) as carry_balance ,workshop_id as wd_id_sum
            from maintenance.warrant_detail 
            where waran_type_id = ?
            and year = ?
            and month in ('.$rangeMonth.')
            group by workshop_id
        )
        , tbl2 AS (
            select id, warrant_received_dt, workshop_id , waran_type_id, osol_type_id , state, allocation , addition, deduct, total_allocation, expense , advance, total_expense ,balance, COALESCE(percent_expense,0) AS percent_expense, COALESCE(percent_advance,0) AS percent_advance, COALESCE(percent_financial,0) AS percent_financial  
            from maintenance.warrant_detail
            where waran_type_id = ? 
            and year = ?
            and month = ?
        )
            select * from
            tbl1 t1
            right join tbl2 t2
            on t1.wd_id_sum =  t2.workshop_id
            order by workshop_id ASC

        '),[$waranType,$year,$waranType,$year,$month]);
        
        //Log::info($query);
        return $query;
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

       // Log::info(dd($tmpQuery));
        return $arr;
    }


    //FOR KKR AND EXTERNAL
    public function getWarrantSum($waranCode,$year,$month){

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
            select  sum(wd.expense) as carry_expense ,sum(wd.advance) as carry_advance , sum(wd.total_expense) as carry_total_expense , wt.code
            from maintenance.warrant_detail wd
            join maintenance.waran_type as wt on wt.id = wd.waran_type_id
            where wt.code = ?
            and wd.year = ?
            and wd.month in ('.$rangeMonth.')
            GROUP BY  wt.code
            )
            , tbl2 AS (
            select SUM(wd.allocation) as sum_allocation, SUM(wd.addition)as sum_addition, SUM(wd.deduct) as sum_deduct, SUM(wd.total_allocation) as sum_total_allocation,
            SUM(wd.expense) as sum_expense, SUM(wd.advance) as sum_advance, SUM(wd.total_expense) as sum_total_expense,
            SUM(wd.balance) as sum_balance ,  wt.code
            from maintenance.warrant_detail as wd
            join maintenance.waran_type as wt on wt.id = wd.waran_type_id
            where wt.code = ?
            and wd.year = ?
            and wd.month = ?
            GROUP BY  wt.code
            )
            select * from
            tbl1 t1
            RIGHT JOIN tbl2 t2
            ON t1.code =  t2.code
            
   '),[$waranCode,$year ,$waranCode,$year,$month]);

 
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

       // Log::info($query);
        return $arr;
    }

    public function getTotalVehicle(){

        $query = DB::select(DB::raw('
        SELECT * FROM fleet.fleet_department LIMIT 20
        '));

        //Log::info($query);
        return $query;
    }

    public function addWarrantAdjustment(Request $request) {
        try {
            // Log::info("ADDDDD  workshop_id--> ".$request->id);
            // Log::info("ADDDDD  workshop_id--> ".$request->workshop_id);
            // Log::info("ADDDDD  year--> ".$request->year);
            // Log::info("ADDDDD  month--> ".$request->month);
            // Log::info("ADDDDD  waran_type_id--> ".$request->waran_type_id);
            // Log::info("ADDDDD  osol_type_id--> ".$request->osol_type_id);
            // Log::info("ADDDDD  amount--> ".$request->amount);
            // Log::info("ADDDDD  note--> ".$request->note);
            // Log::info("ADDDDD  expense_dt--> ".$request->expense_dt);

            //ADD ADJUSTMENT IN TABLE WarrantDetail - allocation
            $query_wd = WarrantDetail::
            where([
                    // 'workshop_id' => $request->workshop_id,
                    // 'waran_type_id' => $request->waran_type_id,
                    // 'osol_type_id' => $request->osol_type_id,
                    // 'year' => $request->year,
                    // 'month' => $request->month
                    'id' => $request->id,
                ])
                ->first();

            $wd_id =  $query_wd->id;
            $amount = str_replace(',', '', $request->amount);

            if($request->adjust == 'expense'){
                $expense =  $query_wd->expense;
                $sum = $expense + $amount;
    
                $data_wd = [
                    'expense' => $sum
                ];
            } else {
                $advance =  $query_wd->advance;
                $sum = $advance + $amount;
    
                $data_wd = [
                    'advance' => $sum
                ];
            }

            $query_wd->update($data_wd);
            $dt = Carbon::parse($request->expense_dt)->format('Y-m-d');
            //ADD ADJUSTMENT IN TABLE WarrantDetailStatement
            $data_wds = [
                'wd_id' => $wd_id,
                'note' => $request->note,
                'expense_dt' => $dt,
                'created_by' => Auth::user()->id,
                'created_at' => 'NOW()'
            ];

            $data_wds[$request->adjust] = $request->amount;
    
            $query_wds = WarrantDetailStatement::insert($data_wds);

        }catch (\Throwable $th) {
            Log::info("Error :: WarrantDistributionDAO.addWarrantAdjustment --> ".$th);
            return false;
        }

    }

    public function updateWarrantAdjustment(Request $request) {
        try {
            $detail = WarrantDetail::find($request->id);
            $amount = str_replace(',', '', $request->amount);
            $detail->update([$request->adjust => $amount]);

        }catch (\Throwable $th) {
            Log::info("Error :: WarrantDistributionDAO.addWarrantAdjustment --> ".$th);
            return false;
        }

    }

    public function updateWarrant(Request $request) {

        try {
            $balance = null;
            $percentExpense = null;
            $percentAdvance = null;
            $percentTotalExpense = null;
            $percentExpense2Deci = null;
            $percentAdvance2Deci = null;
            $percentTotalExpense2Deci = null;
            $totalAllocation = null;

            $allocation = $request->allocation;
            $addition = $request->addition;
            $deduct = $request->deduct;
            $expense = $request->expense;
            $advance = $request->advance;
            $id = $request->id;

            $totalAllocation = $allocation + $addition - $deduct;
            $totalExpense = $expense + $advance;

            $rangeMonth = [1,2,3,4,5,6,7,8,9,10,11,12];

            $rangeMonthCarry = [];
            for ($i = 1; $i <= 12; $i++) {
                if($i >= $request->month ) {
                    array_push($rangeMonthCarry,$i);
                }
            }

            $data = [
                'addition' => $request->addition,
                'deduct' => $request->deduct
            ];


            $query = WarrantDetail::
            where([
                'workshop_id' => $request->workshop_id,
                'waran_type_id' => $request->waran_type_id,
                'osol_type_id' => $request->osol_type_id == "" ? null : $request->osol_type_id,
                'year' => $request->year
            ])
            ->whereIn('month', $rangeMonthCarry);

            $query->update($data);

            $data2 = [
                'allocation' => $request->allocation
            ];

            $query2 = WarrantDetail::
            where([
                'workshop_id' => $request->workshop_id,
                'waran_type_id' => $request->waran_type_id,
                'osol_type_id' => $request->osol_type_id,
                'year' => $request->year
            ])
            ->whereIn('month', $rangeMonth);
            $query2->update($data2);

            $response = [
                'status' => true,
                'message' => 'Maklumat berjaya dikemaskini'
            ];

            return $response;
        
        } catch (\Throwable $th) {
            Log::info("Error :: WarrantDistributionDAO.updateWarrant --> ".$th);
            
            $response = [
                'status' => false,
                'message' => $th
            ];
            
            return $response;
        }
    }
    

    public function getWarrant(Request $request) {
        $year = $request->year;
        $res = $this->generateWarrantData($year); 
        return '';

    }

    public function updateProjection(Request $request) {

        try {
   
            $percent = $request->percent;
            $value = $request->value;

            $data = [
                'percent' => $percent
            ];

            $query = DB::table('maintenance.warrant_projection')
            ->where([
                'value' => $value
            ]);
            $query->update($data);
            $response = [
                'status' => true,
                'message' => 'Maklumat berjaya dikemaskini'
            ];

            return $response;
        
        } catch (\Throwable $th) {
            Log::info("Error :: WarrantDistributionDAO.updateProjection --> ".$th);
            
            $response = [
                'status' => false,
                'message' => $th
            ];
            
            return $response;
        }
    }

    public function getOsolProjectionSet() {
        try {
            
            $query = DB::table('maintenance.warrant_projection')
            ->orderBy(
                'value','ASC'
            )->get();
            return $query;
        }catch (\Throwable $th) {
            $response = false;
            return $response;
        }

    }

    public function getOsolProjectionPercent($code,$selectedyear) {

        $query = DB::select(DB::raw('
        WITH tbl1 AS (
            select DISTINCT SUM(coalesce(wd.expense,wd.expense,0)) over (order by month) as carry_sum_expense , month
            from maintenance.warrant_detail as wd
            join maintenance.osol_type as ot on ot.id = wd.osol_type_id
            where 
            wd.waran_type_id = 1
            and ot.code = ?
            and wd.year = ? 
            GROUP BY month,wd.expense
            )
            , tbl2 AS (
            select month, SUM(wd.expense) as sum_expense ,SUM(allocation) as sum_total_allocation, SUM(addition)as sum_addition, SUM(deduct) as sum_deduct, 
            SUM(total_allocation) as sum_total_allocation 
            from maintenance.warrant_detail as wd
            join maintenance.osol_type as ot on ot.id = wd.osol_type_id
            where 
            wd.waran_type_id = 1
            and ot.code = ?
            and wd.year = ?
            GROUP BY wd.month
            order by month asc
            )
            select * from
            tbl1 t1
            JOIN tbl2 t2
            ON t1.month =  t2.month
            
   '),[$code,$selectedyear ,$code,$selectedyear]);

        if ($query) {

            $arr = [];
            foreach ($query as $item) {
                $percentExpense2Deci = 0;
                $sumTotalAllocation =  $item->sum_total_allocation;
                
                if (is_numeric($item->carry_sum_expense) && is_numeric($sumTotalAllocation) && $sumTotalAllocation != 0) {
                    $sumExpense =  $item->carry_sum_expense;
                    $percentExpense =  ($sumExpense / $sumTotalAllocation) * 100;
                    $percentExpense2Deci = number_format((float)$percentExpense, 2, '.', '');

                }
                array_push($arr, $percentExpense2Deci);
            }
        }
        return $arr;
    }

    public function generateWarrantData($selectedyear) {
        try {
           
            $year = $selectedyear;
            if (WarrantDetail::where('year', '=', $year)->exists()) {
               $response = [
                'status' => false,
                'message' => 'tidak ada maklumat untuk ditambah'
                ];

                return $response;

            } else {
               for ($i = 1; $i <= 12; $i++) {
                $data = [
                    ['state'=>'JOHOR' ,'status'=> 1 ,'waran_type_id'=> 1,'osol_type_id'=> 1,'year'=> $year, 'month'=>$i,'workshop_id'=>2],
                    ['state'=>'KEDAH' ,'status'=> 1 ,'waran_type_id'=> 1,'osol_type_id'=> 1,'year'=> $year, 'month'=>$i,'workshop_id'=>3],
                    ['state'=>'KELANTAN' ,'status'=> 1 ,'waran_type_id'=> 1,'osol_type_id'=> 1,'year'=> $year, 'month'=>$i,'workshop_id'=>4],
                    ['state'=>'MELAKA' ,'status'=> 1 ,'waran_type_id'=> 1,'osol_type_id'=> 1,'year'=> $year, 'month'=>$i,'workshop_id'=>5],
                    ['state'=>'NEGERI SEMBILAN' ,'status'=> 1 ,'waran_type_id'=> 1,'osol_type_id'=> 1,'year'=> $year, 'month'=>$i,'workshop_id'=>6],
                    ['state'=>'PAHANG' ,'status'=> 1 ,'waran_type_id'=> 1,'osol_type_id'=> 1,'year'=> $year, 'month'=>$i,'workshop_id'=>7],
                    ['state'=>'PERAK' ,'status'=> 1 ,'waran_type_id'=> 1,'osol_type_id'=> 1,'year'=> $year, 'month'=>$i,'workshop_id'=>9],
                    ['state'=>'PERLIS' ,'status'=> 1 ,'waran_type_id'=> 1,'osol_type_id'=> 1,'year'=> $year, 'month'=>$i,'workshop_id'=>10],
                    ['state'=>'PULAU PINANG' ,'status'=> 1 ,'waran_type_id'=> 1,'osol_type_id'=> 1,'year'=> $year, 'month'=>$i,'workshop_id'=>8],
                    ['state'=>'SELANGOR' ,'status'=> 1 ,'waran_type_id'=> 1,'osol_type_id'=> 1,'year'=> $year, 'month'=>$i,'workshop_id'=>11],
                    ['state'=>'TERENGGANU' ,'status'=> 1 ,'waran_type_id'=> 1,'osol_type_id'=> 1,'year'=> $year, 'month'=>$i,'workshop_id'=>12],
                    ['state'=>'WOKSYOP PERSEKUTUAN' ,'status'=> 1 ,'waran_type_id'=> 1,'osol_type_id'=> 1,'year'=> $year, 'month'=>$i,'workshop_id'=>1],
                    ['state'=>'WP LABUAN' ,'status'=> 1 ,'waran_type_id'=> 1,'osol_type_id'=> 1,'year'=> $year, 'month'=>$i,'workshop_id'=>13],

                    ['state'=>'JOHOR' ,'status'=> 1 ,'waran_type_id'=> 1,'osol_type_id'=> 2,'year'=> $year, 'month'=>$i,'workshop_id'=>2],
                    ['state'=>'KEDAH' ,'status'=> 1 ,'waran_type_id'=> 1,'osol_type_id'=> 2,'year'=> $year, 'month'=>$i,'workshop_id'=>3],
                    ['state'=>'KELANTAN' ,'status'=> 1 ,'waran_type_id'=> 1,'osol_type_id'=> 2,'year'=> $year, 'month'=>$i,'workshop_id'=>4],
                    ['state'=>'MELAKA' ,'status'=> 1 ,'waran_type_id'=> 1,'osol_type_id'=> 2,'year'=> $year, 'month'=>$i,'workshop_id'=>5],
                    ['state'=>'NEGERI SEMBILAN' ,'status'=> 1 ,'waran_type_id'=> 1,'osol_type_id'=> 2,'year'=> $year, 'month'=>$i,'workshop_id'=>6],
                    ['state'=>'PAHANG' ,'status'=> 1 ,'waran_type_id'=> 1,'osol_type_id'=> 2,'year'=> $year, 'month'=>$i,'workshop_id'=>7],
                    ['state'=>'PERAK' ,'status'=> 1 ,'waran_type_id'=> 1,'osol_type_id'=> 2,'year'=> $year, 'month'=>$i,'workshop_id'=>9],
                    ['state'=>'PERLIS' ,'status'=> 1 ,'waran_type_id'=> 1,'osol_type_id'=> 2,'year'=> $year, 'month'=>$i,'workshop_id'=>10],
                    ['state'=>'PULAU PINANG' ,'status'=> 1 ,'waran_type_id'=> 1,'osol_type_id'=> 2,'year'=> $year, 'month'=>$i,'workshop_id'=>8],
                    ['state'=>'SELANGOR' ,'status'=> 1 ,'waran_type_id'=> 1,'osol_type_id'=> 2,'year'=> $year, 'month'=>$i,'workshop_id'=>11],
                    ['state'=>'TERENGGANU' ,'status'=> 1 ,'waran_type_id'=> 1,'osol_type_id'=> 2,'year'=> $year, 'month'=>$i,'workshop_id'=>12],
                    ['state'=>'WOKSYOP PERSEKUTUAN' ,'status'=> 1 ,'waran_type_id'=> 1,'osol_type_id'=> 2,'year'=> $year, 'month'=>$i,'workshop_id'=>1],
                    ['state'=>'WP LABUAN' ,'status'=> 1 ,'waran_type_id'=> 1,'osol_type_id'=> 2,'year'=> $year, 'month'=>$i,'workshop_id'=>13],

                    ['state'=>'JOHOR' ,'status'=> 1 ,'waran_type_id'=> 2,'osol_type_id'=> null,'year'=> $year, 'month'=>$i,'workshop_id'=>2],
                    ['state'=>'KEDAH' ,'status'=> 1 ,'waran_type_id'=> 2,'osol_type_id'=> null,'year'=> $year, 'month'=>$i,'workshop_id'=>3],
                    ['state'=>'KELANTAN' ,'status'=> 1 ,'waran_type_id'=> 2,'osol_type_id'=> null,'year'=> $year, 'month'=>$i,'workshop_id'=>4],
                    ['state'=>'MELAKA' ,'status'=> 1 ,'waran_type_id'=> 2,'osol_type_id'=> null,'year'=> $year, 'month'=>$i,'workshop_id'=>5],
                    ['state'=>'NEGERI SEMBILAN' ,'status'=> 1 ,'waran_type_id'=> 2,'osol_type_id'=> null,'year'=> $year, 'month'=>$i,'workshop_id'=>6],
                    ['state'=>'PAHANG' ,'status'=> 1 ,'waran_type_id'=> 2,'osol_type_id'=> null,'year'=> $year, 'month'=>$i,'workshop_id'=>7],
                    ['state'=>'PERAK' ,'status'=> 1 ,'waran_type_id'=> 2,'osol_type_id'=> null,'year'=> $year, 'month'=>$i,'workshop_id'=>9],
                    ['state'=>'PERLIS' ,'status'=> 1 ,'waran_type_id'=> 2,'osol_type_id'=> null,'year'=> $year, 'month'=>$i,'workshop_id'=>10],
                    ['state'=>'PULAU PINANG' ,'status'=> 1 ,'waran_type_id'=> 2,'osol_type_id'=> null,'year'=> $year, 'month'=>$i,'workshop_id'=>8],
                    ['state'=>'SELANGOR' ,'status'=> 1 ,'waran_type_id'=> 2,'osol_type_id'=> null,'year'=> $year, 'month'=>$i,'workshop_id'=>11],
                    ['state'=>'TERENGGANU' ,'status'=> 1 ,'waran_type_id'=> 2,'osol_type_id'=> null,'year'=> $year, 'month'=>$i,'workshop_id'=>12],
                    ['state'=>'WOKSYOP PERSEKUTUAN' ,'status'=> 1 ,'waran_type_id'=> 2,'osol_type_id'=> null,'year'=> $year, 'month'=>$i,'workshop_id'=>1],
                    ['state'=>'WP LABUAN' ,'status'=> 1 ,'waran_type_id'=> 2,'osol_type_id'=> null,'year'=> $year, 'month'=>$i,'workshop_id'=>13],
 
                    ['state'=>'JOHOR' ,'status'=> 1 ,'waran_type_id'=> 3,'osol_type_id'=> null,'year'=> $year, 'month'=>$i,'workshop_id'=>2],
                    ['state'=>'KEDAH' ,'status'=> 1 ,'waran_type_id'=> 3,'osol_type_id'=> null,'year'=> $year, 'month'=>$i,'workshop_id'=>3],
                    ['state'=>'KELANTAN' ,'status'=> 1 ,'waran_type_id'=> 3,'osol_type_id'=> null,'year'=> $year, 'month'=>$i,'workshop_id'=>4],
                    ['state'=>'MELAKA' ,'status'=> 1 ,'waran_type_id'=> 3,'osol_type_id'=> null,'year'=> $year, 'month'=>$i,'workshop_id'=>5],
                    ['state'=>'NEGERI SEMBILAN' ,'status'=> 1 ,'waran_type_id'=> 3,'osol_type_id'=> null,'year'=> $year, 'month'=>$i,'workshop_id'=>6],
                    ['state'=>'PAHANG' ,'status'=> 1 ,'waran_type_id'=> 3,'osol_type_id'=> null,'year'=> $year, 'month'=>$i,'workshop_id'=>7],
                    ['state'=>'PERAK' ,'status'=> 1 ,'waran_type_id'=> 3,'osol_type_id'=> null,'year'=> $year, 'month'=>$i,'workshop_id'=>9],
                    ['state'=>'PERLIS' ,'status'=> 1 ,'waran_type_id'=> 3,'osol_type_id'=> null,'year'=> $year, 'month'=>$i,'workshop_id'=>10],
                    ['state'=>'PULAU PINANG' ,'status'=> 1 ,'waran_type_id'=> 3,'osol_type_id'=> null,'year'=> $year, 'month'=>$i,'workshop_id'=>8],
                    ['state'=>'SELANGOR' ,'status'=> 1 ,'waran_type_id'=> 3,'osol_type_id'=> null,'year'=> $year, 'month'=>$i,'workshop_id'=>11],
                    ['state'=>'TERENGGANU' ,'status'=> 1 ,'waran_type_id'=> 3,'osol_type_id'=> null,'year'=> $year, 'month'=>$i,'workshop_id'=>12],
                    ['state'=>'WOKSYOP PERSEKUTUAN' ,'status'=> 1 ,'waran_type_id'=> 3,'osol_type_id'=> null,'year'=> $year, 'month'=>$i,'workshop_id'=>1],
                    ['state'=>'WP LABUAN' ,'status'=> 1 ,'waran_type_id'=> 3,'osol_type_id'=> null,'year'=> $year, 'month'=>$i,'workshop_id'=>13],
   
                ];
                
               // WarrantDetail::insert($data); // Eloquent approach
               DB::table('maintenance.warrant_detail')->insert($data); // Query Builder approach
              }

               $response = [
                   'status' => true,
                   'message' => 'Maklumat berjaya ditambah'
               ];
   
               return $response;
             }

        } catch (\Throwable $th) {
            $response = [
                'status' => false,
                'message' => $th
            ];
            Log::info("ADD WARRANT --> ".$th);
            return $response;
        }
    }

    public function getStatement(Request $request, $mode) {

        Log::info('/getStatement');

       // $workshop_id = $request->workshop_id;

        $workshop_id = $request->selectedWorkshopId;
        $warran_id = $request->selectedWaranId;
        $osol_id = $request->selectedOsolId;
        $year = $request->selectedYear;


        //  Log::info("workshop_id : ".$workshop_id);
        //  Log::info("warran_id : ".$warran_id);
        //  Log::info("osol_id : ".$osol_id);
        //  Log::info("year : ".$year);
        $exQuery = '';
        if ($osol_id != 0) {

            $exQuery = 'and wd.osol_type_id ='.$osol_id;
        }

        $limit = $request->limit ? $request->limit : 10;
        $page = $request->page ? $request->page : 0;
        $offset = $limit * $page;
        $paginate = 'limit '.$limit.' offset '.$offset;
        $select = 'select wd.id, j.ref_number, j.applicant_name, ra.desc as agency, wds.expense ,wds.advance,wds.note ,wds.created_at ,wds.expense_dt ,wd.state, wd.year,wd.month, wd.workshop_id,wd.osol_type_id, wd.waran_type_id';
        $orderBy = 'order by wds.expense_dt desc';
        if($mode == 'total'){
            $paginate = "";
            $select = "select count(*) ";
            $orderBy = "";
        } else if($mode == 'report'){
            $paginate = "";
        }

        $sql = $select.' 
        from maintenance.warrant_detail_statement as wds
        join maintenance.warrant_detail as wd on wd.id = wds.wd_id
        left join maintenance.job_vehicle_examination_form_repair as jvem on jvem.warrant_detail_id = wd.id
        left join maintenance.job_vehicle as jv on jv.id = jvem.vehicle_id
        left join maintenance.job as j on j.id = jv.maintenance_job_id
        left join public.ref_agency as ra on ra.id = j.agency_id
        where wd.id in ( 
        select id from maintenance.warrant_detail 
        where workshop_id = '.$workshop_id.'
        and year = '.$year.'
        and waran_type_id = '.$warran_id.'
       '.$exQuery.'
        order by month
        )
        '.$orderBy.'
        '.$paginate.'
        ';
        $query = DB::select($sql);
       Log::info('$sql => '.$sql);

       if($mode == 'total'){
            return $query;
       }

       // return $query ;
       $arr = [];
        if ($query) {
            $index = 0;
            foreach ($query as $item) {
                $index =+ 1;
                $obj = new WarrantStatement;

                $obj->index = $index;
                if ($item->note == "" || $item->note == null) {
                    $obj->description = $item->ref_number.' , '.$item->applicant_name.' , '.$item->agency;
                }else {
                    $obj->description = $item->note;
                }
                
                $obj->date = $item->expense_dt;
                $obj->expense = $item->expense;
                $obj->advance = $item->advance;
            
                array_push($arr, $obj);

            }
        }

        return $arr;

    }

    public function exportExcel(Request $request)
    {
       // return Excel::download(new WarrantExportView($request), 'vehicles.xlsx');
       return Excel::download(new WarrantExportView($request), 'warrant.xlsx');
    }

    public function addKKRWarantState(Request $request){
        $year = $request->year;
        $workshop = RefWorkshop::find($request->workshop_id);
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            array_push(
                $data,
                [
                    'state' => $workshop->hasState->desc,
                    'status' => 1 ,
                    'waran_type_id' => 2,
                    'osol_type_id' => null,
                    'year' => $year, 
                    'month' =>$i,
                    'workshop_id' => $workshop->id,
                    'warrant_received_dt' => $this->convertDateToSQLDateTime($request->warrant_received_dt, 'Y-m-d')
                ]
            );
        }

        WarrantDetail::insert($data);

        return [
            'message' => 'Maklumat berjaya ditambah',
            'code' => 200
        ];
        
    }

    public function addAgencyWarantState(Request $request){
        $year = $request->year;
        $workshop = RefWorkshop::find($request->workshop_id);
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            array_push(
                $data,
                [
                    'state' => $workshop->hasState->desc,
                    'status' => 1 ,
                    'waran_type_id' => 3,
                    'osol_type_id' => null,
                    'year' => $year, 
                    'month' =>$i,
                    'workshop_id' => $workshop->id,
                    'warrant_received_dt' => $this->convertDateToSQLDateTime($request->warrant_received_dt, 'Y-m-d')
                ]
            );
        }

        WarrantDetail::insert($data);

        return [
            'message' => 'Maklumat berjaya ditambah',
            'code' => 200
        ];
        
    }

    private function convertDateToSQLDateTime($dateVal, $format){
        return Carbon::createFromFormat('d/m/Y', $dateVal)->format($format);
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


class WarrantStatement
{
    public $index;
    public $description;
    public $date;
    public $expense;
    public $advance;

}

