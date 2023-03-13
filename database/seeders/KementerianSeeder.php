<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class KementerianSeeder extends Seeder
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
                'name' => 'Kementerian Perdagangan Antarabangsa dan Industri'
            ],
            [
                'name' => 'Kementerian Perdagangan Dalam Negeri dan Hal Ehwal Pengguna'
            ],
            [
                'name' => 'Kementerian Perusahaan Perladangan dan Komoditi'
            ],
            [
                'name' => 'Kementerian Kewangan'
            ],
            [
                'name' => 'Kementerian Pembangunan Usahawan dan Koperasi'
            ],
            [
                'name' => 'Kementerian Pelancongan, Kesenian dan Kebudayaan'
            ],
            [
                'name' => 'Kementerian Pertahanan'
            ],
            [
                'name' => 'Kementerian Luar Negeri'
            ],
            [
                'name' => 'Kementerian Perpaduan Negara'
            ],
            [
                'name' => 'Kementerian Dalam Negeri'
            ],
            [
                'name' => 'Kementerian Pendidikan'
            ],
            [
                'name' => 'Kementerian Kesihatan'
            ],
            [
                'name' => 'Kementerian Sumber Manusia'
            ],
            [
                'name' => 'Kementerian Komunikasi dan Multimedia'
            ],
            [
                'name' => 'Kementerian Pembangunan Wanita, Keluarga dan Masyarakat'
            ],
            [
                'name' => 'Kementerian Pengajian Tinggi'
            ],
            [
                'name' => 'Kementerian Belia dan Sukan'
            ],
            [
                'name' => 'Kementerian Perumahan dan Kerajaan Tempatan'
            ],
            [
                'name' => 'Kementerian Pengangkutan'
            ],
            [
                'name' => 'Kementerian Pembangunan Luar Bandar'
            ],
            [
                'name' => 'Kementerian Wilayah Persekutuan'
            ],
            [
                'name' => 'Kementerian Tenaga dan Sumber Asli'
            ],
            [
                'name' => 'Kementerian Pertanian dan Industri Makanan'
            ],
            [
                'name' => 'Kementerian Sains, Teknologi dan Inovasi'
            ],
            [
                'name' => 'Kementerian Alam Sekitar dan Air'
            ]
        ];
        for ($i=0; $i <count($data); $i++) {
            $data[$i]['name'] = strtoupper($data[$i]['name']);
            \App\Models\Identifier\Kementerian::create($data[$i]);
        }

    }
}
