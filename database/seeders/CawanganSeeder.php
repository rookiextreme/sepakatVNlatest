<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CawanganSeeder extends Seeder
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
                "cawangan" =>  "CAWANGAN  ALAM SEKITAR & KECEKAPAN TENAGA"
              ],
              [
                "cawangan" =>  "CAWANGAN  ARKITEK"
              ],
              [
                "cawangan" =>  "CAWANGAN KEJURUTERAAN CERUN"
              ],
              [
                "cawangan" =>  "CAWANGAN  DASAR & PENGURUSAN KORPORAT"
              ],
              [
                "cawangan" =>  "CAWANGAN  JALAN"
              ],
              [
                "cawangan" =>  "CAWANGAN  KERJA BANGUNAN AM 1"
              ],
              [
                "cawangan" =>  "CAWANGAN  KERJA BANGUNAN AM 2"
              ],
              [
                "cawangan" =>  "CAWANGAN  KERJA KESELAMATAN"
              ],
              [
                "cawangan" =>  "CAWANGAN  KERJA KESIHATAN"
              ],
              [
                "cawangan" =>  "CAWANGAN  KERJA PENDIDIKAN"
              ],
              [
                "cawangan" =>  "CAWANGAN  KONTRAK DAN UKUR BAHAN"
              ],
              [
                "cawangan" =>  "CAWANGAN  PERANCANGAN ASET BERSEPADU"
              ],
              [
                "cawangan" =>  "CAWANGAN  SENGGARA FASILITI BANGUNAN"
              ],
              [
                "cawangan" =>  "CAWANGAN  SENGGARA FASILITI JALAN"
              ],
              [
                "cawangan" =>  "CAWANGAN KEJURUTERAAN AWAM & STRUKTUR"
              ],
              [
                "cawangan" =>  "CAWANGAN KEJURUTERAAN ELEKTRIK"
              ],
              [
                "cawangan" =>  "CAWANGAN KEJURUTERAAN GEOTEKNIK"
              ],
              [
                "cawangan" =>  "CAWANGAN KEJURUTERAAN INFRASTRUKTUR PENGANGKUTAN"
              ],
              [
                "cawangan" =>  "CAWANGAN KEJURUTERAAN MEKANIKAL"
              ],
              [
                "cawangan" =>  "PUSAT KECEMERLANGAN KEJURUTERAAN DAN TEKNOLOGI JKR (CREaTE)"
              ]
            ];

        \App\Models\Location\Cawangan::insert($data);
    }
}
