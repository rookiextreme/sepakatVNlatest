<?php

namespace App\Models\Logistic;

use App\Models\DisasterReady\DisasterReadyBooking;
use App\Models\Fleet\FleetDepartment;
use App\Models\Fleet\FleetLookupVehicle;
use App\Models\FleetPlacement;
use App\Models\LogisticVehicleStatus;
use App\Models\RefSubCategoryType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class LogisticDisasterReadyVehicle extends Model
{
    use HasFactory;

    protected $table = 'logistic.logistic_disasterready_vehicle';

    protected $fillable = [

        'booking_id',
        'placement_id',
        'vehicle_type_id',
        'total_passenger',
        'is_need_driver',
        'driver_id',
        'vehicle_id',
        'driver_phone_no',
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

    ];

    function hasBooking(){
        return $this->belongsTo(DisasterReadyBooking::class,  'booking_id');
    }

    function hasLocName(){
        return $this->hasBooking()->destination;
    }

    function hasPlacement(){
        return $this->belongsTo(FleetPlacement::class, 'placement_id');
    }

    function hasVehicleType(){
        return $this->belongsTo(RefSubCategoryType::class, 'vehicle_type_id');
    }

    function totalUnitByVehicleType(){
        Log::info($this->vehicle_type_id);
        $query = FleetDepartment::where('sub_category_type_id', $this->vehicle_type_id);
        Log::info($query->toSql());
        return $query->count();
    }

    function hasDriver(){
        return $this->belongsTo(User::class, 'driver_id');
    }

    function hasAssignedVehicle(){
        return $this->belongsTo(FleetLookupVehicle::class, 'vehicle_id');
    }

    function hasVehicle(){
        return FleetLookupVehicle::find($this->vehicle_id);
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

}
