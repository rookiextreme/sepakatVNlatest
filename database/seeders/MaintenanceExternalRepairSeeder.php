<?php

namespace Database\Seeders;

use App\Models\Maintenance\MaintenanceExternalRepair;
use Illuminate\Database\Seeder;

class MaintenanceExternalRepairSeeder extends Seeder
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
                'desc' => 'SEGERA / MENDESAK'
            ],
            [
                'code' => '02',
                'desc' => 'TIADA PERALATAN'
            ],
            [
                'code' => '03',
                'desc' => 'LAIN-LAIN'
            ]
        ];

        MaintenanceExternalRepair::insert($data);
    }
}
