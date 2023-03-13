<?php

namespace App\Models\Saman\Pengguna;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaklumatPembayaran extends Model
{
    use HasFactory;

    protected $table = 'saman.maklumat_pembayarans';

    protected $fillable = [
        'maklumat_kenderaan_saman_id',
        'receipt_no',
        'total_payment',
        'payment_date',
        'payment_method'
    ];

    public function maklumatKenderaanSaman()
    {
        return $this->belongsTo('App\Models\Saman\MaklumatKenderaanSaman');
    }

    public function dokumenPembayaran()
    {
        return $this->hasOne('App\Models\Saman\Pengguna\DokumenPembayaran');
    }
}
