<?php

namespace Database\Seeders;

use App\Models\Maintenance\MaintenanceRepairMethod;
use Illuminate\Database\Seeder;

class MaintenanceRepairMethodSeeder extends Seeder
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
                'desc' => 'SECARA DALAMAN'
            ],
            [
                'code' => '02',
                'desc' => 'SECARA LUARAN'
            ]
        ];

        MaintenanceRepairMethod::insert($data);
    }
}
