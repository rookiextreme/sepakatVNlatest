<?php

namespace App\Models\Saman\Pengguna;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenPembayaran extends Model
{
    use HasFactory;

    protected $table = 'saman.dokumen_pembayarans';

    protected $fillable = [
        'maklumat_pembayaran_id',
        'name_dokumen',
        'path_dokumen'
    ];
    
    public function maklumatPembayaran()
    {
        return $this->belongsTo('App\Models\Saman\Pengguna\MaklumatPembayaran');
    }
}
