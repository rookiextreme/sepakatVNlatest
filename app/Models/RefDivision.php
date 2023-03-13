<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefDivision extends Model
{
    use HasFactory;

    protected $table = 'ref_division';

    protected $fillable = [
        'id',
        'code',
        'desc',
        'status',
        'sector_id',
        'branch_id'
    ];
}
