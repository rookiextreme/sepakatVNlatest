<?php

namespace App\Models\Identifier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdentityType extends Model
{
    use HasFactory;

    protected $table = 'identifiers.identity_types';

    protected $fillable = [
        'identity',
        'type'
    ];

    public function detail()
    {
        return $this->hasMany('App\Models\Users\Detail');
    }
}
