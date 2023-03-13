<?php

namespace Database\Seeders;

use App\Models\RefRoleAccess;
use Illuminate\Database\Seeder;

class RefRoleAccessSeeder extends Seeder
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
                'desc_bm' => 'Sistem',
                'desc_en' => 'System'
            ],
            [
                'code' => '02',
                'desc_bm' => 'Pengurusan',
                'desc_en' => 'Business'
            ],
            [
                'code' => '03',
                'desc_bm' => 'Operasi',
                'desc_en' => 'Operation'
            ],
            [
                'code' => '04',
                'desc_bm' => 'Awam',
                'desc_en' => 'Public'
            ]

        ];

        //\App\Models\RefRoleAccess::insert($data);
        for ($i=0; $i <count($data); $i++) {
            $data[$i]['desc_bm'] = strtoupper($data[$i]['desc_bm']);
            $data[$i]['desc_en'] = strtoupper($data[$i]['desc_en']);
            RefRoleAccess::create($data[$i]);
        }
    }
}
