<?php

namespace App\Models\Assessment;

use App\Models\RefComponentChecklistLvl2;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssessmentFormCheckLvl2 extends Model
{
    use HasFactory;

    protected $table = 'assessment.assessment_form_check_lvl2';

    protected $fillable = [
        'vehicle_id',
        'checklistlvl2_id',
        'formchecklistlvl1_id',
        'note',
        'noted_by',
        'doc_id',
        'is_pass'
    ];

    public function hascheckListLvl1(){
        return $this->belongsTo(AssessmentFormCheckLvl1::class, 'formchecklistlvl1_id');
    }

    public function hasComponentLvl2(){
        return $this->belongsTo(RefComponentChecklistLvl2::class, 'checklistlvl2_id');
    }

    public function hasFormComponentCheckListLvl3(){
        return $this->hasMany(AssessmentFormCheckLvl3::class, 'formchecklistlvl2_id');
    }

    public function hasFormComponentCheckListFailedLvl3(){
        return $this->hasMany(AssessmentFormCheckLvl3::class, 'formchecklistlvl2_id')->where('is_pass', false);
    }

    public function checklistlvl3(){
        return $this->hasFormComponentCheckListLvl3();
    }

    public function hasDoc(){
        return $this->belongsTo(AssessmentFormCheckDoc::class, 'doc_id');
    }

    public function hasDocPath(){
        $code = config('assessment_type_code');
        switch ($code) {
            case '01':
                return $this->belongsTo(AssessmentNewFormCheckDoc::class, 'doc_id');
                break;
            case '02':
                return $this->belongsTo(AssessmentSafetyFormCheckDoc::class, 'doc_id');
                break;
            case '05':
                return $this->belongsTo(AssessmentGovLoanFormCheckDoc::class, 'doc_id');
            case '06':
                return $this->belongsTo(AssessmentDisposalFormCheckDoc::class, 'doc_id');
                break;
            default:
            return $this->belongsTo(AssessmentNewFormCheckDoc::class, 'doc_id');
                break;
        }
    }
}
