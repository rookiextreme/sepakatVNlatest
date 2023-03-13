<?php

namespace Database\Seeders;

use App\Models\Assessment\AssessmentDisposalPercentage;
use Illuminate\Database\Seeder;

class DisposalPercentageSeeder extends Seeder
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
                'value' => '75',
                'desc' => '75%'
            ],
            [
                'code' => '02',
                'value' => '50',
                'desc' => '50%'
            ],
            [
                'code' => '03',
                'value' => '25',
                'desc' => '25%'
            ],
            [
                'code' => '04',
                'value' => '100',
                'desc' => 'ROSAK TERUK'
            ]
        ];

        AssessmentDisposalPercentage::insert($data);
    }
}
