<?php

namespace App\Models\Kenderaan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarKenderaanMigrate extends Model
{
    use HasFactory;

    protected $table = 'migrate.daftar_migrate_03122021';

    protected $fillable = [
        'no_pendaftaran',
        'hakmilik',
        'negeri',
        'pemilik',
        'lokasi_penempatan',
        'id_pemunya',
        'kategori',
        'sub_kategori',
        'jenis',
        'pembuat',
        'model',
        'no_jkr',
        'no_loji',
        'no_enjin',
        'no_chasis',
        'status',
        'harga_perolehan',
        'jenis_perolehan',
        'tarikh_perolehan'
    ];

    protected $dates = [
        'tarikh_perolehan'
    ];
}
