<?php
namespace App\Models\Fleet;

use App\Models\FleetPlacement;
use App\Models\Identifier\KenderaanStatus;
use App\Models\Kenderaan\Dokumen;
use App\Models\Location\Placement;
use App\Models\RefBranch;
use App\Models\RefCategory;
use App\Models\RefDivision;
use App\Models\RefOwner;
use App\Models\RefOwnerType;
use App\Models\RefSector;
use App\Models\RefState;
use App\Models\RefSubCategory;
use App\Models\RefSubCategoryType;
use App\Models\RefUnit;
use App\Models\RefVehicleStatus;
use App\Models\Saman\MaklumatKenderaanSaman;
use App\Models\User;
use App\Models\Vehicle\Brand;
use App\Models\Vehicle\VehicleModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FleetDepartment extends Model
{
    use HasFactory;

    protected $table = 'fleet.fleet_department';

    protected $fillable = [
        'user_id',
        'state_id',
        'district_id',
        'cawangan_id',
        'placement_id',
        'category_id',
        'sub_category_id',
        'sub_category_type_id',
        'brand_id',
        'model_id',
        'no_pendaftaran',
        'no_id_pemunya',
        'owner_type_id',
        'no_jkr',
        'pic_name',
        'pic_email',
        'no_chasis',
        'no_engine',
        'tarikh_belian',
        'no_resit',
        'pembeli',
        'comment',
        'status',
        'no_loji',
        'tarikh_cukai_jalan',
        'harga_perolehan',
        'tarikh_pembelian_kenderaan',
        'no_lo',
        'tarikh_pemeriksaan_fizikal',
        'tarikh_pemeriksaan_keselamatan',
        'manufacture_year',
        'tarikh_kemaskini',
        'acqDt',
        'vapp_status_id',
        'updated_by',
        'created_by',
        'vehicle_status_id',
        'person_incharge_id',
        'main_driver_id',
        'disaster_ready',
        'brand', 'model',
    ];

    public function hasOwnerType()
    {
        return $this->belongsTo(RefOwnerType::class, 'owner_type_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function negeri()
    {
        return $this->belongsTo('App\Models\Location\Negeri');
    }

    public function hasFleetPlacement()
    {
        return $this->belongsTo(FleetPlacement::class, 'placement_id');
    }

    public function daerah()
    {
        return $this->belongsTo('App\Models\Location\Daerah');
    }

    public function cawangan()
    {
        return $this->belongsTo(RefOwner::class, 'cawangan_id');
    }

    public function hasPlacement()
    {
        return FleetPlacement::find($this->placement_id);
    }

    public function category()
    {
        return $this->belongsTo(RefCategory::class, 'category_id');
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
        $result = RefSubCategoryType::find($this->sub_category_type_id);
        return $result;
    }

    public function hasManyCatType()
    {
        return $this->hasMany(RefSubCategoryType::class, 'id', 'sub_category_type_id');
    }

    public function hasBrand()
    {
        return Brand::find($this->brand_id);
    }

    public function BrandAll()
    {
        return $this->belongsTo(Brand::class);
    }

    public function RefOwnerType()
    {
        return $this->belongsTo(RefOwnerType::class, 'owner_type_id', 'id');
    }

    public function hasVehicleModel()
    {
        return VehicleModel::find($this->model_id);
    }

    public function hasManyDocument()
    {
        return $this->hasMany('App\Models\Kenderaan\Dokumen');
    }

    // public function hasManyHistory($month)
    // {
    //     $query = FleetEventHistory::where('vehicle_id', $this->id)->whereMonth('event_dt', $month);
    //     $sql = $query->toSql();
    //     $bindings = $query->getBindings();
    //     Log::info($sql);
    //     Log::info($bindings);
    //     return $query->get();
    // }

    public function hasManyHistoryByRangeDay($year, $month, $startDay, $endDay)
    {
        $query = FleetEventHistory::where('vehicle_id', $this->id)->whereBetween('event_dt', array($year.'-'.$month.'-'.$startDay, $year.'-'.$month.'-'.$endDay));
        $sql = $query->toSql();
        $bindings = $query->getBindings();
        Log::info('hasManyHistoryByRangeDay');
        Log::info($sql);
        Log::info($bindings);
        return $query->get();
    }

    public function vAppStatus()
    {
        return $this->belongsTo(KenderaanStatus::class, 'vapp_status_id');
    }

    public function hasVehicleStatus()
    {
        return $this->belongsTo(RefVehicleStatus::class, 'vehicle_status_id');
    }

    public function hasState(){
        return $this->belongsTo(RefState::class, 'state_id');
    }

    public function hasDivision()
    {
        $result = RefDivision::find($this->cawangan_id);
        return $result;
    }

    public function hasDivisionPlacement()
    {
        $result = RefDivision::find($this->placement_id);
        return $result;
    }

    public function hasUnit()
    {
        return RefUnit::find($this->placement_id);
    }

    public function hasPersonIncharge(){
        return $this->belongsTo(User::class, 'person_incharge_id');
    }

    public function hasAge(){
        Log::info(Carbon::parse($this->tarikh_pembelian_kenderaan)->diff(Carbon::now())->format('%y years, %m months and %d days'));
        return '1';
    }

    public function hasVocDoc(){
        return Dokumen::where([
            'fleet_department_id' => $this->id,
            'doc_type' => 'voc_doc'
        ])->first();
    }

    public function hasMainDriver(){
        return $this->belongsTo(User::class, 'main_driver_id');
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

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function totalByFederal($catId){
        return $this->whereHas('hasOwnerType', function($q){
            $q->where([
                'code' => '01',
                'display_for' => 'vehicle_register'
            ]);
        })->whereHas('category', function($q2) use($catId){
            $q2->where('id', $catId);
        })->whereHas('vAppStatus', function($q){
            $q->where('code', '06');
        })->whereHas('hasVehicleStatus', function($q){
            $q->whereIn('code', ['01','02','03']);
        })->count();
    }

    public function totalByState($catId){
        return $this->whereHas('hasOwnerType', function($q){
            $q->where([
                'code' => '02',
                'display_for' => 'vehicle_register'
            ]);
        })->whereHas('category', function($q2) use($catId){
            $q2->where('id', $catId);
        })->whereHas('vAppStatus', function($q){
            $q->where('code', '06');
        })->whereHas('hasVehicleStatus', function($q){
            $q->whereIn('code', ['01','02','03']);
        })->count();
        
    }

    public function hasManySummon(){
        return $this->hasMany(MaklumatKenderaanSaman::class, 'pendaftaran_id');
    }

}
