<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OsolType extends Model
{
    use HasFactory;

    protected $table = 'maintenance.osol_type';

    protected $fillable = [
        'id',
        'value',
        'warrant_type_id',
        'code',
        'desc'
    ];

}
