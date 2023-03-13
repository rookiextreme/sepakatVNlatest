<?php

namespace App\Models\Logistic;

use App\Models\Fleet\FleetDepartment;
use App\Models\Fleet\FleetGrant;
use App\Models\Fleet\FleetLookupVehicle;
use App\Models\FleetPlacement;
use App\Models\LogisticBookingVehicleStatus;
use App\Models\LogisticVehicleStatus;
use App\Models\RefOwner;
use App\Models\RefSubCategory;
use App\Models\RefSubCategoryType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class LogisticBookingVehicle extends Model
{
    use HasFactory;
    protected $table = 'logistic.logistic_booking_vehicle';

    protected $fillable = [

        'booking_id',
        'placement_id',
        'branch_id',
        'sub_category_id',
        'vehicle_type_id',
        'total_passenger',
        'is_need_driver',
        'driver_id',
        'driver_phone_no',
        'vehicle_id',
        'assign_vehicle_by',
        'status_id',
        'updated_by',
        'created_by',

        'spare_driver_name',
        'next_odometer',
        'before_odometer',
        'task_datetime',
        'task_end_datetime',
        'total_price_tng_used',
        'oil_used',
        'fuel_receipt_id',
        'vehicle_passenger_doc_id',
        'fleet_table'

    ];

    function hasBooking(){
        return $this->belongsTo(LogisticBooking::class,  'booking_id');
    }

    function hasLocName(){
        return $this->hasBooking->destination;
    }

    function hasPlacement(){
        return $this->belongsTo(FleetPlacement::class, 'placement_id');
    }

    function hasBranch(){
        return $this->belongsTo(RefOwner::class, 'branch_id');
    }

    function hasSubCategory(){
        return $this->belongsTo(RefSubCategory::class, 'sub_category_id');
    }

    function hasVehicleType(){
        return $this->belongsTo(RefSubCategoryType::class, 'vehicle_type_id');
    }

    function totalUnitByVehicleType(){
        Log::info($this->vehicle_type_id);
        $query = FleetDepartment::where([
            'placement_id' => $this->placement_id,
            'sub_category_type_id' => $this->vehicle_type_id
        ]);
        Log::info($query->toSql());
        return $query->count();
    }

    function hasDriver(){
        return $this->belongsTo(User::class, 'driver_id');
    }

    function hasVehicle(){
        return FleetLookupVehicle::find($this->vehicle_id);
    }

    function hasDetailVehicle(){
        return $this->belongsTo(FleetLookupVehicle::class, 'vehicle_id');
    }

    function hasAssignedVehicle(){

        if($this->fleet_table == 'grant'){
            return $this->belongsTo(FleetGrant::class, 'vehicle_id');
        } else {
            return $this->belongsTo(FleetLookupVehicle::class, 'vehicle_id');
        }
    }

    function hasManyPassenger(){
        return $this->hasMany(LogisticPassenger::class, 'logistic_booking_vehicle_id');
    }

    function assingVehicleBy(){
        return $this->belongsTo(User::class, 'assign_vehicle_by');
    }

    public function hasStatus(){
        return $this->belongsTo(LogisticVehicleStatus::class, 'status_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function hasFuelReceipt(){
        return $this->belongsTo(LogisticDocument::class, 'fuel_receipt_id');
    }

    public function hasPassengerDoc(){
        return $this->belongsTo(LogisticDocument::class, 'vehicle_passenger_doc_id');
    }

}
