<?php

namespace App\Models\Location;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Negeri extends Model
{
    use HasFactory;

    protected $table = 'locations.negeris';

    protected $fillable = [
        'id',
        'negeri'
    ];

    public function cawangan()
    {
        return $this->hasMany('App\Models\Location\Cawangan');
    }

    public function daerah()
    {
        return $this->hasMany('App\Models\Location\Daerah');
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
