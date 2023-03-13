<?php

namespace Database\Seeders;

use App\Models\RefSteeringType;
use Illuminate\Database\Seeder;

class RefSteeringTypeSeeder extends Seeder
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
                'desc' => 'POWER STEERING'
            ]
        ];

        RefSteeringType::insert($data);
    }
}
