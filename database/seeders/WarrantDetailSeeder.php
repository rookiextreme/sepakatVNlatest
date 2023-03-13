<?php

namespace Database\Seeders;

use App\Models\Maintenance\OsolType;
use App\Models\Maintenance\WaranType;
use Illuminate\Database\Seeder;

class WarrantDetailSeeder extends Seeder
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
            //MHPV OSOL 26000
            [
                'state' => 'JOHOR',
                "waran_type_id" => $warantMhpv->id,
                "osol_type_id" => $osolType26000->id
            ],
            [
                'state' => 'KEDAH',
                "waran_type_id" => $warantMhpv->id,
                "osol_type_id" => $osolType26000->id
            ],
            [
                'state' => 'KELANTAN',
                "waran_type_id" => $warantMhpv->id,
                "osol_type_id" => $osolType26000->id
            ],
            [
                'state' => 'MELAKA',
                "waran_type_id" => $warantMhpv->id,
                "osol_type_id" => $osolType26000->id
            ],
            [
                'state' => 'NEGERI SEMBILAN',
                "waran_type_id" => $warantMhpv->id,
                "osol_type_id" => $osolType26000->id
            ],
            [
                'state' => 'PAHANG',
                "waran_type_id" => $warantMhpv->id,
                "osol_type_id" => $osolType26000->id
            ],
            [
                'state' => 'PERAK',
                "waran_type_id" => $warantMhpv->id,
                "osol_type_id" => $osolType26000->id
            ],
            [
                'state' => 'PERLIS',
                "waran_type_id" => $warantMhpv->id,
                "osol_type_id" => $osolType26000->id
            ],
            [
                'state' => 'PULAU PINANG',
                "waran_type_id" => $warantMhpv->id,
                "osol_type_id" => $osolType26000->id
            ],
            [
                'state' => 'SABAH',
                "waran_type_id" => $warantMhpv->id,
                "osol_type_id" => $osolType26000->id
            ],
            [
                'state' => 'SARAWAK',
                "waran_type_id" => $warantMhpv->id,
                "osol_type_id" => $osolType26000->id
            ],
            [
                'state' => 'SELANGOR',
                "waran_type_id" => $warantMhpv->id,
                "osol_type_id" => $osolType26000->id
            ],
            [
                'state' => 'TERENGGANU',
                "waran_type_id" => $warantMhpv->id,
                "osol_type_id" => $osolType26000->id
            ],
            [
                'state' => 'WP KUALA LUMPUR',
                "waran_type_id" => $warantMhpv->id,
                "osol_type_id" => $osolType26000->id
            ],
            [
                'state' => 'WP LABUAN',
                "waran_type_id" => $warantMhpv->id,
                "osol_type_id" => $osolType26000->id
            ],
            [
                'state' => 'WP PUTRAJAYA',
                "waran_type_id" => $warantMhpv->id,
                "osol_type_id" => $osolType26000->id
            ],

             //MHPV OSOL 26000
             [
                'state' => 'JOHOR',
                "waran_type_id" => $warantMhpv->id,
                "osol_type_id" => $osolType28000->id
            ],
            [
                'state' => 'KEDAH',
                "waran_type_id" => $warantMhpv->id,
                "osol_type_id" => $osolType28000->id
            ],
            [
                'state' => 'KELANTAN',
                "waran_type_id" => $warantMhpv->id,
                "osol_type_id" => $osolType28000->id
            ],
            [
                'state' => 'MELAKA',
                "waran_type_id" => $warantMhpv->id,
                "osol_type_id" => $osolType28000->id
            ],
            [
                'state' => 'NEGERI SEMBILAN',
                "waran_type_id" => $warantMhpv->id,
                "osol_type_id" => $osolType28000->id
            ],
            [
                'state' => 'PAHANG',
                "waran_type_id" => $warantMhpv->id,
                "osol_type_id" => $osolType28000->id
            ],
            [
                'state' => 'PERAK',
                "waran_type_id" => $warantMhpv->id,
                "osol_type_id" => $osolType28000->id
            ],
            [
                'state' => 'PERLIS',
                "waran_type_id" => $warantMhpv->id,
                "osol_type_id" => $osolType28000->id
            ],
            [
                'state' => 'PULAU PINANG',
                "waran_type_id" => $warantMhpv->id,
                "osol_type_id" => $osolType28000->id
            ],
            [
                'state' => 'SABAH',
                "waran_type_id" => $warantMhpv->id,
                "osol_type_id" => $osolType28000->id
            ],
            [
                'state' => 'SARAWAK',
                "waran_type_id" => $warantMhpv->id,
                "osol_type_id" => $osolType28000->id
            ],
            [
                'state' => 'SELANGOR',
                "waran_type_id" => $warantMhpv->id,
                "osol_type_id" => $osolType28000->id
            ],
            [
                'state' => 'TERENGGANU',
                "waran_type_id" => $warantMhpv->id,
                "osol_type_id" => $osolType28000->id
            ],
            [
                'state' => 'WP KUALA LUMPUR',
                "waran_type_id" => $warantMhpv->id,
                "osol_type_id" => $osolType28000->id
            ],
            [
                'state' => 'WP LABUAN',
                "waran_type_id" => $warantMhpv->id,
                "osol_type_id" => $osolType28000->id
            ],
            [
                'state' => 'WP PUTRAJAYA',
                "waran_type_id" => $warantMhpv->id,
                "osol_type_id" => $osolType28000->id
            ]

        ];

        \App\Models\Maintenance\WarrantDetail::insert($data);
    }
}
