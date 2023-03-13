<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AssessmentDisposalVehicleTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('assessment.assessment_disposal_vehicle')->delete();

        \DB::table('assessment.assessment_disposal_vehicle')->insert(array (
            0 =>
            array (
                'assessment_disposal_id' => 1,
                'category_id' => 1,
                'sub_category_id' => 1,
                'sub_category_type_id' => 4,
                'purchase_dt' => '2014-07-08',
                'company_name' => NULL,
                'lo_no' => NULL,
                'location' => 'LOKASI',
                'original_price' => '135600',
                'aset_regno' => 'ASET 01',
                'nc_no' => 'KOD 01',
                'is_gover' => false,
                'is_move' => true,
                'plate_no' => 'JHJ411',
                'engine_no' => '4D56-QAZ301-YIU',
                'chasis_no' => '65JPI-098-09',
                'odometer' => NULL,
                'veh_img_doc' => NULL,
                'evaluation_type' => NULL,
                'vtl_doc' => NULL,
                'vehicle_brand_id' => 86,
                'model_name' => 'M4 1.8',
                'manufacture_year' => 2013,
                'registration_vehicle_dt' => '2014-07-15',
                'mileage_distance' => 0,
                'hours_used' => 0,
                'delivery_service' => 0,
                'earlier_maintenance_cost' => '21900.56',
                'current_maintenance_cost' => '0',
                'current_value' => '0',
                'post_current_value' => '0',
                'post_durability' => 0,
                'estimate_value_after' => '0',
                'manual_depreciation' => 0,
                'app_datetime' => NULL,
                'cert_hash_key' => NULL,
                'cert_ref_number' => NULL,
                'in_assessment' => false,
                'approval' => 0,
                'kewpa_remarks' => NULL,
                'kewpa_remarks2' => NULL,
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
                'created_at' => '2021-11-08 11:06:54',
                'updated_at' => '2021-11-08 11:06:54',
            ),
            1 =>
            array (
                'assessment_disposal_id' => 1,
                'category_id' => 1,
                'sub_category_id' => 1,
                'sub_category_type_id' => 4,
                'purchase_dt' => '2014-07-08',
                'company_name' => NULL,
                'lo_no' => NULL,
                'location' => 'LOKASI',
                'original_price' => '135600',
                'aset_regno' => 'ASET 01',
                'nc_no' => 'KOD 01',
                'is_gover' => false,
                'is_move' => true,
                'plate_no' => 'DEL222',
                'engine_no' => '4D56-QAZ301-YIU',
                'chasis_no' => 'JKM001',
                'odometer' => NULL,
                'veh_img_doc' => NULL,
                'evaluation_type' => NULL,
                'vtl_doc' => NULL,
                'vehicle_brand_id' => 86,
                'model_name' => 'M5 1.8',
                'manufacture_year' => 2013,
                'registration_vehicle_dt' => '2014-07-15',
                'mileage_distance' => 0,
                'hours_used' => 0,
                'delivery_service' => 0,
                'earlier_maintenance_cost' => '21900.56',
                'current_maintenance_cost' => '0',
                'current_value' => '0',
                'post_current_value' => '0',
                'post_durability' => 0,
                'estimate_value_after' => '0',
                'manual_depreciation' => 0,
                'app_datetime' => NULL,
                'cert_hash_key' => NULL,
                'cert_ref_number' => NULL,
                'in_assessment' => false,
                'approval' => 0,
                'kewpa_remarks' => NULL,
                'kewpa_remarks2' => NULL,
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
                'created_at' => '2021-11-08 11:07:32',
                'updated_at' => '2021-11-08 11:07:32',
            ),
        ));


    }
}
