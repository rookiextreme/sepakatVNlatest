<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefLModel extends Model
{
    use HasFactory;

    protected $table = 'l_model';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kod_pembuat',
        'nama_model'
    ];

}
