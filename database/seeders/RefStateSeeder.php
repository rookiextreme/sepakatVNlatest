<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RefStateSeeder extends Seeder
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
                'desc' => 'JOHOR'
            ],
            [
                'code' => '02',
                'desc' => 'KEDAH'
            ],
            [
                'code' => '03',
                'desc' => 'KELANTAN'
            ],
            [
                'code' => '04',
                'desc' => 'MELAKA'
            ],
            [
                'code' => '05',
                'desc' => 'NEGERI SEMBILAN'
            ],
            [
                'code' => '06',
                'desc' => 'PAHANG'
            ],
            [
                'code' => '07',
                'desc' => 'PERAK'
            ],
            [
                'code' => '08',
                'desc' => 'PERLIS'
            ],
            [
                'code' => '09',
                'desc' => 'PULAU PINANG'
            ],
            [
                'code' => '10',
                'desc' => 'SABAH'
            ],
            [
                'code' => '11',
                'desc' => 'SARAWAK'
            ],
            [
                'code' => '12',
                'desc' => 'SELANGOR'
            ],
            [
                'code' => '13',
                'desc' => 'TERENGGANU'
            ],
            [
                'code' => '14',
                'desc' => 'WP KUALA LUMPUR'
            ],
            [
                'code' => '15',
                'desc' => 'WP LABUAN'
            ],
            [
                'code' => '16',
                'desc' => 'WP PUTRAJAYA'
            ]

        ];

        \App\Models\RefState::insert($data);
    }
}
