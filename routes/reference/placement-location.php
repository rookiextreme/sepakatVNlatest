<?php

use App\Http\Controllers\Reference\Placement\PlacementLocationDAO;
use App\Http\Controllers\Reference\Placement\PlacementSublocationDAO;
use App\Http\Controllers\Reference\Vehicle\Brand\VehicleBrandDAO;
use App\Http\Controllers\Reference\Vehicle\Brand\VehicleModelDAO;
use App\Models\FleetPlacement;
use App\Models\Location\Placement;
use App\Models\RefState;
use App\Models\Vehicle\Brand;
use App\Models\Vehicle\VehicleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

Route::get('/placement-location', function(Request $request){
    $refState = RefState::orderBy('id', 'asc');
    $refState->where('status', 1);
    $queryGetLastState = RefState::orderBy('id', 'desc')->first();
    $code = str_pad(((int)$queryGetLastState->code+1), 2, '0', STR_PAD_LEFT);

    if($request->search){
        $search = $request->search;
            $refState->whereRaw("upper(ref_state.desc) LIKE '%".strtoupper($search)."%' ");
    }

    return view('reference.placement.placement-location', [
        'states' => $refState->get(),
        'code' => $code
    ]);
})->name('.placement-location');

Route::post('/placement-location-action', function(Request $request){

    $PlacementLocationDAO = new PlacementLocationDAO();
    $action = $request->action;
    switch ($action) {
        case 'insert':
            $request->validate([
                'name' => 'required',
                'name' => 'required|unique:App\Models\RefState,desc',
            ], [
                'name.required' => 'Sila masukkan nama negeri',
                'name.unique' => 'Nama negeri sudah wujud.',
            ]);
            return $PlacementLocationDAO->insert($request);
            break;
        case 'update':
            $request->validate([
                'name' => 'required'
            ], [
                'name.required' => 'Sila masukkan nama negeri',
            ]);
            return $PlacementLocationDAO->update($request);
            break;
        case 'delete':
            return $PlacementLocationDAO->delete($request);
            break;
    }
})->name('.placement.location.action');

Route::get('/getSublocation', function(){
    session()->put('session_vehicle_placement_id', request('placement_id'));
    $fleetPlacement = FleetPlacement::where([
        'ref_state_id' => request('placement_id'),
        'status' => 1
    ]);

    $fleetPlacement->orderBy('code', 'asc');

    $placementState = RefState::find(request('placement_id'));
    $queryGetLastLocation = FleetPlacement::select('code')->where([
        'ref_state_id' => request('placement_id'),
        'status' => 1
    ])->orderBy('code', 'desc')->first();

    $locationCode = 0;
    if($queryGetLastLocation){
        $locationCode = substr($queryGetLastLocation->code,-2);
    }
    $code = str_pad(((int)$locationCode +1), 2, '0', STR_PAD_LEFT);

    return view('reference.placement.placement-sublocation', [
        'sublocations' => $fleetPlacement->get(),
        'code' => $placementState->code.$code
    ]);

})->name('.getSublocation');

Route::post('/placement-sublocation-action', function(Request $request){

    $PlacementSublocationDAO = new PlacementSublocationDAO();
    $action = $request->action;
    switch ($action) {
        case 'insert':
            $request->validate([
                'name' => 'required',
                'name' => 'required|unique:App\Models\FleetPlacement,desc',
            ], [
                'name.required' => 'Sila masukkan nama lokasi',
                'name.unique' => 'Nama lokasi sudah wujud.',
            ]);
            return $PlacementSublocationDAO->insert($request);
            break;
        case 'update':
            $request->validate([
                'name' => 'required'
            ], [
                'name.required' => 'Sila masukkan nama lokasi',
            ]);
            return $PlacementSublocationDAO->update($request);
            break;
        case 'delete':
            return $PlacementSublocationDAO->delete($request);
            break;
    }
})->name('.placement.sublocation.action');
