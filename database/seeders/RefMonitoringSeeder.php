<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RefMonitoringSeeder extends Seeder
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
                'desc' => 'Proses merombak / melerai bahagian rosak pada kenderaan sedang dilaksanakan'
            ],
            [
                'code' => '02',
                'desc' => 'Alat ganti baharu telah diterima dan mengikut spesifikasi'
            ],
            [
                'code' => '03',
                'desc' => 'Proses pemasangan alat ganti baharu siap dilaksanakan'
            ],
            [
                'code' => '04',
                'desc' => 'Kenderaan sedang diuji oleh pihak woksyop'
            ],
            [
                'code' => '05',
                'desc' => 'Lain-lain'
            ],
        ];

        \App\Models\Maintenance\RefMonitoringInfo::insert($data);
    }
}
