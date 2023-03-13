<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceApplicationStatus extends Model
{
    use HasFactory;

    protected $table = 'maintenance.application_status';

    protected $fillable = [
        'id',
        'code',
        'desc',
        'created_by',
    ];
}
