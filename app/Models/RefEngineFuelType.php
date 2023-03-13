<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefEngineFuelType extends Model
{
    use HasFactory;

    protected $table = 'ref_engine_fuel_type';

    protected $fillable = [
        'id',
        'code',
        'desc'
    ];

}
