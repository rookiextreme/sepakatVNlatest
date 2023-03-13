<?php

namespace Database\Seeders;

use App\Models\Maintenance\MaintenanceJobVehicleStatus;
use App\Models\Maintenance\MaintenanceType;
use Illuminate\Database\Seeder;

class MaintenanceJobVehicleStatusSeeder extends Seeder
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
                'desc' => 'DRAF'
            ],
            [
                'code' => '02',
                'desc' => 'PEMERIKSAAN'
            ],
            [
                'code' => '03',
                'desc' => 'SEMAKAN PEMERIKSAAN'
            ],
            [
                'code' => '04',
                'desc' => 'KAJIAN PASARAN'
            ],
            [
                'code' => '05',
                'desc' => 'SEMAKAN KAJIAN PASARAN'
            ],
            [
                'code' => '06',
                'desc' => 'SAHKAN KAJIAN PASARAN'
            ],
            [
                'code' => '07',
                'desc' => 'BUKAN KAJIAN PASARAN'
            ],
            [
                'code' => '08',
                'desc' => 'JADUAL HARGA'
            ],
            [
                'code' => '09',
                'desc' => 'SEMAKAN JADUAL HARGA'
            ],
            [
                'code' => '10',
                'desc' => 'PENGESAHAN JADUAL HARGA'
            ],
            [
                'code' => '11',
                'desc' => 'PEMBAIKAN SERVIS'
            ],
            [
                'code' => '12',
                'desc' => 'SELESAI PEMBAIKAN SERVIS'
            ]

        ];

        MaintenanceJobVehicleStatus::insert($data);
    }
}
