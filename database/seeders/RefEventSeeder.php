<?php

namespace Database\Seeders;

use App\Models\RefEvent;
use Illuminate\Database\Seeder;

class RefEventSeeder extends Seeder
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
            'desc' => 'Pendaftaran'
        ],
        [
            'code' => '02',
            'desc' => 'Pengesahan'
        ],
        [
            'code' => '03',
            'desc' => 'Penilaian'
        ],
        [
            'code' => '04',
            'desc' => 'Penyengaraan'
        ],
        [
            'code' => '05',
            'desc' => 'Tempahan'
        ],
        [
            'code' => '06',
            'desc' => 'Saman'
        ],
        [
            'code' => '07',
            'desc' => 'Tukar Hak Milik'
        ],
        [
            'code' => '08',
            'desc' => 'Kemalangan'
        ],
        [
            'code' => '09',
            'desc' => 'Disita'
        ],
        [
            'code' => '10',
            'desc' => 'Dipinjamkan'
        ],
        [
            'code' => '11',
            'desc' => 'Dipulangkan'
        ],
        [
            'code' => '12',
            'desc' => 'Mengalami Kerosakan'
        ]
        ];

        RefEvent::insert($data);
    }
}
