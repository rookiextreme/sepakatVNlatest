<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\ModuleSub;
use Illuminate\Database\Seeder;

class ModuleSubSeeder extends Seeder
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
                'module_id' => Module::where('code', '01')->first()->id,
                'code' => '01',
                'name_bm' => 'Rekod Kenderaan',
                'created_by' => 1
            ],
            [
                'module_id' => Module::where('code', '01')->first()->id,
                'code' => '02',
                'name_bm' => 'Rekod Saman',
                'created_by' => 1
            ],
            [
                'module_id' => Module::where('code', '01')->first()->id,
                'code' => '03',
                'name_bm' => 'Laporan dan Statistik',
                'created_by' => 1
            ],

            [
                'module_id' => Module::where('code', '02')->first()->id,
                'code' => '01',
                'name_bm' => 'Kenderaan Baharu',
                'created_by' => 1
            ],
            [
                'module_id' => Module::where('code', '02')->first()->id,
                'code' => '02',
                'name_bm' => 'Keselamatan dan Prestasi',
                'created_by' => 1
            ],
            [
                'module_id' => Module::where('code', '02')->first()->id,
                'code' => '03',
                'name_bm' => 'Nilai Semasa',
                'created_by' => 1
            ],
            [
                'module_id' => Module::where('code', '02')->first()->id,
                'code' => '04',
                'name_bm' => 'Kemalangan',
                'created_by' => 1
            ],
            [
                'module_id' => Module::where('code', '02')->first()->id,
                'code' => '05',
                'name_bm' => 'Pelupusan',
                'created_by' => 1
            ],
            [
                'module_id' => Module::where('code', '02')->first()->id,
                'code' => '06',
                'name_bm' => 'Pinjaman Kerajaan',
                'created_by' => 1
            ],
            [
                'module_id' => Module::where('code', '02')->first()->id,
                'code' => '07',
                'name_bm' => 'Laporan dan Statistik',
                'created_by' => 1
            ],

            [
                'module_id' => Module::where('code', '03')->first()->id,
                'code' => '01',
                'name_bm' => 'Pengagihan Waran',
                'created_by' => 1
            ],
            [
                'module_id' => Module::where('code', '03')->first()->id,
                'code' => '02',
                'name_bm' => 'Penyenggaran',
                'created_by' => 1
            ],
            [
                'module_id' => Module::where('code', '03')->first()->id,
                'code' => '03',
                'name_bm' => 'Laporan dan Statistik',
                'created_by' => 1
            ],

            [
                'module_id' => Module::where('code', '04')->first()->id,
                'code' => '01',
                'name_bm' => 'Tempahan Kenderaan',
                'created_by' => 1
            ],
            [
                'module_id' => Module::where('code', '04')->first()->id,
                'code' => '02',
                'name_bm' => 'Siap Siaga Bencana',
                'created_by' => 1
            ],
            [
                'module_id' => Module::where('code', '04')->first()->id,
                'code' => '03',
                'name_bm' => 'Laporan dan Statistik',
                'created_by' => 1
            ],

            [
                'module_id' => Module::where('code', '05')->first()->id,
                'code' => '01',
                'name_bm' => 'Pengguna Berdaftar',
                'created_by' => 1
            ]

        ];

        ModuleSub::insert($data);
    }
}
