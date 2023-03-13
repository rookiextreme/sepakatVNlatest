<?php

namespace Database\Seeders;

use App\Models\RefTypeAnnouncement;
use Illuminate\Database\Seeder;

class RefTypeAnnouncementSeeder extends Seeder
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
                'desc' => 'Buletin'
            ],
            [
                'code' => '02',
                'desc' => 'Peristiwa'
            ]
        ];

        RefTypeAnnouncement::insert($data);
    }
}
