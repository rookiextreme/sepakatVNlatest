<?php

namespace App\Models\Saman;

use App\Models\Fleet\FleetLookupVehicle;
use App\Models\Saman\Status\StatusSaman;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaklumatKenderaanSaman extends Model
{
    use HasFactory;

    protected $table = 'saman.maklumat_kenderaan_saman';

    protected $fillable = [
        'pendaftaran_id',
        'user_id',
        'status_saman_id',
        'emel_ketua_jabatan',
        'alamat_pejabat_pemilik',
        'summon_notice_doc_id'
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(FleetLookupVehicle::class);
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function hasStatus(){
        return $this->belongsTo(StatusSaman::class, 'status_saman_id');
    }

    public function statusSaman()
    {
        return $this->belongsTo('App\Models\Saman\Status\StatusSaman');
    }

    public function maklumatSaman()
    {
        return $this->hasOne('App\Models\Saman\MaklumatSaman');
    }

    public function hasManySummon()
    {
        return $this->hasMany(MaklumatSaman::class, 'maklumat_kenderaan_saman_id');
    }

    public function dokumenSaman()
    {
        return $this->hasOne('App\Models\Saman\DokumentSaman');
    }

    public function maklumatPembayaran()
    {
        return $this->hasOne('App\Models\Saman\Pengguna\MaklumatPembayaran');
    }

    public function hasSummonNoticeDoc()
    {
        return $this->belongsTo(SummonDocument::class, 'summon_notice_doc_id');
    }

}
