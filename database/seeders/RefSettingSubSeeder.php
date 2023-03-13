<?php

namespace Database\Seeders;

use App\Models\RefSetting;
use App\Models\RefSettingSub;
use Illuminate\Database\Seeder;

class RefSettingSubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $RefSetting01 = RefSetting::where('code', '01')->first();
        $RefSetting02 = RefSetting::where('code', '02')->first();
        $RefSetting03 = RefSetting::where('code', '03')->first();
        $RefSetting04 = RefSetting::where('code', '04')->first();
        $RefSetting05 = RefSetting::where('code', '05')->first();


        // 'status',
        // 'type',
        // 'function_for'

        $data = [
            [
                'code' => '01',
                'name' => 'Hari',
                'setting_id' => $RefSetting01->id,
                'type' => 'radio',
                'function_for' => 'scheduler',
                'status' => 1,
                'value' => 0
            ],
            [
                'code' => '02',
                'name' => 'Minggu',
                'setting_id' => $RefSetting01->id,
                'type' => 'radio',
                'function_for' => 'scheduler',
                'status' => 0,
                'value' => 0
            ],
            [
                'code' => '03',
                'name' => 'Bulan',
                'setting_id' => $RefSetting01->id,
                'type' => 'radio',
                'function_for' => 'scheduler',
                'status' => 0,
                'value' => 0
            ],
            [
                'code' => '01',
                'name' => 'Permohonan Kenderaan Bencana',
                'setting_id' => $RefSetting02->id,
                'type' => 'switch',
                'function_for' => 'disaster_ready',
                'status' => 1,
                'value' => 0
            ],
            [
                'code' => '01',
                'name' => '3 Hari',
                'setting_id' => $RefSetting03->id,
                'type' => 'radio',
                'function_for' => 'scheduler',
                'status' => 1,
                'value' => 3
            ],
            [
                'code' => '02',
                'name' => '5 Hari',
                'setting_id' => $RefSetting03->id,
                'type' => 'radio',
                'function_for' => 'scheduler',
                'status' => 0,
                'value' => 5
            ],
            [
                'code' => '03',
                'name' => '7 Hari',
                'setting_id' => $RefSetting03->id,
                'type' => 'radio',
                'function_for' => 'scheduler',
                'status' => 0,
                'value' => 7
            ],
            [
                'code' => '04',
                'name' => '14 Hari',
                'setting_id' => $RefSetting03->id,
                'type' => 'radio',
                'function_for' => 'scheduler',
                'status' => 0,
                'value' => 14
            ],

            [
                'code' => '01',
                'name' => 'Woksyop Persekutuan',
                'setting_id' => $RefSetting04->id,
                'type' => 'checkbox',
                'function_for' => 'assessment_accident',
                'status' => 0,
                'value' => 1
            ],
            [
                'code' => '02',
                'name' => 'Woksyop Selangor',
                'setting_id' => $RefSetting04->id,
                'type' => 'checkbox',
                'function_for' => 'assessment_accident',
                'status' => 0,
                'value' => 11
            ],
            ////////
            [
                'code' => '01',
                'name' => 'Penilaian Kenderaan Baharu',
                'setting_id' => $RefSetting05->id,
                'type' => 'checkbox',
                'function_for' => 'assessment_new',
                'status' => 0,
                'value' => 0
            ],
            [
                'code' => '02',
                'name' => 'Penilaian Keselamatan & Prestasi',
                'setting_id' => $RefSetting05->id,
                'type' => 'checkbox',
                'function_for' => 'assessment_safety',
                'status' => 0,
                'value' => 0
            ],
            [
                'code' => '03',
                'name' => 'Penilaian Harga Semasa',
                'setting_id' => $RefSetting05->id,
                'type' => 'checkbox',
                'function_for' => 'assessment_currvalue',
                'status' => 0,
                'value' => 0
            ],
            [
                'code' => '04',
                'name' => 'Penilaian Pinjaman Kerajaan',
                'setting_id' => $RefSetting05->id,
                'type' => 'checkbox',
                'function_for' => 'assessment_gov_loan',
                'status' => 0,
                'value' => 0
            ],
            [
                'code' => '05',
                'name' => 'Penilaian Pelupusan',
                'setting_id' => $RefSetting05->id,
                'type' => 'checkbox',
                'function_for' => 'assessment_disposal',
                'status' => 0,
                'value' => 0
            ]

        ];

        RefSettingSub::insert($data);
    }
}
