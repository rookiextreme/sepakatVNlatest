<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
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
                'name' => 'Kereta'
            ],
            [
                'name' => 'Bas'
            ],
            [
                'name' => 'Motosikal'
            ]
        ];

        \App\Models\Kenderaan\Kategori\Kategori::insert($data);
    }
}
