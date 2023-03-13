<?php

namespace Database\Seeders;

use App\Models\RefEngineFuelType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RefEngineFuelTypeSeeder extends Seeder
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
                'desc' => 'PETROL'
            ],
            [
                'code' => '02',
                'desc' => 'DIESEL'
            ],
            [
                'code' => '03',
                'desc' => 'DIESEL HIJAU',
            ],
            [
                'code' => '04',
                'desc' => 'BIO DIESEL',
            ],
            [
                'code' => '05',
                'desc' => 'ELEKTRIK (EV)',
            ],
            [
                'code' => '06',
                'desc' => 'HYBRID',
            ],
            [
                'code' => '07',
                'desc' => 'NGV',
            ],
            [
                'code' => '08',
                'desc' => 'LAIN-LAIN',
            ]
        ];
        DB::table('ref_engine_fuel_type')->delete();
        RefEngineFuelType::insert($data);
    }
}
