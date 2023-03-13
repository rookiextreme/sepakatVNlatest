<?php

namespace App\Http\Controllers\Reference\Vehicle\BranchOwner;

use App\Models\RefOwner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RefOwnerDAO
{

    public function test()
    {
        return 'ada';
    }

    public function insert(Request $request){

        $queryGetLastCategory = RefOwner::orderBy('id', 'desc')->first();
        $code = str_pad(((int)$queryGetLastCategory->code+1), 4, '0', STR_PAD_LEFT);

        $query = RefOwner::insert([
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
        $query = RefOwner::find($id);
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
        $refowner_ids = $request->refowner_ids;
        Log::info($refowner_ids);
        $query = RefOwner::whereIn('id', $refowner_ids);
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
