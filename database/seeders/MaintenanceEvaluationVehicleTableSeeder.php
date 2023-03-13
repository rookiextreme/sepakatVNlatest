<?php

namespace Database\Seeders;

use App\Models\Maintenance\MaintenanceEvaluationVehicle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaintenanceEvaluationVehicleTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        $data = array (
            'maintenance_evaluation_id' => 1,
            'category_id' => 1,
            'sub_category_id' => 1,
            'sub_category_type_id' => 4,
            'purchase_dt' => '2021-09-03',
            'company_name' => 'SUZUKI SDN BHD',
            'lo_no' => 'PESAN 45612',
            'is_gover' => true,
            'plate_no' => 'CBR455',
            'engine_no' => 'SZK45-09IK',
            'chasis_no' => 'EDQWEQW',
            'vehicle_brand_id' => 2,
            'model_name' => 'CLK-235',
            'manufacture_year' => 2019,
            'registration_vehicle_dt' => '2021-09-03',
            'app_datetime' => NULL,
            'cert_hash_key' => NULL,
            'maintenance_vehicle_status_id' => 2,
            'created_by' => 1,
            'updated_by' => NULL,
            'foremen_by' => NULL,
            'assessment_by' => NULL,
            'verify_by' => NULL,
            'created_at' => '2021-09-03 16:03:12',
            'updated_at' => '2021-09-03 16:03:12',
        );

        MaintenanceEvaluationVehicle::insert($data);

    }
}
