<?php

use App\Http\Controllers\Reference\Agency\RefSectorDAO;
use App\Models\RefBranch;
use App\Models\RefDivision;
use App\Models\RefSector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

Route::get('/sector', function(){
    $sectors = RefSector::orderBy('code', 'asc');
    $sectors->where('status', 1);
    $queryGetLastSector = RefSector::orderBy('code', 'desc')->where('status', 1)->first();
    $code = str_pad(((int)$queryGetLastSector->code+1), 2, '0', STR_PAD_LEFT);
    return view('reference.agency.agency-sector', [
        'sectors' => $sectors->get(),
        'code' => $code
    ]);
})->name('.agency');

Route::post('/sector-action', function(Request $request){

    $refSectorDAO = new RefSectorDAO();
    $action = $request->action;
    switch ($action) {
        case 'insert':
            $request->validate([
                'desc' => 'required'
            ], [
                'desc.required' => 'Sila masukkan nama sektor',
            ]);
            return $refSectorDAO->insert($request);
            break;
        case 'update':
            $request->validate([
                'desc' => 'required'
            ], [
                'desc.required' => 'Sila masukkan nama sektor',
            ]);
            return $refSectorDAO->update($request);
            break;
        case 'delete':
            return $refSectorDAO->delete($request);
            break;
    }
})->name('.sector.action');

require __DIR__.'/agency-branch.php';
require __DIR__.'/agency-division.php';
require __DIR__.'/agency-unit.php';