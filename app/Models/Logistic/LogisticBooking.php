<?php

namespace App\Models\Logistic;

use App\Models\Fleet\FleetLookupVehicle;
use App\Models\LogisticBookingStatus;
use App\Models\LogisticStayStatus;
use App\Models\RefOwner;
use App\Models\RefSubCategoryType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class LogisticBooking extends Model
{
    use HasFactory;

    protected $table = 'logistic.logistic_booking';

    protected $fillable = [
        'id',
        'work_ins_letter_id',
        'tel_no',
        'reason',
        'destination',
        'start_destination',
        'end_destination',
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
        'stay_id',
        'booking_person_name',
        'booking_person_email',
        'department_id',
        'appl_id',
        'note',
        'fuel_receipt_id',
        'submitted_by',
        'submitted_dt',
        'approved_by'.
        'approved_dt'
    ];

    public function hasWorkInsLetter(){
        return $this->belongsTo(LogisticDocument::class, 'work_ins_letter_id');
    }

    public function hasFuelReceipt(){
        return $this->belongsTo(LogisticDocument::class, 'fuel_receipt_id');
    }

    public function hasManyVehicle(){
        return $this->hasMany(LogisticBookingVehicle::class, 'booking_id')->whereHas('hasStatus', function($q){
            $q->whereNotIn('code', ['00']);
        });
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

    public function hasBookingStatus(){
        return $this->belongsTo(LogisticBookingStatus::class, 'status_id');
    }

    public function hasSubCategoryType(){
        return $this->belongsTo(RefSubCategoryType::class, 'vehicle_type_id');
    }

    public function hasStayStatus(){
        return $this->belongsTo(LogisticStayStatus::class, 'stay_id');
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

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function hasApplicant(){
        return $this->belongsTo(LogisticApplicant::class, 'appl_id');
    }

    public function hasDepartment(){
        return $this->belongsTo(RefOwner::class, 'department_id');
    }

}
