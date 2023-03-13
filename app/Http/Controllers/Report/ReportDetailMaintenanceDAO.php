<?php

namespace App\Http\Controllers\Report;

use App\Exports\ReportDetailMaintenanceExportView;
use App\Exports\WarrantExportView;
use App\Http\Controllers\Controller;
use App\Models\Maintenance\MaintenanceJob;
use App\Models\RefWorkshop;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;


class ReportDetailMaintenanceDAO extends Controller
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


    public function getWorkshop() {

        $query  = RefWorkshop::get();
        //Log::info($query);
        return $query;
    }

    public function getCustomer($mode, Request $request) {

        $query = MaintenanceJob::select('department_name AS desc')->selectRaw('REPLACE(department_name, \' \', \'\') AS customer_id');

       switch ($mode) {
           case 'based_on_record':
                $query->whereHas('hasVehicle', function($q){
                    $q->whereHas('hasExamform');
                });
                $query->groupBy('department_name');
                return $query->get();
               break;

            case 'selected_customer':
                $query->whereRaw("REPLACE(department_name,' ','') = ? ",[trim($request->customer_id)]);

                Log::info($query->toSql());
                Log::info($query->getBindings());
                Log::info($query->first());
                return $query->first();
                break;
           
           default:
               # code...
               break;
       }
    }

    public function getListReport(Request $request, $year, $month,$id) {

        try {

            // if ($year == 2021 && $month < 10 && $month > 0) {
            //     return [];
            // }
    
            
            
            // $query = DB::select(DB::raw('
            //         select jve.id, sc.company_name, jve.repair_method , jve.vehicle_id , jv.plate_no, jv.model_name,rsct.name , j.department_name, u.name AS pic_name, pjm.name AS pjm_name, jve.v_completed_dt,jve.pro_budget_price,jv.maintenance_job_purpose_type ,jve.waran_type_id, wt.desc as warrant_type, ot.desc as osol_type
            //         from maintenance.supplier_company sc
            //         join maintenance.job_vehicle_examination_form jve on jve.pro_budget_price_supl_id = sc.id and jve.id = sc.form_id 
            //         join maintenance.job_vehicle jv on jv.id = jve.vehicle_id 
            //         join public.ref_sub_category_type rsct on rsct.id = jv.sub_category_type_id
            //         join maintenance.job j on j.id = jv.maintenance_job_id
            //         join maintenance.waran_type wt on wt.id = jve.waran_type_id
            //         left join maintenance.osol_type ot on ot.id = jve.osol_type_id
            //         left join users.users u on u.id = jve.inspected_by
            //         join users.users pjm on pjm.id = j.assistant_engineer_by
            //         where jve.v_completed_dt is not null
            //         and j.workshop_id = ?
            //         and EXTRACT(MONTH FROM jve.v_completed_dt) = ?
            //         and EXTRACT(YEAR FROM jve.v_completed_dt) = ?
        
            // '),[$id,$month,$year]);

            //TODO 20/05/2022 farid
            $query = DB::select(DB::raw('select j.id as job_id, jve.jve_form_id as form_id, jve.id as jve_form_repair_id, sc.company_name, jv_form.repair_method, jve.repair_method_id , jve.vehicle_id , jv.plate_no, jv.model_name,rsct.name , j.department_name, u.name AS pic_name, pjm.name AS pjm_name, jve.v_completed_dt,jve.pro_budget_price,jv.maintenance_job_purpose_type ,jve.waran_type_id, wt.desc as warrant_type, ot.desc as osol_type
            from maintenance.supplier_company sc
            join maintenance.job_vehicle_examination_form jv_form on jv_form.id = sc.form_id 
            join maintenance.job_vehicle_examination_form_repair jve on jve.pro_budget_price_supl_id = sc.id and jve.jve_form_id = sc.form_id 
            join maintenance.job_vehicle jv on jv.id = jve.vehicle_id 
            join public.ref_sub_category_type rsct on rsct.id = jv.sub_category_type_id
            join maintenance.job j on j.id = jv.maintenance_job_id
            join maintenance.waran_type wt on wt.id = jve.waran_type_id
            left join maintenance.osol_type ot on ot.id = jve.osol_type_id
            left join users.users u on u.id = jve.inspected_by
            join users.users pjm on pjm.id = j.assistant_engineer_by
            where jve.v_completed_dt is not null
            and j.workshop_id = ?
            and EXTRACT(MONTH FROM jve.v_completed_dt) = ?
            and EXTRACT(YEAR FROM jve.v_completed_dt) = ?
            '), [$id,$month,$year]);

            Log::info($query);
    
            $arr = [];

            foreach ($query as $item) {

                $maintenanceType = "";
                $repairMethod = "";
                $method = 3;
                $warrantType = "";
                $obj = new ReportDetailMaintenance;

                if (str_contains($item->repair_method, '1') && str_contains($item->repair_method, '2') ) { 
                    $repairMethod = "PERKHIDMATAN & BEKALAN";
                    $method = 1;
                }else if (str_contains($item->repair_method, '2')) {
                    $repairMethod = "PERKHIDMATAN";
                    $method = 2;
                }else {
                    $repairMethod = "BEKALAN";
                    $method = 3;
                }

                if (str_contains($item->maintenance_job_purpose_type, '1') && str_contains($item->maintenance_job_purpose_type, '2') ) { 
                    $maintenanceType = "P & S";
                }else if (str_contains($item->maintenance_job_purpose_type, '2')) {
                    $maintenanceType = "S";
                }else {
                    $maintenanceType = "P";
                }

                if ($item->warrant_type == "MHPV") {
                    $warrantType = $item->osol_type;
                }else {
                    $warrantType = $item->warrant_type;
                }

                $obj->company_name = $item->company_name;
                $obj->company_servis = $repairMethod;
                $obj->plate_no = $item->plate_no;
                $obj->vehicle_type = $item->name;
                $obj->customer = $item->department_name;
                $obj->work_detail = $this->getComponent($item->form_id, $item->jve_form_repair_id);
                $month = date("M",strtotime($item->v_completed_dt));
                $obj->month = strtoupper($month);
                $obj->amount = number_format($item->pro_budget_price,2);
                $obj->pic = strtoupper($item->pic_name);
                $obj->pjm_name = strtoupper($item->pjm_name);
                $obj->maintenance_type = $maintenanceType;
                $obj->warrant_type = $warrantType;
                $obj->method = $method;

                if($obj->method == $request->repair_method){
                    array_push($arr, $obj);
                } else if(!$request->repair_method) {
                   array_push($arr, $obj);
                }
                
            }
            }

            catch (\Throwable $th) {
                Log::info($th);
                //throw $th;
                $arr = [];
            }

            return $arr;

    }

    public function getComponent($form_id, $jve_form_repair_id) {
        try {

            Log::info('getComponent => '. $form_id.' => '.$jve_form_repair_id);

            $query = DB::select(DB::raw('
            select distinct rcl1.component from maintenance.mjob_exam_form_component jvfc
            join public.ref_component_lvl1 rcl1 on rcl1.id  = jvfc.ref_component_lvl1_id
            where jvfc.form_id = ? and jvfc.jve_form_repair_id = ?
        
            '),[$form_id, $jve_form_repair_id]);
    
            Log::info('ReportDetailMaintenance => getComponent => '.$form_id . ' => '.$jve_form_repair_id);
            $componenDesc = "";

            if ($query) {
                $i = 0;
                foreach ($query as $item) {
                    $i++;
                    if($i == count($query) ) {
                        $componenDesc .= $item->component;
                    }else {
                        $componenDesc .= $item->component.',';
                    }
                }
            }

            return $componenDesc;

        }catch (\Throwable $th) {
        
            return '';
        }
    }


    public function exportExcel(Request $request)
    {
       return Excel::download(new ReportDetailMaintenanceExportView($request), 'report_maintenance.xlsx');
    }
    
}


class ReportDetailMaintenance
{
    public $company_name;
    public $company_servis;
    public $plate_no;
    public $vehicle_type;
    public $customer;
    public $work_detail;
    public $month;
    public $amount;
    public $pic;
    public $pjm_name;
    public $maintenance_type;
    public $warrant_type;
    public $method = 3;

}