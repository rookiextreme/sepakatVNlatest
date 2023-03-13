<?php

namespace Database\Seeders;

use App\Models\RefSector;
use App\Models\SektorMigrate;
use Illuminate\Database\Seeder;

class RefSectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $listMigrate = SektorMigrate::orderBy('code', 'asc')->get();

        foreach ($listMigrate as $key) {

            RefSector::create([
                'code' => $key->code,
                'desc' => $key->sector,
                'status' => 1
                //'model_id' => $vehicleModel ? $vehicleModel->id : null
            ]);

        }
    }
}
