<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RefStatusSeeder extends Seeder
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
                'desc_bm' => 'Draft',
                'desc_en' => 'Draft'
            ],
            [
                'code' => '02',
                'desc_bm' => 'Semakan',
                'desc_en' => 'Review'
            ],
            [
                'code' => '03',
                'desc_bm' => 'Pengesahan',
                'desc_en' => 'Approval'
            ],
            [
                'code' => '04',
                'desc_bm' => 'Ditolak',
                'desc_en' => 'Rejected'
            ],
            [
                'code' => '05',
                'desc_bm' => 'Tidak Lengkap',
                'desc_en' => 'Not Complete'
            ],
            [
                'code' => '06',
                'desc_bm' => 'Selesai',
                'desc_en' => 'Completed'
            ],
            [
                'code' => '07',
                'desc_bm' => 'Dikunci',
                'desc_en' => 'Locked'
            ],
            [
                'code' => '08',
                'desc_bm' => 'Dibuang',
                'desc_en' => 'Revoked'
            ]

        ];

        \App\Models\RefStatus::insert($data);
    }
}
