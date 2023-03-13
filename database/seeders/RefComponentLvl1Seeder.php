<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RefComponentLvl1;
use App\Models\KomponenKenderaanLvl1MigrateNew;
// use Illuminate\Support\Facades\Log;

class RefComponentLvl1Seeder extends Seeder
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
        // $listMigrate = KomponenKenderaanLvl1Migrate::all();
        $listMigrate = KomponenKenderaanLvl1MigrateNew::all();

        foreach ($listMigrate as $key) {

            $code = str_pad(((int)$key->id), 2, '0', STR_PAD_LEFT);

            RefComponentLvl1::create([
                'id' => $key->id,
                'component' => $key->komponen,
                // 'code_assessment' => $key->kod_penilaian,
                'code' => $code

                //'model_id' => $vehicleModel ? $vehicleModel->id : null
            ]);


        }

        //
    }
}
