<?php

namespace App\Models\Assessment;

use App\Models\Fleet\FleetDepartment;
use App\Models\Fleet\FleetLookupVehicle;
use App\Models\RefAgency;
use App\Models\RefState;
use App\Models\RefWorkshop;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentSafety extends Model
{
    use HasFactory;

    protected $table = 'assessment.assessment_safety';

    protected $fillable = [
        'ref_number',
        'applicant_name',
        'phone_no',
        'agency_id',
        'email',
        'ic_no',
        'address',
        'department_name',
        'workshop_id',
        'postcode',
        'state_id',
        'app_status_id',
        'appointment_dt1',
        'assistant_engineer_by',
        'appointment_dt2',
        'appointment_dt3',
        'appointment_dt',
        'is_other_app_dt',
        'created_by',
        'updated_by',
        'ttl_draf',
        'ttl_appointment',
        'ttl_assess',
        'ttl_evaluate',
        'ttl_approve',
        'ttl_complete',
        'ttl_vehicle',
        'hod_title',
    ];

    public function hasAssessmentType(){
        return AssessmentType::where('code', '02')->first();
    }

    public function hasAgency(){
        return $this->belongsTo(RefAgency::class, 'agency_id');
    }

    public function hasAssistantEngineerBy(){
        return $this->belongsTo(User::class, 'assistant_engineer_by');
    }

    public function hasVehicle(){
        return $this->hasOne(AssessmentSafetyVehicle::class, 'assessment_safety_id');
    }

    public function hasVehicleMany(){
        return $this->hasMany(AssessmentSafetyVehicle::class, 'assessment_safety_id')->whereHas('hasAssessmentVehicleStatus', function($q){
            $q->whereNotIn('code', ['00']);
        });
    }

    public function hasUnVerifyVehicle(){
        return $this->hasVehicleMany()->whereHas('hasAssessmentVehicleStatus', function($q){
            $q->whereIn('code', ['01', '02', '03', '04','05']);
        });
    }

    public function hasActiveVerifyVehicle(){
        return $this->hasVehicleMany()->whereHas('hasAssessmentVehicleStatus', function($q){
            $q->whereIn('code', ['01', '02','03']);
        });
    }

    public function hasActiveApprovedVehicle(){
        return $this->hasVehicleMany()->whereHas('hasAssessmentVehicleStatus', function($q){
            $q->whereIn('code', ['01', '02', '03', '04']);
        });
    }

    public function hasManyApprovedVehicle(){
        return $this->hasVehicleMany()->whereHas('hasAssessmentVehicleStatus', function($q){
            $q->whereIn('code', ['06']);
        });
    }

    public function hasWorkShop(){
        return $this->belongsTo(RefWorkshop::class, 'workshop_id');
    }

    public function hasState(){
        return $this->belongsTo(RefState::class, 'state_id');
    }

    public function hasStatus(){
        return $this->belongsTo(AssessmentApplicationStatus::class, 'app_status_id');
    }

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(){
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function hasDrafVeh(){
        $q = $this->hasVehicle()->whereHas('hasAssessmentVehicleStatus', function($q){
            $q->where('code', '01');
        })->get();
        return count($q);
    }

    public function hasAppointmentVeh(){
        $q = $this->hasVehicle()->whereHas('hasAssessmentVehicleStatus', function($q){
            $q->where('code', '02');
        })->get();
        return count($q);
    }

    public function hasExaminationVeh(){
        $q = $this->hasVehicle()->whereHas('hasAssessmentVehicleStatus', function($q){
            $q->where('code', '03');
        })->get();
        return count($q);
    }

    public function hasEvaluationVeh(){
        $q = $this->hasVehicle()->whereHas('hasAssessmentVehicleStatus', function($q){
            $q->where('code', '04');
        })->get();
        return count($q);
    }

    public function hasApprovalVeh(){
        $q = $this->hasVehicle()->whereHas('hasAssessmentVehicleStatus', function($q){
            $q->where('code', '05');
        })->get();
        return count($q);
    }

    public function hasCompletedVeh(){
        $q = $this->hasVehicle()->whereHas('hasAssessmentVehicleStatus', function($q){
            $q->where('code', '06');
        })->get();
        return count($q);
    }

    public function hasTotalVeh(){
        $q = $this->hasVehicle()->whereHas('hasAssessmentVehicleStatus', function($q){
            $q->whereIn('code', ['01', '02', '03', '04', '05', '06']);
        })->get();
        return count($q);
    }
    // public function getApplicantNameAttribute()
    // {
    //     return $this->applicant_name;
    // } //Mutator

}
