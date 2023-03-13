<?php

namespace Database\Seeders;

use App\Models\FleetPlacement;
use App\Models\RefState;
use Illuminate\Database\Seeder;

class FleetPlacementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $state01 = RefState::where('code', '01')->first();
        $state02 = RefState::where('code', '02')->first();
        $state03 = RefState::where('code', '03')->first();
        $state04 = RefState::where('code', '04')->first();
        $state05 = RefState::where('code', '05')->first();
        $state06 = RefState::where('code', '06')->first();
        $state07 = RefState::where('code', '07')->first();
        $state08 = RefState::where('code', '08')->first();
        $state09 = RefState::where('code', '09')->first();
        $state10 = RefState::where('code', '10')->first();
        $state11 = RefState::where('code', '11')->first();
        $state12 = RefState::where('code', '12')->first();
        $state13 = RefState::where('code', '13')->first();
        $state14 = RefState::where('code', '14')->first();
        $state15 = RefState::where('code', '15')->first();
        $state16 = RefState::where('code', '16')->first();

        $data = [

            [
                "code" => "0101",
                "desc" => "Jabatan Kerja Raya Negeri Johor"
                ,"ref_state_id" => $state01->id
            ],
            [
                "code" => "0102",
                "desc" => "Ibu Pejabat JKR Johor"
                ,"ref_state_id" => $state01->id
            ],
            [
                "code" => "0103",
                "desc" => "JKR Daerah Tangkak"
                ,"ref_state_id" => $state01->id
            ],
            [
                "code" => "0104",
                "desc" => "JKR Daerah Segamat"
                ,"ref_state_id" => $state01->id
            ],
            [
                "code" => "0105",
                "desc" => "JKR Daerah Pontian"
                ,"ref_state_id" => $state01->id
            ],
            [
                "code" => "0106",
                "desc" => "JKR Daerah Mersing"
                ,"ref_state_id" => $state01->id
            ],
            [
                "code" => "0107",
                "desc" => "JKR Daerah Muar"
                ,"ref_state_id" => $state01->id
            ],
            [
                "code" => "0108",
                "desc" => "JKR Daerah Johor Bharu"
                ,"ref_state_id" => $state01->id
            ],
            [
                "code" => "0109",
                "desc" => "JKR Daerah Kluang"
                ,"ref_state_id" => $state01->id
            ],
            [
                "code" => "0110",
                "desc" => "JKR Daerah Batu Pahat"
                ,"ref_state_id" => $state01->id
            ],
            [
                "code" => "0111",
                "desc" => "JKR Daerah Kota Tinggi"
                ,"ref_state_id" => $state01->id
            ],
            [
                "code" => "0112",
                "desc" => "JKR Daerah Kulai"
                ,"ref_state_id" => $state01->id
            ],
            [
                "code" => "0113",
                "desc" => "Cawangan Dasar dan Pengurusan Korporat"
                ,"ref_state_id" => $state01->id
            ],
            [

                "code" => "0114",
                "desc" => "Cawangan Kejuruteraan Mekanikal Negeri Johor"
                ,"ref_state_id" => $state01->id
            ],
            [

                "code" => "0115",
                "desc" => "Cawangan Kejuruteraan Elektrik Negeri Johor"
                ,"ref_state_id" => $state01->id
            ],
            [
                "code" => "0116",
                "desc" => "Cawangan Pengurusan Aset Bersepadu Negeri Johor"
                ,"ref_state_id" => $state01->id
            ],
            [
                "code" => "0117",
                "desc" => "Bahagian Reka Bentuk Awam & Struktur"
                ,"ref_state_id" => $state01->id
            ],
            [
                "code" => "0118",
                "desc" => "Bahagian Jalan"
                ,"ref_state_id" => $state01->id
            ],
            [
                "code" => "0119",
                "desc" => "Bahagian Bangunan"
                ,"ref_state_id" => $state01->id
            ],
            [
                "code" => "0120",
                "desc" => "Bahagian Arkitek"
                ,"ref_state_id" => $state01->id
            ],
            [
                "code" => "0121",
                "desc" => "Bahagian Senggara Aset Negeri"
                ,"ref_state_id" => $state01->id
            ],
            [
                "code" => "0122",
                "desc" => "Unit Ukur Wilayah Selatan"
                ,"ref_state_id" => $state01->id
            ],
            [
                "code" => "0123",
                "desc" => "Unit Tentera JKR Negeri Johor"
                ,"ref_state_id" => $state01->id
            ],
            [
                "code" => "0124",
                "desc" => "Kem Mahkota, Kluang"
                ,"ref_state_id" => $state01->id
            ],
            [
                "code" => "0125",
                "desc" => "Pasukan Projek Persekutuan Negeri Johor"
                ,"ref_state_id" => $state01->id
            ],
            [
                "code" => "0201",
                "desc" => "Jabatan Kerja Raya Negeri Kedah"
                ,"ref_state_id" => $state02->id
            ],
            [
                "code" => "0202",
                "desc" => "Ibu Pejabat JKR Kedah"
                ,"ref_state_id" => $state02->id
            ],
            [
                "code" => "0203",
                "desc" => "JKR Daerah Baling"
                ,"ref_state_id" => $state02->id
            ],
            [
                "code" => "0204",
                "desc" => "JKR Daerah Bandar Baharu/Kulim"
                ,"ref_state_id" => $state02->id
            ],
            [
                "code" => "0205",
                "desc" => "JKR Daerah Kota Setar"
                ,"ref_state_id" => $state02->id
            ],
            [
                "code" => "0206",
                "desc" => "JKR Daerah Kuala Muda"
                ,"ref_state_id" => $state02->id
            ],
            [
                "code" => "0207",
                "desc" => "JKR Daerah Kubang Pasu"
                ,"ref_state_id" => $state02->id
            ],
            [
                "code" => "0208",
                "desc" => "JKR Daerah Langkawi"
                ,"ref_state_id" => $state02->id
            ],
            [
                "code" => "0209",
                "desc" => "JKR Daerah Padang Terap"
                ,"ref_state_id" => $state02->id
            ],
            [
                "code" => "0210",
                "desc" => "JKR Daerah Pendang"
                ,"ref_state_id" => $state02->id
            ],
            [
                "code" => "0211",
                "desc" => "JKR Daerah Pokok Sena"
                ,"ref_state_id" => $state02->id
            ],
            [
                "code" => "0212",
                "desc" => "JKR Daerah Sik"
                ,"ref_state_id" => $state02->id
            ],
            [
                "code" => "0213",
                "desc" => "JKR Daerah Yan"
                ,"ref_state_id" => $state02->id
            ],
            [
                "code" => "0214",
                "desc" => "Cawangan Dasar dan Pengurusan Korporat"
                ,"ref_state_id" => $state02->id
            ],
            [
                "code" => "0215",
                "desc" => "Cawangan Kejuruteraan Mekanikal Negeri Kedah"
                ,"ref_state_id" => $state02->id
            ],
            [
                "code" => "0216",
                "desc" => "Cawangan Kejuruteraan Elektrik Negeri Kedah"
                ,"ref_state_id" => $state02->id
            ],
            [
                "code" => "0217",
                "desc" => "Cawangan Pengurusan Aset Bersepadu Negeri Kedah"
                ,"ref_state_id" => $state02->id
            ],
            [
                "code" => "0218",
                "desc" => "Bahagian Bangunan"
                ,"ref_state_id" => $state02->id
            ],
            [
                "code" => "0219",
                "desc" => "Bahagian Jalan"
                ,"ref_state_id" => $state02->id
            ],
            [
                "code" => "0220",
                "desc" => "Bahagian Ukur Bahan"
                ,"ref_state_id" => $state02->id
            ],
            [
                "code" => "0221",
                "desc" => "Unit Tentera JKR Negeri Kedah"
                ,"ref_state_id" => $state02->id
            ],
            [
                "code" => "0222",
                "desc" => "Pasukan Projek Persekutuan Negeri Kedah"
                ,"ref_state_id" => $state02->id
            ],
            [
                "code" => "0301",
                "desc" => "Jabatan Kerja Raya Negeri Kelantan "
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0302",
                "desc" => "Ibu Pejabat JKR Kelantan"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0303",
                "desc" => "JKR Jajahan Pasir Puteh"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0304",
                "desc" => "JKR Jajahan Machang"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0305",
                "desc" => "JKR Jajahan Pasir Mas"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0306",
                "desc" => "JKR Jajahan Bachok"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0307",
                "desc" => "JKR Jajahan Kota Bharu"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0308",
                "desc" => "JKR Jajahan Kuala Krai"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0309",
                "desc" => "JKR Jajahan Jeli"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0310",
                "desc" => "JKR Jajahan Tumpat"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0311",
                "desc" => "JKR Jajahan Tanah Merah"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0312",
                "desc" => "JKR Jajahan Gua Musang"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0313",
                "desc" => "JKR Kuari Pusat Bukit Buloh"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0314",
                "desc" => "JKR Kesedar"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0315",
                "desc" => "JKR Feri Pengkalan Kubor"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0316",
                "desc" => "Cawangan Dasar dan Pengurusan Korporat"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0317",
                "desc" => "Cawangan Kejuruteraan Mekanikal Negeri Kelantan"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0318",
                "desc" => "Cawangan Kejuruteraan Elektrik Negeri Kelantan"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0319",
                "desc" => "Cawangan Pengurusan Aset Bersepadu Negeri Kelantan"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0320",
                "desc" => "Bahagian Bangunan"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0321",
                "desc" => "Bahagian Jalanraya dan Jambatan"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0322",
                "desc" => "Bahagian Ukur Bahan"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0323",
                "desc" => "Bahagian Arkitek"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0324",
                "desc" => "Bahagian Senggara Persekutuan Negeri"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0325",
                "desc" => "Unit Ukur Wilayah Utara"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0326",
                "desc" => "Unit Tentera JKR Negeri Kelantan"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0327",
                "desc" => "Kem Gong Kedak"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0401",
                "desc" => "Jabatan Kerja Raya Negeri Melaka"
                ,"ref_state_id" => $state04->id
            ],
            [
                "code" => "0402",
                "desc" => "JKR Daerah Alor Gajah"
                ,"ref_state_id" => $state04->id
            ],
            [
                "code" => "0403",
                "desc" => "JKR Daerah Jasin"
                ,"ref_state_id" => $state04->id
            ],
            [
                "code" => "0404",
                "desc" => "JKR Daerah Melaka Tengah"
                ,"ref_state_id" => $state04->id
            ],
            [
                "code" => "0405",
                "desc" => "Cawangan Dasar dan Pengurusan Korporat"
                ,"ref_state_id" => $state04->id
            ],
            [
                "code" => "0406",
                "desc" => "Cawangan Kejuruteraan Mekanikal Negeri Melaka"
                ,"ref_state_id" => $state04->id
            ],
            [
                "code" => "0407",
                "desc" => "Cawangan Kejuruteraan Elektrik Negeri Melaka"
                ,"ref_state_id" => $state04->id
            ],
            [
                "code" => "0408",
                "desc" => "Cawangan Pengurusan Aset Bersepadu Negeri Melaka"
                ,"ref_state_id" => $state04->id
            ],
            [
                "code" => "0409",
                "desc" => "Pusat Kecemerlangan Kejuruteraan & Teknologi (CREaTE)"
                ,"ref_state_id" => $state04->id
            ],
            [
                "code" => "0410",
                "desc" => "Bahagian Bangunan"
                ,"ref_state_id" => $state04->id
            ],
            [
                "code" => "0411",
                "desc" => "Bahagian Jalan"
                ,"ref_state_id" => $state04->id
            ],
            [
                "code" => "0412",
                "desc" => "Bahagian Ukur Bahan"
                ,"ref_state_id" => $state04->id
            ],
            [
                "code" => "0413",
                "desc" => "Bahagian Arkitek"
                ,"ref_state_id" => $state04->id
            ],
            [
                "code" => "0414",
                "desc" => "Unit Tentera JKR Negeri Melaka"
                ,"ref_state_id" => $state04->id
            ],
            [
                "code" => "0415",
                "desc" => "Pasukan Projek Persekutuan Negeri Melaka"
                ,"ref_state_id" => $state04->id
            ],
            [
                "code" => "0501",
                "desc" => "Jabatan Kerja Raya Negeri Sembilan"
                ,"ref_state_id" => $state05->id
            ],
            [
                "code" => "0502",
                "desc" => "Ibu Pejabat JKR Negeri Sembilan"
                ,"ref_state_id" => $state05->id
            ],
            [
                "code" => "0503",
                "desc" => "JKR Daerah Jelebu"
                ,"ref_state_id" => $state05->id
            ],
            [
                "code" => "0504",
                "desc" => "JKR Daerah Jempol"
                ,"ref_state_id" => $state05->id
            ],
            [
                "code" => "0505",
                "desc" => "JKR Daerah Kuala Pilah"
                ,"ref_state_id" => $state05->id
            ],
            [
                "code" => "0506",
                "desc" => "JKR Daerah Port Dickson"
                ,"ref_state_id" => $state05->id
            ],
            [
                "code" => "0507",
                "desc" => "JKR Daerah Rembau"
                ,"ref_state_id" => $state05->id
            ],
            [
                "code" => "0508",
                "desc" => "JKR Daerah Seremban"
                ,"ref_state_id" => $state05->id
            ],
            [
                "code" => "0509",
                "desc" => "JKR Daerah Tampin"
                ,"ref_state_id" => $state05->id
            ],
            [
                "code" => "0510",
                "desc" => "Cawangan Dasar dan Pengurusan Korporat"
                ,"ref_state_id" => $state05->id
            ],
            [
                "code" => "0511",
                "desc" => "Cawangan Kejuruteraan Mekanikal Negeri Sembilan"
                ,"ref_state_id" => $state05->id
            ],
            [
                "code" => "0512",
                "desc" => "Cawangan Kejuruteraan Elektrik Negeri Sembilan"
                ,"ref_state_id" => $state05->id
            ],
            [
                "code" => "0513",
                "desc" => "Cawangan Pengurusan Aset Bersepadu Negeri Sembilan"
                ,"ref_state_id" => $state05->id
            ],
            [
                "code" => "0514",
                "desc" => "Bahagian Bangunan"
                ,"ref_state_id" => $state05->id
            ],
            [
                "code" => "0515",
                "desc" => "Bahagian Jalan"
                ,"ref_state_id" => $state05->id
            ],
            [
                "code" => "0516",
                "desc" => "Bahagian Ukur Bahan"
                ,"ref_state_id" => $state05->id
            ],
            [
                "code" => "0517",
                "desc" => "Bahagian Arkitek"
                ,"ref_state_id" => $state05->id
            ],
            [
                "code" => "0518",
                "desc" => "Unit Tentera JKR Negeri Sembilan"
                ,"ref_state_id" => $state05->id
            ],
            [
                "code" => "0601",
                "desc" => "Jabatan Kerja Raya Negeri Pahang"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0602",
                "desc" => "Ibu Pejabat JKR Pahang"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0603",
                "desc" => "JKR Daerah Bentong"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0604",
                "desc" => "JKR Daerah Cameron Highlands"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0605",
                "desc" => "JKR Daerah Jerantut"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0606",
                "desc" => "JKR Daerah Kuala Lipis"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0607",
                "desc" => "JKR Daerah Maran"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0608",
                "desc" => "JKR Daerah Bera"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0609",
                "desc" => "JKR Daerah Pekan"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0610",
                "desc" => "JKR Daerah Temerloh"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0611",
                "desc" => "JKR Daerah Rompin"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0612",
                "desc" => "JKR Daerah Kuantan"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0613",
                "desc" => "JKR Daerah Raub"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0614",
                "desc" => "JKR Kuari Pusat Pekan Awah"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0615",
                "desc" => "JKR Woksyop Bentong"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0616",
                "desc" => "Cawangan Dasar dan Pengurusan Korporat"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0617",
                "desc" => "Cawangan Kejuruteraan Mekanikal Negeri Pahang"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0618",
                "desc" => "Cawangan Kejuruteraan Elektrik Negeri Pahang"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0619",
                "desc" => "Cawangan Pengurusan Aset Bersepadu Pahang"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0620",
                "desc" => "Bahagian Bangunan"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0621",
                "desc" => "Bahagian Jalan"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0622",
                "desc" => "Bahagian Ukur Bahan"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0623",
                "desc" => "Bahagian Arkitek"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0624",
                "desc" => "Unit Ukur Wilayah Timur"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0625",
                "desc" => "Unit Tentera JKR Negeri Pahang"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0626",
                "desc" => "Pasukan Projek Persekutuan Negeri Pahang"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0701",
                "desc" => "Jabatan Kerja Raya Negeri Perak"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0702",
                "desc" => "Ibu Pejabat JKR Perak"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0703",
                "desc" => "JKR Daerah Manjung"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0704",
                "desc" => "JKR Daerah Kinta"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0705",
                "desc" => "JKR Daerah Kerian"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0706",
                "desc" => "JKR Daerah Hulu Perak"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0707",
                "desc" => "JKR Daerah Kuala Kangsar"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0708",
                "desc" => "JKR Daerah Bagan Datuk"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0709",
                "desc" => "JKR Daerah Muallim"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0710",
                "desc" => "JKR Daerah Batang Padang"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0711",
                "desc" => "JKR Daerah Larut Matang Dan Selama"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0712",
                "desc" => "JKR Daerah Hilir Perak"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0713",
                "desc" => "JKR Daerah Perak Tengah"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0714",
                "desc" => "JKR Daerah Kampar"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0715",
                "desc" => "Cawangan Dasar dan Pengurusan Korporat"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0716",
                "desc" => "Cawangan Kejuruteraan Mekanikal Negeri Perak"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0717",
                "desc" => "Cawangan Kejuruteraan Elektrik Negeri Perak"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0718",
                "desc" => "Cawangan Pengurusan Aset Bersepadu Perak"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0719",
                "desc" => "Bahagian Bangunan"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0720",
                "desc" => "Bahagian Jalan"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0721",
                "desc" => "Bahagian Ukur Bahan"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0722",
                "desc" => "Bahagian Arkitek"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0723",
                "desc" => "Unit Tentera JKR Negeri Perak (Ipoh)"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0724",
                "desc" => "Unit Tentera JKR Negeri Perak (Taiping)"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0725",
                "desc" => "Unit Tentera JKR Negeri Perak (TLDM Lumut)"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0801",
                "desc" => "Jabatan Kerja Raya Negeri Perlis"
                ,"ref_state_id" => $state08->id
            ],
            [
                "code" => "0802",
                "desc" => "Ibu Pejabat JKR Negeri Perlis"
                ,"ref_state_id" => $state08->id
            ],
            [
                "code" => "0803",
                "desc" => "Cawangan Dasar dan Pengurusan Korporat"
                ,"ref_state_id" => $state08->id
            ],
            [
                "code" => "0804",
                "desc" => "Cawangan Kejuruteraan Mekanikal Negeri Perlis"
                ,"ref_state_id" => $state08->id
            ],
            [
                "code" => "0805",
                "desc" => "Cawangan Kejuruteraan Elektrik Negeri Perlis"
                ,"ref_state_id" => $state08->id
            ],
            [
                "code" => "0806",
                "desc" => "Cawangan Pengurusan Aset Bersepadu Negeri Perlis"
                ,"ref_state_id" => $state08->id
            ],
            [
                "code" => "0901",
                "desc" => "Jabatan Kerja Raya Negeri Pulau Pinang"
                ,"ref_state_id" => $state09->id
            ],
            [
                "code" => "0902",
                "desc" => "Ibu Pejabat JKR Pulau Pinang"
                ,"ref_state_id" => $state09->id
            ],
            [
                "code" => "0903",
                "desc" => "JKR Daerah Barat Daya"
                ,"ref_state_id" => $state09->id
            ],
            [
                "code" => "0904",
                "desc" => "JKR Daerah Seberang Perai Selatan"
                ,"ref_state_id" => $state09->id
            ],
            [
                "code" => "0905",
                "desc" => "JKR Daerah Seberang Perai Tengah"
                ,"ref_state_id" => $state09->id
            ],
            [
                "code" => "0906",
                "desc" => "JKR Daerah Seberang Perai Utara"
                ,"ref_state_id" => $state09->id
            ],
            [
                "code" => "0907",
                "desc" => "JKR Daerah Timur Laut"
                ,"ref_state_id" => $state09->id
            ],
            [
                "code" => "0908",
                "desc" => "Cawangan Dasar dan Pengurusan Korporat"
                ,"ref_state_id" => $state09->id
            ],
            [
                "code" => "0909",
                "desc" => "Cawangan Kejuruteraan Mekanikal Negeri Pulau Pinang"
                ,"ref_state_id" => $state09->id
            ],
            [
                "code" => "0910",
                "desc" => "Cawangan Kejuruteraan Elektrik Negeri Pulau Pinang"
                ,"ref_state_id" => $state09->id
            ],
            [
                "code" => "0911",
                "desc" => "Cawangan Pengurusan Aset Bersepadu Negeri Pulau Pinang"
                ,"ref_state_id" => $state09->id
            ],
            [
                "code" => "0912",
                "desc" => "Unit Ukur Wilayah Utara"
                ,"ref_state_id" => $state09->id
            ],
            [
                "code" => "0913",
                "desc" => "Pasukan Projek Persekutuan Negeri Pulau Pinang"
                ,"ref_state_id" => $state09->id
            ],
            [
                "code" => "1001",
                "desc" => "Jabatan Kerja Raya Negeri Sabah"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1002",
                "desc" => "JKR Daerah Beluran"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1003",
                "desc" => "JKR Daerah Sandakan"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1004",
                "desc" => "JKR Daerah Labut dan Sugut"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1005",
                "desc" => "JKR Daerah Papar"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1006",
                "desc" => "JKR Daerah Kinabatangan / D.k. Tongod"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1007",
                "desc" => "JKR Daerah Kota Kinabalu"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1008",
                "desc" => "JKR Daerah Ranau"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1009",
                "desc" => "JKR Daerah Kota Belud"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1010",
                "desc" => "JKR Daerah Beaufort / D.l Mampakur"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1011",
                "desc" => "JKR Daerah Menumbuk"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1012",
                "desc" => "JKR Daerah Nabawan"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1013",
                "desc" => "JKR Daerah Sipitang"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1014",
                "desc" => "JKR Daerah Tenom"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1015",
                "desc" => "JKR Daerah Keningau"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1016",
                "desc" => "JKR Daerah Tambunan"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1017",
                "desc" => "JKR Daerah Labuan"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1018",
                "desc" => "JKR Daerah Kunak"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1019",
                "desc" => "JKR Daerah Tanparuli"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1020",
                "desc" => "JKR Daerah Penampang"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1021",
                "desc" => "JKR Daerah Kota Marudu"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1022",
                "desc" => "JKR Daerah Kudat"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1023",
                "desc" => "JKR Daerah Pitas"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1024",
                "desc" => "JKR Daerah Tawau"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1025",
                "desc" => "JKR Daerah Lahad Datu"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1026",
                "desc" => "JKR Daerah Semporna"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1027",
                "desc" => "JKR Daerah Tenghilan"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1028",
                "desc" => "JKR Daerah Menggatal / Inanam"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1029",
                "desc" => "JKR Daerah Banggi"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1030",
                "desc" => "JKR Daerah Tuaran"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1031",
                "desc" => "JKR Daerah Kuala Penyu"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1032",
                "desc" => "JKR Daerah Telupid"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1033",
                "desc" => "JKR Daerah Bundu Tuhan"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1034",
                "desc" => "JKR Daerah Kinabatangan"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1101",
                "desc" => "Jabatan Kerja Raya Negeri Sarawak"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1102",
                "desc" => "JKR Daerah Bau"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1103",
                "desc" => "JKR Daerah Serian"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1104",
                "desc" => "JKR Daerah Simunjan"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1105",
                "desc" => "JKR Daerah Lundu"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1106",
                "desc" => "JKR Daerah Kuching"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1107",
                "desc" => "JKR Daerah Simanggang"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1108",
                "desc" => "JKR Daerah Lubuk Antu"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1109",
                "desc" => "JKR Daerah Saribas"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1110",
                "desc" => "JKR Daerah Kalaka"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1111",
                "desc" => "JKR Daerah Sibu"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1112",
                "desc" => "JKR Daerah Mukah"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1113",
                "desc" => "JKR Daerah Kanowit"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1114",
                "desc" => "JKR Daerah Tebedu"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1115",
                "desc" => "JKR Daerah Sadong Jaya"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1116",
                "desc" => "JKR Daerah Oya/dalat"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1117",
                "desc" => "JKR Daerah Miri"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1118",
                "desc" => "JKR Daerah Bintulu"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1119",
                "desc" => "JKR Daerah Baram"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1120",
                "desc" => "JKR Daerah Limbang"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1121",
                "desc" => "JKR Daerah Lawas"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1122",
                "desc" => "JKR Daerah Sarikei"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1123",
                "desc" => "JKR Daerah Bintangor"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1124",
                "desc" => "JKR Daerah Matu / Daro"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1125",
                "desc" => "JKR Daerah Julau"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1126",
                "desc" => "JKR Daerah Kapit"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1127",
                "desc" => "JKR Daerah Song"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1128",
                "desc" => "JKR Daerah Belaga"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1129",
                "desc" => "JKR Daerah Gedung"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1129",
                "desc" => "JKR Daerah Kota Samarahan"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1130",
                "desc" => "JKR Daerah Meradung"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1131",
                "desc" => "JKR Daerah Sri Aman"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1132",
                "desc" => "JKR Daerah Debak"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1133",
                "desc" => "JKR Daerah Siburan"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1134",
                "desc" => "JKR Daerah Budu"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1135",
                "desc" => "JKR Daerah Meludang"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1136",
                "desc" => "JKR Daerah Nanga Merit"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1137",
                "desc" => "JKR Daerah Pendam"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1201",
                "desc" => "Jabatan Kerja Raya Negeri Selangor "
                ,"ref_state_id" => $state12->id
            ],
            [
                "code" => "1202",
                "desc" => "Ibu Pejabat JKR Selangor"
                ,"ref_state_id" => $state12->id
            ],
            [
                "code" => "1203",
                "desc" => "JKR Daerah Kuala Langat"
                ,"ref_state_id" => $state12->id
            ],
            [
                "code" => "1204",
                "desc" => "JKR Daerah Petaling"
                ,"ref_state_id" => $state12->id
            ],
            [
                "code" => "1205",
                "desc" => "JKR Daerah Sabak Bernam"
                ,"ref_state_id" => $state12->id
            ],
            [
                "code" => "1206",
                "desc" => "JKR Daerah Hulu Langat"
                ,"ref_state_id" => $state12->id
            ],
            [
                "code" => "1207",
                "desc" => "JKR Daerah Hulu Selangor"
                ,"ref_state_id" => $state12->id
            ],
            [
                "code" => "1208",
                "desc" => "JKR Daerah Gombak"
                ,"ref_state_id" => $state12->id
            ],
            [
                "code" => "1209",
                "desc" => "JKR Daerah Sepang"
                ,"ref_state_id" => $state12->id
            ],
            [
                "code" => "1210",
                "desc" => "JKR Daerah Klang"
                ,"ref_state_id" => $state12->id
            ],
            [
                "code" => "1211",
                "desc" => "JKR Daerah Kuala Selangor"
                ,"ref_state_id" => $state12->id
            ],
            [
                "code" => "1212",
                "desc" => "Cawangan Dasar dan Pengurusan Korporat"
                ,"ref_state_id" => $state12->id
            ],
            [
                "code" => "1213",
                "desc" => "Cawangan Kejuruteraan Mekanikal Negeri Selangor"
                ,"ref_state_id" => $state12->id
            ],
            [
                "code" => "1214",
                "desc" => "Cawangan Kejuruteraan Elektrik Negeri Selangor"
                ,"ref_state_id" => $state12->id
            ],
            [
                "code" => "1215",
                "desc" => "Cawangan Pengurusan Aset Bersepadu Selangor"
                ,"ref_state_id" => $state12->id
            ],
            [
                "code" => "1216",
                "desc" => "Bahagian Bangunan"
                ,"ref_state_id" => $state12->id
            ],
            [
                "code" => "1217",
                "desc" => "Bahagian Jalan"
                ,"ref_state_id" => $state12->id
            ],
            [
                "code" => "1218",
                "desc" => "Bahagian Ukur Bahan"
                ,"ref_state_id" => $state12->id
            ],
            [
                "code" => "1219",
                "desc" => "Bahagian Arkitek"
                ,"ref_state_id" => $state12->id
            ],
            [
                "code" => "1220",
                "desc" => "Pasukan Projek Persekutuan Negeri Selangor"
                ,"ref_state_id" => $state12->id
            ],
            [
                "code" => "1301",
                "desc" => "Jabatan Kerja Raya Negeri Terengganu"
                ,"ref_state_id" => $state13->id
            ],
            [
                "code" => "1302",
                "desc" => "Ibu Pejabat JKR Terengganu"
                ,"ref_state_id" => $state13->id
            ],
            [
                "code" => "1303",
                "desc" => "JKR Daerah Dungun"
                ,"ref_state_id" => $state13->id
            ],
            [
                "code" => "1304",
                "desc" => "JKR Daerah Besut"
                ,"ref_state_id" => $state13->id
            ],
            [
                "code" => "1305",
                "desc" => "JKR Daerah Marang"
                ,"ref_state_id" => $state13->id
            ],
            [
                "code" => "1306",
                "desc" => "JKR Daerah Setiu"
                ,"ref_state_id" => $state13->id
            ],
            [
                "code" => "1307",
                "desc" => "JKR Daerah Kemaman"
                ,"ref_state_id" => $state13->id
            ],
            [
                "code" => "1308",
                "desc" => "JKR Daerah Kuala Terengganu"
                ,"ref_state_id" => $state13->id
            ],
            [
                "code" => "1309",
                "desc" => "JKR Daerah Hulu Terengganu"
                ,"ref_state_id" => $state13->id
            ],
            [
                "code" => "1310",
                "desc" => "Cawangan Dasar dan Pengurusan Korporat"
                ,"ref_state_id" => $state13->id
            ],
            [
                "code" => "1311",
                "desc" => "Cawangan Kejuruteraan Mekanikal Negeri Terengganu"
                ,"ref_state_id" => $state13->id
            ],
            [
                "code" => "1312",
                "desc" => "Cawangan Kejuruteraan Elektrik Negeri Terengganu"
                ,"ref_state_id" => $state13->id
            ],
            [
                "code" => "1313",
                "desc" => "Cawangan Pengurusan Aset Bersepadu Terengganu"
                ,"ref_state_id" => $state13->id
            ],
            [
                "code" => "1314",
                "desc" => "Bahagian Bangunan"
                ,"ref_state_id" => $state13->id
            ],
            [
                "code" => "1315",
                "desc" => "Bahagian Jalan"
                ,"ref_state_id" => $state13->id
            ],
            [
                "code" => "1316",
                "desc" => "Bahagian Ukur Bahan"
                ,"ref_state_id" => $state13->id
            ],
            [
                "code" => "1317",
                "desc" => "Bahagian Arkitek"
                ,"ref_state_id" => $state13->id
            ],
            [
                "code" => "1318",
                "desc" => "Unit Ukur Wilayah Timur"
                ,"ref_state_id" => $state13->id
            ],
            [
                "code" => "1319",
                "desc" => "Unit Tentera JKR Negeri Terengganu"
                ,"ref_state_id" => $state13->id
            ],
            [
                "code" => "1320",
                "desc" => "Pasukan Projek Persekutuan Negeri Terengganu"
                ,"ref_state_id" => $state13->id
            ],
            [
                "code" => "1401",
                "desc" => "JKR Woksyop Persekutuan"
                ,"ref_state_id" => $state14->id
            ],
            [
                "code" => "1402",
                "desc" => "JKR Wilayah Persekutuan Kuala Lumpur"
                ,"ref_state_id" => $state14->id
            ],
            [
                "code" => "1403",
                "desc" => "Ibu Pejabat Cawangan Kejuruteraan Awam & Struktur"
                ,"ref_state_id" => $state14->id
            ],
            [
                "code" => "1404",
                "desc" => "Ibu Pejabat Cawangan Jalan"
                ,"ref_state_id" => $state14->id
            ],
            [
                "code" => "1405",
                "desc" => "Ibu Pejabat Cawangan Kejuruteraan Mekanikal"
                ,"ref_state_id" => $state14->id
            ],
            [
                "code" => "1406",
                "desc" => "Ibu Pejabat Cawangan Kontrak Dan Ukur Bahan"
                ,"ref_state_id" => $state14->id
            ],
            [
                "code" => "1407",
                "desc" => "Ibu Pejabat Cawangan Kejuruteraan Elektrik"
                ,"ref_state_id" => $state14->id
            ],
            [
                "code" => "1408",
                "desc" => "Ibu Pejabat Cawangan Arkitek"
                ,"ref_state_id" => $state14->id
            ],
            [
                "code" => "1409",
                "desc" => "Ibu Pejabat Cawangan Perancangan Aset Bersepadu"
                ,"ref_state_id" => $state14->id
            ],
            [
                "code" => "1410",
                "desc" => "Ibu Pejabat Cawangan Kerja Bangunan Am 1"
                ,"ref_state_id" => $state14->id
            ],
            [
                "code" => "1411",
                "desc" => "Ibu Pejabat Cawangan Alam Sekitar & Kecekapan Tenaga"
                ,"ref_state_id" => $state14->id
            ],
            [
                "code" => "1412",
                "desc" => "Ibu Pejabat Cawangan Kerja Keselamatan"
                ,"ref_state_id" => $state14->id
            ],
            [
                "code" => "1413",
                "desc" => "Ibu Pejabat Cawangan Kerja Kesihatan"
                ,"ref_state_id" => $state14->id
            ],
            [
                "code" => "1414",
                "desc" => "Ibu Pejabat Cawangan Kejuruteraan Cerun"
                ,"ref_state_id" => $state14->id
            ],
            [
                "code" => "1415",
                "desc" => "Ibu Pejabat Cawangan Senggara Fasiliti Bangunan"
                ,"ref_state_id" => $state14->id
            ],
            [
                "code" => "1416",
                "desc" => "Ibu Pejabat Cawangan Dasar & Pengurusan Korporat"
                ,"ref_state_id" => $state14->id
            ],
            [
                "code" => "1417",
                "desc" => "Ibu Pejabat Cawangan Senggara Fasiliti Jalan"
                ,"ref_state_id" => $state14->id
            ],
            [
                "code" => "1418",
                "desc" => "Ibu Pejabat Cawangan Kejuruteraan Geoteknik"
                ,"ref_state_id" => $state14->id
            ],
            [
                "code" => "1419",
                "desc" => "Ibu Pejabat Cawangan Kejuruteraan Infrastruktur Pengangkutan"
                ,"ref_state_id" => $state14->id
            ],
            [
                "code" => "1420",
                "desc" => "Ibu Pejabat Cawangan Kerja Bangunan Am 2"
                ,"ref_state_id" => $state14->id
            ],
            [
                "code" => "1421",
                "desc" => "Ibu Pejabat Cawangan Kerja Pendidikan"
                ,"ref_state_id" => $state14->id
            ],
            [
                "code" => "1501",
                "desc" => "JKR W.P. LABUAN"
                ,"ref_state_id" => $state15->id
            ],
            [
                "code" => "1601",
                "desc" => "JKR W.P. Putrajaya"
                ,"ref_state_id" => $state16->id
            ]

        ];
        for ($i=0; $i <count($data); $i++) {
            $data[$i]['desc'] = strtoupper($data[$i]['desc']);
            FleetPlacement::create($data[$i]);
        }
    }
}
