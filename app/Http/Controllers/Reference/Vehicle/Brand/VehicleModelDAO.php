<?php

namespace App\Http\Controllers\Reference\Vehicle\Brand;

use App\Models\Vehicle\Brand;
use App\Models\Vehicle\VehicleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VehicleModelDAO
{
    public function insert(Request $request){

        $vehicleBrand = Brand::find($request->brand_id);
        $queryGetLastVehicleModel = VehicleModel::select('code')->where([
            'brand_id' => $request->brand_id,
            'status' => 1
        ])->orderBy('code', 'desc')->first();
        Log::info($queryGetLastVehicleModel);
        $vehicleModelCode = 0;
        if($queryGetLastVehicleModel){
            $vehicleModelCode = substr($queryGetLastVehicleModel->code,-2);
        }
        $code = str_pad(((int)$vehicleModelCode +1), 2, '0', STR_PAD_LEFT);
        Log::info($vehicleBrand->code.$code);

        $query = VehicleModel::insert([
            'code' => $vehicleBrand->code.$code,
            'name' => $request->name,
            'brand_id' => $vehicleBrand->id
        ]);

        $response = [
            'query' => $query,
            'code' => 200,
            'message' => 'Maklumat berjaya ditambah'
        ];

        Log::info($response);
        unset($response['query']);
        return $response;
    }

    public function update(Request $request){
        $id = $request->id;
        $name = $request->name;
        $query = VehicleModel::find($id);
        $query->update([
            'name' => $name
        ]);

        $response = [
            'query' => $query,
            'code' => 200,
            'message' => 'Maklumat berjaya disimpan'
        ];

        Log::info($response);
        unset($response['query']);
        return $response;
    }

    public function delete(Request $request){
        $model_ids = $request->model_ids;
        Log::info($model_ids);
        $query = VehicleModel::whereIn('id', $model_ids);
        $query->update([
            'status' => 0
        ]);
        Log::info($query->toSql());
        Log::info($query->get());

        $response = [
            'code' => 200,
            'message' => 'Maklumat berjaya dihapus'
        ];

        Log::info($response);
        return $response;
    }

}
