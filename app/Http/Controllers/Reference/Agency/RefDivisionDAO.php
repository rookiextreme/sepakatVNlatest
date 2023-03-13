<?php

namespace App\Http\Controllers\Reference\Agency;

use App\Models\RefBranch;
use App\Models\RefDivision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RefDivisionDAO
{
    public function insert(Request $request){

        $refBranch = RefBranch::find($request->branch_id);
        $queryGetLastDivision = RefDivision::select('code')->where([
            'branch_id' => $request->branch_id,
            'status' => 1
        ])->orderBy('code', 'desc')->first();
        Log::info($queryGetLastDivision);
        $divisionCode = 0;
        if($queryGetLastDivision){
            $divisionCode = substr($queryGetLastDivision->code,-2);
        }
        $code = str_pad(((int)$divisionCode +1), 2, '0', STR_PAD_LEFT);
        Log::info($refBranch->code.$code);

        $query = RefDivision::insert([
            'branch_id' => $request->branch_id,
            'code' => $refBranch->code.$code,
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
        $query = RefDivision::find($id);
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
        $query = RefDivision::whereIn('id', $division_ids);
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
