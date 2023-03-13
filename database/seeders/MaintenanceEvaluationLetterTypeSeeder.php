<?php

namespace Database\Seeders;

use App\Models\Maintenance\MaintenanceEvaluationLetterType;
use Illuminate\Database\Seeder;

class MaintenanceEvaluationLetterTypeSeeder extends Seeder
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
                'desc' => 'Dengan Anggaran' 
            ],
            [
                'code' => '02',
                'desc' => 'VIP' 
            ],
            [
                'code' => '03',
                'desc' => 'Pengesahan Kerosakan' 
            ],
            [
                'code' => '04',
                'desc' => 'Alat Ganti Tiruan' 
            ],
            [
                'code' => '05',
                'desc' => 'Tiada Kerosakan' 
            ],
        ];

        MaintenanceEvaluationLetterType::insert($data);
    }
}
