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

class AssessmentCurrvalueVehicle extends Model
{
    use HasFactory;

    protected $table = 'assessment.assessment_currvalue_vehicle';

    protected $fillable = [
        'assessment_currvalue_id',
        'category_id',
        'sub_category_id',
        'sub_category_type_id',
        'purchase_dt',
        'company_name',
        'lo_no',
        'is_gover',
        'evaluation_currvalue_type',
        'evaluation_type',
        'vtl_doc',
        'plate_no',
        'engine_no',
        'chasis_no',
        'vehicle_brand_id',
        'model_name',
        'manufacture_year',
        'registration_vehicle_dt',
        'app_datetime',
        'assessment_vehicle_status_id',
        'workshop_id',
        'cert_hash_key',
        'vehicle_price',
        'created_by',
        'updated_by',
        'applicant_name',
        'applicant_ic_no',
        'applicant_company',
        'evaluate_by',
        'verify_by',

        'original_price',
        'current_price',
        'market_price',
        'estimate_repair',
        'estimate_price',
        'durabilty',

        'veh_img_doc',
        'receipt_doc',
        'approval',
        'in_assessment',

        'foremen_by',
        'foremen_dt',
        'assessment_dt',
        'assessment_by',
        'verify_dt',
        'approve_dt',
        'approve_by',
        'metal_weight',
        'metal_price',
        'cert_ref_number',
        'reason_changed',
        'odometer',
        'certificate_title',
        'location',
        'is_move',
        'has_no_year_manufactured'
    ];

    public function hasAssessmentDetail(){
        return $this->belongsTo(AssessmentCurrvalue::class, 'assessment_currvalue_id');
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

    public function hasReceiptDoc(){
        return $this->belongsTo(AssessmentFormCheckDoc::class, 'receipt_doc');
    }

    public function hasVehicleImgDoc(){
        return $this->belongsTo(AssessmentFormCheckDoc::class, 'veh_img_doc');
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

    public function hasFormlvl1(){
        return $this->hasOne(AssessmentFormCheckLvl1::class, 'vehicle_id');
    }

}
