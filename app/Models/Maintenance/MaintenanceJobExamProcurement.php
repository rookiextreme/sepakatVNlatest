<?php

namespace App\Models\Maintenance;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceJobExamProcurement extends Model
{
    use HasFactory;

    protected $table = 'maintenance.mjob_exam_procurement';

    protected $fillable = [
        'mjob_exam_form_component_id',
        'supplier_company_id',
        'price',
        'created_by',
        'updated_at'
    ];

    public function hasFormComponent(){
        return $this->belongsTo(MaintenanceJobVehicleExaminationFormComponent::class, 'mjob_exam_form_component_id');
    }

    public function hasCompany(){
        return $this->belongsTo(MaintenanceJobSupplierCompany::class, 'supplier_company_id');
    }

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(){
        return $this->belongsTo(User::class, 'updated_by');
    }
}
