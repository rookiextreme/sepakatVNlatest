<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogisticVehicleStatus extends Model
{
    use HasFactory;

    protected $table = 'logistic.vehicle_status';

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
