<?php

namespace Database\Seeders;

use App\Models\Location\Placement;
use Illuminate\Database\Seeder;

class LocationPlacementSeeder extends Seeder
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
                "name"=>  "JKR DAERAH REMBAU"
              ],
              [
                "name"=>  "PARKIR CPAB JOHOR"
              ],
              [
                "name"=>  "JKR DAERAH SETIU"
              ],
              [
                "name"=>  "PARKIR CKMN PULAU PINANG"
              ],
              [
                "name"=>  "JABATAN KERJA RAYA NEGERI SEMBILAN"
              ],
              [
                "name"=>  "JKR DAERAH HULU TERENGGANU"
              ],
              [
                "name"=>  "PARKIR CKMN PERLIS"
              ],
              [
                "name"=>  "JKR WILAYAH PERSEKUTUAN KUALA LUMPUR"
              ],
              [
                "name"=>  "JKR DAERAH ROMPIN"
              ],
              [
                "name"=>  "CAWANGAN ELEKTRIK, JKR KELANTAN"
              ],
              [
                "name"=>  "CAWANGAN ELEKTRIK, JKR KEDAH"
              ],
              [
                "name"=>  "PARKIR CKM MELAKA"
              ],
              [
                "name"=>  "JKR DAERAH KUALA KANGSAR"
              ],
              [
                "name"=>  "JKR DAERAH LARUT MATANG DAN SELAMA"
              ],
              [
                "name"=>  "CAW. KEJURUTERAAN ELEKTRIK"
              ],
              [
                "name"=>  "CAWANGAN ARKITEK"
              ],
              [
                "name"=>  "JKR DAERAH TANGKAK"
              ],
              [
                "name"=>  "PARKIR CPAB KEDAH"
              ],
              [
                "name"=>  "RUANG PARKIR 2B"
              ],
              [
                "name"=>  "PARKIR CKE NEGERI SEMBILAN"
              ],
              [
                "name"=>  "JKR DAERAH BALING"
              ],
              [
                "name"=>  "JKR DAERAH SEGAMAT"
              ],
              [
                "name"=>  "JKR DAERAH MARANG"
              ],
              [
                "name"=>  "PARKIR CKE PULAU PINANG"
              ],
              [
                "name"=>  "JKR DAERAH KUALA LANGAT"
              ],
              [
                "name"=>  "JKR DAERAH PEKAN"
              ],
              [
                "name"=>  "BAHAGIAN PENTADBIRAN & KEWANGAN"
              ],
              [
                "name"=>  "PARKIR CSFB"
              ],
              [
                "name"=>  "CAWANGAN KERJA KESELAMATAN"
              ],
              [
                "name"=>  "JKR DAERAH KUALA SELANGOR"
              ],
              [
                "name"=>  "JKR DAERAH YAN"
              ],
              [
                "name"=>  "JKR DAERAH KUANTAN"
              ],
              [
                "name"=>  "KEM TENTERA JKR NEGERI MELAKA"
              ],
              [
                "name"=>  "PARKIR KEM GONG GEDAK"
              ],
              [
                "name"=>  "JKR DAERAH PORT DICKSON"
              ],
              [
                "name"=>  "PARKIR CKK"
              ],
              [
                "name"=>  "CAWANGAN DASAR DAN PENGURUSAN KORPORAT"
              ],
              [
                "name"=>  "CAWANGAN ELEKTRIK"
              ],
              [
                "name"=>  "JKR DAERAH RAUB"
              ],
              [
                "name"=>  "JKR DAERAH SEBERANG PERAI TENGAH"
              ],
              [
                "name"=>  "UNIT UKUR WILAYAH TIMUR"
              ],
              [
                "name"=>  "PARKIR CKC"
              ],
              [
                "name"=>  "PARKIR CKM PERLIS"
              ],
              [
                "name"=>  "PASUKAN PROJEK PERSEKUTUAN NEGERI SELANGOR"
              ],
              [
                "name"=>  "IBU PEJABAT JKR PAHANG"
              ],
              [
                "name"=>  "UNIT MEKANIKAL"
              ],
              [
                "name"=>  "JKR DAERAH KLANG"
              ],
              [
                "name"=>  "JKR DAERAH PETALING"
              ],
              [
                "name"=>  "JKR DAERAH SABAK BERNAM"
              ],
              [
                "name"=>  "JKR DAERAH KUBANG PASU"
              ],
              [
                "name"=>  "CAWANGAN ELEKTRIK, JKR PERLIS"
              ],
              [
                "name"=>  "JKR DAERAH JOHOR BHARU"
              ],
              [
                "name"=>  "CAWANGAN ELEKTRIK NEGERI PERAK"
              ],
              [
                "name"=>  "JKR DAERAH KOTA TINGGI"
              ],
              [
                "name"=>  "JKR DAERAH MUALLIM"
              ],
              [
                "name"=>  "PARKIR CKM IP"
              ],
              [
                "name"=>  "PARKIR CKAS"
              ],
              [
                "name"=>  "JKR DAERAH JASIN"
              ],
              [
                "name"=>  "PENTADBIRAN DAN KEWANGAN"
              ],
              [
                "name"=>  "PARKIR CPAB"
              ],
              [
                "name"=>  "JABATAN KERJA RAYA NEGERI PERLIS"
              ],
              [
                "name"=>  "JKR DAERAH PONTIAN"
              ],
              [
                "name"=>  "PARKIR CDPK"
              ],
              [
                "name"=>  "PARKIR CKMN MELAKA"
              ],
              [
                "name"=>  "PARKIR JKR JAJAHAN GUA MUSANG"
              ],
              [
                "name"=>  "PARKIR JKR KUARI BUKIT BULOH"
              ],
              [
                "name"=>  "CAWANGAN KEJURUTERAAN ELEKTRIK NEGERI"
              ],
              [
                "name"=>  "JKR DAERAH MELAKA TENGAH"
              ],
              [
                "name"=>  "PARKIR CPAB TERENGGANU"
              ],
              [
                "name"=>  "BAHAGIAN JALANRAYA DAN JAMBATAN"
              ],
              [
                "name"=>  "BAHAGIAN SENIBINA"
              ],
              [
                "name"=>  "PARKIR CASKT"
              ],
              [
                "name"=>  "PARKIR CKM KEDAH"
              ],
              [
                "name"=>  "UNIT TENTERA JKR PAHANG"
              ],
              [
                "name"=>  "JKR DAERAH BERA"
              ],
              [
                "name"=>  "JKR DAERAH HILIR PERAK"
              ],
              [
                "name"=>  "BAHAGIAN JALAN"
              ],
              [
                "name"=>  "JKR DAERAH MERSING"
              ],
              [
                "name"=>  "JKR DAERAH BARAT DAYA"
              ],
              [
                "name"=>  "PARKIR JKR PUTRAJAYA"
              ],
              [
                "name"=>  "JKR DAERAH ALOR GAJAH"
              ],
              [
                "name"=>  "PARKIR JKR WSP"
              ],
              [
                "name"=>  "JKR DAERAH PENDANG"
              ],
              [
                "name"=>  "JKR DAERAH KEMAMAN"
              ],
              [
                "name"=>  "JKR DAERAH TIMUR LAUT"
              ],
              [
                "name"=>  "JKR DAERAH SEREMBAN"
              ],
              [
                "name"=>  "PARKIR CKM PERAK"
              ],
              [
                "name"=>  "JKR DAERAH SEBERANG PERAI SELATAN"
              ],
              [
                "name"=>  "PARKIR CKE PERAK"
              ],
              [
                "name"=>  "IBU PEJABAT JKR PULAU PINANG"
              ],
              [
                "name"=>  "PARKIR CPAB PAHANG"
              ],
              [
                "name"=>  "CAWANGAN KEJURUTERAAN INFRASTRUKTUR PENGANGKUTAN"
              ],
              [
                "name"=>  "PARKIR CKMN W.P. LABUAN"
              ],
              [
                "name"=>  "PARKIR UNIT TENTERA JKR PERAK"
              ],
              [
                "name"=>  "BAHAGIAN KONTRAK UKUR BAHAN"
              ],
              [
                "name"=>  "JKR DAERAH CAMERON HIGHLANDS"
              ],
              [
                "name"=>  "UNIT UKUR WILAYAH SELATAN"
              ],
              [
                "name"=>  "JKR DAERAH BATU PAHAT"
              ],
              [
                "name"=>  "PARKIR KEM MAHKOTA, KLUANG"
              ],
              [
                "name"=>  "BAHAGIAN SENGGARA ASET NEGERI"
              ],
              [
                "name"=>  "PARKIR CPAB MELAKA"
              ],
              [
                "name"=>  "JKR DAERAH MARAN"
              ],
              [
                "name"=>  "PARKIR UNIT TENTERA JKR PAHANG"
              ],
              [
                "name"=>  "PARKIR CKE KELANTAN"
              ],
              [
                "name"=>  "PARKIR UNIT TENTERA JKR KELANTAN"
              ],
              [
                "name"=>  "JKR DAERAH KUALA MUDA"
              ],
              [
                "name"=>  "PARKIR JKR JOHOR"
              ],
              [
                "name"=>  "IBU PEJABAT JKR JOHOR"
              ],
              [
                "name"=>  "JKR DAERAH TEMERLOH"
              ],
              [
                "name"=>  "JKR DAERAH BESUT"
              ],
              [
                "name"=>  "BAHAGIAN PENTADBIRAN DAN KEWANGAN"
              ],
              [
                "name"=>  "PARKIR CPAB NEGERI SEMBILAN"
              ],
              [
                "name"=>  "JKR DAERAH JELEBU"
              ],
              [
                "name"=>  "PARKIR JKR DAERAH KUALA MUDA"
              ],
              [
                "name"=>  "CAWANGAN ELEKTRIK JKR TERENGGANU"
              ],
              [
                "name"=>  "JKR DAERAH KULAI"
              ],
              [
                "name"=>  "PARKIR CREATE"
              ],
              [
                "name"=>  "PARKING BERBUMBUNG TERBUKA"
              ],
              [
                "name"=>  "JKR DAERAH KERIAN"
              ],
              [
                "name"=>  "PARKIR CKMN PAHANG"
              ],
              [
                "name"=>  "JKR DAERAH JEMPOL"
              ],
              [
                "name"=>  "JKR DAERAH BAGAN DATUK"
              ],
              [
                "name"=>  "JKR DAERAH BATANG PADANG"
              ],
              [
                "name"=>  "PARKIR JKR JAJAHAN BACHOK"
              ],
              [
                "name"=>  "PARKIR CKM NEGERI SEMBILAN"
              ],
              [
                "name"=>  "PARKIR CKUB"
              ],
              [
                "name"=>  "PARKIR CKE IP"
              ],
              [
                "name"=>  "PARKIR CKE TERENGGANU"
              ],
              [
                "name"=>  "PARKIR CKE PAHANG"
              ],
              [
                "name"=>  "JKR DAERAH PADANG TERAP"
              ],
              [
                "name"=>  "PARKIR CPAB PERAK"
              ],
              [
                "name"=>  "PARKIR JKR JAJAHAN KUALA KRAI"
              ],
              [
                "name"=>  "JKR DAERAH KOTA SETAR"
              ],
              [
                "name"=>  "PARKIR JKR JAJAHAN TANAH MERAH"
              ],
              [
                "name"=>  "JKR DAERAH HULU LANGAT"
              ],
              [
                "name"=>  "PARKIR CKM SELANGOR"
              ],
              [
                "name"=>  "PARKIR CKM PAHANG"
              ],
              [
                "name"=>  "JKR DAERAH TAMPIN"
              ],
              [
                "name"=>  "JKR KUARI KAMPUNG AWAH, TEMERLOH."
              ],
              [
                "name"=>  "BAHAGIAN ARKITEK (SENIBINA)"
              ],
              [
                "name"=>  "BAHAGIAN UKUR BAHAN"
              ],
              [
                "name"=>  "PARKIR CPAB PERLIS"
              ],
              [
                "name"=>  "IBU PEJABAT JKR KELANTAN"
              ],
              [
                "name"=>  "JKR DAERAH MUAR"
              ],
              [
                "name"=>  "JKR DAERAH KLUANG"
              ],
              [
                "name"=>  "JKR DAERAH MANJUNG"
              ],
              [
                "name"=>  "BAHAGIAN PENGURUSAN KORPORAT"
              ],
              [
                "name"=>  "JKR DAERAH BANDAR BAHARU/KULIM"
              ],
              [
                "name"=>  "PARKIR CKE KEDAH"
              ],
              [
                "name"=>  "BAHAGIAN KONTRAK & UKUR BAHAN"
              ],
              [
                "name"=>  "PARKIR KENDERAAN JABATAN (KEM BATU KENTOMEN)"
              ],
              [
                "name"=>  "BAHAGIAN PAKAR PERLINDUNGAN RISIKO KEBAKARAN"
              ],
              [
                "name"=>  "CAWANGAN KEJURUTERAAN ELEKTRIK"
              ],
              [
                "name"=>  "PARKIR CKM PULAU PINANG"
              ],
              [
                "name"=>  "PARKIR CKE SELANGOR"
              ],
              [
                "name"=>  "PARKIR JKR JAJAHAN PASIR PUTEH"
              ],
              [
                "name"=>  "PARKIR CKS"
              ],
              [
                "name"=>  "BAHAGIAN CPAB & PENGURUSAN KORPORAT"
              ],
              [
                "name"=>  "JKR DAERAH SIK"
              ],
              [
                "name"=>  "JKR DAERAH KAMPAR"
              ],
              [
                "name"=>  "JKR DAERAH LANGKAWI"
              ],
              [
                "name"=>  "PARKIR UNIT TENTERA PORT DICKSON"
              ],
              [
                "name"=>  "BAHAGIAN PENGURUSAN"
              ],
              [
                "name"=>  "BAHAGIAN SETOR NEGERI"
              ],
              [
                "name"=>  "JKR DAERAH JERANTUT"
              ],
              [
                "name"=>  "PARKIR CJ"
              ],
              [
                "name"=>  "UNIT UKUR WILAYAH TENGAH"
              ],
              [
                "name"=>  "PARKIR CKMN KELANTAN"
              ],
              [
                "name"=>  "PARKIR CKG"
              ],
              [
                "name"=>  "JKR DAERAH PERAK TENGAH"
              ],
              [
                "name"=>  "PARKIR CKMN SELANGOR"
              ],
              [
                "name"=>  "PARKIR JKR JAJAHAN TUMPAT"
              ],
              [
                "name"=>  "PARKIR JKR JAJAHAN PASIR MAS"
              ],
              [
                "name"=>  "JKR DAERAH KUALA PILAH"
              ],
              [
                "name"=>  "PARKIR UNIT TENTERA JKR KEDAH"
              ],
              [
                "name"=>  "IBU PEJABAT JKR TERENGGANU"
              ],
              [
                "name"=>  "PARKIR 2 ( BLOK B ARAS 1)"
              ],
              [
                "name"=>  "PARKING BERBUMBUNG"
              ],
              [
                "name"=>  "PARKIR CKMN JOHOR"
              ],
              [
                "name"=>  "IBU PEJABAT JKR PERAK"
              ],
              [
                "name"=>  "PARKIR CKMN KEDAH"
              ],
              [
                "name"=>  "JKR DAERAH SEBERANG PERAI UTARA"
              ],
              [
                "name"=>  "PARKIR CKMN TERENGGANU"
              ],
              [
                "name"=>  "PARKIR JKR JAJAHAN MACHANG"
              ],
              [
                "name"=>  "PARKIR CSFJ"
              ],
              [
                "name"=>  "BAHAGIAN BANGUNAN"
              ],
              [
                "name"=>  "PARKIR CKM TERENGGANU"
              ],
              [
                "name"=>  "PARKIR CKE MELAKA"
              ],
              [
                "name"=>  "PARKIR JKR KEM TLDM"
              ],
              [
                "name"=>  "BAHAGIAN ARKITEK"
              ],
              [
                "name"=>  "CAW. KESELAMATAN PORT DICKSON"
              ],
              [
                "name"=>  "JKR DAERAH GOMBAK"
              ],
              [
                "name"=>  "JKR DAERAH HULU PERAK"
              ],
              [
                "name"=>  "PARKIR CKBA1"
              ],
              [
                "name"=>  "IBU PEJABAT JKR KEDAH"
              ],
              [
                "name"=>  "PARKIR JKR W.P. LABUAN"
              ],
              [
                "name"=>  "JKR DAERAH BENTONG"
              ],
              [
                "name"=>  "JKR PADANG TERAP/POKOK SENA"
              ],
              [
                "name"=>  "JKR DAERAH KUALA LIPIS"
              ],
              [
                "name"=>  "PARKIR JKR JAJAHAN JELI"
              ],
              [
                "name"=>  "BAHAGIAN SENGGARA PERSEKUTUAN NEGERI"
              ],
              [
                "name"=>  "RUANG KERJA AUTOMOTIF"
              ],
              [
                "name"=>  "PARKIR CKE PERLIS"
              ],
              [
                "name"=>  "UNIT KERJA TENTERA"
              ],
              [
                "name"=>  "JKR DAERAH HULU SELANGOR"
              ],
              [
                "name"=>  "PARKIR CKMN NEGERI SEMBILAN"
              ],
              [
                "name"=>  "JKR DAERAH KINTA"
              ],
              [
                "name"=>  "PARKIR CKE JOHOR"
              ],
              [
                "name"=>  "IBU PEJABAT JKR NEGERI SEMBILAN"
              ],
              [
                "name"=>  "PARKIR CKP"
              ],
              [
                "name"=>  "JABATAN KERJA RAYA NEGERI PULAU PINANG"
              ],
              [
                "name"=>  "CAWANGAN ELEKTRIK JKR NEGERI SELANGOR"
              ],
              [
                "name"=>  "PARKIR CKBA 2"
              ],
              [
                "name"=>  "PARKIR JKR KESEDAR"
              ],
              [
                "name"=>  "PARKIR JKR JAJAHAN KOTA BHARU"
              ],
              [
                "name"=>  "PARKIR CPAB KELANTAN"
              ],
              [
                "name"=>  "SABAH"
              ],
              [
                "name"=>  "JKR DAERAH KUALA TERENGGANU"
              ],
              [
                "name"=>  "JKR DAERAH DUNGUN"
              ],
              [
                "name"=>  "PARKIR CPAB SELANGOR"
              ],
              [
                "name"=>  "UNIT UKUR WILAYAH UTARA"
              ],
              [
                "name"=>  "BAHAGIAN ELEKTRIK"
              ],
              [
                "name"=>  "WOKSYOP BENTONG, BENTONG"
              ],
              [
                "name"=>  "PARKIR CKMN PERAK"
              ],
              [
                "name"=>  "JKR DAERAH SEPANG"
              ],
              [
                "name"=>  "JKR FERI PENGKALAN KUBOR"
              ]
        ];

        Placement::insert($data);
    }
}
