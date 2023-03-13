<?php

namespace App\Models\Kenderaan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusSemakan extends Model
{
    use HasFactory;

    protected $table = 'kenderaans.status_semakans';

    protected $fillable = [
        'pendaftaran_id',
        'vapp_status_id',
        'comment'
    ];

    public function pendaftaran()
    {
        return $this->belongsTo('App\Models\Kenderaan\Pendaftaran');
    }

    public function kenderaanStatus()
    {
        return $this->belongsTo('App\Models\Identifier\KenderaanStatus');
    }
}
