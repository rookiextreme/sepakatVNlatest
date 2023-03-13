<?php

namespace Database\Seeders;

use App\Models\LogisticStayStatus;
use Illuminate\Database\Seeder;

class LogisticStayStatusSeeder extends Seeder
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
                'desc' => 'Ulang alik'
            ],
            [
                'code' => '02',
                'desc' => 'Bermalam'
            ]
        ];

        LogisticStayStatus::insert($data);
    }
}
