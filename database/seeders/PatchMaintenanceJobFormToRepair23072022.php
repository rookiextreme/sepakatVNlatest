<?php

namespace Database\Seeders;

use App\Models\Maintenance\MaintenanceJobSupplierCompany;
use App\Models\Maintenance\MaintenanceJobVehicleExaminationForm;
use App\Models\Maintenance\MaintenanceJobVehicleExaminationFormRepair;
use App\Models\Maintenance\MaintenanceRepairMethod;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class PatchMaintenanceJobFormToRepair23072022 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $list = MaintenanceJobVehicleExaminationForm::
        where('repair_method', '!=', '1,2')
        ->whereRaw('repair_method is not null')
        ->whereHas('hasMaintenanceJobVehicleStatus', function($q){
            $q->whereIn('code', ['04','05','06','07','08','09','10','11','12']);
        })
        ->where('is_research_market', 1)
        ->whereDoesntHave('hasFormRepair')
        ->whereHas('hasVehicle', function($q){
            $q->whereHas('hasMaintenanceDetail', function($q2){
                $q2->whereHas('hasStatus', function($q3){
                    $q3->whereNotIn('code', ['00']);
                });
                // $q2->where('ref_number', 'SSA010112');
            });
        });

        $objList = [];
        $objListCompletedDalaman = []; // tray yang dah selesai // status 12 dalaman
        $objListCompletedLuaran = []; // tray yang dah selesai // status 12 dalaman
        $obj = [];

        $totalByStatus = [
            '4' => [
                'code' => null,
                'desc' => null,
                'total' => [
                    'dalaman' => 0,
                    'luaran' => 0,
                ],
                'list' => [],
            ],
            '5' => [
                'code' => null,
                'desc' => null,
                'total' => [
                    'dalaman' => 0,
                    'luaran' => 0,
                ],
                'list' => [],
            ],
            '6' => [
                'code' => null,
                'desc' => null,
                'total' => [
                    'dalaman' => 0,
                    'luaran' => 0,
                ],
                'list' => [],
            ],
            '7' => [
                'code' => null,
                'desc' => null,
                'total' => [
                    'dalaman' => 0,
                    'luaran' => 0,
                ],
                'list' => [],
            ],
            '8' => [
                'code' => null,
                'desc' => null,
                'total' => [
                    'dalaman' => 0,
                    'luaran' => 0,
                ],
                'list' => [],
            ],
            '9' => [
                'code' => null,
                'desc' => null,
                'total' => [
                    'dalaman' => 0,
                    'luaran' => 0,
                ],
                'list' => [],
            ],
            '10' => [
                'code' => null,
                'desc' => null,
                'total' => [
                    'dalaman' => 0,
                    'luaran' => 0,
                ],
                'list' => [],
            ],
            '11' => [
                'code' => null,
                'desc' => null,
                'total' => [
                    'dalaman' => 0,
                    'luaran' => 0,
                ],
                'list' => [],
            ],
            '12' => [
                'code' => null,
                'desc' => null,
                'total' => [
                    'dalaman' => 0,
                    'luaran' => 0,
                ],
                'list' => [],
            ],
        ];

        Log::info('total overall => '.$list->count());

        foreach ($list->get() as $index => $key) {

            // Log::info('$repair_method '.$key->repair_method);

            $repair_method = MaintenanceRepairMethod::find($key->repair_method);


            // Log::info('$key->hasVehicle->plate_no '.$key->hasVehicle->plate_no);
            // Log::info('$key->hasVehicle->hasMaintenanceDetail->ref_number '.$key->hasVehicle->hasMaintenanceDetail->ref_number);
            // Log::info('$repair_method '.$repair_method->desc);

            $obj = [
                'vehicle_id' => $key->vehicle_id,
                'jve_form_id'=> $key->id,
                'repair_method_id'=> $key->repair_method,
                'external_repair_id'=> $key->external_repair_id,
                'other_external_note'=> $key->other_external_note,
                'is_research_market'=> $key->is_research_market,
                'price_budget'=> $key->price_budget,
                'inspected_by'=> $key->inspected_by,
                'inspected_dt'=> $key->inspected_dt,
                'inspected_done_by'=> $key->inspected_done_by,
                'inspected_done_dt'=> $key->inspected_done_dt,
                'rsm_prepared_by'=> $key->rsm_prepared_by,
                'rsm_prepared_dt'=> $key->rsm_prepared_dt,
                'rsm_verified_by'=> $key->rsm_verified_by,
                'rsm_verified_dt'=> $key->rsm_verified_dt,
                'pro_prepared_by'=> $key->pro_prepared_by,
                'pro_prepared_dt'=> $key->pro_prepared_dt,
                'pro_verified_by'=> $key->pro_verified_by,
                'pro_verified_dt'=> $key->pro_verified_dt,
                'pro_approved_by'=> $key->pro_approved_by,
                'pro_approved_dt'=> $key->pro_approved_dt,
                'waran_type_id'=> $key->waran_type_id,
                'osol_type_id'=> $key->osol_type_id,
                'tested_by'=> $key->tested_by,
                'tested_dt'=> $key->tested_dt,
                'tested_done_by'=> $key->tested_done_by,
                'tested_done_dt'=> $key->tested_done_dt,
                'tested_detail'=> $key->tested_detail,
                'tester_note'=> $key->tester_note,
                'next_service_dt'=> $key->next_service_dt,
                'next_service_odometer'=> $key->next_service_odometer,
                'job_vehicle_status_id'=> $key->job_vehicle_status_id,
                'internal_repair_status_id'=> $key->repair_method == 1 ? $key->internal_repair_status_id : null,
                'ext_repair_status_id'=> $key->repair_method == 2 ? $key->ext_repair_status_id : null,
                'pro_budget_price_supl_id'=> $key->pro_budget_price_supl_id,
                'pro_budget_price'=> $key->pro_budget_price,
                'pro_budget_price_note'=> $key->pro_budget_price_note,
                'advance'=> $key->advance,
                'expense'=> $key->expense,
                'lo_no'=> $key->lo_no,
                'completed_dt'=> $key->completed_dt,
                'completed_by'=> $key->completed_by,
                'v_completed_dt'=> $key->v_completed_dt,
                'inspect_type'=> $key->inspect_type,
                'company_signature'=> $key->company_signature,
                'warrant_detail_id'=> $key->warrant_detail_id,
                'is_start'=> false,
                'updated_at' => $key->updated_at,
                'created_at' => $key->created_at,
                'is_scripting' => 1,
            ];

            array_push($objList, $obj);

            if(isset($totalByStatus[$key->hasMaintenanceJobVehicleStatus->id])){
                $totalByStatus[$key->hasMaintenanceJobVehicleStatus->id]['code'] = $key->hasMaintenanceJobVehicleStatus->code;
                $totalByStatus[$key->hasMaintenanceJobVehicleStatus->id]['desc'] = $key->hasMaintenanceJobVehicleStatus->desc;

                if($key->repair_method == 1){
                    $totalByStatus[$key->hasMaintenanceJobVehicleStatus->id]['total']['dalaman'] += 1;
                } elseif($key->repair_method == 2){
                    $totalByStatus[$key->hasMaintenanceJobVehicleStatus->id]['total']['luaran'] += 1;
                }
                
                $obj2 = [
                    'jve_form_id' => $key->id,
                    'ref_number' =>$key->hasVehicle->hasMaintenanceDetail->ref_number,
                    'plate_no' => $key->hasVehicle->plate_no,
                ];
                array_push($totalByStatus[$key->hasMaintenanceJobVehicleStatus->id]['list'], $obj2);
            }


            if($key->repair_method == 1 && $key->hasMaintenanceJobVehicleStatus->code == '12'){
                array_push($objListCompletedDalaman, $obj);
            } elseif($key->repair_method == 2 && $key->hasMaintenanceJobVehicleStatus->code == '12'){
                array_push($objListCompletedLuaran, $obj);
            }
            
        }

        Log::info('$totalByStatus => '.json_encode($totalByStatus));

        // Log::info('$objList', $objList);
        // Log::info('total => $objList => '.count($objList));
        Log::info('objListCompleted Dalaman => '.count($objListCompletedDalaman));
        Log::info('objListCompleted Luaran => '.count($objListCompletedLuaran));
        
        MaintenanceJobVehicleExaminationFormRepair::insert($objList);

        $listInserted = MaintenanceJobVehicleExaminationFormRepair::where('is_scripting', 1);

        foreach ($listInserted->get() as $index => $key2) {
            $querySupplier = MaintenanceJobSupplierCompany::
            where('form_id', $key2->jve_form_id)
            ->whereDate('updated_at', '2022-07-23');

            $querySupplier->update([
                'jve_form_repair_id' => $key2->id
            ]);
        }

    }

}
