<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AssessmentGovLoanVehicleTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('assessment.assessment_gov_loan_vehicle')->delete();

        \DB::table('assessment.assessment_gov_loan_vehicle')->insert(array (
            0 =>
            array (
                'assessment_gov_loan_id' => 1,
                'applicant_name' => 'MUHAMMAD CHE NORHAMIZAN',
                'applicant_ic_no' => '910204-11-9881',
                'applicant_company' => 'PUNCAK JAYA SDN BHD',
                'category_id' => 1,
                'sub_category_id' => 1,
                'sub_category_type_id' => 28,
                'purchase_dt' => NULL,
                'purchase_' => NULL,
                'company_name' => NULL,
                'lo_no' => NULL,
                'is_gover' => false,
                'in_assessment' => false,
                'approval' => NULL,
                'evaluation_type' => NULL,
                'vtl_doc' => NULL,
                'veh_img_doc' => NULL,
                'receipt_doc' => NULL,
                'plate_no' => 'WVE809',
                'engine_no' => '4D56-QAZ301',
                'chasis_no' => '65JPI-098',
                'vehicle_price' => NULL,
                'vehicle_brand_id' => 75,
                'model_name' => 'TRITON VGT',
                'manufacture_year' => 2019,
                'registration_vehicle_dt' => '2019-12-14',
                'original_price' => '135600',
                'current_price' => NULL,
                'market_price' => '120700.9',
                'estimate_repair' => NULL,
                'estimate_price' => NULL,
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
                'created_at' => '2021-11-08 11:04:26',
                'updated_at' => '2021-11-08 11:04:26',
            ),
            1 =>
            array (
                'assessment_gov_loan_id' => 1,
                'applicant_name' => 'MUHAMMAD CHE NORHAMIZAN',
                'applicant_ic_no' => '910204-11-9881',
                'applicant_company' => 'PUNCAK JAYA SDN BHD',
                'category_id' => 1,
                'sub_category_id' => 1,
                'sub_category_type_id' => 28,
                'purchase_dt' => NULL,
                'purchase_' => NULL,
                'company_name' => NULL,
                'lo_no' => NULL,
                'is_gover' => false,
                'in_assessment' => false,
                'approval' => NULL,
                'evaluation_type' => NULL,
                'vtl_doc' => NULL,
                'veh_img_doc' => NULL,
                'receipt_doc' => NULL,
                'plate_no' => 'WVE8091',
                'engine_no' => '4D56-ELO908',
                'chasis_no' => '65JPI-098-09',
                'vehicle_price' => NULL,
                'vehicle_brand_id' => 75,
                'model_name' => 'TRITON VGT',
                'manufacture_year' => 2019,
                'registration_vehicle_dt' => '2019-12-14',
                'original_price' => '135600',
                'current_price' => NULL,
                'market_price' => '120700.9',
                'estimate_repair' => NULL,
                'estimate_price' => NULL,
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
                'created_at' => '2021-11-08 11:04:36',
                'updated_at' => '2021-11-08 11:04:36',
            ),
        ));


    }
}
