<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AssessmentCurrvalueVehicleTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('assessment.assessment_currvalue_vehicle')->delete();

        \DB::table('assessment.assessment_currvalue_vehicle')->insert(array (
            0 =>
            array (
                'assessment_currvalue_id' => 1,
                'applicant_name' => 'MUHAMMAD CHE NORHAMIZAN',
                'applicant_ic_no' => '910204-11-9881',
                'applicant_company' => 'PUNCAK JAYA SDN BHD',
                'category_id' => 1,
                'sub_category_id' => 1,
                'sub_category_type_id' => 40,
                'purchase_dt' => NULL,
                'purchase_' => NULL,
                'company_name' => NULL,
                'lo_no' => NULL,
                'is_gover' => false,
                'in_assessment' => false,
                'approval' => NULL,
                'evaluation_currvalue_type' => NULL,
                'evaluation_type' => NULL,
                'vtl_doc' => NULL,
                'veh_img_doc' => NULL,
                'receipt_doc' => NULL,
                'plate_no' => 'BNM5345',
                'engine_no' => '4D56-QAZ301-YIU',
                'chasis_no' => '65JPI-098-09',
                'vehicle_price' => NULL,
                'vehicle_brand_id' => 86,
                'model_name' => 'XM23',
                'manufacture_year' => 2018,
                'registration_vehicle_dt' => '2018-12-20',
                'original_price' => '110909',
                'current_price' => NULL,
                'market_price' => '120700.9',
                'estimate_repair' => NULL,
                'estimate_price' => NULL,
                'metal_price' => NULL,
                'metal_weight' => NULL,
                'durabilty' => NULL,
                'app_datetime' => NULL,
                'cert_hash_key' => NULL,
                'cert_ref_number' => NULL,
                'assessment_vehicle_status_id' => 2,
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
                'created_at' => '2021-11-08 11:01:41',
                'updated_at' => '2021-11-08 11:01:41',
            ),
            1 =>
            array (
                'assessment_currvalue_id' => 1,
                'applicant_name' => 'MUHAMMAD CHE NORHAMIZAN',
                'applicant_ic_no' => '910204-11-9881',
                'applicant_company' => 'PUNCAK JAYA SDN BHD',
                'category_id' => 1,
                'sub_category_id' => 1,
                'sub_category_type_id' => 40,
                'purchase_dt' => NULL,
                'purchase_' => NULL,
                'company_name' => NULL,
                'lo_no' => NULL,
                'is_gover' => false,
                'in_assessment' => false,
                'approval' => NULL,
                'evaluation_currvalue_type' => NULL,
                'evaluation_type' => NULL,
                'vtl_doc' => NULL,
                'veh_img_doc' => NULL,
                'receipt_doc' => NULL,
                'plate_no' => 'VBW3301',
                'engine_no' => '4D56-QAZ301',
                'chasis_no' => '52WW1038WE',
                'vehicle_price' => NULL,
                'vehicle_brand_id' => 86,
                'model_name' => 'XM23',
                'manufacture_year' => 2018,
                'registration_vehicle_dt' => '2018-12-20',
                'original_price' => '110909',
                'current_price' => NULL,
                'market_price' => '120700.9',
                'estimate_repair' => NULL,
                'estimate_price' => NULL,
                'metal_price' => NULL,
                'metal_weight' => NULL,
                'durabilty' => NULL,
                'app_datetime' => NULL,
                'cert_hash_key' => NULL,
                'cert_ref_number' => NULL,
                'assessment_vehicle_status_id' => 2,
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
                'created_at' => '2021-11-08 11:01:49',
                'updated_at' => '2021-11-08 11:01:49',
            ),
        ));


    }
}
