<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaintenanceEvaluationTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::connection('pgsql_maintenance')->table('evaluation')->delete();

        DB::connection('pgsql_maintenance')->table('evaluation')->insert(array (
            0 =>
            array (
                'ref_number' => 'NNA010001',
                'applicant_name' => 'ADMINISTRATOR',
                'phone_no' => '0147897891',
                'email' => 'admin@spakat.com',
                'address' => 'TAMARIND SQUARE',
                'postcode' => '45050',
                'state_id' => 12,
                'department_name' => 'JKR',
                'hod_name' => 'PENGARAH',
                'appointment_dt1' => '2021-09-23 04:45:00',
                'appointment_dt2' => NULL,
                'appointment_dt3' => NULL,
                'appointment_dt' => NULL,
                'is_other_app_dt' => false,
                'agency_id' => 4,
                'workshop_id' => 12,
                'app_status_id' => 2,
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2021-09-03 12:45:14',
                'updated_at' => '2021-09-03 12:45:14',
            ),
        ));


    }
}
