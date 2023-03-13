<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AssessmentTypeSeeder extends Seeder
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
                'desc' => 'Penilaian Kenderaan Baharu',
                'created_at' => Carbon::now()
            ],
            [
                'code' => '02',
                'desc' => 'Penilaian Keselamatan dan Prestasi',
                'created_at' => Carbon::now()
            ],
            [
                'code' => '03',
                'desc' => 'Penilaian Kemalangan',
                'created_at' => Carbon::now()
            ],
            [
                'code' => '04',
                'desc' => 'Penilaian Harga Semasa',
                'created_at' => Carbon::now()
            ],
            [
                'code' => '05',
                'desc' => 'Penilaian Pinjaman Kerajaan',
                'created_at' => Carbon::now()
            ],
            [
                'code' => '06',
                'desc' => 'Penilaian Pelupusan',
                'created_at' => Carbon::now()
            ]
        ];

        \App\Models\Assessment\AssessmentType::insert($data);
    }
}
