<?php

namespace App\Models\Maintenance;

use App\Models\Maintenance\MaintenanceExternalRepair;
use App\Models\Maintenance\MaintenanceJobPurposeType;
use App\Models\Maintenance\MaintenanceJobVehicle;
use App\Models\Maintenance\MaintenanceJobVehicleStatus;
use App\Models\Maintenance\MaintenanceRepairMethod;
use App\Models\Maintenance\WaranType;
use App\Models\User;
use Database\Seeders\MaintenanceRepairMethodSeeder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceJobVehicleExaminationFormRepair extends Model
{
    use HasFactory;
    protected $table = 'maintenance.job_vehicle_examination_form_repair';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'vehicle_id',
        'jve_form_id', 
        'repair_method_id',
        'external_repair_id',
        'other_external_note',
        'is_research_market',
        'price_budget',
        'inspected_by',
        'inspected_dt',
        'inspected_done_by',
        'inspected_done_dt',
        'rsm_prepared_by',
        'rsm_prepared_dt',
        'rsm_verified_by',
        'rsm_verified_dt',
        'pro_prepared_by',
        'pro_prepared_dt',
        'pro_verified_by',
        'pro_verified_dt',
        'pro_approved_by',
        'pro_approved_dt',
        'waran_type_id',
        'osol_type_id',
        'tested_by',
        'tested_dt',
        'tested_done_by',
        'tested_done_dt',
        'tested_detail',
        'tester_note',
        'next_service_dt',
        'next_service_odometer',
        'job_vehicle_status_id',
        'internal_repair_status_id',
        'ext_repair_status_id',
        'pro_budget_price_supl_id',
        'pro_budget_price',
        'pro_budget_price_note',
        'advance',
        'expense',
        'lo_no',
        'completed_dt',
        'completed_by',
        'v_completed_dt',
        'inspect_type',
        'company_signature',
        'warrant_detail_id',
        'is_start',
        'other_damages',
        'testing_info'
    ];

    public function hasVehicle(){
        return $this->belongsTo(MaintenanceJobVehicle::class, 'vehicle_id');
    }

    public function hasJVEForm(){
        return $this->belongsTo(MaintenanceJobVehicleExaminationForm::class, 'jve_form_id');
    }

    public function hasRepairMethod(){
        return $this->belongsTo(MaintenanceRepairMethod::class, 'repair_method_id');
    }

    public function hasInspectType(){
        $query = null;
        if($this->inspect_type){
            $query = MaintenanceInspectionType::whereIn('id', explode(',',$this->inspect_type));
        }
        return $query;
    }

    public function hasExternalRepair(){
        return $this->belongsTo(MaintenanceExternalRepair::class, 'external_repair_id');
    }

    public function InspectedBy(){
        return $this->belongsTo(User::class, 'inspected_by');
    }

    public function InspectedDoneBy(){
        return $this->belongsTo(User::class, 'inspected_done_by');
    }

    public function hasQuotation(){
        return $this->hasMany(MaintenanceQuotation::class, 'job_v_exam_id');
    }

    public function hasQuotationInternal(){
        return $this->hasQuotation()->whereHas('hasRepairMethod', function($q){
            $q->where('code', '01');
        });
    }

    public function hasQuotationExternal(){
        return $this->hasQuotation()->whereHas('hasRepairMethod', function($q){
            $q->where('code', '02');
        });
    }

    public function RSMPreparedBy(){
        return $this->belongsTo(User::class, 'rsm_prepared_by');
    }

    public function RSMVerifiedBy(){
        return $this->belongsTo(User::class, 'rsm_verified_by');
    }

    public function PROPreparedBy(){
        return $this->belongsTo(User::class, 'pro_prepared_by');
    }

    public function PROVerifiedBy(){
        return $this->belongsTo(User::class, 'pro_verified_by');
    }

    public function PROApprovedBy(){
        return $this->belongsTo(User::class, 'pro_approved_by');
    }

    public function hasWaranType(){
        return $this->belongsTo(WaranType::class, 'waran_type_id');
    }

    public function hasOsolType(){
        return $this->belongsTo(OsolType::class, 'osol_type_id');
    }

    public function testedBy(){
        return $this->belongsTo(User::class, 'tested_by');
    }

    public function testedDoneBy(){
        return $this->belongsTo(User::class, 'tested_done_by');
    }

    public function hasMaintenanceJobVehicleStatus(){
        return $this->belongsTo(MaintenanceJobVehicleStatus::class, 'job_vehicle_status_id');
    }

    public function hasInternalRepairStatus(){
        return $this->belongsTo(MaintenanceJobVehicleMaintenanceStatus::class, 'internal_repair_status_id');
    }

    public function hasExternalRepairStatus(){
        return $this->belongsTo(MaintenanceJobVehicleMaintenanceStatus::class, 'ext_repair_status_id');
    }

    public function hasManySupplierComp(){
        return $this->hasMany(MaintenanceJobSupplierCompany::class, 'jve_form_repair_id');
    }

    public function hasSelectedSupplierComp(){
        return $this->belongsTo(MaintenanceJobSupplierCompany::class, 'pro_budget_price_supl_id');
    }

    public function hasManyMVInspectComponentList(){
        return $this->hasMany(MaintenanceJobVExamFormInspectComponent::class, 'form_id', 'jve_form_id')->orderBy('id', 'asc');
    }

    public function hasManyMVComponentList(){
        return $this->hasMany(MaintenanceJobVehicleExaminationFormComponent::class, 'jve_form_repair_id')->orderBy('id', 'asc');
    }

    public function hasManyMVFormCheckList(){
        return $this->hasMany(MaintenanceJobVehicleExaminationFormChecklist::class, 'jve_form_repair_id')->orderBy('id', 'asc');
    }

    public function hasManyMonitoringInfo(){
        return $this->hasMany(MonitoringInfo::class, 'jve_form_repair_id');
    }

    public function completedBy(){
        return $this->belongsTo(User::class, 'completed_by');
    }

    public function hasSignatureDoc(){
        return $this->belongsTo(MaintenanceJobDoc::class, 'company_signature');
    }
    
    public function hasWarrantDetail(){
        return $this->belongsTo(WarrantDetail::class, 'warrant_detail_id');
    }

    public function hasProcurementSelectedSupplier(){
        return $this->hasMany(MaintenanceJobExamProcurement::class, 'supplier_company_id', 'pro_budget_price_supl_id')
        ->orderBy('supplier_company_id','asc');
    }

    public function hasProcurementSelectedSupplierList(){
        return $this->hasMany(MaintenanceJobExamProcurement::class, 'supplier_company_id', 'pro_budget_price_supl_id')->orderBy('id', 'asc');
    }

}
