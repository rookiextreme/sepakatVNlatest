<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MappStatus extends Model
{
    use HasFactory;

    protected $table = 'maintenance.mapp_status';

    protected $fillable = [
        'id',
        'code',
        'desc'
    ];

}
