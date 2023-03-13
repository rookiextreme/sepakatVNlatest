<?php

namespace Database\Seeders;

use App\Models\RefEngineType;
use Illuminate\Database\Seeder;

class RefEngineTypeSeeder extends Seeder
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
                'desc' => '(4) LEJANG)'
            ],
            [
                'code' => '02',
                'desc' => '(4) SILINDER)'
            ]
        ];

        RefEngineType::insert($data);
    }
}
