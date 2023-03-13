<?php

namespace App\Http\Controllers\Reference\Component;

use App\Models\RefComponentChecklistLvl2;
use App\Models\RefComponentChecklistLvl3;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RefComponentChecklistLvl3DAO
{
    public function insert(Request $request){

        $last_id_lvl1 = $request->last_id_lvl1 ? $request->last_id_lvl1 : null;
        $last_id_lvl2 = $request->last_id_lvl2 ? $request->last_id_lvl2 : null;

        $refComLvl2 = RefComponentChecklistLvl2::find($request->com_lvl2_id);
        $queryGetLastComLvl2 = RefComponentChecklistLvl3::select('code')->where([
            'id_component_checklist_lvl2' => $request->com_lvl2_id,
            'status' => 1
        ])->orderBy('code', 'desc')->first();
        Log::info($queryGetLastComLvl2);
        $checkListLvl3Code = 0;
        if($queryGetLastComLvl2){
            $checkListLvl3Code = substr($queryGetLastComLvl2->code,-2);
        }
        $code = str_pad(((int)$checkListLvl3Code +1), 2, '0', STR_PAD_LEFT);
        Log::info($refComLvl2->code.$code);

        $query = RefComponentChecklistLvl3::insert([
            'code' => $refComLvl2->code.$code,
            'component' => $request->name,
            'id_component_checklist_lvl2' => $refComLvl2->id
        ]);

        $response = [
            'last_id_lvl1' => $last_id_lvl1,
            'last_id_lvl2' => $last_id_lvl2,
            'query' => $query,
            'code' => 200,
            'message' => 'Maklumat berjaya ditambah'
        ];

        Log::info($response);
        unset($response['query']);
        return $response;
    }

    public function update(Request $request){

        $last_id_lvl1 = $request->last_id_lvl1 ? $request->last_id_lvl1 : null;
        $last_id_lvl2 = $request->last_id_lvl2 ? $request->last_id_lvl2 : null;

        $id = $request->id;
        $name = $request->name;
        $query = RefComponentChecklistLvl3::find($id);
        $query->update([
            'component' => $name
        ]);

        $response = [
            'last_id_lvl1' => $last_id_lvl1,
            'last_id_lvl2' => $last_id_lvl2,
            'query' => $query,
            'code' => 200,
            'message' => 'Maklumat berjaya disimpan'
        ];

        Log::info($response);
        unset($response['query']);
        return $response;
    }

    public function delete(Request $request){

        $last_id_lvl1 = $request->last_id_lvl1 ? $request->last_id_lvl1 : null;
        $last_id_lvl2 = $request->last_id_lvl2 ? $request->last_id_lvl2 : null;
        
        $ids = $request->ids;
        Log::info($ids);
        $query = RefComponentChecklistLvl3::whereIn('id', $ids);
        $query->update([
            'status' => 0
        ]);
        Log::info($query->toSql());
        Log::info($query->get());

        $response = [
            'last_id_lvl1' => $last_id_lvl1,
            'last_id_lvl2' => $last_id_lvl2,
            'code' => 200,
            'message' => 'Maklumat berjaya dihapus'
        ];

        Log::info($response);
        return $response;
    }

}
