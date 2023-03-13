<?php

namespace App\Models\Kenderaan;

use App\Models\FleetPlacement;
use App\Models\Location\Placement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'kenderaans.pendaftarans';

    protected $fillable = [
        'user_id',
        'state_id',
        'district_id',
        'cawangan_id',
        'placement_id',
        'hak_milik',
        'daerah_id',
        'no_pendaftaran',
        'no_id_pemunya',
        'no_jkr',
        'maklumat',
        'pic_name',
        'pic_email'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function negeri()
    {
        return $this->belongsTo('App\Models\Location\Negeri');
    }

    public function daerah()
    {
        return $this->belongsTo('App\Models\Location\Daerah');
    }

    public function cawangan()
    {
        return $this->belongsTo('App\Models\Location\Cawangan');
    }

    public function hasPlacement()
    {
        return FleetPlacement::find($this->placement_id);
    }

    public function maklumat()
    {
        return $this->hasOne('App\Models\Kenderaan\Maklumat');
    }

    public function maklumatTambahan()
    {
        return $this->hasOne('App\Models\Kenderaan\MaklumatTambahan');
    }

    public function dokumen()
    {
        return $this->hasMany('App\Models\Kenderaan\Dokumen');
    }

    public function statusSemakan()
    {
        return $this->hasOne('App\Models\Kenderaan\StatusSemakan');
    }

    public function maklumatKenderaanSaman()
    {
        return $this->hasMany('App\Models\Saman\MaklumatKenderaanSaman');
    }

}
