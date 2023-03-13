<?php

namespace App\Models\DisasterReady;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisasterReadyBookingTaskScan extends Model
{
    use HasFactory;
    protected $table = 'logistic.disasterready_booking_taskscan';

    protected $fillable = [
        'finger_print_id',
        'booking_id',
        'is_scan',
        'created_by'
    ];

    public function hasBooking(){
        return $this->belongsTo(DisasterReadyBooking::class, 'booking_id');
    }

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }

}
