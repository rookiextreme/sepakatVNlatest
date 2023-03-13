<?php

use App\Http\Controllers\Reference\Vehicle\Agency\RefAgencyDAO;

use App\Models\RefAgency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/vehicle-agency', function (Request $request) {
    $RefAgencys = RefAgency::where('status', 1)->orderBy('id', 'asc');
    $queryGetLastAgency = RefAgency::orderBy('id', 'desc')->first();
    $code = str_pad(((int)$queryGetLastAgency->code+1), 2, '0', STR_PAD_LEFT);

    if($request->search){
        $search = $request->search;
            $RefAgencys->whereRaw("upper(ref_agency.desc) LIKE '%".strtoupper($search)."%' ");
    }

    Log::info("code --> ".$code);
    return view('reference.agency.agency-name-list', [
        'RefAgencys' =>$RefAgencys->get(),
        'code' => $code
    ]);
})->name('.vehicle-agency');


Route::post('/vehicle-agency-action', function(Request $request){

    $refEventDAO = new RefAgencyDAO();
    $action = $request->action;
    switch ($action) {
        case 'insert':
            $request->validate([
                'name' => 'required',
                'name' => 'required|unique:App\Models\RefAgency,desc',
            ], [
                'name.required' => 'Sila masukkan nama agensi',
                'name.unique' => 'Nama agensi sudah wujud.',
            ]);
            return $refEventDAO->insert($request);
            break;
        case 'update':
            $request->validate([
                'name' => 'required'
            ], [
                'name.required' => 'Sila masukkan nama agensi',
            ]);
            return $refEventDAO->update($request);
            break;
        case 'delete':
            return $refEventDAO->delete($request);
            break;
    }
})->name('.vehicle.agency.action');

?>
