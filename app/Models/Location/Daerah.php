<?php

namespace App\Models\Location;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Daerah extends Model
{
    use HasFactory;

    protected $table = 'locations.daerahs';

    protected $fillable = [
        'state_id',
        'daerah',
        'poskod'
    ];

    public function negeri()
    {
        return $this->belongsTo('App\Models\Location\Cawangan');
    }
    
    public function cawangan()
    {
        return $this->hasMany('App\Models\Location\Cawangan');
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
