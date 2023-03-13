<?php

namespace App\Models\Maintenance;

use App\Models\RefComponentLvl2;
use App\Models\RefComponentLvl3;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceJobVehicleExaminationFormComponentSub extends Model
{
    use HasFactory;
    protected $table = 'maintenance.mjob_exam_form_component_sub';

    protected $fillable = [
        'mjob_exam_form_comp_id',
        'lvl',
        'comp_lvl2_id',
        'comp_lvl3_id',
        'sub_title',
        'quantity',
        'price',
        'created_by',
        'updated_by'
    ];

    public function hasParentComponent(){
        return $this->belongsTo(MaintenanceJobVehicleExaminationFormComponent::class, 'mjob_exam_form_comp_id');
    }

    public function hasCompLvl2(){
        return $this->belongsTo(RefComponentLvl2::class, 'comp_lvl2_id');
    }

    public function hasCompLvl3(){
        return $this->belongsTo(RefComponentLvl3::class, 'comp_lvl3_id');
    }

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(){
        return $this->belongsTo(User::class, 'updated_by');
    }

}
