<?php

namespace Database\Seeders;

use App\Models\RefAgency;
use Illuminate\Database\Seeder;

class RefAgencySeeder extends Seeder
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
                "code" => "01",
                "desc" => "Kementerian Pembangunan Luar Bandar"
            ],
            [
                "code" => "02",
                "desc" => "Kementerian Luar Negeri"
            ],
            [
                "code" => "03",
                "desc" => "Kementerian Dalam Negeri"
            ],
            [
                "code" => "04",
                "desc" => "Kementerian Pertahanan"
            ],
            [
                "code" => "05",
                "desc" => "Kementerian Alam Sekitar Dan Air"
            ],
            [
                "code" => "06",
                "desc" => "Kementerian Hal Ehwal Ekonomi"
            ],
            [
                "code" => "07",
                "desc" => "Kementerian Pendidikan"
            ],
            [
                "code" => "08",
                "desc" => "Kementerian Perdagangan Antarabangsa dan Industri"
            ],
            [
                "code" => "09",
                "desc" => "Kementerian Kesihatan"
            ],
            [
                "code" => "10",
                "desc" => "Kementerian Sumber Manusia"
            ],
            [
                "code" => "11",
                "desc" => "Kementerian Pembangunan Usahawan dan Koperasi"
            ],
            [
                "code" => "12",
                "desc" => "Kementerian Sains, Teknologi & Inovasi"
            ],
            [
                "code" => "13",
                "desc" => "Kementerian Belia dan Sukan"
            ],
            [
                "code" => "14",
                "desc" => "Kementerian Perdagangan Dalam Negeri, Koperasi dan Kepenggunaan"
            ],
            [
                "code" => "15",
                "desc" => "Kementerian Pertanian Dan Industri Makanan,"
            ],
            [
                "code" => "16",
                "desc" => "Kementerian Pembangunan Wanita, Keluarga dan Masyarakat"
            ],
            [
                "code" => "17",
                "desc" => "Kementerian Wilayah Persekutuan"
            ],
            [
                "code" => "18",
                "desc" => "Kementerian Perusahaan Perladangan Dan Komoditi"
            ],
            [
                "code" => "19",
                "desc" => "Kementerian Perumahan dan Kerajaan Tempatan"
            ],
            [
                "code" => "20",
                "desc" => "Kementerian Pelancongan,Seni Dan Budaya"
            ],
            [
                "code" => "21",
                "desc" => "Kementerian Kewangan"
            ],
            [
                "code" => "22",
                "desc" => "Kementerian Komunikasi Dan Multimedia"
            ],
            [
                "code" => "23",
                "desc" => "Kementerian Pengangkutan"
            ],
            [
                "code" => "24",
                "desc" => "Kementerian Tenaga dan Sumber Asli"
            ],
            [
                "code" => "25",
                "desc" => "Kementerian Pengajian Tinggi"
            ],
            [
                "code" => "26",
                "desc" => "Suruhanjaya Pilihan Raya"
            ],
            [
                "code" => "27",
                "desc" => "Suruhanjaya Pencegahan Rasuah Malaysia"
            ],
            [
                "code" => "28",
                "desc" => "Pejabat Suk Selangor"
            ],
            [
                "code" => "29",
                "desc" => "Pejabat Setiausaha Kerajaan Negeri Pulau Pinang"
            ],
            [
                "code" => "30",
                "desc" => "Pejabat Setiausaha Kerajaan Negeri Pahang"
            ],
            [
                "code" => "31",
                "desc" => "Peruntukan Diraja Bagi Seri Paduka Baginda Yang Di-Pertuan Agong"
            ],
            [
                "code" => "32",
                "desc" => "Parlimen"
            ],
            [
                "code" => "33",
                "desc" => "Jabatan Perdana Menteri"
            ],
            [
                "code" => "34",
                "desc" => "Jabatan Audit Negara"
            ],
            [
                "code" => "35",
                "desc" => "Jabatan Perkhidmatan Awam"
            ],
            [
                "code" => "36",
                "desc" => "Jabatan Pelanggan Di Negeri"
            ],
            [
                "code" => "37",
                "desc" => "Jabatan Bekalan Air Negeri Sembilan"
            ]


        ];
        for ($i=0; $i <count($data); $i++) {
            $data[$i]['desc'] = strtoupper($data[$i]['desc']);
            RefAgency::create($data[$i]);
        }
    }
}
