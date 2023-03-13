<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AssessmentSafetyVehicleTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('assessment.assessment_safety_vehicle')->delete();

        \DB::table('assessment.assessment_safety_vehicle')->insert(array (
            0 =>
            array (
                'assessment_safety_id' => 1,
                'category_id' => 1,
                'sub_category_id' => 1,
                'sub_category_type_id' => 4,
                'in_assessment' => false,
                'approval' => NULL,
                'plate_no' => 'WAX3445',
                'engine_no' => '4D56-QAZ301-YIU',
                'chasis_no' => '65JPI-098-09',
                'odometer' => NULL,
                'vehicle_brand_id' => 60,
                'veh_img_doc' => NULL,
                'model_name' => 'X70',
                'manufacture_year' => 2019,
                'registration_vehicle_dt' => '2019-06-18',
                'app_datetime' => NULL,
                'cert_hash_key' => NULL,
                'cert_ref_number' => NULL,
                'assessment_vehicle_status_id' => 2,
                'evaluation_type' => NULL,
                'vtl_doc' => NULL,
                'created_by' => 15,
                'updated_by' => NULL,
                'foremen_dt' => NULL,
                'foremen_by' => NULL,
                'assessment_dt' => NULL,
                'assessment_by' => NULL,
                'verify_dt' => NULL,
                'verify_by' => NULL,
                'approve_dt' => NULL,
                'approve_by' => NULL,
                'evaluate_dt' => NULL,
                'evaluate_by' => NULL,
                'created_at' => '2021-11-08 10:59:28',
                'updated_at' => '2021-11-08 10:59:28',
            ),
            1 =>
            array (
                'assessment_safety_id' => 1,
                'category_id' => 1,
                'sub_category_id' => 1,
                'sub_category_type_id' => 28,
                'in_assessment' => false,
                'approval' => NULL,
                'plate_no' => 'WXX333',
                'engine_no' => '4D56-ELO908',
                'chasis_no' => '65JPI-098',
                'odometer' => NULL,
                'vehicle_brand_id' => 22,
                'veh_img_doc' => NULL,
                'model_name' => 'RANGER',
                'manufacture_year' => 2007,
                'registration_vehicle_dt' => '2007-11-15',
                'app_datetime' => NULL,
                'cert_hash_key' => NULL,
                'cert_ref_number' => NULL,
                'assessment_vehicle_status_id' => 2,
                'evaluation_type' => NULL,
                'vtl_doc' => NULL,
                'created_by' => 15,
                'updated_by' => NULL,
                'foremen_dt' => NULL,
                'foremen_by' => NULL,
                'assessment_dt' => NULL,
                'assessment_by' => NULL,
                'verify_dt' => NULL,
                'verify_by' => NULL,
                'approve_dt' => NULL,
                'approve_by' => NULL,
                'evaluate_dt' => NULL,
                'evaluate_by' => NULL,
                'created_at' => '2021-11-08 11:00:04',
                'updated_at' => '2021-11-08 11:00:04',
            ),
        ));


    }
}
