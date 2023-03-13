<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceType extends Model
{
    use HasFactory;

    protected $table = 'maintenance.type';

    protected $fillable = [
        'id',
        'code',
        'desc'
    ];

}
