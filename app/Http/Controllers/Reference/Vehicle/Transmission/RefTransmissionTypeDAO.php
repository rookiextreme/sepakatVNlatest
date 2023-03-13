<?php

namespace App\Http\Controllers\Reference\Vehicle\Transmission;

use App\Models\RefTransmissionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RefTransmissionTypeDAO
{
    public function insert(Request $request){

        $queryGetTransmissionType = RefTransmissionType::orderBy('id', 'desc')->first();
        $code = str_pad(((int)$queryGetTransmissionType->code+1), 2, '0', STR_PAD_LEFT);

        $query = RefTransmissionType::insert([
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
        $query = RefTransmissionType::find($id);
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

        $ids = $request->reftransmissiontype_ids;

        $query = RefTransmissionType::whereIn('id', $ids);

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
