<?php

namespace App\Models\Assessment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentDisposalPercentage extends Model
{
    use HasFactory;

    protected $table = 'assessment.assessment_disposal_percentage';

    protected $fillable = [
        'id',
        'code',
        'desc'
    ];

}
