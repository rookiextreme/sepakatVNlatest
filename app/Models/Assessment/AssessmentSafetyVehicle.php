<?php

namespace App\Models\Assessment;

use App\Models\RefCategory;
use App\Models\RefSubCategory;
use App\Models\RefSubCategoryType;
use App\Models\RefWorkshop;
use App\Models\User;
use App\Models\Vehicle\Brand;
use App\Models\Vehicle\VehicleModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentSafetyVehicle extends Model
{
    use HasFactory;

    protected $table = 'assessment.assessment_safety_vehicle';

    protected $fillable = [
        'assessment_safety_id',
        'category_id',
        'sub_category_id',
        'sub_category_type_id',
        'purchase_dt',
        'company_name',
        'lo_no',
        'is_gover',
        'plate_no',
        'engine_no',
        'chasis_no',
        'vehicle_brand_id',
        'model_name',
        'manufacture_year',
        'registration_vehicle_dt',
        'app_datetime',
        'assessment_vehicle_status_id',
        'assessment_by',
        'workshop_id',
        'cert_hash_key',
        'foremen_by',
        'created_by',
        'updated_by',
        'assessment_dt',
        'verify_dt',
        'verify_by',
        'approve_by',
        'vtl_doc',
        'evaluation_type',
        'approval',
        'in_assessment',
        'foremen_dt',
        'foremen_by',
        'assessment_dt',
        'assessment_by',
        'verify_dt',
        'verify_by',
        'approve_dt',
        'approve_by',
        'odometer',
        'cert_ref_number',
        'reason_changed',
        'expiry_dt',
    ];

    public function hasAssessmentDetail(){
        return $this->belongsTo(AssessmentSafety::class, 'assessment_safety_id');
    }

    public function hasCheckList(){
        return $this->hasMany(AssessmentFormCheckList::class, 'id');
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

    public function hasVtlDoc(){
        return $this->belongsTo(AssessmentFormCheckDoc::class, 'vtl_doc');
    }

    public function hasVehicleModel(){
        return $this->belongsTo(VehicleModel::class, 'vehicle_model_id');
    }

    public function hasAssessmentOwnership(){
        return $this->belongsTo(AssessmentOwnership::class, 'assessment_ownership_id');
    }

    public function hasAssessmentVehicleStatus(){
        return $this->belongsTo(AssessmentVehicleStatus::class, 'assessment_vehicle_status_id');
    }

    public function hasWorkShop(){
        return $this->belongsTo(RefWorkshop::class, 'workshop_id');
    }

    public function foremenBy(){
        return $this->belongsTo(User::class, 'foremen_by');
    }

    public function verifyBy(){
        return $this->belongsTo(User::class, 'verify_by');
    }

    public function approveBy(){
        return $this->belongsTo(User::class, 'approve_by');
    }

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(){
        return $this->belongsTo(User::class, 'updated_by');
    }

}
