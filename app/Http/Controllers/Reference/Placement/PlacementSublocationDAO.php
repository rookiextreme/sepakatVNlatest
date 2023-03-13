<?php

namespace App\Http\Controllers\Reference\Placement;

use App\Models\FleetPlacement;
use App\Models\RefState;
use App\Models\Vehicle\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PlacementSublocationDAO
{

    public function insert(Request $request){

        $placementState = RefState::find($request->placement_id);
        $queryGetLastSubLocation = FleetPlacement::select('code')->where([
            'ref_state_id' => $request->placement_id,
            'status' => 1
        ])->orderBy('code', 'desc')->first();

        $SublocationCode = 0;
        
        if($queryGetLastSubLocation){
            $SublocationCode = substr($queryGetLastSubLocation->code, -2);
        }

        $code = str_pad(((int)$SublocationCode +1), 2, '0', STR_PAD_LEFT);
        $query = FleetPlacement::insert([
            'code' => $placementState->code.$code,
            'ref_state_id' => $placementState->id,
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
        $query = FleetPlacement::find($id);
        $query->update([
            'id' => $id,
            'desc' => $name
        ]);

        $response = [
            'query' => $query,
            'code' => 200,
            'message' => 'Maklumat berjaya disimpan'
        ];

        unset($response['query']);
        return $response;
    }

    public function delete(Request $request){
        $sublocation_ids = $request->sublocation_ids;
        $query = FleetPlacement::whereIn('id', $sublocation_ids);
        $query->update([
            'status' => 0
        ]);

        $response = [
            'code' => 200,
            'message' => 'Maklumat berjaya dihapus'
        ];

        Log::info($response);
        return $response;
    }

}
