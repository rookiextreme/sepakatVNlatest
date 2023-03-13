<?php

namespace App\Models\Logistic;

use App\Models\Logistic\LogisticBooking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogisticBookingTaskScan extends Model
{
    use HasFactory;
    protected $table = 'logistic.logistic_booking_taskscan';

    protected $fillable = [
        'finger_print_id',
        'booking_id',
        'is_scan',
        'created_by'
    ];

    public function hasBooking(){
        return $this->belongsTo(LogisticBooking::class, 'booking_id');
    }

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }

}
