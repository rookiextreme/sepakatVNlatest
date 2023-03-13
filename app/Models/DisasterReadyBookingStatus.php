<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisasterReadyBookingStatus extends Model
{
    use HasFactory;

    protected $table = 'logistic.disasterready_booking_status';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'code',
        'desc',
        'status',
        'created_by'
    ];
}
