<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KenderaanLupusMigrate extends Model
{
    use HasFactory;

    protected $table = 'migrate.kenderaan_lupus';

    protected $fillable = [
        'bil',
        'nopendaftaran',
        'hakmilik',
        'negeri',
        'pemilik',
        'lokasipenempatan',
        'noidpemunya',
        'kategori',
        'subkategori',
        'jenis',
        'pembuat',
        'model',
        'nojkr',
        'noloji',
        'noenjin',
        'nochasis',
        'status',
        'kaedahpelupusan',
        'tarikhpelupusan',
        'pembelipenerima',
        'noresitrasmi',
        'hargaperolehan',
        'tarikhperolehan'
    ];
}
