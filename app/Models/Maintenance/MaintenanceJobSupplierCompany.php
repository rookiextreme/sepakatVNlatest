<?php

namespace App\Models\Maintenance;

use App\Models\Maintenance\MaintenanceJobVehicleExaminationForm;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceJobSupplierCompany extends Model
{
    use HasFactory;

    protected $table = 'maintenance.supplier_company';

    protected $fillable = [
        'form_id',
        'jve_form_repair_id',
        'company_name',
        'created_by',
        'updated_by',
    ];

    public function hasForm(){
        return $this->belongsTo(MaintenanceJobVehicleExaminationForm::class, 'form_id');
    }

    public function hasFormRepair(){
        return $this->belongsTo(MaintenanceJobVehicleExaminationFormRepair::class, 'jve_form_repair_id');
    }

    public function hasManyProcurement(){
        return $this->hasMany(MaintenanceJobExamProcurement::class, 'supplier_company_id');
    }

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(){
        return $this->belongsTo(User::class, 'updated_by');
    }
}
