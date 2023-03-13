<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefRecheckType extends Model
{
    use HasFactory;

    protected $table = 'ref_recheck_type';

    protected $fillable = [
        'id',
        'code',
        'desc'
    ];

}
