<?php

namespace Database\Seeders;

use App\Models\Assessment\AssessmentOwnership;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AssessmentOwnershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $AssessmentOwnershipData = [
            [
                "code" => "01",
                "name" => "Kerajaan",
                "desc_bm" => "",
                "desc_en" => "",
                'created_at' => Carbon::now()
            ],
            [
                "code" => "02",
                "name" => "Syarikat",
                "desc_bm" => "",
                "desc_en" => "",
                'created_at' => Carbon::now()
            ],
            [
                "code" => "03",
                "name" => "Awam",
                "desc_bm" => "",
                "desc_en" => "",
                'created_at' => Carbon::now()
            ]
        ];

        for ($i=0; $i <count($AssessmentOwnershipData); $i++) {
            $AssessmentOwnershipData[$i]['name'] = strtoupper($AssessmentOwnershipData[$i]['name']);
            AssessmentOwnership::create($AssessmentOwnershipData[$i]);
        }
    }
}
