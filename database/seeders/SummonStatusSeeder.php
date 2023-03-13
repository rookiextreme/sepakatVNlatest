<?php

namespace Database\Seeders;

use App\Models\Saman\Status\StatusSaman;
use Illuminate\Database\Seeder;

class SummonStatusSeeder extends Seeder
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
                'code' => '00',
                'name' => 'Dibuang'
            ],
            [
                'code' => '01',
                'name' => 'Draf'
            ],
            [
                'code' => '02',
                'name' => 'Belum Selesai'
            ],
            [
                'code' => '03',
                'name' => 'Selesai'
            ],
            [
                'code' => '04',
                'name' => 'Tukar Milik Saman'
            ]
        ];
        for ($i=0; $i <count($data); $i++) {
            $data[$i]['name'] = strtoupper($data[$i]['name']);
            StatusSaman::create($data[$i]);
        }
    }
}
