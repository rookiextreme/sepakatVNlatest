<?php

namespace App\Models\Assessment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentBpkNo extends Model
{
    use HasFactory;

    protected $table = 'assessment.assessment_bpk_no';

    protected $fillable = [
        'id',
        'code',
        'desc',
        'created_by',
        'updated_by',
    ];
}
