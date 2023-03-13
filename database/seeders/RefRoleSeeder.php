<?php

namespace Database\Seeders;

use App\Models\RefRole;
use App\Models\RefRoleAccess;
use App\Models\RefWorkshop;
use Illuminate\Database\Seeder;

class RefRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $refRoleAccess01 = RefRoleAccess::where('code', '01')->first();
        $refRoleAccess02 = RefRoleAccess::where('code', '02')->first();
        $refRoleAccess03 = RefRoleAccess::where('code', '03')->first();
        $refRoleAccess04 = RefRoleAccess::where('code', '04')->first();

        $workshop = RefWorkshop::where('code', '01')->first();

        $data = [
            [
                'code' => '01',
                'desc_bm' => 'Pentadbir Sistem',
                'desc_en' => 'Admin',
                'task_desc_bm' => 'Mentadbir operasi sistem SPaKAT',
                'task_desc_en' => '',
                'ref_role_access_id' => $refRoleAccess01->id,
                'workshop_id' => $workshop->id
            ],
            [
                'code' => '02',
                'desc_bm' => 'Pengurusan',
                'desc_en' => 'Business',
                'task_desc_bm' => 'Mempunyai akses kepada laman bisnes yang mengandungi dashboard',
                'task_desc_en' => '',
                'ref_role_access_id' => $refRoleAccess02->id,
                'workshop_id' => $workshop->id
            ],
            [
                'code' => '03',
                'desc_bm' => 'Jurutera',
                'desc_en' => 'Engineer',
                'task_desc_bm' => 'Meluluskan / mengesahkan maklumat yang dimasukkan secara terus',
                'task_desc_en' => '',
                'ref_role_access_id' => $refRoleAccess03->id,
                'workshop_id' => $workshop->id
            ],
            [
                'code' => '04',
                'desc_bm' => 'Penolong Jurutera',
                'desc_en' => 'Assistant Engineer',
                'task_desc_bm' => 'Bertanggungjawab mengesahkan maklumat-maklumat kenderaan',
                'task_desc_en' => '',
                'ref_role_access_id' => $refRoleAccess03->id,
                'workshop_id' => $workshop->id
            ],
            [
                'code' => '05',
                'desc_bm' => 'Orang Awam',
                'desc_en' => 'Public',
                'task_desc_bm' => 'Kakitangan yang mengisi maklumat penilaian dan senggaraan',
                'task_desc_en' => '',
                'ref_role_access_id' => $refRoleAccess04->id,
                'workshop_id' => $workshop->id
            ],
            [
                'code' => '06',
                'desc_bm' => 'Pemandu',
                'desc_en' => 'Driver',
                'task_desc_bm' => 'Pemandu kakitangan',
                'task_desc_en' => '',
                'ref_role_access_id' => $refRoleAccess04->id,
                'workshop_id' => $workshop->id
            ],
            [
                'code' => '07',
                'desc_bm' => 'Pembantu Kemahiran Penilaian',
                'desc_en' => 'Technical Assistant',
                'task_desc_bm' => 'Kakitangan yang berkemahiran melakukan kerja-kerja di woksyop',
                'task_desc_en' => '',
                'ref_role_access_id' => $refRoleAccess03->id,
                'workshop_id' => $workshop->id
            ],
            [
                'code' => '08',
                'desc_bm' => 'Pembantu Kemahiran Penyenggaraan',
                'desc_en' => 'Technical Assistant',
                'task_desc_bm' => 'Kakitangan yang berkemahiran melakukan kerja-kerja di woksyop',
                'task_desc_en' => '',
                'ref_role_access_id' => $refRoleAccess03->id,
                'workshop_id' => $workshop->id
            ],
            [
                'code' => '09',
                'desc_bm' => 'Jurutera Kanan',
                'desc_en' => 'Head Engineer',
                'task_desc_bm' => 'Meluluskan / mengesahkan maklumat yang dimasukkan secara terus',
                'task_desc_en' => '',
                'ref_role_access_id' => $refRoleAccess03->id,
                'workshop_id' => $workshop->id
            ],
            [
                'code' => '10',
                'desc_bm' => 'Jurutera Kanan Penyenggaraan',
                'desc_en' => 'Senior Engineer (Maintenance)',
                'task_desc_bm' => 'Meluluskan / mengesahkan maklumat penyenggaraan yang dimasukkan secara terus',
                'task_desc_en' => '',
                'ref_role_access_id' => $refRoleAccess03->id,
                'workshop_id' => $workshop->id
            ],
            [
                'code' => '11',
                'desc_bm' => 'Jurutera Penyenggaraan',
                'desc_en' => 'Engineer (Maintenance)',
                'task_desc_bm' => 'Meluluskan / mengesahkan maklumat penyenggaraan yang dimasukkan secara terus',
                'task_desc_en' => '',
                'ref_role_access_id' => $refRoleAccess03->id,
                'workshop_id' => $workshop->id
            ],
            [
                'code' => '12',
                'desc_bm' => 'Penolong Jurutera Penyenggaraan',
                'desc_en' => 'Assisstant Engineer (Maintenance)',
                'task_desc_bm' => 'Bertanggungjawab mengesahkan maklumat-maklumat penyenggaraan',
                'task_desc_en' => '',
                'ref_role_access_id' => $refRoleAccess03->id,
                'workshop_id' => $workshop->id
            ],
            [
                'code' => '13',
                'desc_bm' => 'Jurutera Kanan Penilaian',
                'desc_en' => 'Senior Engineer (Inspection)',
                'task_desc_bm' => 'Meluluskan / mengesahkan maklumat penilaian yang dimasukkan secara terus',
                'task_desc_en' => '',
                'ref_role_access_id' => $refRoleAccess03->id,
                'workshop_id' => $workshop->id
            ],
            [
                'code' => '14',
                'desc_bm' => 'Jurutera Penilaian',
                'desc_en' => 'Engineer (Inspection)',
                'task_desc_bm' => 'Bertanggungjawab mengesahkan maklumat-maklumat penilaian',
                'task_desc_en' => '',
                'ref_role_access_id' => $refRoleAccess03->id,
                'workshop_id' => $workshop->id
            ],
            [
                'code' => '15',
                'desc_bm' => 'Penolong Jurutera Penilaian',
                'desc_en' => 'Assisstant Engineer (Inspection)',
                'task_desc_bm' => 'Bertanggungjawab menyemak maklumat-maklumat penilaian',
                'task_desc_en' => '',
                'ref_role_access_id' => $refRoleAccess03->id,
                'workshop_id' => $workshop->id
            ]

        ];

        RefRole::insert($data);
    }
}
