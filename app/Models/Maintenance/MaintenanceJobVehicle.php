<?php

namespace App\Models\Maintenance;

use App\Models\Maintenance\MaintenanceOwnership;
use App\Models\Maintenance\MaintenanceJobVehicleExaminationForm;
use App\Models\RefCategory;
use App\Models\RefEngineFuelType;
use App\Models\RefSubCategory;
use App\Models\RefSubCategoryType;
use App\Models\RefWorkshop;
use App\Models\User;
use App\Models\Vehicle\Brand;
use App\Models\Vehicle\VehicleModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceJobVehicle extends Model
{
    use HasFactory;

    protected $table = 'maintenance.job_vehicle';

    protected $fillable = [
        'maintenance_job_id',
        'maintenance_job_purpose_type',
        'complaint_damage',
        'last_service_dt',
        'category_id',
        'sub_category_id',
        'sub_category_type_id',
        'purchase_dt',
        'company_name',
        'lo_no',
        'current_loc',
        'is_gover',
        'plate_no',
        'engine_no',
        'chasis_no',
        'vehicle_brand_id',
        'fuel_type_id',
        'model_name',
        'manufacture_year',
        'registration_vehicle_dt',
        'app_datetime',
        'maintenance_vehicle_status_id',
        'maintenance_by',
        'workshop_id',
        'cert_hash_key',
        'foremen_by',
        'created_by',
        'updated_by'
    ];

    public function hasMaintenanceDetail(){
        return $this->belongsTo(MaintenanceJob::class, 'maintenance_job_id');
    }

    public function hasManyPurposeType(){
        $query = null;
        if($this->maintenance_job_purpose_type){
            $query = MaintenanceJobPurposeType::whereIn('id', explode(',',$this->maintenance_job_purpose_type));
        }
        return $query;
    }

    public function hasRepair(){
        return MaintenanceJobPurposeType::whereIn('id', explode(',',$this->maintenance_job_purpose_type))
        ->where('code', '01')
        ->count();
    }

    public function hasService(){
        return MaintenanceJobPurposeType::whereIn('id', explode(',',$this->maintenance_job_purpose_type))
        ->where('code', '02')
        ->count();
    }

    public function hasCheckList(){
        return $this->hasMany(MaintenanceFormCheckList::class, 'id');
    }

    public function hasCategory(){
        return $this->belongsTo(RefCategory::class, 'category_id');
    }

    public function hasSubCategory(){
        return $this->belongsTo(RefSubCategory::class, 'sub_category_id');
    }

    public function hasSubCategoryType(){
        return $this->belongsTo(RefSubCategoryType::class, 'sub_category_type_id');
    }

    public function hasVehicleBrand(){
        return $this->belongsTo(Brand::class, 'vehicle_brand_id');
    }

    public function hasVehicleModel(){
        return $this->belongsTo(VehicleModel::class, 'vehicle_model_id');
    }

    public function hasMaintenanceOwnership(){
        return $this->belongsTo(MaintenanceOwnership::class, 'maintenance_ownership_id');
    }

    public function hasMaintenanceVehicleStatus(){
        return $this->belongsTo(MaintenanceVehicleStatus::class, 'maintenance_vehicle_status_id');
    }

    public function hasExamform(){
        return $this->belongsTo(MaintenanceJobVehicleExaminationForm::class, 'id', 'vehicle_id');
    }

    public function hasFuelType(){
        return $this->belongsTo(RefEngineFuelType::class, 'fuel_type_id');
    }

    public function foremenBy(){
        return $this->belongsTo(User::class, 'foremen_by');
    }

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(){
        return $this->belongsTo(User::class, 'updated_by');
    }
}
