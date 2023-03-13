<?php

use App\Http\Controllers\Reference\Component\RefComponentDAO;
use App\Models\RefComponentLvl1;
use App\Models\RefComponentLvl2;
use App\Models\RefComponentLvl3;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

Route::get('/vehicle-component', function(Request $request){
    $component = RefComponentLvl1::orderBy('id', 'asc');
    $component->where('status', 1);
    $queryGetLastCategory = RefComponentLvl1::where([
        'status' => 1
    ])->orderBy('code', 'desc')->first();
    $code = str_pad(((int)$queryGetLastCategory->code+1), 2, '0', STR_PAD_LEFT);

    if($request->search){
        $search = $request->search;
            $component->whereRaw("upper(component) LIKE '%".strtoupper($search)."%' ");
    }

    return view('reference.vehicle-component.vehicle-component', [
        'component' => $component->get(),
        'code' => $code
    ]);
})->name('.vehicle-component');


Route::get('/getComponentLvl2', function(Request $request){
    session()->put('session_id_component_lvl1', request('lvl1_id'));
    $parent = RefComponentLvl1::find($request->lvl1_id);
    $componentlvl2 = RefComponentLvl2::where([
        'id_component_lvl1' => $request->lvl1_id
    ])->orderBy('id', 'asc');
    $componentlvl2->where('status', 1);

    $code = 0;
    $queryGetLastComponentlvl2 = RefComponentLvl2::where(
        [
            'id_component_lvl1' => $request->lvl1_id,
            'status' => 1
        ]
    )->orderBy('code', 'desc')->first();
    if($queryGetLastComponentlvl2){
        $code = substr($queryGetLastComponentlvl2->code,-2);
    }

    $code = str_pad(((int)$code +1), 2, '0', STR_PAD_LEFT);

    return view('reference.vehicle-component.level2-component', [
        'componentLvl2' => $componentlvl2->get(),
        'code' => $parent->code.$code
    ]);
})->name('.getComponentLvl2');


Route::get('/getComponentLvl3', function(Request $request){
    $parent = RefComponentLvl2::find($request->lvl2_id);
    $componentlvl3 = RefComponentLvl3::where([
        'id_component_lvl2' => $request->lvl2_id,
        'status' => 1
    ])->orderBy('id', 'asc');
    $componentlvl3->where('status', 1);

    $code = 0;
    $queryGetLastComponentlvl3 = RefComponentLvl3::where(
        [
            'id_component_lvl2' => $request->lvl2_id
        ]
    )->orderBy('code', 'desc')->first();
    if($queryGetLastComponentlvl3){
        $code = substr($queryGetLastComponentlvl3->code,-2);
    }
    $code = str_pad(((int)$code +1), 2, '0', STR_PAD_LEFT);

    return view('reference.vehicle-component.level3-component', [
        'componentLvl3' => $componentlvl3->get(),
        'code' => $parent->code.$code
    ]);
})->name('.getComponentLvl3');

Route::post('/vehicle-component-action', function(Request $request){

    $refComponentDAO = new RefComponentDAO();
    $action = $request->action;
    $lvl = $request->lvl ? $request->lvl : 1;

    switch ($action) {
        case 'insert':

            switch ($lvl) {
                case 1:
                    $request->validate([
                        'name' => 'required',
                        'name' => 'required|unique:App\Models\RefComponentLvl1,component',
                    ], [
                        'name.required' => 'Sila masukkan nama komponen',
                        'name.unique' => 'Nama Komponen sudah wujud.',
                    ]);
                break;

                case 2:
                    $request->validate([
                        'name' => 'required',
                        'name' => 'required|unique:App\Models\RefComponentLvl2,component',
                    ], [
                        'name.required' => 'Sila masukkan nama komponen',
                        'name.unique' => 'Nama Komponen sudah wujud.',
                    ]);
                break;

                case 3:
                    $request->validate([
                        'name' => 'required',
                        'name' => 'required|unique:App\Models\RefComponentLvl3,component',
                    ], [
                        'name.required' => 'Sila masukkan nama komponen',
                        'name.unique' => 'Nama Komponen sudah wujud.',
                    ]);
                break;
            }

            $request->validate([
                'name' => 'required',
                'name' => 'required|unique:App\Models\RefComponentLvl1,component',
            ], [
                'name.required' => 'Sila masukkan nama komponen FIRST',
                'name.unique' => 'Nama Komponen sudah wujud.',
            ]);
            return $refComponentDAO->insert($request);
            break;
        case 'update':
            $request->validate([
                'name' => 'required'
            ], [
                'name.required' => 'Sila masukkan nama komponen',
            ]);
            return $refComponentDAO->update($request);
            break;
        case 'delete':
            return $refComponentDAO->delete($request);
            break;
    }
})->name('.vehicle.component.action');
