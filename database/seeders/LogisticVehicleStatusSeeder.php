<?php

namespace Database\Seeders;

use App\Models\LogisticVehicleStatus;
use Illuminate\Database\Seeder;

class LogisticVehicleStatusSeeder extends Seeder
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
                'name' => 'Telah Hapus'
            ],
            [
                'code' => '01',
                'name' => 'Draf'
            ],
            [
                'code' => '02',
                'name' => 'Mulakan Tugasan'
            ],
            [
                'code' => '03',
                'name' => 'Kemaskini Tugasan'
            ],
            [
                'code' => '04',
                'name' => 'Tugasan Selesai'
            ]
        ];

        LogisticVehicleStatus::insert($data);
    }
}
