<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class WaranTypeSeeder extends Seeder
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
                'desc' => 'MHPV'
            ],
            [
                'code' => '02',
                'desc' => 'KKR'
            ],
            [
                'code' => '03',
                'desc' => 'AGENSI LUAR'
            ]
        ];

        \App\Models\Maintenance\WaranType::insert($data);
    }
}
