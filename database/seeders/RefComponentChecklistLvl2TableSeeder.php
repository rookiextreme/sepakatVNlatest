<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RefComponentChecklistLvl2TableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        // DB::table('ref_component_checklist_lvl2')->delete();

        DB::table('ref_component_checklist_lvl2')->insert(array (
            0 =>
            array (
                'id' => 204,
                'code' => '2044',
                'id_component_checklist_lvl1' => 204,
                'component' => 'Pemeriksaan Lampu dan Indikator',
                'status' => 1,
                'created_by' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            1 =>
            array (
                'id' => 205,
                'code' => '2045',
                'id_component_checklist_lvl1' => 204,
                'component' => 'Pemeriksaan Meter Laju',
                'status' => 1,
                'created_by' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            2 =>
            array (
                'id' => 206,
                'code' => '2046',
                'id_component_checklist_lvl1' => 204,
                'component' => 'Pemeriksaan Sistem Gantungan',
                'status' => 1,
                'created_by' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            3 =>
            array (
                'id' => 207,
                'code' => '2047',
                'id_component_checklist_lvl1' => 204,
                'component' => 'Pemeriksaan Gelincir Sisi',
                'status' => 1,
                'created_by' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            4 =>
            array (
                'id' => 208,
                'code' => '2048',
                'id_component_checklist_lvl1' => 204,
                'component' => 'Pemeriksaan Brek',
                'status' => 1,
                'created_by' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            204 =>
            array (
                'id' => 209,
                'code' => '2049',
                'id_component_checklist_lvl1' => 204,
                'component' => 'Pemeriksaan Asap',
                'status' => 1,
                'created_by' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),

        ));


    }
}
