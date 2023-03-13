<?php

namespace App\Models\Maintenance;

use App\Models\Maintenance\MaintenanceJobPurposeType;
use App\Models\RefComponentLvl1;
use App\Models\RefComponentLvl2;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceJobVehicleExaminationFormComponent extends Model
{
    use HasFactory;

    protected $table = 'maintenance.mjob_exam_form_component';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'form_id',
        'jve_form_repair_id',
        'maintenance_job_purpose_type_id',
        'ref_component_lvl1_id',
        'ref_component_lvl2_id',
        'note',
        'quantity',
        'per_price',
        'total_price',
        'noted_by',
        'detail'
    ];

    public function hasForm(){
        return $this->belongsTo(MaintenanceJobVehicleExaminationForm::class, 'form_id');
    }

    public function hasFormRepair(){
        return $this->belongsTo(MaintenanceJobVehicleExaminationFormRepair::class, 'jve_form_repair_id');
    }

    public function hasMaintenanceJobPurposeType(){
        return $this->belongsTo(MaintenanceJobPurposeType::class, 'maintenance_job_purpose_type_id');
    }

    public function hasRefComponentLvl1(){
        return $this->belongsTo(RefComponentLvl1::class, 'ref_component_lvl1_id');
    }

    public function hasRefComponentLvl2(){
        return $this->belongsTo(RefComponentLvl2::class, 'ref_component_lvl2_id');
    }

    public function notedBy(){
        return $this->belongsTo(User::class, 'noted_by');
    }

    public function hasManyResearchMarketComponent(){
        return $this->hasMany(MaintenanceJobVehicleExaminationFormComponentSub::class, 'mjob_exam_form_comp_id')->orderBy('created_at', 'desc');
    }

    public function hasManyExamProcurement(){
        return $this->hasMany(MaintenanceJobExamProcurement::class, 'mjob_exam_form_component_id')
        ->whereHas('hasCompany', function($q){
            $q->where('form_id', $this->form_id);
        })
        ->orderBy('supplier_company_id','asc');
    }

}
