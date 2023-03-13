<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefUnit extends Model
{
    use HasFactory;

    protected $table = 'ref_unit';

    protected $fillable = [
        'id',
        'code',
        'desc',
        'status',
        'sector_id',
        'branch_id',
        'division_id'
    ];
}
