<?php

namespace App\Models\Assessment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentVehicleStatus extends Model
{
    use HasFactory;
    protected $table = 'assessment.assessment_vehicle_status';

    protected $fillable = [
        'id',
        'code',
        'desc',
        'created_at',
    ];
}
