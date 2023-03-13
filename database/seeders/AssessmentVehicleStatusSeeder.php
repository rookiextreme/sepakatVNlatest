<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssessmentVehicleStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('assessment.assessment_vehicle_status')->delete();
        DB::table('assessment.assessment_vehicle_status')->insert([
            [
                'code' => '00',
                'desc' => 'Telah Hapus',
                'created_at' => Carbon::now()
            ],
            [
                'code' => '01',
                'desc' => 'Draf',
                'created_at' => Carbon::now()
            ],
            [
                'code' => '02',
                'desc' => 'Temujanji',
                'created_at' => Carbon::now()
            ],
            [
                'code' => '03',
                'desc' => 'Penilaian',
                'created_at' => Carbon::now()
            ],
            [
                'code' => '04',
                'desc' => 'Semakan',
                'created_at' => Carbon::now()
            ],
            [
                'code' => '05',
                'desc' => 'Kelulusan',
                'created_at' => Carbon::now()
            ],
            [
                'code' => '06',
                'desc' => 'Selesai',
                'created_at' => Carbon::now()
            ],
        ]);
    }
}
