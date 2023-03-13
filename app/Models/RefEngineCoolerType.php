<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefEngineCoolerType extends Model
{
    use HasFactory;

    protected $table = 'ref_engine_cooler_type';

    protected $fillable = [
        'id',
        'code',
        'desc'
    ];

}
