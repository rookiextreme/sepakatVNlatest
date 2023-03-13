<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CawanganMigrate extends Model
{
    use HasFactory;

    protected $table = 'migrate.cawangan';

    protected $fillable = [
        'id',
        'code',
        'cawangan',
        'sector_id'
    ];
}
