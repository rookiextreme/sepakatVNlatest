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

class AssessmentAccident extends Model
{
    use HasFactory;

    protected $table = 'assessment.assessment_accident';

    protected $fillable = [
        'ref_number',
        'representing',
        'applicant_name',
        'phone_no',
        'agency_id',
        'email',
        'address',
        'department_name',
        'workshop_id',
        'postcode',
        'report_no',
        'state_id',
        'app_status_id',
        'appointment_dt1',
        'assistant_engineer_by',
        'appointment_dt2',
        'appointment_dt3',
        'appointment_dt',
        'is_other_app_dt',
        'driver_name',
        'driver_mykad',
        'driver_phone',
        'report_dt',
        'created_by',
        'updated_by',
        'vehicle_image',
        'odometer',
    ];

    public function hasAgency(){
        return $this->belongsTo(RefAgency::class, 'agency_id');
    }

    public function hasAssistantEngineerBy(){
        return $this->belongsTo(User::class, 'assistant_engineer_by');
    }

    public function hasVehicle(){
        return $this->hasOne(AssessmentAccidentVehicle::class, 'assessment_accident_id');
    }

    public function hasVehicleMany(){
        return $this->hasMany(AssessmentAccidentVehicle::class, 'assessment_accident_id')->whereHas('hasAssessmentVehicleStatus', function($q){
            $q->whereNotIn('code', ['00']);
        });
    }

    public function hasUnVerifyVehicle(){
        return $this->hasVehicle()->whereHas('hasAssessmentVehicleStatus', function($q){
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

    public function hasVehicleImage(){
        return $this->belongsTo(AssessmentFormCheckDoc::class, 'vehicle_image');
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
