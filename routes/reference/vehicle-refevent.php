<?php

use App\Http\Controllers\Reference\Vehicle\Event\RefEventDAO;
use App\Models\RefEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/vehicle-refevent', function () {
    $RefEventS = RefEvent::where('status', 1)->orderBy('id', 'asc')->get();
    $queryGetLastCategory = RefEvent::orderBy('id', 'desc')->first();
    $code = str_pad(((int)$queryGetLastCategory->code+1), 2, '0', STR_PAD_LEFT);
    return view('reference.vehicle-refevent.vehicle-refevent', [
        'RefEventS' => $RefEventS,
        'code' => $code
    ]);
})->name('.vehicle-refevent');

Route::post('/vehicle-refevent-action', function(Request $request){

    $refEventDAO = new RefEventDAO();
    $action = $request->action;
    switch ($action) {
        case 'insert':
            $request->validate([
                'name' => 'required'
            ], [
                'name.required' => 'Sila masukkan nama kategori',
            ]);
            return $refEventDAO->insert($request);
            break;
        case 'update':
            $request->validate([
                'name' => 'required'
            ], [
                'name.required' => 'Sila masukkan nama kategori',
            ]);
            return $refEventDAO->update($request);
            break;
        case 'delete':
            return $refEventDAO->delete($request);
            break;
    }
})->name('.vehicle.refevent.action');
