<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MaintenanceJobPurposeTypeSeeder extends Seeder
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
                'desc' => 'PEMBAIKAN'
            ],
            [
                'code' => '02',
                'desc' => 'SERVIS (PENCEGAHAN)'
            ]
        ];

        \App\Models\Maintenance\MaintenanceJobPurposeType::insert($data);
    }
}
