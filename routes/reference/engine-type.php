<?php

use App\Http\Controllers\Reference\Vehicle\Engine\RefEngineTypeDAO;

use App\Models\RefEngineType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/engine-type', function () {
    $RefEngineType = RefEngineType::where('status', 1)->orderBy('id', 'asc')->get();
    $queryGetLastEngineType = RefEngineType::orderBy('id', 'desc')->first();
    $code = str_pad(((int)$queryGetLastEngineType->code+1), 2, '0', STR_PAD_LEFT);

    Log::info("code --> ".$code);
    return view('reference.engine.engine-type', [
        'RefEngineType' =>$RefEngineType,
        'code' => $code
    ]);
})->name('.engine-type');


Route::post('/engine-type-action', function(Request $request){

    $RefEngineTypeDAO = new RefEngineTypeDAO();
    $action = $request->action;
    switch ($action) {
        case 'insert':
            $request->validate([
                'name' => 'required'
            ], [
                'name.required' => 'Sila masukkan jenis enjin',
            ]);
            return $RefEngineTypeDAO->insert($request);
            break;
        case 'update':
            $request->validate([
                'name' => 'required'
            ], [
                'name.required' => 'Sila masukkan jenis enjin',
            ]);
            return $RefEngineTypeDAO->update($request);
            break;
        case 'delete':
            return $RefEngineTypeDAO->delete($request);
            break;
    }
})->name('.engine.type.action');

?>
