<?php

use App\Http\Controllers\Reference\Agency\RefUnitDAO;
use App\Models\RefBranch;
use App\Models\RefDivision;
use App\Models\RefUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

Route::get('/getUnit', function(){
    session()->put('session_ref_division_id', request('division_id'));
    $units = RefUnit::where([
        'division_id' => request('division_id'),
        'status' => 1
    ]);

    $units->orderBy('code', 'asc');

    $refDivision = RefDivision::find(request('division_id'));
    $queryGetLastUnit = RefUnit::select('code')->where([
        'division_id' => request('division_id'),
        'status' => 1
    ])->orderBy('code', 'desc')->first();
    Log::info($queryGetLastUnit);
    $unitCode = 0;
    if($queryGetLastUnit){
        $unitCode = substr($queryGetLastUnit->code,-2);
    }
    $code = str_pad(((int)$unitCode +1), 2, '0', STR_PAD_LEFT);
    Log::info($code);
    return view('reference.agency.agency-Unit', [
        'division' => $refDivision,
        'units' => $units->get(),
        'code' => $refDivision->code.$code
    ]);
})->name('.getUnit');

Route::post('/unit-action', function(Request $request){

    $refUnitDAO = new RefUnitDAO();
    $action = $request->action;
    switch ($action) {
        case 'insert':
            $request->validate([
                'desc' => 'required'
            ], [
                'desc.required' => 'Sila masukkan nama unit',
            ]);
            return $refUnitDAO->insert($request);
            break;
        case 'update':
            $request->validate([
                'desc' => 'required'
            ], [
                'desc.required' => 'Sila masukkan nama unit',
            ]);
            return $refUnitDAO->update($request);
            break;
        case 'delete':
            return $refUnitDAO->delete($request);
            break;
    }
})->name('.unit.action');