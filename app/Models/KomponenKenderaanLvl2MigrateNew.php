<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomponenKenderaanLvl2MigrateNew extends Model
{
    use HasFactory;

    protected $table = 'migrate.komponen_kenderaan_lvl2_new';

    protected $fillable = [
        'id',
        'id_komponen_lvl1',
    ];
}
