<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AssessmentNewVehicleTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('assessment.assessment_new_vehicle')->delete();

        \DB::table('assessment.assessment_new_vehicle')->insert(array (
            0 =>
            array (
                'assessment_new_id' => 1,
                'category_id' => 1,
                'sub_category_id' => 1,
                'sub_category_type_id' => 24,
                'purchase_dt' => '2019-07-17',
                'company_name' => 'PROTON SDN BHD',
                'lo_no' => 'JKR001',
                'is_gover' => true,
                'in_assessment' => false,
                'approval' => NULL,
                'plate_no' => 'VBA111',
                'engine_no' => '4D56-QAZ301-YIU',
                'chasis_no' => '65JPI-098-09',
                'price' => '0',
                'odometer' => NULL,
                'receipt_no' => NULL,
                'receipt_doc' => NULL,
                'evaluation_type' => NULL,
                'vtl_doc' => NULL,
                'veh_img_doc' => NULL,
                'vehicle_brand_id' => 60,
                'model_name' => 'X70',
                'manufacture_year' => 2019,
                'registration_vehicle_dt' => '2019-07-18',
                'app_datetime' => NULL,
                'cert_hash_key' => NULL,
                'cert_ref_number' => NULL,
                'assessment_vehicle_status_id' => 2,
                'created_by' => 15,
                'updated_by' => NULL,
                'foremen_by' => NULL,
                'foremen_dt' => NULL,
                'assessment_by' => NULL,
                'assessment_dt' => NULL,
                'verify_by' => NULL,
                'verify_dt' => NULL,
                'approve_by' => NULL,
                'approve_dt' => NULL,
                'evaluate_by' => NULL,
                'created_at' => '2021-11-08 10:55:00',
                'updated_at' => '2021-11-08 10:55:00',
            ),
            1 =>
            array (
                'assessment_new_id' => 1,
                'category_id' => 1,
                'sub_category_id' => 1,
                'sub_category_type_id' => 4,
                'purchase_dt' => '2014-12-29',
                'company_name' => 'PROTON SDN BHD',
                'lo_no' => 'JKR001',
                'is_gover' => true,
                'in_assessment' => false,
                'approval' => NULL,
                'plate_no' => 'VBV111',
                'engine_no' => '4D56-QAZ301-YIU',
                'chasis_no' => '65JPI-098',
                'price' => '0',
                'odometer' => NULL,
                'receipt_no' => NULL,
                'receipt_doc' => NULL,
                'evaluation_type' => NULL,
                'vtl_doc' => NULL,
                'veh_img_doc' => NULL,
                'vehicle_brand_id' => 75,
                'model_name' => 'LANCER',
                'manufacture_year' => 2014,
                'registration_vehicle_dt' => '2014-05-28',
                'app_datetime' => NULL,
                'cert_hash_key' => NULL,
                'cert_ref_number' => NULL,
                'assessment_vehicle_status_id' => 2,
                'created_by' => 15,
                'updated_by' => NULL,
                'foremen_by' => NULL,
                'foremen_dt' => NULL,
                'assessment_by' => NULL,
                'assessment_dt' => NULL,
                'verify_by' => NULL,
                'verify_dt' => NULL,
                'approve_by' => NULL,
                'approve_dt' => NULL,
                'evaluate_by' => NULL,
                'created_at' => '2021-11-08 10:56:13',
                'updated_at' => '2021-11-08 10:56:13',
            ),
        ));


    }
}
