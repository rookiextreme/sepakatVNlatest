<?php

namespace App\Http\Controllers\Reference\Component;

use App\Models\RefComponentChecklistLvl1;
use App\Models\RefComponentChecklistLvl2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RefComponentChecklistLvl2DAO
{
    public function insert(Request $request){

        $refComLvl1 = RefComponentChecklistLvl1::find($request->com_lvl1_id);
        $queryGetLastComLvl2 = RefComponentChecklistLvl2::select('code')->where([
            'id_component_checklist_lvl1' => $request->com_lvl1_id,
            'status' => 1
        ])->orderBy('code', 'desc')->first();
        Log::info($queryGetLastComLvl2);
        $checkListLvl2Code = 0;
        if($queryGetLastComLvl2){
            $checkListLvl2Code = substr($queryGetLastComLvl2->code,-2);
        }
        $code = str_pad(((int)$checkListLvl2Code +1), 2, '0', STR_PAD_LEFT);
        Log::info($refComLvl1->code.$code);

        $query = RefComponentChecklistLvl2::insert([
            'code' => $refComLvl1->code.$code,
            'component' => $request->name,
            'id_component_checklist_lvl1' => $refComLvl1->id
        ]);

        $response = [
            'last_id_lvl1' => 'last_id_lvl1',
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
        $query = RefComponentChecklistLvl2::find($id);
        $query->update([
            'component' => $name
        ]);

        $response = [
            'last_id_lvl1' => 'last_id_lvl1',
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
        $query = RefComponentChecklistLvl2::whereIn('id', $ids);
        $query->update([
            'status' => 0
        ]);
        Log::info($query->toSql());
        Log::info($query->get());

        $response = [
            'last_id_lvl1' => 'last_id_lvl1',
            'code' => 200,
            'message' => 'Maklumat berjaya dihapus'
        ];

        Log::info($response);
        return $response;
    }

}
