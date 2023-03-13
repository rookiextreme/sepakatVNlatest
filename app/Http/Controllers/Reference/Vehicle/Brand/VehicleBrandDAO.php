<?php

namespace App\Http\Controllers\Reference\Vehicle\Brand;

use App\Models\Vehicle\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VehicleBrandDAO
{

    public function insert(Request $request){

        $queryGetLastVehicleBrand = Brand::orderBy('id', 'desc')->first();
        $code = str_pad(((int)$queryGetLastVehicleBrand->code+1), 2, '0', STR_PAD_LEFT);

        $query = Brand::insert([
            'code' => $code,
            'name' => $request->name
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
        $query = Brand::find($id);
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
        $brand_ids = $request->brand_ids;
        Log::info($brand_ids);
        $query = Brand::whereIn('id', $brand_ids);
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
