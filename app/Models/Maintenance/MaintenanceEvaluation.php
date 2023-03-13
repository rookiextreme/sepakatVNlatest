<?php

namespace App\Models\Maintenance;

use App\Models\Fleet\FleetLookupVehicle;
use App\Models\Fleet\FleetPublic;
use App\Models\RefAgency;
use App\Models\RefState;
use App\Models\RefWorkshop;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceEvaluation extends Model
{
    use HasFactory;

    protected $table = 'maintenance.evaluation';

    protected $fillable = [
        'ref_number',
        'applicant_name',
        'phone_no',
        'email',
        'address',
        'postcode',
        'state_id',
        'department_name',
        'hod_name',
        'appointment_dt1',
        'appointment_dt2',
        'appointment_dt3',
        'appointment_dt',
        'is_other_app_dt',
        'app_status_id',
        'engineer_workshop_id',
        'applicant_workshop_id',
        'workshop_id',
        'assign_engineer_by',
        'assistant_engineer_by',
        'agency_id',
        'created_by',
        'updated_by'
    ];

    public function hasAgency(){
        return $this->belongsTo(RefAgency::class, 'agency_id');
    }

    public function hasVehicle(){
        return $this->hasMany(MaintenanceEvaluationVehicle::class, 'maintenance_evaluation_id');
    }

    public function hasUnVerifyVehicle(){
        return $this->hasVehicle()->whereHas('hasMaintenanceVehicleStatus', function($q){
            $q->where('code', '01');
        });
    }

    public function hasActiveVerifyVehicle(){
        return $this->hasVehicle()->whereHas('hasMaintenanceVehicleStatus', function($q){
            $q->whereIn('code', ['02','06','07']);
        });
    }

    public function hasActiveApprovedVehicle(){
        return $this->hasVehicle()->whereHas('hasMaintenanceVehicleStatus', function($q){
            $q->where('code', '10');
        });
    }

    public function hasActiveVehicleLetter(){
        return $this->hasVehicle()->whereHas('hasTemplateLetter', function($q){
            $q->whereHas('hasStatus', function($q2){
                $q2->whereIn('code', ['01', '02', '03']);
            });
        });
    }

    public function hasWorkShop(){
        return $this->belongsTo(RefWorkshop::class, 'workshop_id');
    }

    public function hasEngineerWorkShop(){
        return $this->belongsTo(RefWorkshop::class, 'engineer_workshop_id');
    }

    public function hasApplicantWorkShop(){
        return $this->belongsTo(RefWorkshop::class, 'applicant_workshop_id');
    }

    //whois enginerr assign assistant
    public function hasAssignEngineerBy(){
        return $this->belongsTo(User::class,'assign_engineer_by');
    }

    public function hasAssistantEngineerBy(){
        return $this->belongsTo(User::class,'assistant_engineer_by');
    }

    public function hasState(){
        return $this->belongsTo(RefState::class, 'state_id');
    }

    public function hasStatus(){
        return $this->belongsTo(MaintenanceApplicationStatus::class, 'app_status_id');
    }

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(){
        return $this->belongsTo(User::class, 'updated_by');
    }

}
