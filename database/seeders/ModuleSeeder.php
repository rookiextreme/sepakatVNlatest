<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
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
                'name_bm' => 'Kenderaan',
                'created_by' => 1
            ],
            [
                'code' => '02',
                'name_bm' => 'Penilaian',
                'created_by' => 1
            ],
            [
                'code' => '03',
                'name_bm' => 'Penyelenggaraan',
                'created_by' => 1
            ],
            [
                'code' => '04',
                'name_bm' => 'Logistik',
                'created_by' => 1
            ],
            [
                'code' => '05',
                'name_bm' => 'Akses',
                'created_by' => 1
            ]
        ];

        Module::insert($data);
    }
}
