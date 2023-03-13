<?php

namespace Database\Seeders;

use App\Models\RefDisposal;
use App\Models\RefEvent;
use Illuminate\Database\Seeder;

class RefDisposalSeeder extends Seeder
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
            'desc' => 'Sebut Harga'
        ],
        [
            'code' => '02',
            'desc' => 'Jualan Sisa'
        ],
        [
            'code' => '03',
            'desc' => 'Hadiah'
        ],
        [
            'code' => '04',
            'desc' => 'Lelong'
        ]
        ];

        RefDisposal::insert($data);
    }
}
