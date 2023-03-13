<?php

namespace App\Models\Identifier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jawatan extends Model
{
    use HasFactory;

    protected $table = 'identifiers.jawatans';

    protected $fillable = [
        'jawatan'
    ];

    public function jkrStaff()
    {
        return $this->hasMany('App\Models\Users\JkrStaff');
    }
}
