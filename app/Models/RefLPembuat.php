<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefLPembuat extends Model
{
    use HasFactory;

    protected $table = 'l_pembuat';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kod_pembuat',
        'nama_pembuat'
    ];

}
