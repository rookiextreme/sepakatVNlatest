<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefMonitoringInfo extends Model
{
    use HasFactory;

    protected $table = 'maintenance.ref_monitoring_info';

    protected $fillable = [
        'id',
        'code',
        'desc'
    ];

}
