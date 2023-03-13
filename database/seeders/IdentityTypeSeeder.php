<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class IdentityTypeSeeder extends Seeder
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
                'identity' => 'Polis',
                'type' => 'ID Polis'
            ],
            [
                'identity' => 'Tentera',
                'type' => 'ID Tentera'
            ],
            [
                'identity' => 'Warganegara',
                'type' => 'No Kad Pengenalan'
            ],
            [
                'identity' => 'Passport',
                'type' => 'No Passport'
            ],
        ];

        \App\Models\Identifier\IdentityType::insert($data);
    }
}
