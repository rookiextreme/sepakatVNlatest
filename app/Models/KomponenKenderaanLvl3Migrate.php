<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomponenKenderaanLvl3Migrate extends Model
{
    use HasFactory;

    protected $table = 'migrate.komponen_kenderaan_lvl3';

    protected $fillable = [
        'id',
        'id_komponen_lvl2',
        'komponen'
    ];
}
