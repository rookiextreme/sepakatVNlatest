<?php

namespace Database\Seeders;

use App\Models\RefFleetStatus;
use App\Models\RefVehicleStatus;
use Illuminate\Database\Seeder;

class RefVehicleStatusSeeder extends Seeder
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
            'desc' => 'Aktif'
        ],
        [
            'code' => '02',
            'desc' => 'Rosak'
        ],
        [
            'code' => '03',
            'desc' => 'PEP'
        ],
        [
            'code' => '04',
            'desc' => 'Lupus'
        ]
        ];
        for ($i=0; $i <count($data); $i++) {
            $data[$i]['desc'] = strtoupper($data[$i]['desc']);
            RefVehicleStatus::create($data[$i]);
        }
    }
}
