<?php

namespace App\Http\Controllers\Reference\Placement;

use App\Models\RefState;
use App\Models\Vehicle\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PlacementLocationDAO
{

    public function insert(Request $request){

        $queryGetLastPlacementLocation = RefState::orderBy('id', 'desc')->first();
        $code = str_pad(((int)$queryGetLastPlacementLocation->code+1), 2, '0', STR_PAD_LEFT);

        $query = RefState::insert([
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
        $query = RefState::find($id);
        $query->update([
            'state_id' => $id,
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
        $placement_ids = $request->placement_ids;
        $query = RefState::whereIn('id', $placement_ids);
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
