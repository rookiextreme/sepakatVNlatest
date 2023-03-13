<?php

use App\Http\Controllers\Reference\Agency\RefDivisionDAO;
use App\Models\RefBranch;
use App\Models\RefDivision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

Route::get('/getDivision', function(){
    session()->put('session_ref_branch_id', request('branch_id'));
    $divisions = RefDivision::where([
        'branch_id' => request('branch_id'),
        'status' => 1
    ]);

    $divisions->orderBy('code', 'asc');

    $refBranch = RefBranch::find(request('branch_id'));
    $queryGetLastDivision = RefDivision::select('code')->where([
        'branch_id' => request('branch_id'),
        'status' => 1
    ])->orderBy('code', 'desc')->first();
    Log::info($queryGetLastDivision);
    $divisionCode = 0;
    if($queryGetLastDivision){
        $divisionCode = substr($queryGetLastDivision->code,-2);
    }
    $code = str_pad(((int)$divisionCode +1), 2, '0', STR_PAD_LEFT);
    Log::info($code);
    return view('reference.agency.agency-division', [
        'branch' => $refBranch,
        'divisions' => $divisions->get(),
        'code' => $refBranch->code.$code
    ]);
})->name('.getDivision');

Route::post('/division-action', function(Request $request){

    $refDivisionDAO = new RefDivisionDAO();
    $action = $request->action;
    switch ($action) {
        case 'insert':
            $request->validate([
                'desc' => 'required'
            ], [
                'desc.required' => 'Sila masukkan nama bahagian',
            ]);
            return $refDivisionDAO->insert($request);
            break;
        case 'update':
            $request->validate([
                'desc' => 'required'
            ], [
                'desc.required' => 'Sila masukkan nama bahagian',
            ]);
            return $refDivisionDAO->update($request);
            break;
        case 'delete':
            return $refDivisionDAO->delete($request);
            break;
    }
})->name('.division.action');