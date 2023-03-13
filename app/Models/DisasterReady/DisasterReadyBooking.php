<?php

namespace App\Models\DisasterReady;

use App\Models\DisasterReadyBookingStatus;
use App\Models\Fleet\FleetLookupVehicle;
use App\Models\Logistic\LogisticApplicant;
use App\Models\Logistic\LogisticDisasterReadyVehicle;
use App\Models\Logistic\LogisticDocument;
use App\Models\RefAgency;
use App\Models\RefSubCategoryType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DisasterReadyBooking extends Model
{
    use HasFactory;

    protected $table = 'logistic.disasterready_booking';

    protected $fillable = [
        'id',
        'work_ins_letter_id',
        'tel_no',
        'reason',
        'destination',
        // 'start_destination',
        // 'end_destination',
        'start_datetime',
        'end_datetime',
        'booking_by',
        'created_by',
        'vehicle_id',
        'driver_id',
        'vehicle_type_id',
        'total_vehicle',
        'spare_driver_name',
        'total_passenger',
        'before_odometer',
        'after_odometer',
        'task_datetime',
        'task_end_datetime',
        'total_price_tng_used',
        'oil_used',
        'status_id',
        'disaster_center',
        'agency_id',
        'booking_person_name',
        'booking_person_email',
        'assembly_location',
        'assembly_datetime',
        'trip_expense_type',
        'note',
        'fuel_receipt_id',
        'submitted_by',
        'submitted_dt',
        'approved_by'.
        'approved_dt'
    ];

    public function hasWorkInsLetter(){
        return $this->belongsTo(DisasterReadyDocument::class, 'work_ins_letter_id');
    }

    public function hasFuelReceipt(){
        return $this->belongsTo(LogisticDocument::class, 'fuel_receipt_id');
    }

    public function hasManyVehicle(){
        return $this->hasMany(LogisticDisasterReadyVehicle::class, 'booking_id');
    }

    public function hasManyAssignedVehicle() {
        return $this->hasManyVehicle()->whereNotNull('vehicle_id');
    }

    public function hasManyAssignedVehicleWithDriver() {
        return $this->hasManyAssignedVehicle()->where([
            'is_need_driver' => true,
            'driver_id' => Auth::user()->id
        ]);
    }

    public function hasVehicle(){
        return $this->belongsTo(FleetLookupVehicle::class, 'vehicle_id');
    }

    public function hasBookingStatus(){
        return $this->belongsTo(DisasterReadyBookingStatus::class, 'status_id');
    }

    public function hasSubCategoryType(){
        return $this->belongsTo(RefSubCategoryType::class, 'vehicle_type_id');
    }

    public function hasDriver(){
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function bookingBy(){
        return $this->belongsTo(User::class, 'booking_by');
    }

    public function submittedBy(){
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function approvedBy(){
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function hasAgency(){
        return $this->belongsTo(RefAgency::class, 'agency_id');
    }

}
