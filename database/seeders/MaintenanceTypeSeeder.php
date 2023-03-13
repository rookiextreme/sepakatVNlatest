<?php

namespace Database\Seeders;

use App\Models\Maintenance\MaintenanceType;
use Illuminate\Database\Seeder;

class MaintenanceTypeSeeder extends Seeder
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
                'desc' => 'PEMERIKSAAN'
            ],
            [
                'code' => '02',
                'desc' => 'SERVIS DAN PEMBAIKAN'
            ],
            [
                'code' => '03',
                'desc' => 'PEMERIKSAAN LOJI / JENTERA'
            ]

        ];

        MaintenanceType::insert($data);
    }
}
