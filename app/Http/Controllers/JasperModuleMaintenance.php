<?php

use App\Models\Maintenance\MaintenanceEvaluationLetter;
use App\Models\Maintenance\MaintenanceJob;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

$carbon = new Carbon();
$carbon->setLocale('ms');

switch ($reportName) {
    case 'maintenance_vehicle_certificate':

        $module = [
            'maintenance_evaluation' => 'evaluation',
            'maintenance_job' => 'job'
        ];
        $params = [
            'check_is_genuine_url' => Route('.redirect').'?redirectTo='.route('maintenance.'.$module[$request->table_name].'.vehicle-certificate.checkGenuine'),
            'asset_path' => public_path('my-assets'),
            'table_name' => $module[$request->table_name],
            'vehicle_id' => $request->vehicle_id
        ];
        break;
    
    case 'maintenance_eval_exam_letter':
        $module = [
            'maintenance_evaluation' => 'evaluation',
            'maintenance_job' => 'job'
        ];


        $reportName = 'template_letter/letter';

        $query = MaintenanceEvaluationLetter::where([
            'vehicle_id' => $request->vehicle_id,
        ])->whereHas('hasStatus', function($q){
            $q->where('code', '04');
        })->first();

        $date = Carbon::parse($query->date)->format('d F Y');
        $appointment_dt = Carbon::parse($query->appointment_dt)->format('d F Y');
        $checkDate = Carbon::parse($query->date)->format('F');
        $checkApp = Carbon::parse($query->appointment_dt)->format('F');
        
        $params = [
            'template_letter_id' => $query->id,
            'asset_path' => public_path('my-assets'),
            'table_name' => $module[$request->table_name],
            'vehicle_id' => $request->vehicle_id,
            'plate_no' => $query->hasVehicle->plate_no,
            'vehicle_brand' => $query->hasVehicle->hasVehicleBrand ? $query->hasVehicle->hasVehicleBrand->name : '',
            'vehicle_model' => $query->hasVehicle->model_name ? $query->hasVehicle->model_name : '',
        ];

        break;

    case 'maintenance_eval_vehicle_letter':

        $letterCode = $request->letter_code;

        $module = [
            'maintenance_evaluation' => 'evaluation',
            'maintenance_job' => 'job'
        ];


        $reportName = 'template_letter/letter-'.$letterCode;

        $query = MaintenanceEvaluationLetter::where([
            'vehicle_id' => $request->vehicle_id,
        ])->whereHas('hasLetterType', function($q) use($request) {
            $q->where('code', $request->letter_code);
        })->first();

        Log::info("Query sini".$query);

        $date = Carbon::parse($query->date)->format('d F Y');
        $appointment_dt = Carbon::parse($query->appointment_dt)->format('d F Y');
        $checkDate = Carbon::parse($query->date)->format('F');
        $checkApp = Carbon::parse($query->appointment_dt)->format('F');

        if($checkDate == 'January' && $checkApp == 'January'){

            $new_date = str_replace('January', 'Januari', $date);
            $new_appointment_dt = str_replace('January', 'Januari', $appointment_dt);

        }elseif($checkDate == 'February' && $checkApp == 'February'){

            $new_date = str_replace('February', 'Februari', $date);
            $new_appointment_dt = str_replace('February', 'Februari', $appointment_dt);

        }elseif($checkDate == 'March' && $checkApp == 'March'){

            $new_date = str_replace('March', 'Mac', $date);
            $new_appointment_dt = str_replace('March', 'Mac', $appointment_dt);

        }elseif($checkDate == 'April' && $checkApp == 'April'){

            $new_date = str_replace('April', 'April', $date);
            $new_appointment_dt = str_replace('April', 'April', $appointment_dt);

        }elseif($checkDate == 'May' && $checkApp == 'May'){

            $new_date = str_replace('May', 'Mei', $date);
            $new_appointment_dt = str_replace('May', 'Mei', $appointment_dt);

        }elseif($checkDate == 'June' && $checkApp == 'June'){

            $new_date = str_replace('June', 'Jun', $date);
            $new_appointment_dt = str_replace('June', 'Jun', $appointment_dt);

        }elseif($checkDate == 'July' && $checkApp == 'July'){

            $new_date = str_replace('July', 'Julai', $date);
            $new_appointment_dt = str_replace('July', 'Julai', $appointment_dt);

        }elseif($checkDate == 'August' && $checkApp == 'August'){

            $new_date = str_replace('August', 'Ogos', $date);
            $new_appointment_dt = str_replace('August', 'Ogos', $appointment_dt);

        }elseif($checkDate == 'September' && $checkApp == 'September'){

            $new_date = str_replace('September', 'September', $date);
            $new_appointment_dt = str_replace('September', 'September', $appointment_dt);

        }elseif($checkDate == 'October' && $checkApp == 'October'){

            $new_date = str_replace('October', 'Oktober', $date);
            $new_appointment_dt = str_replace('October', 'Oktober', $appointment_dt);

        }elseif($checkDate == 'November' && $checkApp == 'November'){

            $new_date = str_replace('November', 'November', $date);
            $new_appointment_dt = str_replace('November', 'November', $appointment_dt);

        }else{

            $new_date = str_replace('December', 'Disember', $date);
            $new_appointment_dt = str_replace('December', 'Disember', $appointment_dt);

        }

        $params = [
            'template_letter_id' => $query->id,
            'asset_path' => public_path('my-assets'),
            'table_name' => $module[$request->table_name],
            'vehicle_id' => $request->vehicle_id,
            'ref_number' => $query->ref_number,
            'date' => $new_date,

            'address_to' => $query->address_to,

            'plate_no' => $query->hasVehicle->plate_no,
            'vehicle_brand' => $query->hasVehicle->hasVehicleBrand ? $query->hasVehicle->hasVehicleBrand->name : '',
            'vehicle_model' => $query->hasVehicle->model_name ? $query->hasVehicle->model_name : '',
            'placement_name' => $query->placement_name,
            'body_detail' => $query->body_detail,

            'appointment_dt' => $new_appointment_dt,

            'officername' => $query->officer_name,
            'officerphone' => $query->officer_phone,
            'signature_quote' => str_replace("\"", "",$query->signature_quote),
            'officerdesignation' => $query->officer_designation,
        ];

        switch ($request->letter_code) {
            case '01':

                $total_budget = $query->total_budget;
                $f = new NumberFormatter("ms", NumberFormatter::SPELLOUT);
                $total_budget_formatted = ucwords($f->format($total_budget));
                $params['total_budget'] = number_format($total_budget, 2);
                $params['total_budget_formatted'] = $total_budget_formatted;
                break;
            case '02':

                $params['vip_address'] = $query->vip_address;
                break;

            default:
                # code...
                break;
        }


        break;

}
