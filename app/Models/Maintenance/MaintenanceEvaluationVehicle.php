<?php

namespace App\Models\Maintenance;

use App\Models\Maintenance\MaintenanceOwnership;
use App\Models\RefCategory;
use App\Models\RefEngineFuelType;
use App\Models\RefSubCategory;
use App\Models\RefSubCategoryType;
use App\Models\User;
use App\Models\Vehicle\Brand;
use App\Models\Vehicle\VehicleModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceEvaluationVehicle extends Model
{
    use HasFactory;

    protected $table = 'maintenance.evaluation_vehicle';

    protected $fillable = [
        'maintenance_evaluation_id',
        'category_id',
        'sub_category_id',
        'sub_category_type_id',
        'purchase_dt',
        'company_name',
        'lo_no',
        'current_loc',
        'is_gover',
        'odometer',
        'date_entry',
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
        'assessment_by',
        'assessment_dt',
        'verify_by',
        'verify_dt',
        'evaluation_letter_id',
        'cert_hash_key',
        'is_carry_over_maintenance',
        'foremen_by',
        'created_by',
        'updated_by',
        'is_carry_over_maintenance'
    ];

    public function hasMaintenanceDetail(){
        return $this->belongsTo(MaintenanceEvaluation::class, 'maintenance_evaluation_id');
    }

    public function hasCheckListLvl1(){
        return $this->hasMany(MaintenanceFormCheckLvl1::class, 'vehicle_id');
    }
    public function hasCheckListLvl2(){
        return $this->hasMany(MaintenanceFormCheckLvl2::class, 'vehicle_id');
    }
    public function hasCheckListLvl3(){
        return $this->hasMany(MaintenanceFormCheckLvl3::class, 'vehicle_id');
    }

    public function hasCheckListLvl1WithNote(){
        return $this->hasCheckListLvl1()->whereNotNull('note');
    }

    public function hasCheckListLvl2WithNote(){
        return $this->hasCheckListLvl2()->whereNotNull('note');
    }

    public function hasCheckListLvl3WithNote(){
        return $this->hasCheckListLvl3()->whereNotNull('note');
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
        return $this->belongsTo(MaintenanceOwnership::class, 'assessment_ownership_id');
    }

    public function hasMaintenanceVehicleStatus(){
        return $this->belongsTo(MaintenanceVehicleStatus::class, 'maintenance_vehicle_status_id');
    }

    public function hasFuelType(){
        return $this->belongsTo(RefEngineFuelType::class, 'fuel_type_id');
    }

    public function hasTemplateLetter(){
        return $this->belongsTo(MaintenanceEvaluationLetter::class, 'evaluation_letter_id');
    }

    public function foremenBy(){
        return $this->belongsTo(User::class, 'foremen_by');
    }

    public function assessmentedBy(){
        return $this->belongsTo(User::class, 'assessment_by');
    }

    public function verifiedBy(){
        return $this->belongsTo(User::class, 'verify_by');
    }

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(){
        return $this->belongsTo(User::class, 'updated_by');
    }
}
