<?php

namespace Database\Seeders;

use App\Models\TaskFlow;
use Illuminate\Database\Seeder;

class TaskFlowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [ 
            [
                'code' => '01',
                'name_bm' => 'Kenderaan',
                'is_verify' => true,
                'is_verify_bm' => 'Semak',
                'is_appointment' => false,
                'is_appointment_bm' => '',
                'is_approval' => true,
                'is_approval_bm' => 'Sah',
                'is_pass' => false,
                'is_pass_bm' => '',
                'created_by' => 1
            ],
            [
                'code' => '02',
                'name_bm' => 'Penilaian',
                'is_verify' => true,
                'is_verify_bm' => 'Semak',
                'is_appointment' => true,
                'is_appointment_bm' => 'TemuJanji',
                'is_approval' => true,
                'is_approval_bm' => 'Sah',
                'is_pass' => false,
                'is_pass_bm' => '',
                'created_by' => 1
            ],
            [
                'code' => '03',
                'name_bm' => 'Penyelenggaraan',
                'is_verify' => false,
                'is_verify_bm' => '',
                'is_appointment' => true,
                'is_appointment_bm' => 'TemuJanji',
                'is_approval' => true,
                'is_approval_bm' => 'Sah',
                'is_pass' => false,
                'is_pass_bm' => '',
                'created_by' => 1
            ],
            [
                'code' => '04',
                'name_bm' => 'Logistik',
                'is_verify' => true,
                'is_verify_bm' => 'Semak',
                'is_appointment' => false,
                'is_appointment_bm' => '',
                'is_approval' => true,
                'is_approval_bm' => 'Sah',
                'is_pass' => false,
                'is_pass_bm' => '',
                'created_by' => 1
            ]
        ];

        TaskFlow::insert($data);
    }
}
