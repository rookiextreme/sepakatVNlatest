<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use App\Models\Maintenance\MaintenanceEvaluationLetter;
use App\Models\Maintenance\MaintenanceEvaluationLetterStatus;
use App\Models\Maintenance\MaintenanceEvaluationLetterType;
use App\Models\Maintenance\MaintenanceFormCheckLvl1;
use App\Models\Maintenance\MaintenanceFormCheckLvl1Selection;
use App\Models\Maintenance\MaintenanceFormCheckLvl2;
use App\Models\Maintenance\MaintenanceFormCheckLvl3;
use App\Models\Maintenance\MaintenanceEvaluationVehicle;
use App\Models\Maintenance\MaintenanceJobVehicle;
use App\Models\Maintenance\MaintenanceJobVehicleStatus;
use App\Models\Maintenance\MaintenanceType;
use App\Models\Maintenance\MaintenanceVehicleStatus;
use App\Models\Maintenance\MaintenanceJobVehicleExaminationForm;
use App\Models\Maintenance\MaintenanceJobVehicleExaminationFormRepair;
use App\Models\Maintenance\MaintenanceRepairMethod;
use App\Models\RefComponentChecklistLvl1;
use App\Models\RefComponentLvl1;
use App\Models\RefSelection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MaintenanceDAO extends Controller
{
    public $id = -1;
    public $detail;
    public $message;
    public $maintenance_type_code;

    public function generateLetter(Request $request){

        $checkLetter = MaintenanceEvaluationLetter::where([
            'vehicle_id' => $request->vehicle_id
        ])->first();

        if(!$checkLetter){

            $LetterTypeList = MaintenanceEvaluationLetterType::all();

            foreach ($LetterTypeList as $LetterType) {
            MaintenanceEvaluationLetter::create([
                'evaluation_letter_type_id' => $LetterType->id,
                'vehicle_id' => $request->vehicle_id,
                'letter_status_id' => $this->letterStatus('01'),
                'created_by' => Auth::user()->id
            ]);
            }
        }

        $route = '';

        $vehicleDetail = MaintenanceEvaluationVehicle::find($request->vehicle_id);

        return [
            'url' => route('maintenance.evaluation.vehicle-maintenance.letter', [
                'maintenance_id' => session()->get('mjob_current_detail_id'),
                'vehicle_id' => $request->vehicle_id,
                'template_type_id' => $vehicleDetail->hasTemplateLetter ? $vehicleDetail->hasTemplateLetter->hasLetterType->id: null,
                'template_type_code' => $vehicleDetail->hasTemplateLetter ? $vehicleDetail->hasTemplateLetter->hasLetterType->code: null,
                'tab' => $request->tab
            ])
        ];
    }

    public function generateExamLetter(Request $request){

        $checkLetter = MaintenanceEvaluationLetter::where([
            'vehicle_id' => $request->vehicle_id
        ])->first();

        if(!$checkLetter){

            MaintenanceEvaluationLetter::create([
                'vehicle_id' => $request->vehicle_id,
                'letter_status_id' => $this->letterStatus('01'),
                'created_by' => Auth::user()->id
            ]);
        }

        $route = '';

        $vehicleDetail = MaintenanceEvaluationVehicle::find($request->vehicle_id);

        return [
            'url' => route('maintenance.evaluation.vehicle-maintenance.letter', [
                'maintenance_id' => session()->get('mjob_current_detail_id'),
                'vehicle_id' => $request->vehicle_id,
                // 'template_type_id' => $vehicleDetail->hasTemplateLetter ? $vehicleDetail->hasTemplateLetter->hasLetterType->id: null,
                // 'template_type_code' => $vehicleDetail->hasTemplateLetter ? $vehicleDetail->hasTemplateLetter->hasLetterType->code: null,
                'tab' => $request->tab
            ])
        ];
    }

    public function generateForm(Request $request)
    {
        // dd($request->all());
        Log::info('MaintenanceDAO ::  GenerateForm');
        Log::info($request);
        $this->maintenance_type_code = $request->maintenance_type_code;

        $route = '';
        $tab = $request->tab;

        switch ($this->maintenance_type_code) {
            case '01':

                $checkExistFormLvl1 = MaintenanceFormCheckLvl1::where([
                    'vehicle_id' => $request->vehicle_id,
                    'maintenance_type_id' => $this->hasMaintenanceType($this->maintenance_type_code)
                ])->first();
                $CheckListLvl1 = RefComponentChecklistLvl1::whereHas('hasMaintenanceType', function($q){
                    $q->where('code', $this->maintenance_type_code);
                })->get();

                Log::info($checkExistFormLvl1);

                if(!$checkExistFormLvl1){

                    Log::info($CheckListLvl1);
                    foreach ($CheckListLvl1 as $CheckList){

                        $insertedFormCheckLvl1  = MaintenanceFormCheckLvl1::create([
                            'maintenance_type_id' => $this->hasMaintenanceType($this->maintenance_type_code),
                            'vehicle_id' => $request->vehicle_id,
                            'checklistlvl1_id' => $CheckList->id
                        ]);

                        if($CheckList->has_selection){

                            foreach ($CheckList->hasManySelection as $tableSelection) {
                                $data = [
                                    'form_checklist_lvl1_id' => $insertedFormCheckLvl1->id,
                                    'table_selection_id' => $tableSelection->id,
                                    'selection_id' => RefSelection::where('code', '01')->first()->id
                                ];
                                MaintenanceFormCheckLvl1Selection::create($data);
                            }
                        }

                        Log::info($CheckList->hasManyComponentChecklistLvl2);

                        foreach ($CheckList->hasManyComponentChecklistLvl2 as $CheckListLvl2){
                            $insertedFormCheckLvl2 = MaintenanceFormCheckLvl2::create([
                                'vehicle_id' => $request->vehicle_id,
                                'formchecklistlvl1_id' => $insertedFormCheckLvl1->id,
                                'checklistlvl2_id' => $CheckListLvl2->id
                            ]);

                            foreach ($CheckListLvl2->hasManyComponentChecklistLvl3 as $CheckListLvl3){
                                MaintenanceFormCheckLvl3::create([
                                    'vehicle_id' => $request->vehicle_id,
                                    'formchecklistlvl2_id' => $insertedFormCheckLvl2->id,
                                    'checklistlvl3_id' => $CheckListLvl3->id
                                ]);
                            }
                        }
                    }
                }

                $queryVehicle = MaintenanceEvaluationVehicle::find($request->vehicle_id);
                $route = 'maintenance.evaluation.vehicle-maintenance.form';
                break;
            case '02':

                Log::info('$request->vehicle_id => '.$request->vehicle_id);

                $checkExistForm = MaintenanceJobVehicleExaminationForm::where([
                    'vehicle_id' => $request->vehicle_id
                ])->first();

                Log::info($checkExistForm);

                if($request->repair_method_id){

                    $checkExistForm = MaintenanceJobVehicleExaminationFormRepair::where([
                        'vehicle_id' => $request->vehicle_id,
                        'repair_method_id' => $request->repair_method_id,
                    ])->first();

                    Log::info('repair_method_id::$checkExistForm => '.$checkExistForm);
                }

                if(!$checkExistForm){
                    $data = [
                        'vehicle_id' => $request->vehicle_id,
                        'job_vehicle_status_id' => $this->hasMaintenanceJobVehicleStatus('01')
                    ];

                    MaintenanceJobVehicleExaminationForm::create($data);
                } else {
                    if($checkExistForm->hasMaintenanceJobVehicleStatus->code == '01'){
                        $checkExistForm->update([
                            'job_vehicle_status_id' => $this->hasMaintenanceJobVehicleStatus('02')
                        ]);
                    }
                }

                if($checkExistForm){

                    if($checkExistForm->hasInternalRepairStatus){
                        Log::info('internal ?');
                        if(in_array($checkExistForm->hasInternalRepairStatus->code, ['01','02','07'])){
                            $tab = 4;
                        } else {
                            $tab = 5;
                        }

                        Log::info($checkExistForm->hasInternalRepairStatus);

                        if($checkExistForm->hasInternalRepairStatus->code == '01'){
                            $checkExistForm->update([
                                'internal_repair_status_id' => 7
                            ]);

                            if($checkExistForm->hasJveForm){
                                $checkExistForm->hasJveForm->update([
                                    'internal_repair_status_id' => 7
                                ]);
                            }
                        } else if($checkExistForm->hasInternalRepairStatus->code == '03' && $checkExistForm->hasExternalRepairStatus->code == '04'){
                            $checkExistForm->update([
                                'ext_repair_status_id' => 8
                            ]);
                        }
                    }  else {

                        Log::info('external ?');

                        if($checkExistForm->hasExternalRepairStatus && in_array($checkExistForm->hasExternalRepairStatus->code, ['04','05','08'])){
                            if($checkExistForm->hasExternalRepairStatus->code == '05'){
                                $tab = 5;
                            } else if(Auth::user()->isForemenMaintenance()){
                                $tab = 5;
                                if($checkExistForm->hasJveForm){
                                    $checkExistForm->hasJveForm->update([
                                        'ext_repair_status_id' => 8
                                    ]);
                                }
    
                                $checkExistForm->update([
                                    'ext_repair_status_id' => 8
                                ]);
                            } else {
                                $tab = 2;
                            }
                            
                        }
                        else if($checkExistForm->hasMaintenanceJobVehicleStatus->code == '11' && $checkExistForm->hasExternalRepairStatus && $checkExistForm->hasExternalRepairStatus->code == '04'){
                            $checkExistForm->update([
                                'ext_repair_status_id' => 8
                            ]);
                            $tab = 5;
                        }
                    }
                }

                if($checkExistForm->hasInternalRepairStatus && $checkExistForm->hasInternalRepairStatus->code == '07'){
                    $tab = 4;
                } else if($checkExistForm->hasExternalRepairStatus && $checkExistForm->hasExternalRepairStatus->code == '08'){
                    $tab = 5;
                }

                $queryVehicle = MaintenanceJobVehicle::find($request->vehicle_id);
                $route = 'maintenance.job.vehicle-maintenance.form';
                break;

            case '03':

                $checkExistFormLvl1 = MaintenanceFormCheckLvl1::where([
                    'vehicle_id' => $request->vehicle_id,
                    'maintenance_type_id' => $this->hasMaintenanceType($this->maintenance_type_code)
                ]);

                $listLvl1 = RefComponentChecklistLvl1::whereHas('hasMaintenanceType', function($q){
                        $q->where('code', $this->maintenance_type_code);
                    })->get();

                    Log::info('masuk checklist loji');
                    Log::info($checkExistFormLvl1->exists());
                if(!$checkExistFormLvl1->exists()){
                    Log::info('xda lagi');

                    // $checkExistFormLvl1->whereHas('hasComponentLvl1', function ($q){
                    //     $q->whereHas('hasMaintenanceType', function($q){
                    //                 $q->where('code', $this->maintenance_type_code);
                    //             })->get();
                    // });
                    // dd($checkExistFormLvl1);

                    foreach ($listLvl1 as $CheckList){

                                $insertedFormCheckLvl1  = MaintenanceFormCheckLvl1::create([
                                    'maintenance_type_id' => $this->hasMaintenanceType($this->maintenance_type_code),
                                    'vehicle_id' => $request->vehicle_id,
                                    'checklistlvl1_id' => $CheckList->id
                                ]);

                                foreach ($CheckList->hasManyComponentChecklistLvl2 as $CheckListLvl2){
                                    $insertedFormCheckLvl2 = MaintenanceFormCheckLvl2::create([
                                        'vehicle_id' => $request->vehicle_id,
                                        'formchecklistlvl1_id' => $insertedFormCheckLvl1->id,
                                        'checklistlvl2_id' => $CheckListLvl2->id
                                    ]);

                                    foreach ($CheckListLvl2->hasManyComponentChecklistLvl3 as $CheckListLvl3){
                                        MaintenanceFormCheckLvl3::create([
                                            'vehicle_id' => $request->vehicle_id,
                                            'formchecklistlvl2_id' => $insertedFormCheckLvl2->id,
                                            'checklistlvl3_id' => $CheckListLvl3->id
                                        ]);
                                    }
                                }
                            }
                }

                $queryVehicle = MaintenanceEvaluationVehicle::find($request->vehicle_id);
                $route = 'maintenance.evaluation.vehicle-maintenance-loji.form';
                break;

            default:
                break;
        }

        $data = [];

        if($queryVehicle->hasMaintenanceVehicleStatus->code == '01'){
            $data['maintenance_vehicle_status_id'] = $this->hasMaintenanceVehicleStatus("06");
        }

        if(Auth::user()->isForemenMaintenance()){
            $data['foremen_by'] = Auth::user()->id;
        };

        $queryVehicle->update($data);

        return [
            'url' => route($route, [
                'maintenance_type_id' => $this->hasMaintenanceType($this->maintenance_type_code),
                'maintenance_id' => $queryVehicle->hasMaintenanceDetail,
                'repair_method_id' => $request->repair_method_id,
                'vehicle_id' => $request->vehicle_id,
                'tab' => $tab
            ])
        ];
    }

    private function convertDateToSQLDateTime($dateVal, $format){
        return Carbon::createFromFormat('d/m/Y', $dateVal)->format($format);
    }

    private function hasMaintenanceType($code){
        $data = MaintenanceType::where('code', $code)->first();
        return $data->id;
    }

    private function hasMaintenanceVehicleStatus($code){
        $data = MaintenanceVehicleStatus::where('code', $code)->first();
        return $data->id;
    }

    private function hasMaintenanceJobVehicleStatus($code){
        $data = MaintenanceJobVehicleStatus::where('code', $code)->first();
        return $data->id;
    }

    private function letterStatus($code){
        $data = MaintenanceEvaluationLetterStatus::where('code', $code)->first();
        return $data->id;
    }

}
