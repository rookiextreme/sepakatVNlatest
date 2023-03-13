<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AssessmentSafetyTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('assessment.assessment_safety')->delete();

        \DB::table('assessment.assessment_safety')->insert(array (
            0 =>
            array (
                'ref_number' => 'NSAW10001',
                'applicant_name' => 'ADNAN MUSTAFA BIN AHMAD ALBAB',
                'phone_no' => '0147897891',
                'ic_no' => NULL,
                'email' => 'muhdamin1997.ma@gmail.com',
                'address' => 'IPPM KAJANG',
                'postcode' => '47100',
                'state_id' => 12,
                'department_name' => 'IBU PEJABAT POLIS MALAYSIA',
                'hod_title' => 'PENGARAH',
                'appointment_dt1' => '2021-11-19 12:00:00',
                'appointment_dt2' => NULL,
                'appointment_dt3' => NULL,
                'appointment_dt' => NULL,
                'is_other_app_dt' => false,
                'ttl_draf' => 2,
                'ttl_appointment' => 0,
                'ttl_assess' => 0,
                'ttl_evaluate' => 0,
                'ttl_approve' => 0,
                'ttl_complete' => 0,
                'ttl_vehicle' => 2,
                'agency_id' => 4,
                'workshop_id' => 1,
                'app_status_id' => 2,
                'created_by' => 15,
                'updated_by' => NULL,
                'is_migrate' => false,
                'created_at' => '2021-11-08 10:59:05',
                'updated_at' => '2021-11-08 11:00:04',
            ),
        ));


    }
}
