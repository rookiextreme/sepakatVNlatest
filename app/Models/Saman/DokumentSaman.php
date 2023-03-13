<?php

namespace App\Models\Saman;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumentSaman extends Model
{
    use HasFactory;

    protected $table = 'saman.dokumen_saman';

    protected $fillable = [
        'maklumat_kenderaan_saman_id',
        'name_dokumen',
        'path_dokumen'
    ];

    public function maklumatKenderaanSaman()
    {
        return $this->belongsTo('App\Models\Saman\MaklumatKenderaanSaman');
    }
}
