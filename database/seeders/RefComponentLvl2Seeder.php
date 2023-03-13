<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RefComponentLvl2;
use App\Models\KomponenKenderaanLvl2MigrateNew;

class RefComponentLvl2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $listMigrate = KomponenKenderaanLvl2MigrateNew::all();

        foreach ($listMigrate as $key) {
            $codelvl1 = str_pad(((int)$key->id_komponen_lvl1), 2, '0', STR_PAD_LEFT);
            $codelvl2 = str_pad( $codelvl1, 4, $key->id, STR_PAD_RIGHT);

            RefComponentLvl2::create([
                'id' => $key->id,
                'id_component_lvl1' => $key->id_komponen_lvl1,
                'component' => $key->komponen,
                'code' => $codelvl2
                //'model_id' => $vehicleModel ? $vehicleModel->id : null
            ]);


        }
    }
}
