<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahagianMigrate extends Model
{
    use HasFactory;

    protected $table = 'migrate.bahagian';

    protected $fillable = [
        'id',
        'code',
        'bahagian',
        'sector_id',
        'cawangan_id'
    ];
}
