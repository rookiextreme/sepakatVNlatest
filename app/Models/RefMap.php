<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RefMap extends Model
{
    use HasFactory;

    protected $table = 'ref_map';

    protected $fillable = [
        'id',
        'code',
        'state_id',
        'desc_bm',
        'desc_en',
        'status'
    ];

    public function hasState(){
        return $this->belongsTo(RefState::class, 'state_id');
    }

}
