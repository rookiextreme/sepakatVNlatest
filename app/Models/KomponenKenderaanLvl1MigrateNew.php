<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomponenKenderaanLvl1MigrateNew extends Model
{
    use HasFactory;

    protected $table = 'migrate.komponen_kenderaan_lvl1_new';

    protected $fillable = [
        'id',
        'komponen',

    ];

}
