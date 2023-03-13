<?php

namespace App\Models;

use App\Models\Maintenance\MaintenanceJobPurposeType;
use App\Models\Maintenance\MaintenanceJobVehicleExaminationFormChecklist;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefComponentLvl1 extends Model
{
    use HasFactory;

    protected $table = 'ref_component_lvl1';

    protected $fillable = [
        'id',
        'code',
        'component',
        'component_shortname',
        'status',
        // 'code_assessment',
        'assessment_type_id',
        'job_purpose_type_id'

    ];

    public function hasJobPurposeType(){
        return $this->belongsTo(MaintenanceJobPurposeType::class, 'job_purpose_type_id');
    }

    public function hasManyCheckListLvl1(){
        return $this->hasMany(MaintenanceJobVehicleExaminationFormChecklist::class, 'component_lvl1_id');
    }

    public function hasTotalCheckListLvl1($month){
        return $this->hasMany(MaintenanceJobVehicleExaminationFormChecklist::class, 'component_lvl1_id')->
            whereMonth('updated_at', $month)
            ->whereHas('hasFormRepair', function($q){
                $q->whereHas('hasMaintenanceJobVehicleStatus', function($q2){
                    $q2->where('code', '12');
                });
            })
            ->count();
    }

    public function hasTotalCheckListLvl1Internal($month){
        return $this->hasMany(MaintenanceJobVehicleExaminationFormChecklist::class, 'component_lvl1_id')->
            whereMonth('updated_at', $month)
            ->whereHas('hasFormRepair', function($q){
                $q->whereHas('hasMaintenanceJobVehicleStatus', function($q2){
                    $q2->where('code', '12');
                })->whereHas('hasRepairMethod', function($q3){
                    $q3->where('code', '01');
                });
            })
            ->count();
    }

    public function hasTotalCheckListLvl1External($month){
        return $this->hasMany(MaintenanceJobVehicleExaminationFormChecklist::class, 'component_lvl1_id')->
            whereMonth('updated_at', $month)
            ->whereHas('hasFormRepair', function($q){
                $q->whereHas('hasMaintenanceJobVehicleStatus', function($q2){
                    $q2->where('code', '12');
                })->whereHas('hasRepairMethod', function($q3){
                    $q3->where('code', '02');
                });
            })
            ->count();
    }

    public function hasManyCheckListLvl2(){
        return $this->hasMany(MaintenanceJobVehicleExaminationFormChecklist::class, 'component_lvl1_id')->where('lvl', 2);
    }

    public function hasManyLvl2(){
        return $this->hasMany(RefComponentLvl2::class, 'id_component_lvl1');
    }

}
