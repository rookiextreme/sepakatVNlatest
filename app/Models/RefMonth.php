<?php

namespace App\Models;

use App\Models\Maintenance\MaintenanceJobVehicleExaminationFormChecklist;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RefMonth extends Model
{
    use HasFactory;

    protected $table = 'ref_month';

    protected $fillable = [
        'id',
        'code',
        'desc_bm',
        'desc_en',
        'detail_bm'.
        'detail_en'.
        'status'
    ];

    public function hasTotalCheckListLvl1(){
        return MaintenanceJobVehicleExaminationFormChecklist::whereMonth('updated_at', $this->code)
        ->whereHas('hasFormRepair', function($q){
            $q->whereHas('hasMaintenanceJobVehicleStatus', function($q2){
                $q2->where('code', '12');
            });
        })->count();
    }

    public function hasTotalCheckListLvl1Internal(){
        return MaintenanceJobVehicleExaminationFormChecklist::whereMonth('updated_at', $this->code)
        ->whereHas('hasFormRepair', function($q){
            $q->whereHas('hasMaintenanceJobVehicleStatus', function($q2){
                $q2->where('code', '12');
            })->whereHas('hasRepairMethod', function($q3){
                $q3->where('code', '01');
            });
        })->count();
    }

    public function hasTotalCheckListLvl1External(){
        return MaintenanceJobVehicleExaminationFormChecklist::whereMonth('updated_at', $this->code)
        ->whereHas('hasFormRepair', function($q){
            $q->whereHas('hasMaintenanceJobVehicleStatus', function($q2){
                $q2->where('code', '12');
            })->whereHas('hasRepairMethod', function($q3){
                $q3->where('code', '02');
            });
        })->count();
    }

    public function hasPercentageCheckListLvl1Internal(){
        if($this->hasTotalCheckListLvl1Internal() > 0){
            return $this->hasTotalCheckListLvl1Internal() / $this->hasTotalCheckListLvl1() * 100;
        } else {
            return 0;
        }
        
    }

    public function hasTotalCompCheck(){
        $query = DB::select('select count(*) FROM 
        (
            select d.component as component, a.updated_at as comp_updated_at from maintenance.form_checklist_lvl3 a 
            join maintenance.form_checklist_lvl2 b on b.id = a.formchecklistlvl2_id
            join maintenance.form_checklist_lvl1 c on c.id = b.formchecklistlvl1_id
            join ref_component_checklist_lvl1 d on d.id = c.checklistlvl1_id
            where a.is_pass = true AND EXTRACT(MONTH FROM a.updated_at) = '.$this->code.'
            union
            select c.component as component, a.updated_at as comp_updated_at from maintenance.form_checklist_lvl2 a 
            join maintenance.form_checklist_lvl1 b on b.id = a.formchecklistlvl1_id
            join ref_component_checklist_lvl1 c on c.id = b.checklistlvl1_id
            where a.is_pass = true AND EXTRACT(MONTH FROM a.updated_at) = '.$this->code.'
        ) 
        as com_list');
        return $query[0]->count;
    }

}
