<?php

namespace App\Models\Identifier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;

    protected $table = 'identifiers.jabatans';

    protected $fillable = [
        'id',
        'kementerian_id',
        'jabatan'
    ];

    public function kementerian()
    {
        return $this->belongsTo('App\Models\Identifier\Kementerian');
    }
}
