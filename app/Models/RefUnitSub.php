<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefUnitSub extends Model
{
    use HasFactory;

    protected $table = 'ref_unit_sub';

    protected $fillable = [
        'id',
        'code',
        'desc',
        'status',
        'sector_id',
        'branch_id',
        'division_id',
        'unit_id'
    ];
}
