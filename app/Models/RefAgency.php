<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefAgency extends Model
{
    use HasFactory;

    protected $table = 'ref_agency';

    protected $fillable = [
        'id',
        'code',
        'status',
        'desc'
    ];

}
