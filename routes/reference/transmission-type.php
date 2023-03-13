<?php

use App\Http\Controllers\Reference\Vehicle\Transmission\RefTransmissionTypeDAO;
use App\Models\RefTransmissionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/transmission-type', function () {
    $RefTransmissionType = RefTransmissionType::where('status', 1)->orderBy('id', 'asc')->get();
    $queryGetLastRefTransmissionType = RefTransmissionType::orderBy('id', 'desc')->first();
    $code = str_pad(((int)$queryGetLastRefTransmissionType->code+1), 2, '0', STR_PAD_LEFT);

    Log::info("code --> ".$code);
    return view('reference.transmission.transmission-type', [
        'RefTransmissionType' =>$RefTransmissionType,
        'code' => $code
    ]);
})->name('.transmission-type');


Route::post('/transmission-type-action', function(Request $request){

    $RefTransmissionTypeDAO = new RefTransmissionTypeDAO();
    $action = $request->action;
    switch ($action) {
        case 'insert':
            $request->validate([
                'name' => 'required'
            ], [
                'name.required' => 'Sila masukkan jenis enjin',
            ]);
            return $RefTransmissionTypeDAO->insert($request);
            break;
        case 'update':
            $request->validate([
                'name' => 'required'
            ], [
                'name.required' => 'Sila masukkan jenis enjin',
            ]);
            return $RefTransmissionTypeDAO->update($request);
            break;
        case 'delete':
            return $RefTransmissionTypeDAO->delete($request);
            break;
    }
})->name('.transmission.type.action');

?>
