<?php

namespace App\Models\Assessment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentType extends Model
{
    use HasFactory;

    protected $table = 'assessment.assessment_type';

    protected $fillable = [
        'id',
        'code',
        'desc',
        'document_no',
        'produce_no',
        'amendment_no',
        'amendment_dt'
    ];

}
