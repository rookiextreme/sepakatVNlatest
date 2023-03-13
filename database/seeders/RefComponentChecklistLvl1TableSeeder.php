<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RefComponentChecklistLvl1TableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        // DB::table('ref_component_checklist_lvl1')->delete();

        DB::table('ref_component_checklist_lvl1')->insert(array (
            0 =>
            array (
                'id' => 202,
                'code' => '202',
            'component' => 'PEMERIKSAAN KESELAMATAN & PRESTASI (PENGUJIAN)',
            'component_shortname' => 'KESELAMATAN & PRESTASI (PENGUJIAN)',
                'status' => 1,
                'has_selection' => false,
                'has_upload' => false,
                'assessment_type_id' => NULL,
                'maintenance_type_id' => NULL,
                'created_by' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 =>
            array (
                'id' => 203,
                'code' => '203',
            'component' => 'PEMERIKSAAN KESELAMATAN & PRESTASI (FIZIKAL)',
            'component_shortname' => 'KESELAMATAN & PRESTASI (FIZIKAL)',
                'status' => 1,
                'has_selection' => false,
                'has_upload' => false,
                'assessment_type_id' => NULL,
                'maintenance_type_id' => NULL,
                'created_by' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 =>
            array (
                'id' => 204,
                'code' => '204',
            'component' => 'BUTIR PEMERIKSAAN',
            'component_shortname' => 'BUTIR PEMERIKSAAN',
                'status' => 1,
                'has_selection' => false,
                'has_upload' => true,
                'assessment_type_id' => 2,
                'maintenance_type_id' => NULL,
                'created_by' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));


    }
}
