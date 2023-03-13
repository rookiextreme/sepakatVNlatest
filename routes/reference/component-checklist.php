<?php

use App\Http\Controllers\Reference\Component\RefComponentChecklistLvl1DAO;
use App\Http\Controllers\Reference\Component\RefComponentChecklistLvl2DAO;
use App\Http\Controllers\Reference\Component\RefComponentChecklistLvl3DAO;
use App\Models\Assessment\AssessmentType;
use App\Models\RefComponentChecklistLvl1;
use App\Models\RefComponentChecklistLvl1Selection;
use App\Models\RefComponentChecklistLvl2;
use App\Models\RefComponentChecklistLvl3;
use App\Models\RefSelection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

Route::get('/component-checklist', function(Request $request){
    $table = new RefComponentChecklistLvl1();
    $components = $table->setTable('ref_component_checklist_lvl1 AS a')
    ->select('a.id','a.code','a.component','a.status')
    ->orderBy('code', 'asc');
    $components->where('a.status', 1);

    if($request->assement_type_code){
        $components->join('assessment.assessment_type AS b', 'b.id', 'a.assessment_type_id');
        $components->where('b.code', $request->assement_type_code);
        $queryGetLastCheckListLvl1 = RefComponentChecklistLvl1::whereHas('hasAssessmentType', function($q) use($request){
            $q->where('code', $request->assement_type_code);
        })->orderBy('code', 'desc')->first();
    } elseif($request->maintenance_type_code){
        $components->join('maintenance.type AS b', 'b.id', 'a.maintenance_type_id');
        $components->where('b.code', $request->maintenance_type_code);
        $queryGetLastCheckListLvl1 = RefComponentChecklistLvl1::whereHas('hasMaintenanceType', function($q) use($request){
            $q->where('code', $request->maintenance_type_code);
        })->orderBy('code', 'desc')->first();
    }

    $list = $components->get();

    $code = 0;
    if($queryGetLastCheckListLvl1){
        $code = $queryGetLastCheckListLvl1->code;
    }

    $code = str_pad(((int)$code+1), 2, '0', STR_PAD_LEFT);

    $ref_selection_list = RefSelection::all();

    $assessmentType = AssessmentType::where('code', $request->assement_type_code)->first();

    if($queryGetLastCheckListLvl1 && $queryGetLastCheckListLvl1->hasAssessmentType){
        $assessmentType = $queryGetLastCheckListLvl1->hasAssessmentType;
        session()->put('assessment_type_id', $queryGetLastCheckListLvl1->hasAssessmentType->id);
    }

    return view('reference.component.component-checklist', [
        'components' => $list,
        'code' => $code,
        'ref_selection_list' => $ref_selection_list,
        'assessmentType' => $assessmentType
    ]);
})->name('.component.checklist');

Route::post('/component-checklist-lvl1-action', function(Request $request){

    $RefComponentChecklistLvl1DAO = new RefComponentChecklistLvl1DAO();
    $action = $request->action;
    switch ($action) {
        case 'insert':
            $request->validate([
                'name' => 'required'
            ], [
                'name.required' => 'Sila masukkan nama komponen',
            ]);
            return $RefComponentChecklistLvl1DAO->insert($request);
            break;
        case 'update':
            $request->validate([
                'name' => 'required'
            ], [
                'name.required' => 'Sila masukkan nama komponen',
            ]);
            return $RefComponentChecklistLvl1DAO->update($request);
            break;
        case 'delete':
            return $RefComponentChecklistLvl1DAO->delete($request);
            break;
    }
})->name('.component.checklist.lvl1.action');

