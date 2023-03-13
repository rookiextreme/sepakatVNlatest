<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefComponentLvl2 extends Model
{
    protected $table = 'ref_component_lvl2';

    protected $fillable = [
        'id',
        'code',
        'id_component_lvl1',
        'component',
        'status'
    ];
    use HasFactory;

    public function hasCompLvl1(){
        return $this->belongsTo(RefComponentLvl1::class, 'id_component_lvl1');
    }

    public function hasManyLvl3(){
        return $this->hasMany(RefComponentLvl3::class, 'id_component_lvl2');
    }
}
