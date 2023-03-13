<?php

namespace App\Models\Assessment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentApplicationStatus extends Model
{
    use HasFactory;

    protected $table = 'assessment.assessment_application_status';

    protected $fillable = [
        'id',
        'code',
        'desc',
        'created_by',
    ];

}
