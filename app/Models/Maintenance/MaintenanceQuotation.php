<?php

namespace App\Models\Maintenance;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceQuotation extends Model
{
    use HasFactory;

    protected $table = 'maintenance.quotation';

    protected $fillable = [
        'job_v_exam_id',
        'repair_method_id',
        'quotation_no',
        'company_name',
        'quotation_dt',
        'sst_dt',
        'total_price',
        'end_dt',
        'waran_type_id',
        'osol_type_id',
        'updated_by',
        'createdt_by'
    ];

    public function hasForm(){
        return $this->belongsTo(MaintenanceJobVehicleExaminationForm::class, 'job_v_exam_id');
    }

    public function hasWarantType(){
        return $this->belongsTo(WaranType::class, 'waran_type_id');
    }

    public function hasOsolType(){
        return $this->belongsTo(OsolType::class, 'osol_type_id');
    }

    public function hasRepairMethod(){
        return $this->belongsTo(MaintenanceRepairMethod::class, 'repair_method_id');
    }

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(){
        return $this->belongsTo(User::class, 'updated_by');
    }

}
