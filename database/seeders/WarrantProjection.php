<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Identifier\Jawatan;
use App\Models\Maintenance\WarrantProjection as MaintenanceWarrantProjection;

class WarrantProjection extends Seeder
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
                'month' => 'JAN',
                'percent' => '10',
                'value' => '1',
                'month_desc' => 'JANUARY'
            ],
            [
                'month' => 'FEB',
                'percent' => '10',
                'value' => '2',
                'month_desc' => 'FEBUARY'
            ],
            [
                'month' => 'MAR',
                'percent' => '30',
                'value' => '3',
                'month_desc' => 'MARCH'
            ],
            [
                'month' => 'APRIL',
                'percent' => '40',
                'value' => '4',
                'month_desc' => 'APRIL'
            ],
            [
                'month' => 'MAY',
                'percent' => '50',
                'value' => '5',
                'month_desc' => 'MAY'
            ],
            [
                'month' => 'JUNE',
                'percent' => '60',
                'value' => '6',
                'month_desc' => 'JUNE'
            ],
            [
                'month' => 'JULY',
                'percent' => '70',
                'value' => '7',
                'month_desc' => 'JULY'
            ],
            [
                'month' => 'AUG',
                'percent' => '80',
                'value' => '8',
                'month_desc' => 'AUGUST'
            ],
            [
                'month' => 'SEP',
                'percent' => '90',
                'value' => '9',
                'month_desc' => 'SEPTEMBER'
            ],
            [
                'month' => 'OCT',
                'percent' => '100',
                'value' => '10',
                'month_desc' => 'OCTOBER'
            ],
            [
                'month' => 'NOV',
                'percent' => '100',
                'value' => '11',
                'month_desc' => 'NOVEMBER'
            ],
            [
                'month' => 'DEC',
                'percent' => '100',
                'value' => '12',
                'month_desc' => 'DECEMBER'
            ],
        ];

        $create = MaintenanceWarrantProjection::insert($data);
    }
}

