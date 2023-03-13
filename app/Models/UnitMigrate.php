<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitMigrate extends Model
{
    use HasFactory;

    protected $table = 'migrate.unit';

    protected $fillable = [
        'id',
        'code',
        'unit',
        'sector_id',
        'cawangan_id',
        'bahagian_id'
    ];
}
