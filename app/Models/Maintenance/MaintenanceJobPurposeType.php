<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceJobPurposeType extends Model
{
    use HasFactory;

    protected $table = 'maintenance.job_purpose_type';

    protected $fillable = [
        'id',
        'code',
        'desc'
    ];

}
