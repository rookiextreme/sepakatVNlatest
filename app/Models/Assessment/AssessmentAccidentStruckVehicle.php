<?php

namespace App\Models\Assessment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentAccidentStruckVehicle extends Model
{
    use HasFactory;

    protected $table = 'assessment.assessment_accident_struck_vehicle';

    protected $fillable = [
        'assessment_accident_vehicle_id',
        'accwit_regno',
        'vehicle_desc',
        'category_id',
        'sub_category_id',
        'sub_category_type_id',
        'plate_no',
        'engine_no',
        'chasis_no',
        'created_by',
        'updated_by',
        'foremen_by',
        'assessment_by',
        'verify_by',
    ];


}
