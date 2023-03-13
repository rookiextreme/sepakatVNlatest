<?php
namespace App\Models\Fleet;

use App\Models\FleetDisposal;
use App\Models\FleetPlacement;
use App\Models\Identifier\KenderaanStatus;
use App\Models\Kenderaan\Dokumen;
use App\Models\Location\Cawangan;
use App\Models\Location\Placement;
use App\Models\RefBranch;
use App\Models\RefCategory;
use App\Models\RefOwner;
use App\Models\RefOwnerType;
use App\Models\RefState;
use App\Models\RefSubCategory;
use App\Models\RefSubCategoryType;
use App\Models\Saman\MaklumatKenderaanSaman;
use App\Models\User;
use App\Models\Vehicle\Brand;
use App\Models\Vehicle\VehicleModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FleetLookupVehicle extends Model
{
    use HasFactory;

    protected $table = 'fleet.fleet_lookup_vehicle_view';

    protected $fillable = [];

    public function hasOwnerType()
    {
        return $this->belongsTo(RefOwnerType::class, 'owner_type_id');
    }

    public function cawangan()
    {
        return $this->belongsTo(RefOwner::class, 'cawangan_id');
    }

    public function hasPlacement()
    {
        return FleetPlacement::find($this->placement_id);
    }

    public function hasCategory()
    {
        return RefCategory::find($this->category_id);
    }

    public function hasSubCategory()
    {
        return RefSubCategory::find($this->sub_category_id);
    }

    public function hasSubCategoryType()
    {
        return RefSubCategoryType::find($this->sub_category_type_id);
    }

    public function hasBrand()
    {
        return $this->BelongsTo(Brand::class, 'brand_id');
    }

    public function hasModel()
    {
        return $this->BelongsTo(VehicleModel::class, 'model_id');
    }

    public function hasPersonIncharge(){
        return $this->belongsTo(User::class, 'person_incharge_id');
    }

    public function hashVehicleImagePrimary(){
        Log::info('::hashVehicleImagePrimary');
        $query = Dokumen::where([
            'fleet_department_id' => $this->id,
            'doc_type' =>  'gambarKenderaan',
            'is_primary' => true
        ]);

        Log::info($query->toSql());
        return $query->first();
    }

    public function hasMoreDetail()
    {
        if($this->table_type == 'department'){
            return $this->belongsTo(FleetDepartment::class, 'id');
        } else if($this->table_type == 'public') {
            return $this->belongsTo(FleetPublic::class, 'id');
        } else if($this->table_type == 'disposal') {
            return $this->belongsTo(FleetDisposal::class, 'id');
        } else {
            return $this->belongsTo(FleetDepartment::class, 'id');
        }
        
    }

    public function hasState(){
        return $this->belongsTo(RefState::class, 'state_id');
    }

    public function hasMainDriver(){
        return $this->belongsTo(User::class, 'main_driver_id');
    }

    public function hasManySummon(){
        return $this->hasMany(MaklumatKenderaanSaman::class, 'pendaftaran_id');
    }

    public function vAppStatus()
    {
        return $this->belongsTo(KenderaanStatus::class, 'vapp_status_id');
    }

}
