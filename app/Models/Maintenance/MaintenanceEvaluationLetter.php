<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class MaintenanceEvaluationLetter extends Model
{
    use HasFactory;
    protected $table = 'maintenance.evaluation_template_letter';

    protected $fillable = [

        'evaluation_letter_type_id',
        'vehicle_id',
        'ref_number',
        'date',
        'placement_name',
        'signature_quote',
        'officer_designation',
        'officer_name',
        'appointment_dt',
        'total_budget',
        'letter_status_id',
        'created_by',
        'updated_by',
        'address_to',
        'body_detail',
        'officer_phone',
        'vip_address',
        'exam_letter',
        'exam_letter_path'
    ];

    public function hasLetterType(){
        return $this->belongsTo(MaintenanceEvaluationLetterType::class, 'evaluation_letter_type_id');
    }

    public function hasVehicle(){
        return $this->belongsTo(MaintenanceEvaluationVehicle::class, 'vehicle_id');
    }

    public function hasCheckList(){
        return $this->hasMany(MaintenanceEvaluationLetterCheckList::class, 'evaluation_template_letter_id');
    }

    public function hasStatus(){
        return $this->belongsTo(MaintenanceEvaluationLetterStatus::class,  'letter_status_id');
    }

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }
}
