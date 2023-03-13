<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RefComponentLvl3;
use App\Models\KomponenKenderaanLvl3Migrate;

class RefComponentLvl3Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $listMigrate = KomponenKenderaanLvl3Migrate::all();

        foreach ($listMigrate as $key) {

            RefComponentLvl3::create([
                // 'id' => $key->id,
                'id_component_lvl2' => $key->id_komponen_lvl2,
                'component' => $key->komponen
                //'model_id' => $vehicleModel ? $vehicleModel->id : null
            ]);


        }
    }
}
