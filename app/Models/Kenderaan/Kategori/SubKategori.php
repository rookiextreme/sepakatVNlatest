<?php

namespace App\Models\Kenderaan\Kategori;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubKategori extends Model
{
    use HasFactory;

    protected $table = 'kenderaans.sub_kategoris';

    protected $fillable = [
        'kategori_id',
        'sub_kategori'
    ];
    

    public function kategori()
    {
        return $this->belongsTo('App\Models\Kenderaan\Kategori\Kategori');
    }
    
    public function maklumat()
    {
        return $this->hasMany('App\Models\Kenderaan\Maklumat', 'subkategori_id', 'id');
    }

}
