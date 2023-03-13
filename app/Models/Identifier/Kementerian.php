<?php

namespace App\Models\Identifier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kementerian extends Model
{
    use HasFactory;

    protected $table = 'identifiers.kementerians';

    protected $fillable = [
        'id',
        'name'
    ];

    public function jabatan()
    {
        return $this->hasMany('App\Models\Identifier\Jabatan');
    }
}
