<?php

namespace Database\Seeders;

use App\Models\RefTableType;
use Illuminate\Database\Seeder;

class RefTableTypeSeeder extends Seeder
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
                'desc' => 'Fleet Department'
            ],
            [
                'code' => '02',
                'desc' => 'Fleet Public'
            ],
            [
                'code' => '03',
                'desc' => 'Fleet Disposal'
            ]
        ];

        RefTableType::insert($data);
    }
}
