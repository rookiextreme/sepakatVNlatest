<?php

use App\Http\Controllers\Assessment\New\AssessmentNewDAO;
use App\Http\Controllers\Helpers\HelpersFunction;
use App\Models\Assessment\AssessmentFormCheckLvl1;
use App\Models\Assessment\AssessmentNew;
use App\Models\RefComponentChecklistLvl1;
use App\Models\RefComponentLvl1;
use App\Models\RefWorkshop;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/mockup-generate-RefNumber', function(){

    $year = Carbon::now()->format('Y');
    $query = AssessmentNew::orderBy('created_at', 'desc')->whereHas('hasStatus', function($q){
        $q->whereNotIn('code', ['00','06']);
    });
    if($query->first()){
        $baseYear = Carbon::parse($query->first()->created_at)->format('Y');
    } else {
        $baseYear = Carbon::now()->format('Y');
    }
    
    $modulePrefix = 'N'; //Module Penilaian
    $SubModulePrefix = 'N'; //Kenderaan Baharu

    $diffYear = $year-$baseYear;
    $HelpersFunction = new HelpersFunction();

    $alpha = $HelpersFunction->getAlpha($diffYear);

    $workShop = RefWorkshop::find(1);
    $applicationRunningNo = str_pad(((int)$query->count() +1), 4, '0', STR_PAD_LEFT);
    
    return $modulePrefix.$SubModulePrefix.$alpha.$workShop->code.$applicationRunningNo;
});

Route::get('/mockup-form', function(){

    $Ref01ComponentChecklistLvl1 = RefComponentChecklistLvl1::whereHas('hasAssessmentType', function($q){
        $q->where('code', '01');
    });

    Log::info($Ref01ComponentChecklistLvl1->toSql());

    $RefComponentChecklistLvl1 = RefComponentChecklistLvl1::whereHas('hasAssessmentType', function($q){
        $q->where('code', '02');
    });

    Log::info($RefComponentChecklistLvl1->toSql());

    return view('mockup.form', [
        'Ref01ComponentChecklistLvl1' => $Ref01ComponentChecklistLvl1->get(),
        'RefComponentChecklistLvl1' => $RefComponentChecklistLvl1->get()
    ]);
})->name('.mockup.form');

Route::get('/mockup-letter-01', function(){
    return view('mockup.letter-01', [
    ]);
})->name('.mockup.letter-01');

Route::get('/mockup-assessment-checklist', function(Request $request){
    $AssessmentFormCheckLvl1List = AssessmentFormCheckLvl1::where([
        'assessment_type_id' => $request->assessment_type_id,
        'vehicle_id' => $request->vehicle_id
    ]);
    return view('mockup.assessment-checklist', [
        'AssessmentFormCheckLvl1List' => $AssessmentFormCheckLvl1List->get()
    ]);
})->name('.mockup.assessment-checklist');

