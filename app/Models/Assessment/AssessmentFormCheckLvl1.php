<?php

namespace App\Models\Assessment;

use App\Models\RefComponentChecklistLvl1;
use App\Models\User;
use Database\Seeders\RefComponentLvl1Seeder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentFormCheckLvl1 extends Model
{
    use HasFactory;

    protected $table = 'assessment.assessment_form_check_lvl1';

    protected $fillable = [
        'assessment_type_id',
        'vehicle_id',
        'checklistlvl1_id',
        'disposal_percentage_id',
        'note',
        'is_repair',
        'is_repairs',
        'is_replacement',

        'receipt_no',
        'receipt_doc',
        'vehicle_doc',
        'vtl_doc',
        'evaluation_type',
        'original_price',
        'current_price',
        'market_price',
        'estimate_repair',
        'estimate_price',
        'durabilty',

        'total_price',
        'noted_by',
        'transmission',
        'odo_read',
        'fuel_type_id',
        'wheel_type',
        'bottom_part_cond',
        'inner_part_cond',
        'outer_part_cond',
        'engine_system_check',
        'trans_system_check',
        'susp_system_check',
        'brek_system_check',
        'wiring_system_check',
        'aircond_system_check',
        'engine_system',
        'trans_system',
        'susp_system',
        'brek_system',
        'wiring_system',
        'aircond_system',
        'tyre_year_fl',
        'tyre_year_rl',
        'tyre_year_fr',
        'tyre_year_rr',
        'total_seat',
        'tyre_front_left_percentage',
        'tyre_front_right_percentage',
        'tyre_back_left_percentage',
        'tyre_back_right_percentage',
        'accessories_detail',

        'assessment_dt',
        'assessment_by',
        'verify_dt',
        'verify_by',
        'approve_dt',
        'approve_by'

    ];

    public function hasAssessmentType(){
        return $this->belongsTo(AssessmentType::class, 'assessment_type_id');
    }

    public function hasComponentLvl1(){
        return $this->belongsTo(RefComponentChecklistLvl1::class, 'checklistlvl1_id');
    }

    public function hasDisposalPercentage(){
        return $this->belongsTo(AssessmentDisposalPercentage::class, 'disposal_percentage_id');
    }

    public function hasManySelection(){
        return $this->hasMany(AssessmentFormCheckLvl1Selection::class, 'assessment_form_check_lvl1_id');
    }

    public function hasFormComponentCheckListFailedLvl2(){
        return $this->hasMany(AssessmentFormCheckLvl2::class, 'formchecklistlvl1_id')->where('is_pass', false);
    }

    public function hasFormComponentCheckListLvl2(){
        return $this->hasMany(AssessmentFormCheckLvl2::class, 'formchecklistlvl1_id')->with('checklistlvl3');
    }

    public function hasVtlDoc(){
        return $this->belongsTo(AssessmentFormCheckDoc::class, 'vtl_doc');
    }

    public function hasReceiptDoc(){
        return $this->belongsTo(AssessmentFormCheckDoc::class, 'receipt_doc');
    }

    public function hasVehicleImgDoc(){
        return $this->belongsTo(AssessmentFormCheckDoc::class, 'vehicle_doc');
    }

    public function checklistlvl2(){
        return $this->hasFormComponentCheckListLvl2();
    }

    public function assessmentBy(){
        return $this->belongsTo(User::class, 'assessment_by');
    }

    public function verifyBy(){
        return $this->belongsTo(User::class, 'verify_by');
    }

    public function approve_by(){
        return $this->belongsTo(User::class, 'approve_by');
    }

    public function hasVehicle(){

        switch ($this->hasAssessmentType->code) {
            case '01':
                return $this->belongsTo(AssessmentNewVehicle::class, 'vehicle_id');
                break;
            case '02':
                return $this->belongsTo(AssessmentSafetyVehicle::class, 'vehicle_id');
                break;
            case '03':
                return $this->belongsTo(AssessmentAccidentVehicle::class, 'vehicle_id');
                break;
            case '04':
                return $this->belongsTo(AssessmentCurrvalueVehicle::class, 'vehicle_id');
                break;
            case '05':
                return $this->belongsTo(AssessmentGovLoanVehicle::class, 'vehicle_id');
                break;
            case '06':
                return $this->belongsTo(AssessmentDisposalVehicle::class, 'vehicle_id');
                break;
            
            default:
                # code...
                break;
        }
    }


}
