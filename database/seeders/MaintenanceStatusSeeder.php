<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MaintenanceStatusSeeder extends Seeder
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
                'code' => '00',
                'desc' => 'Telah Hapus'
            ],
            [
                'code' => '01',
                'desc' => 'Draf'
            ],
            [
                'code' => '02',
                'desc' => 'Menunggu Temujanji'
            ],
            [
                'code' => '03',
                'desc' => 'Menunggu Pemeriksaan'
            ],
            [
                'code' => '03',
                'desc' => 'Menunggu Pengujian'
            ],
            [
                'code' => '04',
                'desc' => 'Menunggu Pengesahan'
            ],
            [
                'code' => '05',
                'desc' => 'Di Tolak'
            ],
            [
                'code' => '06',
                'desc' => 'Tidak Lengkap'
            ],
            [
                'code' => '07',
                'desc' => 'Selesai'
            ]
        ];

        \App\Models\Maintenance\MappStatus::insert($data);
    }
}
