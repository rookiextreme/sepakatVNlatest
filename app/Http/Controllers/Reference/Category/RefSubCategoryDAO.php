<?php

namespace App\Http\Controllers\Reference\Category;

use App\Models\RefCategory;
use App\Models\RefSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RefSubCategoryDAO
{
    public function insert(Request $request){

        $refCategory = RefCategory::find($request->category_id);
        $queryGetLastSubCategory = RefSubCategory::select('code')->where([
            'category_id' => $request->category_id,
            'status' => 1
        ])->orderBy('id', 'desc')->first();
        Log::info($queryGetLastSubCategory);
        $subCategoryCode = 0;
        if($queryGetLastSubCategory){
            $subCategoryCode = substr($queryGetLastSubCategory->code,-2);
        }
        $code = str_pad(((int)$subCategoryCode +1), 2, '0', STR_PAD_LEFT);
        Log::info($refCategory->code.$code);

        $query = RefSubCategory::insert([
            'code' => $refCategory->code.$code,
            'name' => $request->name,
            'category_id' => $refCategory->id
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
        $query = RefSubCategory::find($id);
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
        $subcategory_ids = $request->subcategory_ids;
        Log::info($subcategory_ids);
        $query = RefSubCategory::whereIn('id', $subcategory_ids);
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
