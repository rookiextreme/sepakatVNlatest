<?php

namespace Database\Seeders;

use App\Models\Maintenance\WaranType;
use Illuminate\Database\Seeder;

class OsolTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $warrantMHPV = WaranType::where('code', '01')->first();
        $data = [
            [
                'warrant_type_id' => $warrantMHPV->id,
                'code' => '01',
                'value' => 26000,
                'desc' => 'MHPV (OSOL 26000)'
            ],
            [
                'warrant_type_id' => $warrantMHPV->id,
                'code' => '02',
                'value' => 28000,
                'desc' => 'MHPV (OSOL 28000)'
            ]
        ];

        \App\Models\Maintenance\OsolType::insert($data);
    }
}
