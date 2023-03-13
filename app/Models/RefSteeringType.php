<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefSteeringType extends Model
{
    use HasFactory;

    protected $table = 'ref_steering_type';

    protected $fillable = [
        'id',
        'code',
        'desc'
    ];

}
