<?php

namespace Database\Seeders;

use App\Models\RefRecheckType;
use Illuminate\Database\Seeder;

class RefRecheckTypeSeeder extends Seeder
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
                'desc' => 'KUANTITI'
            ],
            [
                'code' => '02',
                'desc' => 'PARAS'
            ],
            [
                'code' => '03',
                'desc' => 'BACAAN'
            ]
        ];

        RefRecheckType::insert($data);
    }
}
