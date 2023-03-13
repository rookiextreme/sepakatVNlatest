<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class NegeriSeeder extends Seeder
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
                'negeri' => 'Johor'
            ],
            [
                'negeri' => 'Kedah'
            ],
            [
                'negeri' => 'Kelantan'
            ],
            [
                'negeri' => 'Melaka'
            ],
            [
                'negeri' => 'Negeri Sembilan'
            ],
            [
                'negeri' => 'Pahang'
            ],
            [
                'negeri' => 'Perak'
            ],
            [
                'negeri' => 'Perlis'
            ],
            [
                'negeri' => 'Pulau Pinang'
            ],
            [
                'negeri' => 'Sabah'
            ],
            [
                'negeri' => 'Sarawak'
            ],
            [
                'negeri' => 'Terengganu'
            ],
            [
                'negeri' => 'Wilayah Persekutuan Kuala Lumpur'
            ],
            [
                'negeri' => 'Wilayah Persekutuan Labuan'
            ],
            [
                'negeri' => 'Wilayah Persekutuan Putrajaya'
            ],
            [
                'negeri' => 'Selangor'
            ]
        ];

        \App\Models\Location\Negeri::insert($data);
    }
}
