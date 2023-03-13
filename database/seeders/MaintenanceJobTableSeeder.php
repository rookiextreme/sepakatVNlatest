<?php

namespace Database\Seeders;

use App\Models\Maintenance\MaintenanceJob;
use App\Models\Maintenance\MaintenanceJobVehicle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaintenanceJobTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $ineedData = 10;

        for ($i=1; $i < $ineedData; $i++) {
            $data = [
                'ref_number' => 'NNA01000'.$i,
                'applicant_name' => 'FADZILAH ABDULLAH BIN MAT TAHIR',
                'phone_no' => '0166279246',
                'email' => 'polis01@pdrm.gov',
                'address' => 'LOT 1718 JALAN JEPUN KAMPONG MELAKA',
                'postcode' => '45500',
                'state_id' => 14,
                'department_name' => 'X11',
                'hod_name' => 'PEGARAH',
                'appointment_dt1' => '2021-09-16 01:45:00',
                'appointment_dt2' => NULL,
                'appointment_dt3' => NULL,
                'appointment_dt' => NULL,
                'is_other_app_dt' => false,
                'assistant_engineer_by' => NULL,
                'agency_id' => 34,
                'applicant_workshop_id' => 11,
                'workshop_id' => 1,
                'app_status_id' => 3,
                'total_price' => NULL,
                'assessed_dt' => NULL,
                'assessed_by' => NULL,
                'evaluated_dt' => NULL,
                'evaluated_by' => NULL,
                'approved_dt' => NULL,
                'approved_by' => NULL,
                'created_by' => 9,
                'updated_by' => NULL,
            ];
           $inserted = MaintenanceJob::create($data);

            $dataVehicle = [
                'maintenance_job_purpose_type' => '1',
                'complaint_damage' => 'kaburator',
                'last_service_dt' => '2021-09-16',
                'maintenance_job_id' => $inserted->id,
                'category_id' => NULL,
                'sub_category_id' => NULL,
                'sub_category_type_id' => NULL,
                'purchase_dt' => NULL,
                'company_name' => NULL,
                'lo_no' => NULL,
                'current_loc' => 'SELANGOR',
                'is_gover' => false,
                'plate_no' => 'BND218'.$i,
                'engine_no' => '1212',
                'chasis_no' => '11',
                'vehicle_brand_id' => 3,
                'fuel_type_id' => 1,
                'model_name' => '11',
                'manufacture_year' => NULL,
                'registration_vehicle_dt' => NULL,
                'app_datetime' => NULL,
                'cert_hash_key' => NULL,
                'is_maintained' => false,
                'maintenance_vehicle_status_id' => 2,
                'created_by' => 9,
                'updated_by' => NULL,
                'foremen_by' => NULL,
                'assessment_by' => NULL,
                'verify_by' => NULL,
            ];

           MaintenanceJobVehicle::create($dataVehicle);
        }


    }
}
