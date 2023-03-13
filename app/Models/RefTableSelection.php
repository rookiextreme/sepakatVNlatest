<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefTableSelection extends Model
{
    use HasFactory;

    protected $table = 'ref_table_selection';

    protected $fillable = [
        'code',
        'desc'
    ];
}
