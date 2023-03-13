<?php

use App\Http\Controllers\Reference\Category\RefCategoryDAO;
use App\Http\Controllers\Reference\Category\RefSubCategoryDAO;
use App\Http\Controllers\Reference\Category\RefSubCategoryTypeDAO;
use App\Models\RefCategory;
use App\Models\RefSubCategory;
use App\Models\RefSubCategoryType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

Route::get('/vehicle-category', function(){
    $categories = RefCategory::orderBy('id', 'asc');
    $categories->where('status', 1);
    $queryGetLastCategory = RefCategory::orderBy('id', 'desc')->first();
    $code = str_pad(((int)$queryGetLastCategory->code+1), 2, '0', STR_PAD_LEFT);
    return view('reference.vehicle-category.vehicle-category', [
        'categories' => $categories->get(),
        'code' => $code
    ]);
})->name('.vehicle-category');

Route::post('/vehicle-category-action', function(Request $request){

    $refCategoryDAO = new RefCategoryDAO();
    $action = $request->action;
    switch ($action) {
        case 'insert':
            $request->validate([
                'name' => 'required'
            ], [
                'name.required' => 'Sila masukkan nama kategori',
            ]);
            return $refCategoryDAO->insert($request);
            break;
        case 'update':
            $request->validate([
                'name' => 'required'
            ], [
                'name.required' => 'Sila masukkan nama kategori',
            ]);
            return $refCategoryDAO->update($request);
            break;
        case 'delete':
            return $refCategoryDAO->delete($request);
            break;
    }
})->name('.vehicle.category.action');

Route::get('/getSubCategory', function(){
    session()->put('session_ref_category_id', request('category_id'));
    $subCategories = RefSubCategory::where([
        'category_id' => request('category_id'),
        'status' => 1
    ]);

    $subCategories->orderBy('id', 'asc');

    $refCategory = RefCategory::find(request('category_id'));
    $queryGetLastSubCategory = RefSubCategory::select('code')->where([
        'category_id' => request('category_id'),
        'status' => 1
    ])->orderBy('id', 'desc')->first();
    Log::info($queryGetLastSubCategory);
    $subCategoryCode = 0;
    if($queryGetLastSubCategory){
        $subCategoryCode = substr($queryGetLastSubCategory->code,-2);
    }
    $code = str_pad(((int)$subCategoryCode +1), 2, '0', STR_PAD_LEFT);
    Log::info($code);
    return view('reference.vehicle-category.vehicle-subcategory', [
        'subCategories' => $subCategories->get(),
        'code' => $refCategory->code.$code
    ]);
})->name('.getSubCategory');

Route::post('/vehicle-subCategory-action', function(Request $request){

    $refSubCategoryDAO = new RefSubCategoryDAO();
    $action = $request->action;
    switch ($action) {
        case 'insert':
            $request->validate([
                'name' => 'required'
            ], [
                'name.required' => 'Sila masukkan nama Sub kategori',
            ]);
            return $refSubCategoryDAO->insert($request);
            break;
        case 'update':
            $request->validate([
                'name' => 'required'
            ], [
                'name.required' => 'Sila masukkan nama Sub kategori',
            ]);
            return $refSubCategoryDAO->update($request);
            break;
        case 'delete':
            return $refSubCategoryDAO->delete($request);
            break;
    }
})->name('.vehicle.subCategory.action');

Route::get('/getSubCategoryType', function(){
    session()->put('session_ref_subcategory_id', request('sub_category_id'));
    $subCategoryTypes = RefSubCategoryType::where([
        'sub_category_id' => request('sub_category_id'),
        'status' => 1
    ]);

    $subCategoryTypes->orderBy('id', 'asc');

    $refSubCategory = RefSubCategory::find(request('sub_category_id'));
    $queryGetLastSubCategoryType = RefSubCategoryType::select('code')->where([
        'sub_category_id' => request('sub_category_id'),
        'status' => 1
    ])->orderBy('id', 'desc')->first();
    Log::info($queryGetLastSubCategoryType);
    $subCategoryTypeCode = 0;
    if($queryGetLastSubCategoryType){
        $subCategoryTypeCode = substr($queryGetLastSubCategoryType->code,-2);
    }
    $code = str_pad(((int)$subCategoryTypeCode +1), 2, '0', STR_PAD_LEFT);
    Log::info($code);
    return view('reference.vehicle-category.vehicle-subcategory-type', [
        'subCategoryTypes' => $subCategoryTypes->get(),
        'code' => $refSubCategory->code.$code
    ]);
})->name('.getSubCategoryType');

Route::post('/vehicle-subCategoryType-action', function(Request $request){

    $refSubCategorTypeDAO = new RefSubCategoryTypeDAO();
    $action = $request->action;
    switch ($action) {
        case 'insert':
            $request->validate([
                'name' => 'required'
            ], [
                'name.required' => 'Sila masukkan nama kategori',
            ]);
            return $refSubCategorTypeDAO->insert($request);
            break;
        case 'update':
            $request->validate([
                'name' => 'required'
            ], [
                'name.required' => 'Sila masukkan nama kategori',
            ]);
            return $refSubCategorTypeDAO->update($request);
            break;
        case 'delete':
            return $refSubCategorTypeDAO->delete($request);
            break;
    }
})->name('.vehicle.subCategoryType.action');
