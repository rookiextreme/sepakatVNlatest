<?php

namespace Database\Seeders;

use App\Models\RefEngineCoolerType;
use Illuminate\Database\Seeder;

class RefEngineCoolerTypeSeeder extends Seeder
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
                'desc' => 'AIR'
            ],
            [
                'code' => '02',
                'desc' => 'UDARA'
            ]
        ];

        RefEngineCoolerType::insert($data);
    }
}
