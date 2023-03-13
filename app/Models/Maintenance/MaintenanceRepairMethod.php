<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceRepairMethod extends Model
{
    use HasFactory;

    protected $table = 'maintenance.repair_method';

    protected $fillable = [
        'id',
        'code',
        'desc'
    ];

}
