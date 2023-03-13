<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaranType extends Model
{
    use HasFactory;

    protected $table = 'maintenance.waran_type';

    protected $fillable = [
        'id',
        'code',
        'desc'
    ];

}
