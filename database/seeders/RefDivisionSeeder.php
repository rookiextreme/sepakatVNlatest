<?php

namespace Database\Seeders;

use App\Models\BahagianMigrate;
use App\Models\RefBranch;
use App\Models\RefDivision;
use Illuminate\Database\Seeder;

class RefDivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $listMigrate = BahagianMigrate::all();

        foreach ($listMigrate as $key) {

            $branchCode = substr($key->code,0, 4);
            $checkRefBranch= RefBranch::where('code', $branchCode)->first();

            RefDivision::create([
                'code' => $key->code,
                'desc' => $key->bahagian,
                'status' => 1,
                'sector_id' => $checkRefBranch && $checkRefBranch->sector_id ? $checkRefBranch->sector_id : null,
                'branch_id' => $checkRefBranch ? $checkRefBranch->id : null
                //'model_id' => $vehicleModel ? $vehicleModel->id : null
            ]);


        }
    }
}
