<?php

use App\Http\Controllers\Reference\Agency\RefBranchDAO;
use App\Models\RefBranch;
use App\Models\RefSector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

Route::get('/getBranch', function(){
    session()->put('session_ref_sector_id', request('sector_id'));
    $branches = RefBranch::where([
        'sector_id' => request('sector_id'),
        'status' => 1
    ]);

    $branches->orderBy('code', 'asc');

    $refSector = RefSector::find(request('sector_id'));
    $queryGetLastBranch = RefBranch::select('code')->where([
        'sector_id' => request('sector_id'),
        'status' => 1
    ])->orderBy('code', 'desc')->first();
    Log::info($queryGetLastBranch);
    $branchCode = 0;
    if($queryGetLastBranch){
        $branchCode = substr($queryGetLastBranch->code,-2);
    }
    $code = str_pad(((int)$branchCode +1), 2, '0', STR_PAD_LEFT);
    Log::info($code);
    return view('reference.agency.agency-branch', [
        'sector' => $refSector,
        'branches' => $branches->get(),
        'code' => $refSector->code.$code
    ]);
})->name('.getBranch');

Route::post('/branch-action', function(Request $request){

    $refBranchDAO = new RefBranchDAO();
    $action = $request->action;
    switch ($action) {
        case 'insert':
            $request->validate([
                'desc' => 'required'
            ], [
                'desc.required' => 'Sila masukkan nama cawangan',
            ]);
            return $refBranchDAO->insert($request);
            break;
        case 'update':
            $request->validate([
                'desc' => 'required'
            ], [
                'desc.required' => 'Sila masukkan nama cawangan',
            ]);
            return $refBranchDAO->update($request);
            break;
        case 'delete':
            return $refBranchDAO->delete($request);
            break;
    }
})->name('.branch.action');