<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceExternalRepair extends Model
{
    use HasFactory;

    protected $table = 'maintenance.external_repair';

    protected $fillable = [
        'id',
        'code',
        'desc'
    ];

}
