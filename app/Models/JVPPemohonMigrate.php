<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JVPPemohonMigrate extends Model
{
    use HasFactory;
    protected $connection = 'pgsql_jvp_public';

    protected $table = 'pemohon';

    protected $fillable = [
        'nokp',
        'nama_pemohon',
        'no_tel_bimbit',
        'email',
        'alamat_agensi'
    ];
}
