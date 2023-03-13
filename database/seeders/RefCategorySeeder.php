<?php

namespace Database\Seeders;

use App\Models\RefCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class RefCategorySeeder extends Seeder
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
                'code' => '01',
                'name' => 'Kenderaan Penumpang'
            ],
            [
                'code' => '02',
                'name' => 'Loji / Jentera'
            ],
            [
                'code' => '03',
                'name' => 'Kenderaan Pengangkut'
            ]
        ];

        for ($i=0; $i <count($data); $i++) { 
            $data[$i]['name'] = strtoupper($data[$i]['name']);
            RefCategory::create($data[$i]);
        }

    }
}