Route::get('/component-checklist-lvl2-lastcode', function(Request $request){

        $RefComponentChecklistLvl1 = RefComponentChecklistLvl1::find($request->comLvl1Id);
        $RefComponentChecklistLvl2 = RefComponentChecklistLvl2::select('code')->where([
            'id_component_checklist_lvl1' => $request->comLvl1Id,
            'status' => 1
        ])->orderBy('code', 'desc')->first();
        Log::info($RefComponentChecklistLvl2);
        $ChecklistLvl2Code = 0;
        if($RefComponentChecklistLvl2){
            $ChecklistLvl2Code = substr($RefComponentChecklistLvl2->code,-2);
        }
        $code = str_pad(((int)$ChecklistLvl2Code +1), 2, '0', STR_PAD_LEFT);

    return [
        'code' => $RefComponentChecklistLvl1->code.$code,
    ];

})->name('.component.checklist.lvl2.lastcode');

Route::post('/component-checklist-lvl2-action', function(Request $request){

    $RefComponentChecklistLvl2DAO = new RefComponentChecklistLvl2DAO();
    $action = $request->action;
    switch ($action) {
        case 'insert':
            $request->validate([
                'name' => 'required'
            ], [
                'name.required' => 'Sila masukkan nama komponen',
            ]);
            return $RefComponentChecklistLvl2DAO->insert($request);
            break;
        case 'update':
            $request->validate([
                'name' => 'required'
            ], [
                'name.required' => 'Sila masukkan nama komponen',
            ]);
            return $RefComponentChecklistLvl2DAO->update($request);
            break;
        case 'delete':
            return $RefComponentChecklistLvl2DAO->delete($request);
            break;
    }
})->name('.component.checklist.lvl2.action');

Route::get('/component-checklist-lvl3-lastcode', function(Request $request){

    $RefComponentChecklistLvl2 = RefComponentChecklistLvl2::find($request->comLvl2Id);
    $RefComponentChecklistLvl3 = RefComponentChecklistLvl3::select('code')->where([
        'id_component_checklist_lvl2' => $request->comLvl2Id,
        'status' => 1
    ])->orderBy('code', 'desc')->first();
    Log::info($RefComponentChecklistLvl3);
    $ChecklistLvl3Code = 0;
    if($RefComponentChecklistLvl3){
        $ChecklistLvl3Code = substr($RefComponentChecklistLvl3->code,-2);
    }
    $code = str_pad(((int)$ChecklistLvl3Code +1), 2, '0', STR_PAD_LEFT);

return [
    'code' => $RefComponentChecklistLvl2->code.$code,
];

})->name('.component.checklist.lvl3.lastcode');

Route::post('/component-checklist-lvl3-action', function(Request $request){

    $RefComponentChecklistLvl3DAO = new RefComponentChecklistLvl3DAO();
    $action = $request->action;
    switch ($action) {
        case 'insert':
            $request->validate([
                'name' => 'required'
            ], [
                'name.required' => 'Sila masukkan nama komponen',
            ]);
            return $RefComponentChecklistLvl3DAO->insert($request);
            break;
        case 'update':
            $request->validate([
                'name' => 'required'
            ], [
                'name.required' => 'Sila masukkan nama komponen',
            ]);
            return $RefComponentChecklistLvl3DAO->update($request);
            break;
        case 'delete':
            return $RefComponentChecklistLvl3DAO->delete($request);
            break;
    }
})->name('.component.checklist.lvl3.action');

Route::post('/component-checklist-lvl1-update_selection_type', function(Request $request){

    $RefSelection = RefComponentChecklistLvl1Selection::find($request->id);
    $RefSelection->update([
        'selection_id' => $request->selection_type_id
    ]);

})->name('.component.checklist.lvl1.update_selection_type');

Route::post('/component-update-ammendment', function(Request $request){

    $assessment_type_id = session()->get('assessment_type_id');
    $AssessmentType = AssessmentType::find($assessment_type_id);
    $data = [
        'document_no' => $request->document_no,
        'produce_no' => $request->produce_no,
        'amendment_no' => $request->amendment_no,
        'amendment_dt' => Carbon::createFromFormat('d/m/Y', $request->amendment_dt)->format('Y-m-d')
    ];
    $AssessmentType->update($data);

    return [
        'message' => 'Maklumat pindaan berjaya disimpan',
        'code' => 200
    ];

})->name('.component.update.ammendment');