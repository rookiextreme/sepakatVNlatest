<?php

namespace App\Console\Commands\maintenance;

use App\Mail\Scheduler\SchedulerMaintenanceServiceNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class QueryMaintenanceService
{

    public function maintenanceServiceInfo(){

        $MaintenanceServiceUrl = route('maintenance.job.list');

        $query = DB::select("select j.email,jv.plate_no, jve.next_service_dt, rs.name as setting_name, rss.value as day_before from maintenance.job j 
        join maintenance.job_vehicle jv on jv.maintenance_job_id = j.id
        join maintenance.job_vehicle_examination_form jve on jve.vehicle_id = jv.id
        join ref_setting rs on rs.code = '03'
        join ref_setting_sub rss on rss.setting_id = rs.id and rss.status = 1 
        where date_part('days', jve.next_service_dt - now()) >= rss.value and date_part('days', jve.next_service_dt - now()) < 31");

        if(count($query) > 0){
            foreach ($query as $item) {

                $emails = ['farid.developer.1992@gmail.com'];
    
                array_push($emails, $item->email);
                $emailBody = [
                    'subject' => 'Maklumat Servis Kenderaan',
                    'title' => 'Maklumat Servis Kenderaan',
                    'plate_no' => $item->plate_no,
                    'next_service_dt' => $item->next_service_dt,
                    'url' =>  Route('.redirect').'?redirectTo='.$MaintenanceServiceUrl
                ];
                
                Mail::to($emails)->send(new SchedulerMaintenanceServiceNotification($emailBody));
            }
        } else {
            $emails = ['farid.developer.1992@gmail.com'];

            $emailBody = [
                'subject' => 'Maklumat Servis Kenderaan Testing',
                'title' => 'Maklumat Servis Kenderaan Testing',
                'plate_no' => 'BND 2184',
                'next_service_dt' => Carbon::now(),
                'url' =>  'testing'
            ];
            
            Mail::to($emails)->send(new SchedulerMaintenanceServiceNotification($emailBody));
        }

        Log::info('Run Scheduler for Service Maintenance');
    }

}