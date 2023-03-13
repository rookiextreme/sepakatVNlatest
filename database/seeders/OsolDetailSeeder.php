<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OsolDetailSeeder extends Seeder
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
                'osol' => '26000'
            ],
            [
                'osol' => '28000'
            ]
        ];

        \App\Models\Maintenance\OsolDetail::insert($data);
    }
}
