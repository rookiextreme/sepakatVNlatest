<?php

namespace Database\Seeders;

use App\Models\RefOwner;
use App\Models\RefOwnerType;
use Illuminate\Database\Seeder;

class RefOwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $owner01 = RefOwnerType::where([
            'code' => '01',
            'display_for' => 'vehicle_register'
        ])->first();
        $owner02 = RefOwnerType::where([
            'code' => '02',
            'display_for' => 'vehicle_register'
        ])->first();


        $data = [

            [
                "code" => "0101",
                "name" => "Cawangan Dasar dan Pengurusan Korporat"
                ,"owner_type_id" => $owner01->id
            ],
            [
                "code" => "0102",
                "name" => "Cawangan Perancangan Aset Bersepadu"
                ,"owner_type_id" => $owner01->id
            ],
            [
                "code" => "0103",
                "name" => "Cawangan Jalan"
                ,"owner_type_id" => $owner01->id
            ],
            [
                "code" => "0104",
                "name" => "Cawangan Kejuruteraan Infrastruktur & Pengangkutan"
                ,"owner_type_id" => $owner01->id
            ],
            [
                "code" => "0105",
                "name" => "Cawangan Kejuruteraan Cerun"
                ,"owner_type_id" => $owner01->id
            ],
            [
                "code" => "0106",
                "name" => "Cawangan Senggara Fasiliti Jalan"
                ,"owner_type_id" => $owner01->id
            ],
            [
                "code" => "0107",
                "name" => "Cawangan Kerja Bangunan Am 1"
                ,"owner_type_id" => $owner01->id
            ],
            [
                "code" => "0108",
                "name" => "Cawangan Kerja Bangunan Am 2"
                ,"owner_type_id" => $owner01->id
            ],
            [
                "code" => "0109",
                "name" => "Cawangan Kerja Pendidikan"
                ,"owner_type_id" => $owner01->id
            ],
            [
                "code" => "0110",
                "name" => "Cawangan Kerja Keselamatan"
                ,"owner_type_id" => $owner01->id
            ],
            [
                "code" => "0111",
                "name" => "Cawangan Kerja Kesihatan"
                ,"owner_type_id" => $owner01->id
            ],
            [
                "code" => "0112",
                "name" => "Cawangan Senggara Fasiliti Bangunan"
                ,"owner_type_id" => $owner01->id
            ],
            [
                "code" => "0113",
                "name" => "Cawangan Arkitek"
                ,"owner_type_id" => $owner01->id
            ],
            [

                "code" => "0114",
                "name" => "Cawangan Kejuruteraan Awam & Struktur"
                ,"owner_type_id" => $owner01->id
            ],
            [

                "code" => "0115",
                "name" => "Cawangan Kontrak dan Ukur Bahan"
                ,"owner_type_id" => $owner01->id
            ],
            [
                "code" => "0116",
                "name" => "Cawangan Kejuruteraan Mekanikal"
                ,"owner_type_id" => $owner01->id
            ],
            [
                "code" => "0117",
                "name" => "Cawangan Kejuruteraan Elektrik"
                ,"owner_type_id" => $owner01->id
            ],
            [
                "code" => "0118",
                "name" => "Cawangan Kejuruteraan Geoteknik"
                ,"owner_type_id" => $owner01->id
            ],
            [
                "code" => "0119",
                "name" => "Cawangan Alam Sekitar & Kecekapan Tenaga"
                ,"owner_type_id" => $owner01->id
            ],
            [
                "code" => "0120",
                "name" => "JKR Kesedar"
                ,"owner_type_id" => $owner01->id
            ],
            [
                "code" => "0121",
                "name" => "JKR Ketengah"
                ,"owner_type_id" => $owner01->id
            ],
            [
                "code" => "0122",
                "name" => "JKR Wilayah Persekutuan Putrajaya"
                ,"owner_type_id" => $owner01->id
            ],
            [
                "code" => "0123",
                "name" => "JKR Wilayah Persekutuan Kuala Lumpur"
                ,"owner_type_id" => $owner01->id
            ],
            [
                "code" => "0124",
                "name" => "JKR Wilayah Persekutuan Labuan"
                ,"owner_type_id" => $owner01->id
            ],
            [
                "code" => "0125",
                "name" => "JKR Woksyop Persekutuan"
                ,"owner_type_id" => $owner01->id
            ],
            [
                "code" => "0126",
                "name" => "Pusat Kecemerlangan Kejuruteraan & Teknologi (CREaTE)"
                ,"owner_type_id" => $owner01->id
            ],


            [
                "code" => "0201",
                "name" => "Jabatan Kerja Raya Negeri Johor"
                ,"owner_type_id" => $owner02->id
            ],
            [
                "code" => "0202",
                "name" => "Jabatan Kerja Raya Negeri Kedah"
                ,"owner_type_id" => $owner02->id
            ],
            [
                "code" => "0203",
                "name" => "Jabatan Kerja Raya Negeri Kelantan"
                ,"owner_type_id" => $owner02->id
            ],
            [
                "code" => "0204",
                "name" => "Jabatan Kerja Raya Negeri Melaka"
                ,"owner_type_id" => $owner02->id
            ],
            [
                "code" => "0205",
                "name" => "Jabatan Kerja Raya Negeri Sembilan"
                ,"owner_type_id" => $owner02->id
            ],
            [
                "code" => "0206",
                "name" => "Jabatan Kerja Raya Negeri Pahang"
                ,"owner_type_id" => $owner02->id
            ],
            [
                "code" => "0207",
                "name" => "Jabatan Kerja Raya Negeri Perak"
                ,"owner_type_id" => $owner02->id
            ],
            [
                "code" => "0208",
                "name" => "Jabatan Kerja Raya Negeri Perlis"
                ,"owner_type_id" => $owner02->id
            ],
            [
                "code" => "0209",
                "name" => "Jabatan Kerja Raya Negeri Pulau Pinang"
                ,"owner_type_id" => $owner02->id
            ],
            [
                "code" => "0210",
                "name" => "Jabatan Kerja Raya Negeri Selangor"
                ,"owner_type_id" => $owner02->id
            ],
            [
                "code" => "0211",
                "name" => "Jabatan Kerja Raya Negeri Terengganu"
                ,"owner_type_id" => $owner02->id
            ]

        ];
        for ($i=0; $i <count($data); $i++) {
            $data[$i]['name'] = strtoupper($data[$i]['name']);
            RefOwner::create($data[$i]);
        }
    }
}
