<?php

namespace App\Models\Maintenance;

use App\Models\RefComponentChecklistLvl3;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceFormCheckLvl3 extends Model
{
    use HasFactory;

    protected $table = 'maintenance.form_checklist_lvl3';

    protected $fillable = [
        'vehicle_id',
        'checklistlvl3_id',
        'formchecklistlvl2_id',
        'note',
        'doc_id',
        'is_pass',
        'verify_by',
        'created_by'
    ];

    public function hasComponentLvl3(){
        return $this->belongsTo(RefComponentChecklistLvl3::class, 'checklistlvl3_id');
    }

    public function hasDoc(){
        return $this->belongsTo(MaintenanceEvaluationFormCheckDoc::class, 'doc_id');
    }

}
