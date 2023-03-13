<?php

namespace Database\Seeders;

use App\Models\CawanganMigrate;
use App\Models\RefBranch;
use App\Models\RefCawangan;
use App\Models\RefSector;
use Illuminate\Database\Seeder;

class RefBranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $listMigrate = CawanganMigrate::all();

        foreach ($listMigrate as $key) {

            $sectorCode = substr($key->code,0, 2);
            $checkRefSector = RefSector::where('code', $sectorCode)->first();

            RefBranch::create([
                'code' => $key->code,
                'desc' => $key->cawangan,
                'status' => 1,
                'sector_id' => $checkRefSector ? $checkRefSector->id : null
                //'model_id' => $vehicleModel ? $vehicleModel->id : null
            ]);


        }
    }
}
