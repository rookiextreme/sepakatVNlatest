<?php

namespace App\Http\Controllers\Reference\Vehicle\CoolingSystem;

use App\Models\RefEngineCoolerType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RefCoolingSystemTypeDAO
{
    public function insert(Request $request){

        $queryGetEngineCoolerType = RefEngineCoolerType::orderBy('id', 'desc')->first();
        $code = str_pad(((int)$queryGetEngineCoolerType->code+1), 2, '0', STR_PAD_LEFT);

        $query = RefEngineCoolerType::insert([
            'code' => $code,
            'desc' => $request->name
        ]);

        $response = [
            'query' => $query,
            'code' => 200,
            'message' => 'Maklumat berjaya ditambah'
        ];

        unset($response['query']);
        return $response;
    }

    public function update(Request $request){
        $id = $request->id;
        $name = $request->name;
        $query = RefEngineCoolerType::find($id);
        $query->update([
            'desc' => $name
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

        $ids = $request->refcoolingsystemtype_ids;

        $query = RefEngineCoolerType::whereIn('id', $ids);

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
