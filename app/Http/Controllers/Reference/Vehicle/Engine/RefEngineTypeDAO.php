<?php

namespace App\Http\Controllers\Reference\Vehicle\Engine;

use App\Models\RefEngineType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RefEngineTypeDAO
{
    public function insert(Request $request){

        $queryGetLastEngineType = RefEngineType::orderBy('id', 'desc')->first();
        $code = str_pad(((int)$queryGetLastEngineType->code+1), 2, '0', STR_PAD_LEFT);

        $query = RefEngineType::insert([
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
        $query = RefEngineType::find($id);
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

        $ids = $request->refenginetype_ids;

        $query = RefEngineType::whereIn('id', $ids);

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
