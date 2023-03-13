<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefComponentLvl3 extends Model
{
    protected $table = 'ref_component_lvl3';

    protected $fillable = [
        'id',
        'code',
        'id_component_lvl1',
        'id_component_lvl2',
        'component',
        'status'
    ];
    use HasFactory;
    public function hasCompLvl2(){
        return $this->belongsTo(RefComponentLvl2::class, 'id_component_lvl2');
    }
}
