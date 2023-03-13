<?php

namespace Database\Seeders;

use App\Models\RefLModel;
use App\Models\Vehicle\Brand;
use App\Models\Vehicle\VehicleModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VehicleModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vehicleModels = DB::select("select pembuat,model from migrate.daftar_migrate where model is not null AND model != '' GROUP BY pembuat,model ORDER BY pembuat");    

        foreach ($vehicleModels as $vehicleModel) {

            $brand = Brand::select('id','name')->whereRaw("upper(name) = '".strtoupper(trim($vehicleModel->pembuat))."'")->first();
            if(!$brand){
                Log::info('brand xda, isrt la');
                Log::info(strtoupper($vehicleModel->pembuat));
            }

            $vModel = VehicleModel::select('id','name')->whereRaw("upper(name) = '".strtoupper(trim($vehicleModel->model))."'")->first();

            if(!$brand){
                $brand = Brand::create([
                    'name' => strtoupper($vehicleModel->pembuat)
                ]);
            }
            if(!$vModel){
                VehicleModel::create([
                    'brand_id' => $brand->id,
                    'name' => strtoupper($vehicleModel->model)
                ]);
            }
        }

        $latestCode = Brand::latest()->limit(1)->first();
        $countme = 1;
        if(!$latestCode){
            $countme = 1;
        }

        $brands = Brand::all();
        $brandsCompleted = 0;
        foreach ($brands as $brand) {
            Log::info($countme);
            $brand->update([
                'code' => str_pad(($countme++), 2, '0', STR_PAD_LEFT)
            ]);

            $brandsCompleted++;
            
        }

        if($brands->count() == $brandsCompleted){
            $latestVMCode = VehicleModel::latest()->limit(1)->first();
            $countVMme = 1;
            if(!$latestVMCode){
                $countVMme = 1;
            }
    
            $VehicleModels = VehicleModel::all();
            foreach ($VehicleModels as $VehicleModel) {
                Log::info($countVMme);
                if($VehicleModel->brand){
                    $VehicleModel->update([
                        'code' => str_pad(($VehicleModel->brand->code.$countVMme++), 4, '0', STR_PAD_LEFT)
                    ]);
                }
            }
        }

    }
}
