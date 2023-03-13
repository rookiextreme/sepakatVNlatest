<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JVPPermohonanMigrate extends Model
{
    use HasFactory;

    protected $table = 'permohonan';

    protected $fillable = [
        'nokp',
        'kod_agensi',
        'kod_penilaian',
        'trkh_masuk',
        'kemaskini_oleh',
        'trkh_kemaskini',
        'kod_waran_pej',
        'akuan',
        'kelayakan_pinjaman',
        'kod_status',
        'agensi_lain',
        'alamat_agensi',
    ];
}
