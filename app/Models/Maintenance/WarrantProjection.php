<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarrantProjection extends Model
{
    use HasFactory;

    protected $table = 'maintenance.warrant_projection';

    protected $fillable = [
        'id',
        'month',
        'percent',
        'value',
        'month_desc',
    ];
}
