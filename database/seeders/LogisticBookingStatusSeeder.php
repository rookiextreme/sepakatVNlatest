<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LogisticBookingStatusSeeder extends Seeder
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
                'name' => 'Menunggu Kelulusan'
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
            ],
            [
                'code' => '07',
                'name' => 'Tugasan Selesai'
            ]
        ];

        \App\Models\LogisticBookingStatus::insert($data);
    }
}
