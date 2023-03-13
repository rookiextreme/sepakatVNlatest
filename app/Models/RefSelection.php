<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefSelection extends Model
{
    use HasFactory;
    protected $table = 'ref_selection';

    protected $fillable = [
        'code',
        'desc'
    ];
}
