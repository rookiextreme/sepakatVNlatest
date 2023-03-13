<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JVPMaklumatKenderaanMigrate extends Model
{
    use HasFactory;
    protected $connection = 'pgsql_jvp_public';

    protected $table = 'maklumat_kenderaan';

    protected $fillable = [
        'id_permohonan',
        'kod_utama_aset',
        'kod_kategori_aset',
        'kod_sub_aset',
        'kod_pembuat',
        'tahun_dibuat',
        'no_pendaftaran_kend',
        'no_enjin',
        'no_chasis',
        'no_pesanan_kerajaan',
        'trkh_beli',
        'trkh_daftar',
        'nama_syarikat',
        'tahun_dibuat',
        'id_model'
    ];
}
