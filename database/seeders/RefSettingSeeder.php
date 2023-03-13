<?php

namespace Database\Seeders;

use App\Models\RefSetting;
use Illuminate\Database\Seeder;

class RefSettingSeeder extends Seeder
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
                'name' => 'Frekuensi Peringatan Saman',
                'is_required' => true,
                'element_type' => 'radio'
            ],
            [
                //Permohonan
                'code' => '02',
                'name' => 'Siap Siaga Bencana' ,
                'is_required' => false,
                'element_type' => 'switch'
            ],
            [
                'code' => '03',
                'name' => 'Frekuensi Peringatan Servis Kenderaan (Sebelum)' ,
                'is_required' => true,
                'element_type' => 'radio'
            ],
            [
                'code' => '04',
                'name' => 'Tetapan Kemaskini Selepas Disahkan' ,
                'is_required' => true,
                'element_type' => 'checkbox'
            ],
            [
                'code' => '05',
                'name' => 'Tetapan Kemaskini Sijil Penilaian' ,
                'is_required' => true,
                'element_type' => 'checkbox'
            ]
        ];

        RefSetting::insert($data);
    }
}
