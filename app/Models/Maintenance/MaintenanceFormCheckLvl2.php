<?php

namespace App\Models\Maintenance;

use App\Models\RefComponentChecklistLvl2;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceFormCheckLvl2 extends Model
{
    use HasFactory;

    protected $table = 'maintenance.form_checklist_lvl2';

    protected $fillable = [
        'vehicle_id',
        'checklistlvl2_id',
        'formchecklistlvl1_id',
        'note',
        'doc_id',
        'is_pass'
    ];

    public function hasComponentLvl2(){
        return $this->belongsTo(RefComponentChecklistLvl2::class, 'checklistlvl2_id');
    }

    public function hasFormComponentCheckListLvl3(){
        return $this->hasMany(MaintenanceFormCheckLvl3::class, 'formchecklistlvl2_id');
    }

    public function hasDoc(){
        return $this->belongsTo(MaintenanceEvaluationFormCheckDoc::class, 'doc_id');
    }

}
