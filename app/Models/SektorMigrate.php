<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SektorMigrate extends Model
{
    use HasFactory;

    protected $table = 'migrate.sektor';

    protected $fillable = [
        'id',
        'code',
        'sektor'
    ];
}
