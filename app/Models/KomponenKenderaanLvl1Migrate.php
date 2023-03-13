<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomponenKenderaanLvl1Migrate extends Model
{
    use HasFactory;

    protected $table = 'migrate.komponen_kenderaan_lvl1';

    protected $fillable = [
        'id',
        'komponen',
        'kod_penilaian'
    ];

}
