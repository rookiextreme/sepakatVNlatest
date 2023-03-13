<?php

namespace Database\Seeders;

use App\Models\RefSelection;
use Illuminate\Database\Seeder;

class RefSelectionSeeder extends Seeder
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
                'desc' => 'Drop Down'
            ],
            [
                'code' => '02',
                'desc' => 'Check Box'
            ],
            [
                'code' => '03',
                'desc' => 'Radio'
            ]
        ];

        RefSelection::insert($data);
    }
}
