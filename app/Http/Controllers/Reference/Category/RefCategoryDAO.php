<?php

namespace App\Http\Controllers\Reference\Category;

use App\Models\RefCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RefCategoryDAO
{

    public function insert(Request $request){

        $queryGetLastCategory = RefCategory::orderBy('id', 'desc')->first();
        $code = str_pad(((int)$queryGetLastCategory->code+1), 2, '0', STR_PAD_LEFT);

        $query = RefCategory::insert([
            'code' => $code,
            'name' => $request->name
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
        $query = RefCategory::find($id);
        $query->update([
            'name' => $name
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
        $category_ids = $request->category_ids;
        Log::info($category_ids);
        $query = RefCategory::whereIn('id', $category_ids);
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
