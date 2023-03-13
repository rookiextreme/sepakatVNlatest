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
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssessmentNewVehicle extends Model
{
    use HasFactory;

    protected $table = 'assessment.assessment_new_vehicle';

    protected $fillable = [
        'assessment_new_id',
        'category_id',
        'sub_category_id',
        'sub_category_type_id',
        'purchase_dt',
        'company_name',
        'lo_no',
        'odometer',
        'is_gover',
        'evaluation_type',
        'vtl_doc',
        'veh_img_doc',
        'plate_no',
        'engine_no',
        'chasis_no',
        'price',
        'vehicle_brand_id',
        'model_name',
        'manufacture_year',
        'registration_vehicle_dt',
        'app_datetime',
        'assessment_vehicle_status_id',
        'assessment_by',
        'assessment_dt',
        'workshop_id',
        'cert_hash_key',
        'foremen_by',
        'verify_by',
        'approve_by',
        'created_by',
        'updated_by',
        'receipt_doc',
        'receipt_no',
        'foremen_dt',
        'verify_dt',
        'approve_dt',
        'approval',
        'in_assessment',
        'cert_ref_number',
        'reason_changed',
    ];

    public function hasAssessmentDetail(){
        return $this->belongsTo(AssessmentNew::class, 'assessment_new_id');
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

    public function hasVehicleModel(){
        return $this->belongsTo(VehicleModel::class, 'vehicle_model_id');
    }

    public function hasReceiptDoc(){
        return $this->belongsTo(AssessmentFormCheckDoc::class, 'receipt_doc');
    }

    public function hasVtlDoc(){
        return $this->belongsTo(AssessmentFormCheckDoc::class, 'vtl_doc');
    }

    public function hasVehicleImgDoc(){
        return $this->belongsTo(AssessmentFormCheckDoc::class, 'veh_img_doc');
    }

    public function hasAssessmentOwnership(){
        return $this->belongsTo(AssessmentOwnership::class, 'assessment_ownership_id');
    }

    public function hasAssessmentVehicleStatus(){
        return $this->belongsTo(AssessmentVehicleStatus::class, 'assessment_vehicle_status_id');
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

    public function hasWorkshop(){
        return $this->belongsTo(RefWorkshop::class, 'workshop_id');
    }



}
