<?php

namespace Database\Seeders;

use App\Models\RefOwner;
use App\Models\RefState;
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
                "name" => "Jabatan Kerja Raya Negeri Johor"
                ,"ref_state_id" => $state01->id
            ],
            [
                "code" => "0102",
                "name" => "Ibu Pejabat JKR Johor"
                ,"ref_state_id" => $state01->id
            ],
            [
                "code" => "0103",
                "name" => "JKR Daerah Tangkak"
                ,"ref_state_id" => $state01->id
            ],
            [
                "code" => "0104",
                "name" => "JKR Daerah Segamat"
                ,"ref_state_id" => $state01->id
            ],
            [
                "code" => "0105",
                "name" => "JKR Daerah Pontian"
                ,"ref_state_id" => $state01->id
            ],
            [
                "code" => "0106",
                "name" => "JKR Daerah Mersing"
                ,"ref_state_id" => $state01->id
            ],
            [
                "code" => "0107",
                "name" => "JKR Daerah Muar"
                ,"ref_state_id" => $state01->id
            ],
            [
                "code" => "0108",
                "name" => "JKR Daerah Johor Bharu"
                ,"ref_state_id" => $state01->id
            ],
            [
                "code" => "0109",
                "name" => "JKR Daerah Kluang"
                ,"ref_state_id" => $state01->id
            ],
            [
                "code" => "0110",
                "name" => "JKR Daerah Batu Pahat"
                ,"ref_state_id" => $state01->id
            ],
            [
                "code" => "0111",
                "name" => "JKR Daerah Kota Tinggi"
                ,"ref_state_id" => $state01->id
            ],
            [
                "code" => "0112",
                "name" => "JKR Daerah Kulai"
                ,"ref_state_id" => $state01->id
            ],
            [
                "code" => "0113",
                "name" => "Cawangan Dasar dan Pengurusan Korporat"
                ,"ref_state_id" => $state01->id
            ],
            [

                "code" => "0114",
                "name" => "Cawangan Kejuruteraan Mekanikal Negeri Johor"
                ,"ref_state_id" => $state01->id
            ],
            [

                "code" => "0115",
                "name" => "Cawangan Kejuruteraan Elektrik Negeri Johor"
                ,"ref_state_id" => $state01->id
            ],
            [
                "code" => "0116",
                "name" => "Cawangan Pengurusan Aset Bersepadu Negeri Johor"
                ,"ref_state_id" => $state01->id
            ],
            [
                "code" => "0117",
                "name" => "Bahagian Reka Bentuk Awam & Struktur"
                ,"ref_state_id" => $state01->id
            ],
            [
                "code" => "0118",
                "name" => "Bahagian Jalan"
                ,"ref_state_id" => $state01->id
            ],
            [
                "code" => "0119",
                "name" => "Bahagian Bangunan"
                ,"ref_state_id" => $state01->id
            ],
            [
                "code" => "0120",
                "name" => "Bahagian Arkitek"
                ,"ref_state_id" => $state01->id
            ],
            [
                "code" => "0121",
                "name" => "Bahagian Senggara Aset Negeri"
                ,"ref_state_id" => $state01->id
            ],
            [
                "code" => "0122",
                "name" => "Unit Ukur Wilayah Selatan"
                ,"ref_state_id" => $state01->id
            ],
            [
                "code" => "0123",
                "name" => "Unit Tentera JKR Negeri Johor"
                ,"ref_state_id" => $state01->id
            ],
            [
                "code" => "0124",
                "name" => "Kem Mahkota, Kluang"
                ,"ref_state_id" => $state01->id
            ],
            [
                "code" => "0125",
                "name" => "Pasukan Projek Persekutuan Negeri Johor"
                ,"ref_state_id" => $state01->id
            ],
            [
                "code" => "0201",
                "name" => "Jabatan Kerja Raya Negeri Kedah"
                ,"ref_state_id" => $state02->id
            ],
            [
                "code" => "0202",
                "name" => "Ibu Pejabat JKR Kedah"
                ,"ref_state_id" => $state02->id
            ],
            [
                "code" => "0203",
                "name" => "JKR Daerah Baling"
                ,"ref_state_id" => $state02->id
            ],
            [
                "code" => "0204",
                "name" => "JKR Daerah Bandar Baharu/Kulim"
                ,"ref_state_id" => $state02->id
            ],
            [
                "code" => "0205",
                "name" => "JKR Daerah Kota Setar"
                ,"ref_state_id" => $state02->id
            ],
            [
                "code" => "0206",
                "name" => "JKR Daerah Kuala Muda"
                ,"ref_state_id" => $state02->id
            ],
            [
                "code" => "0207",
                "name" => "JKR Daerah Kubang Pasu"
                ,"ref_state_id" => $state02->id
            ],
            [
                "code" => "0208",
                "name" => "JKR Daerah Langkawi"
                ,"ref_state_id" => $state02->id
            ],
            [
                "code" => "0209",
                "name" => "JKR Daerah Padang Terap"
                ,"ref_state_id" => $state02->id
            ],
            [
                "code" => "0210",
                "name" => "JKR Daerah Pendang"
                ,"ref_state_id" => $state02->id
            ],
            [
                "code" => "0211",
                "name" => "JKR Daerah Pokok Sena"
                ,"ref_state_id" => $state02->id
            ],
            [
                "code" => "0212",
                "name" => "JKR Daerah Sik"
                ,"ref_state_id" => $state02->id
            ],
            [
                "code" => "0213",
                "name" => "JKR Daerah Yan"
                ,"ref_state_id" => $state02->id
            ],
            [
                "code" => "0214",
                "name" => "Cawangan Dasar dan Pengurusan Korporat"
                ,"ref_state_id" => $state02->id
            ],
            [
                "code" => "0215",
                "name" => "Cawangan Kejuruteraan Mekanikal Negeri Kedah"
                ,"ref_state_id" => $state02->id
            ],
            [
                "code" => "0216",
                "name" => "Cawangan Kejuruteraan Elektrik Negeri Kedah"
                ,"ref_state_id" => $state02->id
            ],
            [
                "code" => "0217",
                "name" => "Cawangan Pengurusan Aset Bersepadu Negeri Kedah"
                ,"ref_state_id" => $state02->id
            ],
            [
                "code" => "0218",
                "name" => "Bahagian Bangunan"
                ,"ref_state_id" => $state02->id
            ],
            [
                "code" => "0219",
                "name" => "Bahagian Jalan"
                ,"ref_state_id" => $state02->id
            ],
            [
                "code" => "0220",
                "name" => "Bahagian Ukur Bahan"
                ,"ref_state_id" => $state02->id
            ],
            [
                "code" => "0221",
                "name" => "Unit Tentera JKR Negeri Kedah"
                ,"ref_state_id" => $state02->id
            ],
            [
                "code" => "0222",
                "name" => "Pasukan Projek Persekutuan Negeri Kedah"
                ,"ref_state_id" => $state02->id
            ],
            [
                "code" => "0301",
                "name" => "Jabatan Kerja Raya Negeri Kelantan "
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0302",
                "name" => "Ibu Pejabat JKR Kelantan"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0303",
                "name" => "JKR Jajahan Pasir Puteh"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0304",
                "name" => "JKR Jajahan Machang"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0305",
                "name" => "JKR Jajahan Pasir Mas"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0306",
                "name" => "JKR Jajahan Bachok"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0307",
                "name" => "JKR Jajahan Kota Bharu"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0308",
                "name" => "JKR Jajahan Kuala Krai"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0309",
                "name" => "JKR Jajahan Jeli"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0310",
                "name" => "JKR Jajahan Tumpat"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0311",
                "name" => "JKR Jajahan Tanah Merah"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0312",
                "name" => "JKR Jajahan Gua Musang"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0313",
                "name" => "JKR Kuari Pusat Bukit Buloh"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0314",
                "name" => "JKR Kesedar"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0315",
                "name" => "JKR Feri Pengkalan Kubor"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0316",
                "name" => "Cawangan Dasar dan Pengurusan Korporat"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0317",
                "name" => "Cawangan Kejuruteraan Mekanikal Negeri Kelantan"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0318",
                "name" => "Cawangan Kejuruteraan Elektrik Negeri Kelantan"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0319",
                "name" => "Cawangan Pengurusan Aset Bersepadu Kelantan"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0320",
                "name" => "Bahagian Bangunan"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0321",
                "name" => "Bahagian Jalanraya dan Jambatan"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0322",
                "name" => "Bahagian Ukur Bahan"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0323",
                "name" => "Bahagian Arkitek"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0324",
                "name" => "Bahagian Senggara Persekutuan Negeri"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0325",
                "name" => "Unit Ukur Wilayah Utara"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0326",
                "name" => "Unit Tentera JKR Negeri Kelantan"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0327",
                "name" => "Kem Gong Kedak"
                ,"ref_state_id" => $state03->id
            ],
            [
                "code" => "0401",
                "name" => "Jabatan Kerja Raya Negeri Melaka"
                ,"ref_state_id" => $state04->id
            ],
            [
                "code" => "0402",
                "name" => "JKR Daerah Alor Gajah"
                ,"ref_state_id" => $state04->id
            ],
            [
                "code" => "0403",
                "name" => "JKR Daerah Jasin"
                ,"ref_state_id" => $state04->id
            ],
            [
                "code" => "0404",
                "name" => "JKR Daerah Melaka Tengah"
                ,"ref_state_id" => $state04->id
            ],
            [
                "code" => "0405",
                "name" => "Cawangan Dasar dan Pengurusan Korporat"
                ,"ref_state_id" => $state04->id
            ],
            [
                "code" => "0406",
                "name" => "Cawangan Kejuruteraan Mekanikal Negeri Melaka"
                ,"ref_state_id" => $state04->id
            ],
            [
                "code" => "0407",
                "name" => "Cawangan Kejuruteraan Elektrik Negeri Melaka"
                ,"ref_state_id" => $state04->id
            ],
            [
                "code" => "0408",
                "name" => "Cawangan Pengurusan Aset Bersepadu Negeri Melaka"
                ,"ref_state_id" => $state04->id
            ],
            [
                "code" => "0409",
                "name" => "Pusat Kecemerlangan Kejuruteraan & Teknologi (CREaTE)"
                ,"ref_state_id" => $state04->id
            ],
            [
                "code" => "0410",
                "name" => "Bahagian Bangunan"
                ,"ref_state_id" => $state04->id
            ],
            [
                "code" => "0411",
                "name" => "Bahagian Jalan"
                ,"ref_state_id" => $state04->id
            ],
            [
                "code" => "0412",
                "name" => "Bahagian Ukur Bahan"
                ,"ref_state_id" => $state04->id
            ],
            [
                "code" => "0413",
                "name" => "Bahagian Arkitek"
                ,"ref_state_id" => $state04->id
            ],
            [
                "code" => "0414",
                "name" => "Unit Tentera JKR Negeri Melaka"
                ,"ref_state_id" => $state04->id
            ],
            [
                "code" => "0415",
                "name" => "Pasukan Projek Persekutuan Negeri Melaka"
                ,"ref_state_id" => $state04->id
            ],
            [
                "code" => "0501",
                "name" => "Jabatan Kerja Raya Negeri Sembilan"
                ,"ref_state_id" => $state05->id
            ],
            [
                "code" => "0502",
                "name" => "Ibu Pejabat JKR Negeri Sembilan"
                ,"ref_state_id" => $state05->id
            ],
            [
                "code" => "0503",
                "name" => "JKR Daerah Jelebu"
                ,"ref_state_id" => $state05->id
            ],
            [
                "code" => "0504",
                "name" => "JKR Daerah Jempol"
                ,"ref_state_id" => $state05->id
            ],
            [
                "code" => "0505",
                "name" => "JKR Daerah Kuala Pilah"
                ,"ref_state_id" => $state05->id
            ],
            [
                "code" => "0506",
                "name" => "JKR Daerah Port Dickson"
                ,"ref_state_id" => $state05->id
            ],
            [
                "code" => "0507",
                "name" => "JKR Daerah Rembau"
                ,"ref_state_id" => $state05->id
            ],
            [
                "code" => "0508",
                "name" => "JKR Daerah Seremban"
                ,"ref_state_id" => $state05->id
            ],
            [
                "code" => "0509",
                "name" => "JKR Daerah Tampin"
                ,"ref_state_id" => $state05->id
            ],
            [
                "code" => "0510",
                "name" => "Cawangan Dasar dan Pengurusan Korporat"
                ,"ref_state_id" => $state05->id
            ],
            [
                "code" => "0511",
                "name" => "Cawangan Kejuruteraan Mekanikal Negeri Sembilan"
                ,"ref_state_id" => $state05->id
            ],
            [
                "code" => "0512",
                "name" => "Cawangan Kejuruteraan Elektrik Negeri Sembilan"
                ,"ref_state_id" => $state05->id
            ],
            [
                "code" => "0513",
                "name" => "Cawangan Pengurusan Aset Bersepadu Negeri Sembilan"
                ,"ref_state_id" => $state05->id
            ],
            [
                "code" => "0514",
                "name" => "Bahagian Bangunan"
                ,"ref_state_id" => $state05->id
            ],
            [
                "code" => "0515",
                "name" => "Bahagian Jalan"
                ,"ref_state_id" => $state05->id
            ],
            [
                "code" => "0516",
                "name" => "Bahagian Ukur Bahan"
                ,"ref_state_id" => $state05->id
            ],
            [
                "code" => "0517",
                "name" => "Bahagian Arkitek"
                ,"ref_state_id" => $state05->id
            ],
            [
                "code" => "0518",
                "name" => "Unit Tentera JKR Negeri Sembilan"
                ,"ref_state_id" => $state05->id
            ],
            [
                "code" => "0601",
                "name" => "Jabatan Kerja Raya Negeri Pahang"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0602",
                "name" => "Ibu Pejabat JKR Pahang"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0603",
                "name" => "JKR Daerah Bentong"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0604",
                "name" => "JKR Daerah Cameron Highlands"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0605",
                "name" => "JKR Daerah Jerantut"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0606",
                "name" => "JKR Daerah Kuala Lipis"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0607",
                "name" => "JKR Daerah Maran"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0608",
                "name" => "JKR Daerah Bera"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0609",
                "name" => "JKR Daerah Pekan"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0610",
                "name" => "JKR Daerah Temerloh"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0611",
                "name" => "JKR Daerah Rompin"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0612",
                "name" => "JKR Daerah Kuantan"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0613",
                "name" => "JKR Daerah Raub"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0614",
                "name" => "JKR Kuari Pusat Pekan Awah"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0615",
                "name" => "JKR Woksyop Bentong"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0616",
                "name" => "Cawangan Dasar dan Pengurusan Korporat"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0617",
                "name" => "Cawangan Kejuruteraan Mekanikal Negeri Pahang"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0618",
                "name" => "Cawangan Kejuruteraan Elektrik Negeri Pahang"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0619",
                "name" => "Cawangan Pengurusan Aset Bersepadu Pahang"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0620",
                "name" => "Bahagian Bangunan"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0621",
                "name" => "Bahagian Jalan"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0622",
                "name" => "Bahagian Ukur Bahan"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0623",
                "name" => "Bahagian Arkitek"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0624",
                "name" => "Unit Ukur Wilayah Timur"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0625",
                "name" => "Unit Tentera JKR Negeri Pahang"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0626",
                "name" => "Pasukan Projek Persekutuan Negeri Pahang"
                ,"ref_state_id" => $state06->id
            ],
            [
                "code" => "0701",
                "name" => "Jabatan Kerja Raya Negeri Perak"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0702",
                "name" => "Ibu Pejabat JKR Perak"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0703",
                "name" => "JKR Daerah Manjung"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0704",
                "name" => "JKR Daerah Kinta"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0705",
                "name" => "JKR Daerah Kerian"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0706",
                "name" => "JKR Daerah Hulu Perak"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0707",
                "name" => "JKR Daerah Kuala Kangsar"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0708",
                "name" => "JKR Daerah Bagan Datuk"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0709",
                "name" => "JKR Daerah Muallim"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0710",
                "name" => "JKR Daerah Batang Padang"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0711",
                "name" => "JKR Daerah Larut Matang Dan Selama"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0712",
                "name" => "JKR Daerah Hilir Perak"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0713",
                "name" => "JKR Daerah Perak Tengah"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0714",
                "name" => "JKR Daerah Kampar"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0715",
                "name" => "Cawangan Dasar dan Pengurusan Korporat"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0716",
                "name" => "Cawangan Kejuruteraan Mekanikal Negeri Perak"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0717",
                "name" => "Cawangan Kejuruteraan Elektrik Negeri Perak"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0718",
                "name" => "Cawangan Pengurusan Aset Bersepadu Perak"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0719",
                "name" => "Bahagian Bangunan"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0720",
                "name" => "Bahagian Jalan"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0721",
                "name" => "Bahagian Ukur Bahan"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0722",
                "name" => "Bahagian Arkitek"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0723",
                "name" => "Unit Tentera JKR Negeri Perak (Ipoh)"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0724",
                "name" => "Unit Tentera JKR Negeri Perak (Taiping)"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0725",
                "name" => "Unit Tentera JKR Negeri Perak (TLDM Lumut)"
                ,"ref_state_id" => $state07->id
            ],
            [
                "code" => "0801",
                "name" => "Jabatan Kerja Raya Negeri Perlis"
                ,"ref_state_id" => $state08->id
            ],
            [
                "code" => "0802",
                "name" => "Ibu Pejabat JKR Negeri Perlis"
                ,"ref_state_id" => $state08->id
            ],
            [
                "code" => "0803",
                "name" => "Cawangan Dasar dan Pengurusan Korporat"
                ,"ref_state_id" => $state08->id
            ],
            [
                "code" => "0804",
                "name" => "Cawangan Kejuruteraan Mekanikal Negeri Perlis"
                ,"ref_state_id" => $state08->id
            ],
            [
                "code" => "0805",
                "name" => "Cawangan Kejuruteraan Elektrik Negeri Perlis"
                ,"ref_state_id" => $state08->id
            ],
            [
                "code" => "0806",
                "name" => "Cawangan Pengurusan Aset Bersepadu Negeri Perlis"
                ,"ref_state_id" => $state08->id
            ],
            [
                "code" => "0901",
                "name" => "Jabatan Kerja Raya Negeri Pulau Pinang"
                ,"ref_state_id" => $state09->id
            ],
            [
                "code" => "0902",
                "name" => "Ibu Pejabat JKR Pulau Pinang"
                ,"ref_state_id" => $state09->id
            ],
            [
                "code" => "0903",
                "name" => "JKR Daerah Barat Daya"
                ,"ref_state_id" => $state09->id
            ],
            [
                "code" => "0904",
                "name" => "JKR Daerah Seberang Perai Selatan"
                ,"ref_state_id" => $state09->id
            ],
            [
                "code" => "0905",
                "name" => "JKR Daerah Seberang Perai Tengah"
                ,"ref_state_id" => $state09->id
            ],
            [
                "code" => "0906",
                "name" => "JKR Daerah Seberang Perai Utara"
                ,"ref_state_id" => $state09->id
            ],
            [
                "code" => "0907",
                "name" => "JKR Daerah Timur Laut"
                ,"ref_state_id" => $state09->id
            ],
            [
                "code" => "0908",
                "name" => "Cawangan Dasar dan Pengurusan Korporat"
                ,"ref_state_id" => $state09->id
            ],
            [
                "code" => "0909",
                "name" => "Cawangan Kejuruteraan Mekanikal Negeri Pulau Pinang"
                ,"ref_state_id" => $state09->id
            ],
            [
                "code" => "0910",
                "name" => "Cawangan Kejuruteraan Elektrik Negeri Pulau Pinang"
                ,"ref_state_id" => $state09->id
            ],
            [
                "code" => "0911",
                "name" => "Cawangan Pengurusan Aset Bersepadu Negeri Pulau Pinang"
                ,"ref_state_id" => $state09->id
            ],
            [
                "code" => "0912",
                "name" => "Unit Ukur Wilayah Utara"
                ,"ref_state_id" => $state09->id
            ],
            [
                "code" => "0913",
                "name" => "Pasukan Projek Persekutuan Negeri Pulau Pinang"
                ,"ref_state_id" => $state09->id
            ],
            [
                "code" => "1001",
                "name" => "Jabatan Kerja Raya Negeri Sabah"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1002",
                "name" => "JKR Daerah Beluran"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1003",
                "name" => "JKR Daerah Sandakan"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1004",
                "name" => "JKR Daerah Labut dan Sugut"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1005",
                "name" => "JKR Daerah Papar"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1006",
                "name" => "JKR Daerah Kinabatangan / D.k. Tongod"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1007",
                "name" => "JKR Daerah Kota Kinabalu"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1008",
                "name" => "JKR Daerah Ranau"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1009",
                "name" => "JKR Daerah Kota Belud"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1010",
                "name" => "JKR Daerah Beaufort / D.l Mampakur"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1011",
                "name" => "JKR Daerah Menumbuk"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1012",
                "name" => "JKR Daerah Nabawan"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1013",
                "name" => "JKR Daerah Sipitang"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1014",
                "name" => "JKR Daerah Tenom"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1015",
                "name" => "JKR Daerah Keningau"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1016",
                "name" => "JKR Daerah Tambunan"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1017",
                "name" => "JKR Daerah Labuan"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1018",
                "name" => "JKR Daerah Kunak"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1019",
                "name" => "JKR Daerah Tanparuli"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1020",
                "name" => "JKR Daerah Penampang"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1021",
                "name" => "JKR Daerah Kota Marudu"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1022",
                "name" => "JKR Daerah Kudat"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1023",
                "name" => "JKR Daerah Pitas"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1024",
                "name" => "JKR Daerah Tawau"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1025",
                "name" => "JKR Daerah Lahad Datu"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1026",
                "name" => "JKR Daerah Semporna"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1027",
                "name" => "JKR Daerah Tenghilan"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1028",
                "name" => "JKR Daerah Menggatal / Inanam"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1029",
                "name" => "JKR Daerah Banggi"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1030",
                "name" => "JKR Daerah Tuaran"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1031",
                "name" => "JKR Daerah Kuala Penyu"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1032",
                "name" => "JKR Daerah Telupid"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1033",
                "name" => "JKR Daerah Bundu Tuhan"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1034",
                "name" => "JKR Daerah Kinabatangan"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1101",
                "name" => "Jabatan Kerja Raya Negeri Sarawak"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1102",
                "name" => "JKR Daerah Bau"
                ,"ref_state_id" => $state10->id
            ],
            [
                "code" => "1103",
                "name" => "JKR Daerah Serian"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1104",
                "name" => "JKR Daerah Simunjan"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1105",
                "name" => "JKR Daerah Lundu"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1106",
                "name" => "JKR Daerah Kuching"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1107",
                "name" => "JKR Daerah Simanggang"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1108",
                "name" => "JKR Daerah Lubuk Antu"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1109",
                "name" => "JKR Daerah Saribas"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1110",
                "name" => "JKR Daerah Kalaka"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1111",
                "name" => "JKR Daerah Sibu"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1112",
                "name" => "JKR Daerah Mukah"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1113",
                "name" => "JKR Daerah Kanowit"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1114",
                "name" => "JKR Daerah Tebedu"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1115",
                "name" => "JKR Daerah Sadong Jaya"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1116",
                "name" => "JKR Daerah Oya/dalat"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1117",
                "name" => "JKR Daerah Miri"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1118",
                "name" => "JKR Daerah Bintulu"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1119",
                "name" => "JKR Daerah Baram"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1120",
                "name" => "JKR Daerah Limbang"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1121",
                "name" => "JKR Daerah Lawas"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1122",
                "name" => "JKR Daerah Sarikei"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1123",
                "name" => "JKR Daerah Bintangor"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1124",
                "name" => "JKR Daerah Matu / Daro"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1125",
                "name" => "JKR Daerah Julau"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1126",
                "name" => "JKR Daerah Kapit"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1127",
                "name" => "JKR Daerah Song"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1128",
                "name" => "JKR Daerah Belaga"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1129",
                "name" => "JKR Daerah Gedung"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1129",
                "name" => "JKR Daerah Kota Samarahan"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1130",
                "name" => "JKR Daerah Meradung"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1131",
                "name" => "JKR Daerah Sri Aman"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1132",
                "name" => "JKR Daerah Debak"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1133",
                "name" => "JKR Daerah Siburan"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1134",
                "name" => "JKR Daerah Budu"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1135",
                "name" => "JKR Daerah Meludang"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1136",
                "name" => "JKR Daerah Nanga Merit"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1137",
                "name" => "JKR Daerah Pendam"
                ,"ref_state_id" => $state11->id
            ],
            [
                "code" => "1201",
                "name" => "Jabatan Kerja Raya Negeri Selangor "
                ,"ref_state_id" => $state12->id
            ],
            [
                "code" => "1202",
                "name" => "Ibu Pejabat JKR Selangor"
                ,"ref_state_id" => $state12->id
            ],
            [
                "code" => "1203",
                "name" => "JKR Daerah Kuala Langat"
                ,"ref_state_id" => $state12->id
            ],
            [
                "code" => "1204",
                "name" => "JKR Daerah Petaling"
                ,"ref_state_id" => $state12->id
            ],
            [
                "code" => "1205",
                "name" => "JKR Daerah Sabak Bernam"
                ,"ref_state_id" => $state12->id
            ],
            [
                "code" => "1206",
                "name" => "JKR Daerah Hulu Langat"
                ,"ref_state_id" => $state12->id
            ],
            [
                "code" => "1207",
                "name" => "JKR Daerah Hulu Selangor"
                ,"ref_state_id" => $state12->id
            ],
            [
                "code" => "1208",
                "name" => "JKR Daerah Gombak"
                ,"ref_state_id" => $state12->id
            ],
            [
                "code" => "1209",
                "name" => "JKR Daerah Sepang"
                ,"ref_state_id" => $state12->id
            ],
            [
                "code" => "1210",
                "name" => "JKR Daerah Klang"
                ,"ref_state_id" => $state12->id
            ],
            [
                "code" => "1211",
                "name" => "JKR Daerah Kuala Selangor"
                ,"ref_state_id" => $state12->id
            ],
            [
                "code" => "1212",
                "name" => "Cawangan Dasar dan Pengurusan Korporat"
                ,"ref_state_id" => $state12->id
            ],
            [
                "code" => "1213",
                "name" => "Cawangan Kejuruteraan Mekanikal Negeri Selangor"
                ,"ref_state_id" => $state12->id
            ],
            [
                "code" => "1214",
                "name" => "Cawangan Kejuruteraan Elektrik Negeri Selangor"
                ,"ref_state_id" => $state12->id
            ],
            [
                "code" => "1215",
                "name" => "Cawangan Pengurusan Aset Bersepadu Selangor"
                ,"ref_state_id" => $state12->id
            ],
            [
                "code" => "1216",
                "name" => "Bahagian Bangunan"
                ,"ref_state_id" => $state12->id
            ],
            [
                "code" => "1217",
                "name" => "Bahagian Jalan"
                ,"ref_state_id" => $state12->id
            ],
            [
                "code" => "1218",
                "name" => "Bahagian Ukur Bahan"
                ,"ref_state_id" => $state12->id
            ],
            [
                "code" => "1219",
                "name" => "Bahagian Arkitek"
                ,"ref_state_id" => $state12->id
            ],
            [
                "code" => "1220",
                "name" => "Pasukan Projek Persekutuan Negeri Selangor"
                ,"ref_state_id" => $state12->id
            ],
            [
                "code" => "1301",
                "name" => "Jabatan Kerja Raya Negeri Terengganu"
                ,"ref_state_id" => $state13->id
            ],
            [
                "code" => "1302",
                "name" => "Ibu Pejabat JKR Terengganu"
                ,"ref_state_id" => $state13->id
            ],
            [
                "code" => "1303",
                "name" => "JKR Daerah Dungun"
                ,"ref_state_id" => $state13->id
            ],
            [
                "code" => "1304",
                "name" => "JKR Daerah Besut"
                ,"ref_state_id" => $state13->id
            ],
            [
                "code" => "1305",
                "name" => "JKR Daerah Marang"
                ,"ref_state_id" => $state13->id
            ],
            [
                "code" => "1306",
                "name" => "JKR Daerah Setiu"
                ,"ref_state_id" => $state13->id
            ],
            [
                "code" => "1307",
                "name" => "JKR Daerah Kemaman"
                ,"ref_state_id" => $state13->id
            ],
            [
                "code" => "1308",
                "name" => "JKR Daerah Kuala Terengganu"
                ,"ref_state_id" => $state13->id
            ],
            [
                "code" => "1309",
                "name" => "JKR Daerah Hulu Terengganu"
                ,"ref_state_id" => $state13->id
            ],
            [
                "code" => "1310",
                "name" => "Cawangan Dasar dan Pengurusan Korporat"
                ,"ref_state_id" => $state13->id
            ],
            [
                "code" => "1311",
                "name" => "Cawangan Kejuruteraan Mekanikal Negeri Terengganu"
                ,"ref_state_id" => $state13->id
            ],
            [
                "code" => "1312",
                "name" => "Cawangan Kejuruteraan Elektrik Negeri Terengganu"
                ,"ref_state_id" => $state13->id
            ],
            [
                "code" => "1313",
                "name" => "Cawangan Pengurusan Aset Bersepadu Terengganu"
                ,"ref_state_id" => $state13->id
            ],
            [
                "code" => "1314",
                "name" => "Bahagian Bangunan"
                ,"ref_state_id" => $state13->id
            ],
            [
                "code" => "1315",
                "name" => "Bahagian Jalan"
                ,"ref_state_id" => $state13->id
            ],
            [
                "code" => "1316",
                "name" => "Bahagian Ukur Bahan"
                ,"ref_state_id" => $state13->id
            ],
            [
                "code" => "1317",
                "name" => "Bahagian Arkitek"
                ,"ref_state_id" => $state13->id
            ],
            [
                "code" => "1318",
                "name" => "Unit Ukur Wilayah Timur"
                ,"ref_state_id" => $state13->id
            ],
            [
                "code" => "1319",
                "name" => "Unit Tentera JKR Negeri Terengganu"
                ,"ref_state_id" => $state13->id
            ],
            [
                "code" => "1320",
                "name" => "Pasukan Projek Persekutuan Negeri Terengganu"
                ,"ref_state_id" => $state13->id
            ],
            [
                "code" => "1401",
                "name" => "JKR Woskyop Persekutuan"
                ,"ref_state_id" => $state14->id
            ],
            [
                "code" => "1402",
                "name" => "JKR Wilayah Persekutuan Kuala Lumpur"
                ,"ref_state_id" => $state14->id
            ],
            [
                "code" => "1403",
                "name" => "Ibu Pejabat Cawangan Kejuruteraan Awam & Struktur"
                ,"ref_state_id" => $state14->id
            ],
            [
                "code" => "1404",
                "name" => "Ibu Pejabat Cawangan Jalan"
                ,"ref_state_id" => $state14->id
            ],
            [
                "code" => "1405",
                "name" => "Ibu Pejabat Cawangan Kejuruteraan Mekanikal"
                ,"ref_state_id" => $state14->id
            ],
            [
                "code" => "1406",
                "name" => "Ibu Pejabat Cawangan Kontrak Dan Ukur Bahan"
                ,"ref_state_id" => $state14->id
            ],
            [
                "code" => "1407",
                "name" => "Ibu Pejabat Cawangan Kejuruteraan Elektrik"
                ,"ref_state_id" => $state14->id
            ],
            [
                "code" => "1408",
                "name" => "Ibu Pejabat Cawangan Arkitek"
                ,"ref_state_id" => $state14->id
            ],
            [
                "code" => "1409",
                "name" => "Ibu Pejabat Cawangan Perancangan Aset Bersepadu"
                ,"ref_state_id" => $state14->id
            ],
            [
                "code" => "1410",
                "name" => "Ibu Pejabat Cawangan Kerja Bangunan Am 1"
                ,"ref_state_id" => $state14->id
            ],
            [
                "code" => "1411",
                "name" => "Ibu Pejabat Cawangan Alam Sekitar & Kecekapan Tenaga"
                ,"ref_state_id" => $state14->id
            ],
            [
                "code" => "1412",
                "name" => "Ibu Pejabat Cawangan Kerja Keselamatan"
                ,"ref_state_id" => $state14->id
            ],
            [
                "code" => "1413",
                "name" => "Ibu Pejabat Cawangan Kerja Kesihatan"
                ,"ref_state_id" => $state14->id
            ],
            [
                "code" => "1414",
                "name" => "Ibu Pejabat Cawangan Kejuruteraan Cerun"
                ,"ref_state_id" => $state14->id
            ],
            [
                "code" => "1415",
                "name" => "Ibu Pejabat Cawangan Senggara Fasiliti Bangunan"
                ,"ref_state_id" => $state14->id
            ],
            [
                "code" => "1416",
                "name" => "Ibu Pejabat Cawangan Dasar & Pengurusan Korporat"
                ,"ref_state_id" => $state14->id
            ],
            [
                "code" => "1417",
                "name" => "Ibu Pejabat Cawangan Senggara Fasiliti Jalan"
                ,"ref_state_id" => $state14->id
            ],
            [
                "code" => "1418",
                "name" => "Ibu Pejabat Cawangan Kejuruteraan Geoteknik"
                ,"ref_state_id" => $state14->id
            ],
            [
                "code" => "1419",
                "name" => "Ibu Pejabat Cawangan Kejuruteraan Infrastruktur Pengangkutan"
                ,"ref_state_id" => $state14->id
            ],
            [
                "code" => "1420",
                "name" => "Ibu Pejabat Cawangan Kerja Bangunan Am 2"
                ,"ref_state_id" => $state14->id
            ],
            [
                "code" => "1421",
                "name" => "Ibu Pejabat Cawangan Kerja Pendidikan"
                ,"ref_state_id" => $state14->id
            ],
            [
                "code" => "1501",
                "name" => "JKR W.P. LABUAN"
                ,"ref_state_id" => $state15->id
            ],
            [
                "code" => "1601",
                "name" => "JKR W.P. Putrajaya"
                ,"ref_state_id" => $state16->id
            ]



        ];

        RefOwner::insert($data);
    }
}
