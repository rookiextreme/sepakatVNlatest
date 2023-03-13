<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AssessmentApplicationStatusSeeder extends Seeder
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
                'desc' => 'Telah Hapus',
                'created_at' => Carbon::now()
            ],
            [
                'code' => '01',
                'desc' => 'Draf',
                'created_at' => Carbon::now()
            ],
            [
                'code' => '02',
                'desc' => 'Tetapan Temujanji',
                'created_at' => Carbon::now()
            ],
            [
                'code' => '03',
                'desc' => 'Menunggu Pemeriksaan',
                'created_at' => Carbon::now()
            ],
            [
                'code' => '04',
                'desc' => 'Menunggu Semakan',
                'created_at' => Carbon::now()
            ],
            [
                'code' => '05',
                'desc' => 'Menunggu Pengesahan',
                'created_at' => Carbon::now()
            ],
            [
                'code' => '06',
                'desc' => 'Ditolak',
                'created_at' => Carbon::now()
            ],
            [
                'code' => '07',
                'desc' => 'Tidak Lengkap',
                'created_at' => Carbon::now()
            ],
            [
                'code' => '08',
                'desc' => 'Selesai',
                'created_at' => Carbon::now()
            ]
        ];

        \App\Models\Assessment\AssessmentApplicationStatus::insert($data);
    }
}
