<?php

namespace Database\Seeders;

use App\Models\Maintenance\MaintenanceJobVehicleMaintenanceStatus;
use App\Models\Maintenance\MaintenanceJobVehicleStatus;
use App\Models\Maintenance\MaintenanceType;
use Illuminate\Database\Seeder;

class MaintenanceJobVehicleMaintenanceStatusSeeder extends Seeder
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
                'desc' => 'DRAF PEMBAIKAN / SERVIS DALAMAN'
            ],
            [
                'code' => '02',
                'desc' => 'SEMAKAN PEMBAIKAN / SERVIS DALAMAN'
            ],
            [
                'code' => '03',
                'desc' => 'SELESAI PEMBAIKAN / SERVIS DALAMAN'
            ],
            [
                'code' => '04',
                'desc' => 'DRAF PEMBAIKAN / SERVIS LUARAN'
            ],
            [
                'code' => '05',
                'desc' => 'SEMAKAN PEMBAIKAN / SERVIS LUARAN'
            ],
            [
                'code' => '06',
                'desc' => 'SELESAI PEMBAIKAN / SERVIS LUARAN'
            ],
            [
                'code' => '07',
                'desc' => 'PEMBAIKAN / SERVIS DALAMAN SEDANG BERJALAN'
            ],
            [
                'code' => '08',
                'desc' => 'PEMBAIKAN / SERVIS LUARAN SEDANG BERJALAN'
            ],

        ];

        MaintenanceJobVehicleMaintenanceStatus::insert($data);
    }
}
