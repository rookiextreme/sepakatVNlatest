<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceInspectionType extends Model
{
    use HasFactory;

    protected $table = 'maintenance.inspection_type';

    protected $fillable = [
        'id',
        'code',
        'desc'
    ];

}
