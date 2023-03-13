<?php

namespace Database\Seeders;

use App\Models\RefTransmissionType;
use Illuminate\Database\Seeder;

class RefTransmissionTypeSeeder extends Seeder
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
                'desc' => 'MANUAL'
            ],
            [
                'code' => '02',
                'desc' => 'AUTOMATIK'
            ]
        ];

        RefTransmissionType::insert($data);
    }
}
