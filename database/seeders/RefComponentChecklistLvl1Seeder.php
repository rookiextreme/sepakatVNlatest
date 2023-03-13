<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RefComponentChecklistLvl1;
use App\Models\KomponenKenderaanLvl1Migrate;
// use Illuminate\Support\Facades\Log;

class RefComponentChecklistLvl1Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    // 'id',
    // 'komponen',
    // 'kod_penilaian'

    public function run()
    {
        $listMigrate = KomponenKenderaanLvl1Migrate::all();

        $codeHasSelection = ['02','03','05','06'];

        foreach ($listMigrate as $key) {

            $code = str_pad(((int)$key->id), 2, '0', STR_PAD_LEFT);

            $componentshortname = str_replace('PEMERIKSAAN', '', $key->komponen);

            RefComponentChecklistLvl1::create([
                'id' => $key->id,
                'component' => $key->komponen,
                // 'code_assessment' => $key->kod_penilaian,
                'code' => $code,
                'component_shortname' => $componentshortname,
                'has_selection' => in_array($code, $codeHasSelection) ? true : false

                //'model_id' => $vehicleModel ? $vehicleModel->id : null
            ]);


        }

        //
    }
}
