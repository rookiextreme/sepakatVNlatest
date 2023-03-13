<?php

namespace App\Models\Kenderaan\Kategori;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kenderaans.kategoris';

    protected $fillable = [
        'name'
    ];

    public function subKategori()
    {
        return $this->hasMany('App\Models\Kenderaan\Kategori\SubKategori');
    }

    public function maklumat()
    {
        return $this->hasMany('App\Models\Kenderaan\Maklumat');
    }
}
