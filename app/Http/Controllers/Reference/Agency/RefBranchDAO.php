<?php

namespace App\Http\Controllers\Reference\Agency;

use App\Models\RefBranch;
use App\Models\RefSector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RefBranchDAO
{
    public function insert(Request $request){

        $refSector = RefSector::find($request->sector_id);
        $queryGetLastBranch = RefBranch::select('code')->where([
            'sector_id' => $request->sector_id,
            'status' => 1
        ])->orderBy('code', 'desc')->first();
        Log::info($queryGetLastBranch);
        $branchCode = 0;
        if($queryGetLastBranch){
            $branchCode = substr($queryGetLastBranch->code,-2);
        }
        $code = str_pad(((int)$branchCode +1), 2, '0', STR_PAD_LEFT);
        Log::info($refSector->code.$code);

        $query = RefBranch::insert([
            'sector_id' => $request->sector_id,
            'code' => $refSector->code.$code,
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
        $query = RefBranch::find($id);
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
        $branch_ids = $request->branch_ids;
        Log::info($branch_ids);
        $query = RefBranch::whereIn('id', $branch_ids);
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
