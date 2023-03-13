<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class KenderaanStatusSeeder extends Seeder
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
                'name' => 'Telah Hapus' 
            ],
            [
                'code' => '01',
                'name' => 'Draf' 
            ],
            [
                'code' => '02',
                'name' => 'Menunggu Semakan'
            ],
            [
                'code' => '03',
                'name' => 'Menunggu Pengesahan'
            ],
            [
                'code' => '04',
                'name' => 'Di Tolak'
            ],
            [
                'code' => '05',
                'name' => 'Tidak Lengkap'
            ],
            [
                'code' => '06',
                'name' => 'Selesai'
            ]
        ];

        \App\Models\Identifier\KenderaanStatus::insert($data);
    }
}
