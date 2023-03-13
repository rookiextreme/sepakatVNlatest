<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceJobVehicleStatus extends Model
{
    use HasFactory;

    protected $table = 'maintenance.job_vehicle_status';

    protected $fillable = [
        'id',
        'code',
        'desc'
    ];

}
