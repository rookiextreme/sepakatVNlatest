<?php

namespace Database\Seeders;

use App\Models\Location\Daerah;
use Illuminate\Database\Seeder;

class DaerahSeeder extends Seeder
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
                'state_id' => 1,
                'name' => 'Masai',
                'poskod' => '81750'
            ],
            [
                'state_id' => 4,
                'name' => 'Jasin',
                'poskod' => '77000'
            ],
            [
                'state_id' => 4,
                'name' => 'Masjid Tanah',
                'poskod' => '77100'
            ],
            [
                'state_id' => 15,
                'name' => 'Sepang',
                'poskod' => '63000'
            ],
        ];

        Daerah::insert($data);
    }
}
