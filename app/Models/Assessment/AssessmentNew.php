<?php

namespace App\Models\Assessment;

use App\Models\Fleet\FleetDepartment;
use App\Models\Fleet\FleetLookupVehicle;
use App\Models\RefAgency;
use App\Models\RefState;
use App\Models\RefSubCategoryType;
use App\Models\RefWorkshop;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AssessmentNew extends Model
{
    use HasFactory;
    // public $applicant_name;
    protected $table = 'assessment.assessment_new';

    protected $fillable = [
        'ref_number',
        'applicant_name',
        'phone_no',
        'agency_id',
        'ic_no',
        'bpk_id',
        'email',
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
        'ttl_draf',
        'ttl_appointment',
        'ttl_assess',
        'ttl_evaluate',
        'ttl_approve',
        'ttl_complete',
        'ttl_vehicle',
        'is_other_app_dt',
        'created_by',
        'updated_by',
        'hod_title',
        'no_ptj',
        'no_receipt',
        'receipt_doc',
    ];

    public function hasAssessmentType(){
        return AssessmentType::where('code', '01')->first();
    }

    public function hasAgency(){
        return $this->belongsTo(RefAgency::class, 'agency_id');
    }

    public function hasAssistantEngineerBy(){
        return $this->belongsTo(User::class, 'assistant_engineer_by');
    }

    public function hasVehicle(){
        return $this->hasOne(AssessmentNewVehicle::class, 'assessment_new_id');
    }

    public function hasVehicleMany(){
        return $this->hasMany(AssessmentNewVehicle::class, 'assessment_new_id')->whereHas('hasAssessmentVehicleStatus', function($q){
            $q->whereNotIn('code', ['00']);
        });
    }

    public function hasManyVehicleModelWithTotal(){
        return $this->hasMany(AssessmentNewVehicle::class, 'assessment_new_id')
                    ->select('vehicle_brand_id', 'model_name', DB::raw('count(*) as total'))
                    ->groupBy('vehicle_brand_id', 'model_name');
    }

    public function hasManyVehicleTypeWithTotal(){
        return $this->hasMany(AssessmentNewVehicle::class, 'assessment_new_id')
                    ->select('sub_category_type_id', DB::raw('count(*) as total'))
                    ->groupBy('sub_category_type_id');
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

    public function hasBpkNo(){
        return $this->belongsTo(AssessmentBpkNo::class, 'bpk_id');
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
        return $q;
    }

    public function hasTotalVeh(){
        $q = $this->hasVehicle()->whereHas('hasAssessmentVehicleStatus', function($q){
            $q->whereIn('code', ['00','01', '02', '03', '04', '05', '06']);
        })->get();
        return $q;
    }

    public function hasReceiptDoc(){
        return $this->belongsTo(AssessmentFormCheckDoc::class, 'receipt_doc');
    }

    // public function getApplicantNameAttribute()
    // {
    //     return $this->applicant_name;
    // } //Mutator

}
