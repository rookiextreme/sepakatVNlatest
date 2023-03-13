<?php

use App\Http\Controllers\Reference\Vehicle\Fuel\RefFuelTypeDAO;

use App\Models\RefEngineFuelType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/fuel-type', function () {
    $RefEngineFuelType = RefEngineFuelType::where('status', 1)->orderBy('id', 'asc')->get();
    $queryGetLastEngineFuelType = RefEngineFuelType::orderBy('id', 'desc')->first();
    $code = str_pad(((int)$queryGetLastEngineFuelType->code+1), 2, '0', STR_PAD_LEFT);

    Log::info("code --> ".$code);
    return view('reference.fuel.fuel-type', [
        'RefEngineFuelType' =>$RefEngineFuelType,
        'code' => $code
    ]);
})->name('.fuel-type');


Route::post('/fuel-type-action', function(Request $request){

    $RefEngineFuelTypeDAO = new RefFuelTypeDAO();
    $action = $request->action;
    switch ($action) {
        case 'insert':
            $request->validate([
                'name' => 'required'
            ], [
                'name.required' => 'Sila masukkan jenis enjin',
            ]);
            return $RefEngineFuelTypeDAO->insert($request);
            break;
        case 'update':
            $request->validate([
                'name' => 'required'
            ], [
                'name.required' => 'Sila masukkan jenis enjin',
            ]);
            return $RefEngineFuelTypeDAO->update($request);
            break;
        case 'delete':
            return $RefEngineFuelTypeDAO->delete($request);
            break;
    }
})->name('.fuel.type.action');

?>
