<?php

namespace Database\Seeders;

use App\Models\Kenderaan\Kategori\SubKategori;
use Illuminate\Database\Seeder;

class SubKategoriSeeder extends Seeder
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
                'kategori_id' => 1,
                'sub_kategori' => 'Kereta Sedan'
            ],
            [
                'kategori_id' => 1,
                'sub_kategori' => 'Kereta Eksekutif'
            ],
            [
                'kategori_id' => 1,
                'sub_kategori' => 'MPV'
            ],
            [
                'kategori_id' => 1,
                'sub_kategori' => 'Van'
            ],
            [
                'kategori_id' => 2,
                'sub_kategori' => 'Bas Eksekutif'
            ],
            [
                'kategori_id' => 2,
                'sub_kategori' => 'Bas 40 Penumpang'
            ],
            [
                'kategori_id' => 2,
                'sub_kategori' => 'Bas 24 Penumpang'
            ],
            [
                'kategori_id' => 3,
                'sub_kategori' => 'Motosikal 2 Roda'
            ],
            [
                'kategori_id' => 3,
                'sub_kategori' => 'Motosikal 3 Roda'
            ],
        ];
        for ($i=0; $i <count($data); $i++) {
            $data[$i]['name'] = strtoupper($data[$i]['name']);
            SubKategori::create($data[$i]);
        }
    }
}
