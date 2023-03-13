<?php

namespace Database\Seeders;

use App\Models\RefSummonType;
use Illuminate\Database\Seeder;

class RefSummonTypeSeeder extends Seeder
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
                'desc' => 'Trafik'
            ],
            [
                'code' => '02',
                'desc' => 'Parkir'
            ]
        ];

        RefSummonType::insert($data);
    }
}
