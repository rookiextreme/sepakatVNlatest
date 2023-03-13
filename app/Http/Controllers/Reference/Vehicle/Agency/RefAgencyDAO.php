<?php

namespace App\Http\Controllers\Reference\Vehicle\Agency;

use App\Models\RefAgency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RefAgencyDAO
{

    public function test()
    {
        return 'ada';
    }

    public function insert(Request $request){

        $queryGetLastAgency = RefAgency::orderBy('id', 'desc')->first();
        $code = str_pad(((int)$queryGetLastAgency->code+1), 2, '0', STR_PAD_LEFT);

        $query = RefAgency::insert([
            'code' => $code,
            'desc' => $request->name
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
        $query = RefAgency::find($id);
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

        $ids = $request->ids;
        Log::info($ids);

        $query = RefAgency::whereIn('id', $ids);

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
