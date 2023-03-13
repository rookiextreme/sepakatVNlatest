<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefDisposal extends Model
{
    use HasFactory;

    protected $table = 'ref_disposal';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'code',
        'desc',
        'status',
        'created_by'
    ];
}
