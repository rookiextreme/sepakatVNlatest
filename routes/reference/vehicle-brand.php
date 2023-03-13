<?php

use App\Http\Controllers\Reference\Vehicle\Brand\VehicleBrandDAO;
use App\Http\Controllers\Reference\Vehicle\Brand\VehicleModelDAO;
use App\Models\Vehicle\Brand;
use App\Models\Vehicle\VehicleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

Route::get('/vehicle-brand', function(Request $request){
    $vehicleBrands = Brand::orderBy('id', 'asc');
    $vehicleBrands->where('status', 1);
    $queryGetLastVehicleBrand = Brand::orderBy('id', 'desc')->first();
    $code = str_pad(((int)$queryGetLastVehicleBrand->code+1), 2, '0', STR_PAD_LEFT);

    if($request->search){
        $search = $request->search;
            $vehicleBrands->whereRaw("upper(name) LIKE '%".strtoupper($search)."%' ");
    }

    return view('reference.vehicle-brand.vehicle-brand', [
        'brands' => $vehicleBrands->get(),
        'code' => $code
    ]);
})->name('.vehicle-brand');

Route::post('/vehicle-brand-action', function(Request $request){

    $VehicleBrandDAO = new VehicleBrandDAO();
    $action = $request->action;
    switch ($action) {
        case 'insert':
            $request->validate([
                'name' => 'required',
                'name' => 'required|unique:App\Models\Vehicle\Brand,name',
            ], [
                'name.required' => 'Sila masukkan nama kategori',
                'name.unique' => 'Nama Kategori sudah wujud.',
            ]);
            return $VehicleBrandDAO->insert($request);
            break;
        case 'update':
            $request->validate([
                'name' => 'required'
            ], [
                'name.required' => 'Sila masukkan nama kategori',
            ]);
            return $VehicleBrandDAO->update($request);
            break;
        case 'delete':
            return $VehicleBrandDAO->delete($request);
            break;
    }
})->name('.vehicle.brand.action');

Route::get('/getVehicleModel', function(){
    session()->put('session_vehicle_brand_id', request('brand_id'));
    $vehicleModels = VehicleModel::where([
        'brand_id' => request('brand_id'),
        'status' => 1
    ]);

    $vehicleModels->orderBy('code', 'asc');

    $vehicleBrand = Brand::find(request('brand_id'));
    $queryGetLastModel = VehicleModel::select('code')->where([
        'brand_id' => request('brand_id'),
        'status' => 1
    ])->orderBy('code', 'desc')->first();
    Log::info($queryGetLastModel);
    $modelCode = 0;
    if($queryGetLastModel){
        $modelCode = substr($queryGetLastModel->code,-2);
    }
    $code = str_pad(((int)$modelCode +1), 2, '0', STR_PAD_LEFT);
    Log::info($code);
    return view('reference.vehicle-brand.vehicle-model', [
        'models' => $vehicleModels->get(),
        'code' => $vehicleBrand->code.$code
    ]);
})->name('.getModel');

Route::post('/vehicle-model-action', function(Request $request){

    $VehicleModelDAO = new VehicleModelDAO();
    $action = $request->action;
    switch ($action) {
        case 'insert':
            $request->validate([
                'name' => 'required',
                'name' => 'required|unique:App\Models\Vehicle\VehicleModel,name',
            ], [
                'name.required' => 'Sila masukkan nama Sub kategori',
                'name.unique' => 'Nama Sub Kategori sudah wujud.',
            ]);
            return $VehicleModelDAO->insert($request);
            break;
        case 'update':
            $request->validate([
                'name' => 'required'
            ], [
                'name.required' => 'Sila masukkan nama Sub kategori',
            ]);
            return $VehicleModelDAO->update($request);
            break;
        case 'delete':
            return $VehicleModelDAO->delete($request);
            break;
    }
})->name('.vehicle.model.action');
