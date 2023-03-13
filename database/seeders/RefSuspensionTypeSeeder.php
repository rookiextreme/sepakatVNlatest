<?php

namespace Database\Seeders;

use App\Models\RefSuspensionType;
use Illuminate\Database\Seeder;

class RefSuspensionTypeSeeder extends Seeder
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
                'desc' => 'LEAF SPRING'
            ],
            [
                'code' => '02',
                'desc' => 'COIL SPRING'
            ],
            [
                'code' => '03',
                'desc' => 'AIR SUSPENSION'
            ]
        ];

        RefSuspensionType::insert($data);
    }
}
