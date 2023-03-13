<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogisticBookingStatus extends Model
{
    use HasFactory;

    protected $table = 'logistic.logistic_booking_status';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'code',
        'name',
        'status',
        'created_by'
    ];
}
