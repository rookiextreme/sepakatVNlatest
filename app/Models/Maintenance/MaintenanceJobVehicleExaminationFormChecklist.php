<?php

namespace App\Models\Maintenance;

use App\Models\RefComponentLvl1;
use App\Models\RefComponentLvl2;
use App\Models\RefComponentLvl3;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceJobVehicleExaminationFormChecklist extends Model
{
    use HasFactory;
    protected $table = 'maintenance.job_ve_form_checklist';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
       'form_id',
       'jve_form_repair_id',
       'component_lvl1_id',
       'component_lvl2_id',
       'component_lvl3_id',
       'lvl',
       'is_pass',
       'noted',
       'noted_by',
       'updated_by',
       'created_by',
       'prepared_dt',
       'prepared_by',
       'verified_dt',
       'verified_by',
       'completed_dt',
       'completed_by'
    ];

    public function hasForm(){
        return $this->belongsTo(MaintenanceJobVehicleExaminationForm::class, 'form_id');
    }

    public function hasFormRepair(){
        return $this->belongsTo(MaintenanceJobVehicleExaminationFormRepair::class, 'jve_form_repair_id');
    }

    public function hasCompLvl1(){
        return $this->belongsTo(RefComponentLvl1::class, 'component_lvl1_id');
    }

    public function hasCompLvl2(){
        return $this->belongsTo(RefComponentLvl2::class, 'component_lvl2_id');
    }

    public function hasCompLvl3(){
        return $this->belongsTo(RefComponentLvl3::class, 'component_lvl3_id');
    }

    public function notedBy(){
        return $this->belongsTo(User::class, 'noted_by');
    }

    public function updatedBy(){
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function preparedBy(){
        return $this->belongsTo(User::class, 'prepared_by');
    }

    public function verifiedBy(){
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function completedBy(){
        return $this->belongsTo(User::class, 'completed_by');
    }
    
}
