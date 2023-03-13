<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaintenanceVehicleStatusTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::connection('pgsql_maintenance')->table('vehicle_status')->delete();

        DB::connection('pgsql_maintenance')->table('vehicle_status')->insert(array (
            0 =>
            array (
                'code' => '00',
                'desc' => 'Telah Hapus',
                'created_at' => Carbon::now()
            ),
            1 =>
            array(
                'code' => '01',
                'desc' => 'Draf',
                'created_at' => Carbon::now()
            ),
            2 =>
            array(
                'code' => '02',
                'desc' => 'Menunggu Penilaian',
                'created_at' => Carbon::now()
            ),
            3 =>
            array(
                'code' => '03',
                'desc' => 'Menunggu Kelulusan',
                'created_at' => Carbon::now()
            ),
            4 =>
            array(
                'code' => '04',
                'desc' => 'Lulus',
                'created_at' => Carbon::now()
            ),
            5 =>
            array(
                'code' => '05',
                'desc' => 'Gagal',
                'created_at' => Carbon::now()
            ),
            6 =>
            array(
                'code' => '06',
                'desc' => 'Penilaian Sedang Berjalan',
                'created_at' => Carbon::now()
            ),
            7 =>
            array(
                'code' => '07',
                'desc' => 'Menunggu Semakan Pengujian',
                'created_at' => Carbon::now()
            ),
            8 =>
            array(
                'code' => '08',
                'desc' => 'Pengujian Selesai',
                'created_at' => Carbon::now()
            ),
        ));

    }
}
