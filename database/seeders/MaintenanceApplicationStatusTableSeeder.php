<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaintenanceApplicationStatusTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        DB::connection('pgsql_maintenance')->table('application_status')->delete();

        DB::connection('pgsql_maintenance')->table('application_status')->insert(array (
            0 =>
            array (
                'code' => '00',
                'desc' => 'Telah Hapus',
                'created_at' => Carbon::now()
            ),
            1 =>
            array (
                'code' => '01',
                'desc' => 'Draf',
                'created_at' => Carbon::now()
            ),
            2 =>
            array (
                'code' => '02',
                'desc' => 'Menunggu Temujanji',
                'created_at' => Carbon::now()
            ),
            3 =>
            array (
                'code' => '03',
                'desc' => 'Menunggu Pemeriksaan',
                'created_at' => Carbon::now()
            ),
            4 =>
            array (
                'code' => '04',
                'desc' => 'Menunggu Semakan',
                'created_at' => Carbon::now()
            ),
            5 =>
            array (
                'code' => '05',
                'desc' => 'Menunggu Pengesahan',
                'created_at' => Carbon::now()
            ),
            6 =>
            array (
                'code' => '06',
                'desc' => 'Di Tolak',
                'created_at' => Carbon::now()
            ),
            7 =>
            array (
                'code' => '07',
                'desc' => 'Tidak Lengkap',
                'created_at' => Carbon::now()
            ),
            8 =>
            array (
                'code' => '08',
                'desc' => 'Selesai',
                'created_at' => Carbon::now()
            ),
            9 =>
            array (
                'code' => '09',
                'desc' => 'Menunggu Hasil Pemeriksaan',
                'created_at' => Carbon::now()
            ),
            10 =>
            array (
                'code' => '10',
                'desc' => 'Hasil Pemeriksaan Selesai',
                'created_at' => Carbon::now()
            ),
            11 =>
            array (
                'code' => '11',
                'desc' => 'Janaan Perihal Kerosakan',
                'created_at' => Carbon::now()
            ),
        ));

    }
}
