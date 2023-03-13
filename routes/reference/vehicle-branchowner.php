<?php

use App\Http\Controllers\Reference\Vehicle\BranchOwner\RefOwnerDAO;

use App\Models\RefOwner;
use App\Models\RefOwnerType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::get('/vehicle-branchowner', function (Request $request) {

    $ownerTypeByFederal = RefOwnerType::where([
        'code' => '01',
        'display_for' => 'user_register'
    ])->first();

    $RefOwners = RefOwner::where([
        'owner_type_id' => $ownerTypeByFederal->id
    ])->orderBy('id', 'asc');
    $queryGetLastCategory = RefOwner::where([
        'owner_type_id' => $ownerTypeByFederal->id
    ])->orderBy('id', 'desc')->first();
    $code = str_pad(((int)$queryGetLastCategory->code+1), 4, '0', STR_PAD_LEFT);

    if($request->search){
        $search = $request->search;
            $RefOwners->whereRaw("upper(name) LIKE '%".strtoupper($search)."%' ");
    }

    Log::info("code --> ".$code);
    return view('reference.vehicle-branchowner.vehicle-branchowner', [
        'ownerTypeByFederal' => $ownerTypeByFederal,
        'RefOwners' => $RefOwners->get(),
        'code' => $code
    ]);
})->name('.vehicle-branchowner');


Route::post('/vehicle-branchowner-action', function(Request $request){

    $refEventDAO = new RefOwnerDAO();
    $action = $request->action;
    switch ($action) {
        case 'insert':
            $request->validate([
                'name' => 'required',
                'name' => 'required|unique:App\Models\RefOwner,name',
            ], [
                'name.required' => 'Sila masukkan nama cawangan',
                'name.unique' => 'Nama cawangan sudah wujud.',

            ]);
            return $refEventDAO->insert($request);
            break;
        case 'update':
            $request->validate([
                'name' => 'required',
                'name' => 'required|unique:App\Models\RefOwner,name',
            ], [
                'name.required' => 'Sila masukkan nama cawangan',
                'name.unique' => 'Nama cawangan sudah wujud.',
            ]);
            return $refEventDAO->update($request);
            break;
        case 'delete':
            return $refEventDAO->delete($request);
            break;
    }
})->name('.vehicle.branchowner.action');

?>
