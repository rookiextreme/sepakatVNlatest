<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceEvaluationLetterCheckList extends Model
{
    use HasFactory;
    protected $table = 'maintenance.evaluation_template_letter_checklist';

    protected $fillable = [
        'template_letter_type_id',
        'evaluation_template_letter_id',
        'job_detail',
        'syntom',
        'accessories',
        'budget',
        'created_by',
        'updated_by'
    ];

    public function hasTemplateLetterDetail(){
        return $this->belongsTo(MaintenanceEvaluationLetter::class, 'evaluation_template_letter_id');
    }

    public function hasVehicle(){
        return $this->belongsTo(MaintenanceEvaluationVehicle::class, 'vehicle_id');
    }

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }
}
