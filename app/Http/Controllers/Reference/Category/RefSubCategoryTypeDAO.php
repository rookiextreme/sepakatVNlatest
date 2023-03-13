<?php

namespace App\Http\Controllers\Reference\Category;

use App\Models\RefSubCategory;
use App\Models\RefSubCategoryType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RefSubCategoryTypeDAO
{
    public function insert(Request $request){

        $refSubCategory = RefSubCategory::find($request->sub_category_id);
        $queryGetLastSubCategoryType = RefSubCategoryType::select('code')->where([
            'sub_category_id' => $request->sub_category_id,
            'status' => 1
        ])->orderBy('id', 'desc')->first();
        Log::info($queryGetLastSubCategoryType);
        $subCategoryTypeCode = 0;
        if($queryGetLastSubCategoryType){
            $subCategoryTypeCode = substr($queryGetLastSubCategoryType->code,-2);
        }
        $code = str_pad(((int)$subCategoryTypeCode +1), 2, '0', STR_PAD_LEFT);
        Log::info($refSubCategory->code.$code);

        $query = RefSubCategoryType::insert([
            'code' => $refSubCategory->code.$code,
            'name' => $request->name,
            'category_id' => $refSubCategory->category_id,
            'sub_category_id' => $refSubCategory->id
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
        $query = RefSubCategoryType::find($id);
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
        $subcategorytype_ids = $request->subcategorytype_ids;
        Log::info($subcategorytype_ids);
        $query = RefSubCategoryType::whereIn('id', $subcategorytype_ids);
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
