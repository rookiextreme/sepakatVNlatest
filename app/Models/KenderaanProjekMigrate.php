<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KenderaanProjekMigrate extends Model
{
    use HasFactory;

    protected $table = 'migrate.kenderaan_projek';

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
        'tarikhperolehan',
        'nokontrak',
        'namaprojek',
        'hopt',
        'namasyarikat',
        'tarikhmula',
        'tarikhsiap',
        'tarikhcpc'
    ];
}
