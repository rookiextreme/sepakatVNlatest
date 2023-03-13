<?php

namespace Database\Seeders;

use App\Models\RefTableSelection;
use Illuminate\Database\Seeder;

class RefTableSelectionSeeder extends Seeder
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
                'desc' => 'Jenis Enjin',
                'model' => 'RefEngineType',
                'table' => 'ref_engine_type'
            ],
            [
                'code' => '02',
                'desc' => 'Bahanapi',
                'model' => 'RefEngineFuelType',
                'table' => 'ref_engine_fuel_type'
            ],
            [
                'code' => '03',
                'desc' => 'Sistem Penyejukan',
                'model' => 'RefEngineCoolerType',
                'table' => 'ref_engine_cooler_type'
            ],
            [
                'code' => '04',
                'desc' => 'Steering',
                'model' => 'RefSteeringType',
                'table' => 'ref_steering_type'
            ],
            [
                'code' => '05',
                'desc' => 'Suspension',
                'model' => 'RefSuspensionType',
                'table' => 'ref_suspension_type'
            ],
            [
                'code' => '06',
                'desc' => 'Transmission',
                'model' => 'RefTransmissionType',
                'table' => 'ref_transmission_type'
            ],
            [
                'code' => '07',
                'desc' => 'Semakan Semula',
                'model' => 'RefRecheckType',
                'table' => 'ref_recheck_type'
            ]
        ];

        RefTableSelection::insert($data);
    }
}
