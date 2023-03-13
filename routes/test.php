<?php

use App\Http\Controllers\Test\TestController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

Route::get('/testEmailTemplateSummon', function(){

    return view('emails.summon.pic-notification', [
        'details' => [
            'vehicle_plat_no' => 'BND2184',
            'summon_notice_no' => '2192004142',
            'mistake_date' => '2021-08-10',
            'mistake_time' => '05:00:00',
            'vehicler_type' => 'TOYOTA FORTUNER 2.5G (D) AUTO',
            'placement_name' => 'CAW. KERJA PENDIDIKAN'
        ]
    ]);

})->name('testEmailTemplateSummon');

Route::get('/testDateFormat', function(Request $request){

    $TestController = new TestController();
    return $TestController->testDate($request);
})->name('testDateFormat');

Route::get('/OsolType', function(Request $request){

    $TestController = new TestController();
    return $TestController->OsolType($request);
})->name('OsolType');

Route::get('/testQuery', function(Request $request){

    $id = 1;
    $month = 5;
    $year = 2022;

    $query = DB::select(DB::raw('select jve.id, sc.company_name, jve.repair_method_id , jve.vehicle_id , jv.plate_no, jv.model_name,rsct.name , j.department_name, u.name AS pic_name, pjm.name AS pjm_name, jve.v_completed_dt,jve.pro_budget_price,jv.maintenance_job_purpose_type ,jve.waran_type_id, wt.desc as warrant_type, ot.desc as osol_type
        from maintenance.supplier_company sc
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
        '), [$id]);

        Log::info($query);

        foreach ($query as $key) {
            Log::info($key);
        }

        return $query;
        
})->name('testQuery');