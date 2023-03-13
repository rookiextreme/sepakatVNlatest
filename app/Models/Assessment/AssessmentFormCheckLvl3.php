<?php

namespace App\Models\Assessment;

use App\Models\RefComponentChecklistLvl3;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentFormCheckLvl3 extends Model
{
    use HasFactory;

    protected $table = 'assessment.assessment_form_check_lvl3';

    protected $fillable = [
        'vehicle_id',
        'checklistlvl3_id',
        'formchecklistlvl2_id',
        'note',
        'noted_by',
        'doc_id',
        'is_pass',
        'verify_by',
        'created_by'
    ];

    public function hascheckListLvl2(){
        return $this->belongsTo(AssessmentFormCheckLvl2::class, 'formchecklistlvl2_id');
    }

    public function hasComponentLVl3(){
        return $this->belongsTo(RefComponentChecklistLvl3::class, 'checklistlvl3_id');
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
