<?php

namespace App\Models\Location;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cawangan extends Model
{
    use HasFactory;

    protected $table = 'locations.cawangans';

    protected $fillable = [
        'state_id',
        'daerah_id',
        'cawangan',
    ];

    public function negeri()
    {
        return $this->belongsTo('App\Models\Location\Negeri');
    }

    public function daerah()
    {
        return $this->belongsTo('App\Models\Location\Daerah');
    }

    public function jkrStaff()
    {
        return $this->hasMany('App\Models\Users\JkrStaff');
    }

    public function pendaftaran()
    {
        return $this->hasMany('App\Models\Kenderaan\Pendaftaran');
    }

    public function maklumatSaman()
    {
        return $this->hasMany('App\Models\Saman\MaklumatSaman');
    }
}
