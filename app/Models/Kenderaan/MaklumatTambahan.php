<?php

namespace App\Models\Kenderaan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaklumatTambahan extends Model
{
    use HasFactory;

    protected $table = 'kenderaans.maklumat_tambahans';

    protected $fillable = [
        'pendaftaran_id',
        'no_id_pemunya',
        'no_jkr',
        'no_loji',
        'tarikh_cukai_jalan',
        'harga_perolehan',
        'tarikh_pembelian_kenderaan',
        'no_lo',
        'tarikh_pemeriksaan_fizikal',
        'tarikh_pemeriksaan_keselamatan',
        'tarikh_kemaskini',
        'created_by',
        'updated_by'
    ];

    public function pendaftaran()
    {
        return $this->belongso('App\Models\Kenderaan\Pendaftaran');
    }
}
