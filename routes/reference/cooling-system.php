<?php

use App\Http\Controllers\Reference\Vehicle\CoolingSystem\RefCoolingSystemTypeDAO;
use App\Models\RefEngineCoolerType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/cooling-system', function () {
    $RefEngineCoolerType = RefEngineCoolerType::where('status', 1)->orderBy('id', 'asc')->get();
    $queryGetLastEngineCoolerType = RefEngineCoolerType::orderBy('id', 'desc')->first();
    $code = str_pad(((int)$queryGetLastEngineCoolerType->code+1), 2, '0', STR_PAD_LEFT);

    Log::info("code --> ".$code);
    return view('reference.cooling-system.cooling-system-type', [
        'RefEngineCoolerType' =>$RefEngineCoolerType,
        'code' => $code
    ]);
})->name('.cooling-system');


Route::post('/cooling-system-type-action', function(Request $request){

    $RefCoolingSystemTypeDAO = new RefCoolingSystemTypeDAO();
    $action = $request->action;
    switch ($action) {
        case 'insert':
            $request->validate([
                'name' => 'required'
            ], [
                'name.required' => 'Sila masukkan jenis enjin',
            ]);
            return $RefCoolingSystemTypeDAO->insert($request);
            break;
        case 'update':
            $request->validate([
                'name' => 'required'
            ], [
                'name.required' => 'Sila masukkan jenis enjin',
            ]);
            return $RefCoolingSystemTypeDAO->update($request);
            break;
        case 'delete':
            return $RefCoolingSystemTypeDAO->delete($request);
            break;
    }
})->name('.cooling.system.type.action');

?>
