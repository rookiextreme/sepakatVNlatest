<?php

namespace App\Http\Controllers\Reference\Agency;

use App\Models\RefDivision;
use App\Models\RefUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RefUnitDAO
{
    public function insert(Request $request){

        $refDivision = RefDivision::find($request->division_id);
        $queryGetLastUnit = RefUnit::select('code')->where([
            'division_id' => $request->division_id,
            'status' => 1
        ])->orderBy('code', 'desc')->first();
        Log::info($queryGetLastUnit);
        $divisionCode = 0;
        if($queryGetLastUnit){
            $divisionCode = substr($queryGetLastUnit->code,-2);
        }
        $code = str_pad(((int)$divisionCode +1), 2, '0', STR_PAD_LEFT);
        Log::info($refDivision->code.$code);

        $query = RefUnit::insert([
            'division_id' => $request->division_id,
            'code' => $refDivision->code.$code,
            'desc' => $request->desc
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
        $desc = $request->desc;
        $query = RefUnit::find($id);
        $query->update([
            'desc' => $desc
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
        $division_ids = $request->division_ids;
        Log::info($division_ids);
        $query = RefUnit::whereIn('id', $division_ids);
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
