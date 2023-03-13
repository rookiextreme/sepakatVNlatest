<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class PatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::statement('update ref_component_checklist_lvl1 set assessment_type_id = 1 where id in (2,3,4,5,6,8,9,10,11,12)');
        DB::statement('update ref_component_checklist_lvl1 set assessment_type_id = 1 where id in (2,3,4,5,6,7,8,9,10,11,131,126,140)');
        DB::statement('update ref_component_checklist_lvl2 set id_component_checklist_lvl1 = null where id in(3,4,5)');
        DB::statement('update ref_component_checklist_lvl1 set assessment_type_id = 2 where id in (104,105,106,107,108,109,110,111,112,113,114)');
        DB::statement('update ref_component_checklist_lvl1 set maintenance_type_id = 3 where id in (121,122,123,124,125,127,128,129,130,132,133,134,135,136,137,138,139,141,142)');

        // --Pelupusan disposal
        DB::statement('update ref_component_checklist_lvl1 set assessment_type_id = 6 where id in '.$this->idInserted().'');
        DB::statement('update ref_component_checklist_lvl1 set has_selection = true where assessment_type_id = 6');

        DB::statement('insert into "ref_component_checklist_lvl1_selection" ( "ref_component_checklist_lvl1_id", "table_selection_id", "selection_id") values ( \'5\', \'4\', \'1\')');
        DB::statement('insert into "ref_component_checklist_lvl1_selection" ( "ref_component_checklist_lvl1_id", "table_selection_id", "selection_id") values ( \'6\', \'5\', \'1\')');
        DB::statement('insert into "ref_component_checklist_lvl1_selection" ( "ref_component_checklist_lvl1_id", "table_selection_id", "selection_id") values ( \'3\', \'6\', \'1\')');

        // --Penilaian baharu
        // DB::statement('insert into "ref_component_checklist_lvl1_selection" ( "ref_component_checklist_lvl1_id", "table_selection_id", "selection_id") values ( \'126\', \'4\', \'1\')');

        // Maintenance Evaluation
        DB::statement('update ref_component_checklist_lvl1 set maintenance_type_id = 1 where id in (2,3,4,5,6,8,9,10,11,12)');

        DB::statement('update ref_component_lvl1 set job_purpose_type_id = 1 where id in (1,2,3,4,5,6,7,8,9,10,11,12,13,14)');
        DB::statement('update ref_component_lvl1 set job_purpose_type_id = 2 where id in (15,16,17,18,19,20,21)');

        DB::statement('CREATE SEQUENCE vehicles.kelas_kenderaan_susut_nilai_kelas_kenderaan_susut_nilai_id_seq
        INCREMENT 1
        START 1
        MINVALUE 1
        MAXVALUE 2147483647
        CACHE 1');

        DB::statement('CREATE SEQUENCE vehicles.kelas_susut_nilai_kelas_susut_nilai_id_seq
            INCREMENT 1
            START 1
            MINVALUE 1
            MAXVALUE 2147483647
            CACHE 1');

        DB::statement('CREATE SEQUENCE vehicles.ref_kelas_susut_nilai_ref_kelas_susut_nilai_id_seq
        INCREMENT 1
        START 1
        MINVALUE 1
        MAXVALUE 2147483647
        CACHE 1');

        DB::statement('ALTER SEQUENCE ref_component_checklist_lvl1_id_seq RESTART WITH 204');
        DB::statement('ALTER SEQUENCE ref_component_checklist_lvl2_id_seq RESTART WITH 263');
        DB::statement('ALTER SEQUENCE ref_component_checklist_lvl3_id_seq RESTART WITH 13');

        DB::statement('ALTER SEQUENCE ref_component_lvl1_id_seq RESTART WITH 21');
        DB::statement('ALTER SEQUENCE ref_component_lvl2_id_seq RESTART WITH 365');

    }

    public function idInserted()
    {
        $bulk_id = '(26,27,32,41,43,44,45,42,25,27,42,53,58,58,56,5,4,55,61,62,63,64,65,66,67,8,69,70,71)';
        return $bulk_id;
    }
}
