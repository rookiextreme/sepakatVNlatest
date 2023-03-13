<?php

namespace Database\Seeders;

use App\Models\Maintenance\OsolType;
use App\Models\Maintenance\WaranType;
use Illuminate\Database\Seeder;

class WarrantDetail2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $warantMhpv = WaranType::where('code', '01')->first();
        $osolType26000 = OsolType::where('code', '01')->first();
        $osolType28000 = OsolType::where('code', '02')->first();

        $warantKkr = WaranType::where('code', '02')->first();
        $warantAgensiLuar = WaranType::where('code', '03')->first();

        $data = [
            //---KKR
            [
                'state' => 'JOHOR',
                "waran_type_id" => $warantKkr->id
            ],
            [
                'state' => 'KEDAH',
                "waran_type_id" => $warantKkr->id
            ],
            [
                'state' => 'KELANTAN',
                "waran_type_id" => $warantKkr->id
            ],
            [
                'state' => 'MELAKA',
                "waran_type_id" => $warantKkr->id
            ],
            [
                'state' => 'NEGERI SEMBILAN',
                "waran_type_id" => $warantKkr->id
            ],
            [
                'state' => 'PAHANG',
                "waran_type_id" => $warantKkr->id
            ],
            [
                'state' => 'PERAK',
                "waran_type_id" => $warantKkr->id
            ],
            [
                'state' => 'PERLIS',
                "waran_type_id" => $warantKkr->id
            ],
            [
                'state' => 'PULAU PINANG',
                "waran_type_id" => $warantKkr->id
            ],
            [
                'state' => 'SABAH',
                "waran_type_id" => $warantKkr->id
            ],
            [
                'state' => 'SARAWAK',
                "waran_type_id" => $warantKkr->id
            ],
            [
                'state' => 'SELANGOR',
                "waran_type_id" => $warantKkr->id
            ],
            [
                'state' => 'TERENGGANU',
                "waran_type_id" => $warantKkr->id
            ],
            [
                'state' => 'WP KUALA LUMPUR',
                "waran_type_id" => $warantKkr->id
            ],
            [
                'state' => 'WP LABUAN',
                "waran_type_id" => $warantKkr->id
            ],
            [
                'state' => 'WP PUTRAJAYA',
                "waran_type_id" => $warantKkr->id
            ],

            //AGENSI LUAR
            [
                'state' => 'JOHOR',
                "waran_type_id" => $warantAgensiLuar->id
            ],
            [
                'state' => 'KEDAH',
                "waran_type_id" => $warantAgensiLuar->id
            ],
            [
                'state' => 'KELANTAN',
                "waran_type_id" => $warantAgensiLuar->id
            ],
            [
                'state' => 'MELAKA',
                "waran_type_id" => $warantAgensiLuar->id
            ],
            [
                'state' => 'NEGERI SEMBILAN',
                "waran_type_id" => $warantAgensiLuar->id
            ],
            [
                'state' => 'PAHANG',
                "waran_type_id" => $warantAgensiLuar->id
            ],
            [
                'state' => 'PERAK',
                "waran_type_id" => $warantAgensiLuar->id
            ],
            [
                'state' => 'PERLIS',
                "waran_type_id" => $warantAgensiLuar->id
            ],
            [
                'state' => 'PULAU PINANG',
                "waran_type_id" => $warantAgensiLuar->id
            ],
            [
                'state' => 'SABAH',
                "waran_type_id" => $warantAgensiLuar->id
            ],
            [
                'state' => 'SARAWAK',
                "waran_type_id" => $warantAgensiLuar->id
            ],
            [
                'state' => 'SELANGOR',
                "waran_type_id" => $warantAgensiLuar->id
            ],
            [
                'state' => 'TERENGGANU',
                "waran_type_id" => $warantAgensiLuar->id
            ],
            [
                'state' => 'WP KUALA LUMPUR',
                "waran_type_id" => $warantAgensiLuar->id
            ],
            [
                'state' => 'WP LABUAN',
                "waran_type_id" => $warantAgensiLuar->id
            ],
            [
                'state' => 'WP PUTRAJAYA',
                "waran_type_id" => $warantAgensiLuar->id
            ]

        ];

        \App\Models\Maintenance\WarrantDetail::insert($data);
    }
}
