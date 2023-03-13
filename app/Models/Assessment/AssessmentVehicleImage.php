<?php

namespace App\Models\Assessment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentVehicleImage extends Model
{
    use HasFactory;
    protected $table = 'assessment.assessment_vehicle_image';

    protected $fillable = [
        'ref_id',
        'category',
        'doc_type',
        'doc_format',
        'doc_path',
        'doc_path_thumbnail',
        'doc_name',
        'created_by',
        'is_primary',
        'assessment_type_id',
        'vehicle_id',
    ];

    public function hasAssessmentType(){
        return $this->belongsTo(AssessmentType::class, 'assessment_type_id');
    }
}
