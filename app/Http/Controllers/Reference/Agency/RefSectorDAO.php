<?php

namespace App\Http\Controllers\Reference\Agency;

use App\Models\RefSector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RefSectorDAO
{
    public function insert(Request $request){

        $queryGetLastSector= RefSector::orderBy('code', 'desc')->where('status', 1)->first();
        $code = str_pad(((int)$queryGetLastSector->code+1), 2, '0', STR_PAD_LEFT);

        $query = RefSector::insert([
            'code' => $code,
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
        $query = RefSector::find($id);
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
        $sector_ids = $request->sector_ids;
        Log::info($sector_ids);
        $query = RefSector::whereIn('id', $sector_ids);
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
