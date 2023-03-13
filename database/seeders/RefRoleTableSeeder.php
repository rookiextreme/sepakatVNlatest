<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RefRoleTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        #/DB::table('ref_role')->delete();
        DB::table('ref_role')->delete();

        #DB::table('ref_role')->insert(array (
        DB::table('ref_role')->insert(array (
            0 =>
            array (
                'id' => 1,
                'code' => '01',
                'desc_bm' => 'Pentadbir Sistem',
                'desc_en' => 'Admin',
                'task_desc_bm' => 'Mentadbir operasi sistem SPaKAT',
                'task_desc_en' => '',
                'can_delete' => false,
                'ref_role_access_id' => 1,
                'workshop_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 =>
            array (
                'id' => 2,
                'code' => '02',
                'desc_bm' => 'Pengurusan',
                'desc_en' => 'Business',
                'task_desc_bm' => 'Mempunyai akses kepada laman bisnes yang mengandungi dashboard',
                'task_desc_en' => '',
                'can_delete' => false,
                'ref_role_access_id' => 2,
                'workshop_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 =>
            array (
                'id' => 3,
                'code' => '03',
                'desc_bm' => 'Jurutera',
                'desc_en' => 'Engineer',
                'task_desc_bm' => 'Meluluskan / mengesahkan maklumat yang dimasukkan secara terus',
                'task_desc_en' => '',
                'can_delete' => false,
                'ref_role_access_id' => 3,
                'workshop_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 =>
            array (
                'id' => 4,
                'code' => '04',
                'desc_bm' => 'Penolong Jurutera',
                'desc_en' => 'Assistant Engineer',
                'task_desc_bm' => 'Bertanggungjawab mengesahkan maklumat-maklumat kenderaan',
                'task_desc_en' => '',
                'can_delete' => false,
                'ref_role_access_id' => 3,
                'workshop_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 =>
            array (
                'id' => 5,
                'code' => '05',
                'desc_bm' => 'Orang Awam',
                'desc_en' => 'Public',
                'task_desc_bm' => 'Kakitangan yang mengisi maklumat penilaian dan senggaraan',
                'task_desc_en' => '',
                'can_delete' => false,
                'ref_role_access_id' => 4,
                'workshop_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 =>
            array (
                'id' => 6,
                'code' => '06',
                'desc_bm' => 'Pemandu',
                'desc_en' => 'Driver',
                'task_desc_bm' => 'Pemandu kakitangan',
                'task_desc_en' => '',
                'can_delete' => false,
                'ref_role_access_id' => 4,
                'workshop_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 =>
            array (
                'id' => 7,
                'code' => '07',
                'desc_bm' => 'Pembantu Kemahiran',
                'desc_en' => 'Technical Assistant',
                'task_desc_bm' => 'Kakitangan yang berkemahiran melakukan kerja-kerja di woksyop',
                'task_desc_en' => '',
                'can_delete' => false,
                'ref_role_access_id' => 3,
                'workshop_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));


    }
}
