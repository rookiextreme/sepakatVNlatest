<?php

namespace Database\Seeders;

use App\Models\RefSummonAgency;
use Illuminate\Database\Seeder;

class RefSummonAgencySeeder extends Seeder
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
                'desc' => 'PDRM'
            ],
            [
                'code' => '02',
                'desc' => 'JPJ'
            ],
            [
                'code' => '03',
                'desc' => 'PBT'
            ]
        ];

        RefSummonAgency::insert($data);
    }
}
