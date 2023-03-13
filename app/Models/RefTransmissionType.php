<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefTransmissionType extends Model
{
    use HasFactory;

    protected $table = 'ref_transmission_type';

    protected $fillable = [
        'id',
        'code',
        'desc'
    ];

}
