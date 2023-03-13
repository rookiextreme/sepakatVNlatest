<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class InspectionTypeSeeder extends Seeder
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
                'desc' => 'TERDAPAT KEROSAKAN BERULANG'
            ],
            [
                'code' => '02',
                'desc' => 'TERDAPAT KEROSAKAN YANG LAIN'
            ],
            [
                'code' => '03',
                'desc' => 'TIADA KEROSAKAN BERULANG'
            ]
        ];

        \App\Models\Maintenance\MaintenanceInspectionType::insert($data);
    }
}
