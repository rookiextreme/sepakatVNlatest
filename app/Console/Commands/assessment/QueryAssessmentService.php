<?php

namespace App\Console\Commands\assessment;

use App\Mail\Scheduler\SchedulerAssessmentSafetyServiceNotification;
use App\Mail\Scheduler\SchedulerAssessmentServiceNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class QueryAssessmentService
{

    public function assessmentServiceInfo(){

        $AssessmentServiceUrl = route('assessment.safety.list');

        $query = DB::select("select j.email,jv.plate_no, jv.expiry_dt, rs.name as setting_name, rss.value as day_before from assessment.assessment_safety j 
        join assessment.assessment_safety_vehicle jv on jv.assessment_safety_id = j.id
        join ref_setting rs on rs.code = '06'
        join ref_setting_sub rss on rss.setting_id = rs.id and rss.status = 1 
        where date_part('days', jv.expiry_dt - now()) >= rss.value and date_part('days', jv.expiry_dt - now()) < 31");

        if(count($query) > 0){
            foreach ($query as $item) {

                $emails = ['farid.developer.1992@gmail.com'];
    
                array_push($emails, $item->email);
                $emailBody = [
                    'subject' => 'MAKLUMAN PENILAIAN KESELAMATAN DAN PRESTASI KENDERAAN',
                    'title' => 'MAKLUMAN PENILAIAN KESELAMATAN DAN PRESTASI KENDERAAN',
                    'plate_no' => $item->plate_no,
                    'expiry_dt' => $item->expiry_dt,
                    'url' =>  Route('.redirect').'?redirectTo='.$AssessmentServiceUrl
                ];
                
                Mail::to($emails)->send(new SchedulerAssessmentSafetyServiceNotification($emailBody));
            }
        } else {
            $emails = ['farid.developer.1992@gmail.com'];

            $emailBody = [
                'subject' => 'MAKLUMAN PENILAIAN KESELAMATAN DAN PRESTASI KENDERAAN Testing',
                'title' => 'MAKLUMAN PENILAIAN KESELAMATAN DAN PRESTASI KENDERAAN Testing',
                'plate_no' => 'BND 2184',
                'expiry_dt' => Carbon::now(),
                'url' =>  'testing'
            ];
            
            Mail::to($emails)->send(new SchedulerAssessmentSafetyServiceNotification($emailBody));
        }

        Log::info('Run Scheduler for Service Assessment');
    }

}