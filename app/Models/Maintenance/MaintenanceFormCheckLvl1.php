<?php

namespace App\Models\Maintenance;

use App\Models\RefComponentChecklistLvl1;
use Database\Seeders\RefComponentLvl1Seeder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceFormCheckLvl1 extends Model
{
    use HasFactory;

    protected $table = 'maintenance.form_checklist_lvl1';

    protected $fillable = [
        'maintenance_type_id',
        'vehicle_id',
        'checklistlvl1_id',
        'disposal_percentage_id',
        'note',
        'is_pass',
        'is_repair',
        'is_replacement',
        'note_by'
    ];

    public function hasVehicleDetail(){
        return $this->belongsTo(MaintenanceEvaluationVehicle::class, 'vehicle_id');
    }

    public function hasComponentLvl1(){
        return $this->belongsTo(RefComponentChecklistLvl1::class, 'checklistlvl1_id');
    }

    public function hasManySelection(){
        return $this->hasMany(MaintenanceFormCheckLvl1Selection::class, 'form_checklist_lvl1_id');
    }

    public function hasFormComponentCheckListLvl2(){
        return $this->hasMany(MaintenanceFormCheckLvl2::class, 'formchecklistlvl1_id');
    }
}
