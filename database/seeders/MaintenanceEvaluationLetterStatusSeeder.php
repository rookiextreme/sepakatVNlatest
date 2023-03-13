<?php

namespace Database\Seeders;

use App\Models\Maintenance\MaintenanceEvaluationLetterStatus;
use Illuminate\Database\Seeder;

class MaintenanceEvaluationLetterStatusSeeder extends Seeder
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
                'code' => '00',
                'desc' => 'Telah Hapus'
            ],
            [
                'code' => '01',
                'desc' => 'Draf'
            ],
            [
                'code' => '02',
                'desc' => 'Menunggu Semakan'
            ],
            [
                'code' => '03',
                'desc' => 'Menunggu Kelulusan'
            ],
            [
                'code' => '04',
                'desc' => 'Selesai'
            ]
        ];

        MaintenanceEvaluationLetterStatus::insert($data);
    }
}
