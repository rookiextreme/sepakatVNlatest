<?php

namespace Database\Seeders;

use App\Models\RefDivision;
use App\Models\RefUnit;
use App\Models\UnitMigrate;
use Illuminate\Database\Seeder;

class RefUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $listMigrate = UnitMigrate::all();

        foreach ($listMigrate as $key) {

            $divisionCode = substr($key->code,0, 6);
            $checkRefDivision= RefDivision::where('code', $divisionCode)->first();

            RefUnit::create([
                'code' => $key->code,
                'desc' => $key->unit,
                'status' => 1,
                'sector_id' => $checkRefDivision && $checkRefDivision->sector_id ? $checkRefDivision->sector_id : null,
                'branch_id' => $checkRefDivision && $checkRefDivision->branch_id ? $checkRefDivision->branch_id : null,
                'division_id' => $checkRefDivision ? $checkRefDivision->id : null
                //'model_id' => $vehicleModel ? $vehicleModel->id : null
            ]);


        }
    }
}
