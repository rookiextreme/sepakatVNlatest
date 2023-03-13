<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefEngineType extends Model
{
    use HasFactory;

    protected $table = 'ref_engine_type';

    protected $fillable = [
        'id',
        'code',
        'desc'
    ];

}
