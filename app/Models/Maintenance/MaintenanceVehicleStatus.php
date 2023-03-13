<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceVehicleStatus extends Model
{
    use HasFactory;
    protected $table = 'maintenance.vehicle_status';

    protected $fillable = [
        'id',
        'code',
        'desc',
        'created_at',
    ];
}
