<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Identifier\Jawatan;

class JawatanSeeder extends Seeder
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
                'jawatan' => 'Penolong Jurutera'
            ],
            [
                'jawatan' => 'Penolong Jurutera Mekanikal'
            ],
            [
                'jawatan' => 'Jurutera'
            ],
            [
                'jawatan' => 'Ketua Penolong Jurutera'
            ],
            [
                'jawatan' => 'Ketua Jurutera'
            ],
            [
                'jawatan' => 'Lain-lain'
            ],
        ];

        $create = Jawatan::insert($data);
    }
}
