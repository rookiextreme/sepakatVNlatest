<?php

use App\Http\Controllers\Reference\Vehicle\Suspension\RefSuspensionTypeDAO;
use App\Models\RefSuspensionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/suspension-type', function () {
    $RefSuspensionType = RefSuspensionType::where('status', 1)->orderBy('id', 'asc')->get();
    $queryGetLastRefSuspensionType = RefSuspensionType::orderBy('id', 'desc')->first();
    $code = str_pad(((int)$queryGetLastRefSuspensionType->code+1), 2, '0', STR_PAD_LEFT);

    Log::info("code --> ".$code);
    return view('reference.suspension.suspension-type', [
        'RefSuspensionType' => $RefSuspensionType,
        'code' => $code
    ]);
})->name('.suspension-type');


Route::post('/suspension-type-action', function(Request $request){

    $RefSuspensionTypeDAO = new RefSuspensionTypeDAO();
    $action = $request->action;
    switch ($action) {
        case 'insert':
            $request->validate([
                'name' => 'required'
            ], [
                'name.required' => 'Sila masukkan jenis enjin',
            ]);
            return $RefSuspensionTypeDAO->insert($request);
            break;
        case 'update':
            $request->validate([
                'name' => 'required'
            ], [
                'name.required' => 'Sila masukkan jenis enjin',
            ]);
            return $RefSuspensionTypeDAO->update($request);
            break;
        case 'delete':
            return $RefSuspensionTypeDAO->delete($request);
            break;
    }
})->name('.suspension.type.action');

?>
