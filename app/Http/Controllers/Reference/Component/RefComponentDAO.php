<?php

namespace App\Http\Controllers\Reference\Component;

use App\Models\RefComponentLvl1;
use App\Models\RefComponentLvl2;
use App\Models\RefComponentLvl3;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RefComponentDAO
{
    public function insert(Request $request){

        $lvl = $request->lvl ? $request->lvl : 1;

        switch ($lvl) {
            case 1:
                $table = new RefComponentLvl1();
                $queryGetLastComp = $table::where([
                    'status' => 1
                ])->orderBy('id', 'desc')->first();
                $code = str_pad(((int)$queryGetLastComp->code+1), 2, '0', STR_PAD_LEFT);
                $data = [
                    'code' => $code,
                    'component' => $request->name
                ];
                break;

            case 2:
                $table = new RefComponentLvl2();
                $parent = RefComponentLvl1::find($request->lvl1_id);
                $queryGetLastComp = $table::where([
                    'id_component_lvl1' => $request->lvl1_id,
                    'status' => 1
                ])->orderBy('code', 'desc')->first();
                $code = 0;
                if($queryGetLastComp){
                    $code = substr($queryGetLastComp->code,-2);
                }
                $code = str_pad(((int)$code +1), 2, '0', STR_PAD_LEFT);
                $data = [
                    'id_component_lvl1' => $request->lvl1_id,
                    'code' => $parent->code.$code,
                    'component' => $request->name
                ];
                break;

            case 3:
                $table = new RefComponentLvl3();
                $parent = RefComponentLvl2::find($request->lvl2_id);
                $queryGetLastComp = $table::where([
                    'id_component_lvl2' => $request->lvl2_id,
                    'status' => 1
                ])->orderBy('code', 'desc')->first();
                $code = 0;
                if($queryGetLastComp){
                    $code = substr($queryGetLastComp->code,-2);
                }
                $code = str_pad(((int)$code +1), 2, '0', STR_PAD_LEFT);
                $data = [
                    'id_component_lvl2' => $request->lvl2_id,
                    'code' => $parent->code.$code,
                    'component' => $request->name
                ];
                break;
        }

        $query = $table::insert($data);

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

        $lvl = $request->lvl ? $request->lvl : 1;

        switch ($lvl) {
            case 1:
                $table = new RefComponentLvl1();
                break;

            case 2:
                $table = new RefComponentLvl2();
                break;

            case 3:
                $table = new RefComponentLvl3();
                break;
        }

        $id = $request->id;
        $name = $request->name;
        $query = $table::find($id);
        $query->update([
            'component' => $name
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

        $lvl = $request->lvl ? $request->lvl : 1;

        switch ($lvl) {
            case 1:
                $table = new RefComponentLvl1();
                break;

            case 2:
                $table = new RefComponentLvl2();
                break;

            case 3:
                $table = new RefComponentLvl3();
                break;
        }

        $comp_ids = $request->comp_ids;
        Log::info($comp_ids);
        $query = $table::whereIn('id', $comp_ids);
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
