<?php

namespace App\Http\Controllers\Reference\Vehicle\Event;

use App\Models\RefEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RefEventDAO
{

    public function test()
    {
        return 'ada';
    }

    public function insert(Request $request){

        $queryGetLastCategory = RefEvent::orderBy('id', 'desc')->first();
        $code = str_pad(((int)$queryGetLastCategory->code+1), 2, '0', STR_PAD_LEFT);

        $query = RefEvent::insert([
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
        $query = RefEvent::find($id);
        $query->update([
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
        $refevent_ids = $request->refevent_ids;
        Log::info($refevent_ids);
        $query = RefEvent::whereIn('id', $refevent_ids);
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
