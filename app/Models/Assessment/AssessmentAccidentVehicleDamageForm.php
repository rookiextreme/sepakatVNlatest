<?php

namespace App\Models\Assessment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentAccidentVehicleDamageForm extends Model
{
    use HasFactory;

    protected $table = 'assessment.assessment_accident_vehicle_damage_form';

    protected $fillable = [
        'damage',
        'damage_note',
        'is_repair',
        'is_replace',
        'assessment_accident_vehicle_id',
        'price_list',
        'wages_cost',
        'spare_part_price',
        'created_by',
        'updated_by',
        'verify_by',
        'approve_by',
        'doc_id',
    ];

    public function hasDamageImage(){
        return $this->belongsTo(AssessmentFormCheckDoc::class, 'doc_id');
    }

    public function hasAccidentVehicle(){
        return $this->belongsTo(AssessmentAccidentVehicle::class, 'assessment_accident_vehicle_id');
    }
}
