<?php

namespace App\Models\Maintenance;

use App\Models\RefAgency;
use App\Models\RefState;
use App\Models\RefWorkshop;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceJob extends Model
{
    use HasFactory;

    protected $table = 'maintenance.job';

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
        'assistant_engineer_repair_by',
        'assistant_engineer_service_by',
        'assistant_engineer_by',
        'agency_id',
        'created_by',
        'updated_by'
    ];

    public function hasAgency(){
        return $this->belongsTo(RefAgency::class, 'agency_id');
    }

    public function hasVehicle(){
        return $this->hasMany(MaintenanceJobVehicle::class, 'maintenance_job_id');
    }

    public function hasUnVerifyVehicle(){
        return $this->hasVehicle()->whereHas('hasMaintenanceVehicleStatus', function($q){
            $q->where('code', '01');
        });
    }

    public function hasActiveVerifyVehicle(){
        return $this->hasVehicle()->whereHas('hasMaintenanceVehicleStatus', function($q){
            $q->whereIn('code', ['02','06']);
        });
    }
   
    public function hasVehicleInprogress(){
        return $this->hasVehicle()->whereHas('hasExamform', function($q){
            $q->whereHas('hasFormRepair', function($q2){
                $q2->whereHas('hasMaintenanceJobVehicleStatus', function($q3){
                    $q3->where('code', '!=','12');
                });
            });
        });
    }

    public function hasInProgressVehicle(){
        return $this->hasVehicle()->whereHas('hasMaintenanceVehicleStatus', function($q){
            $q->whereIn('code', ['02','03','06','07']);
        });
    }

    public function hasActiveApprovedVehicle(){
        return $this->hasVehicle()->whereHas('hasMaintenanceVehicleStatus', function($q){
            $q->where('code', '04');
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

    public function hasAssistantEngineerRepairBy(){
        return $this->belongsTo(User::class,'assistant_engineer_repair_by');
    }

    public function hasAssistantEngineerServiceBy(){
        return $this->belongsTo(User::class,'assistant_engineer_service_by');
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
