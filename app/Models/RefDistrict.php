<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefDistrict extends Model
{
    use HasFactory;

    protected $table = 'ref_district';

    protected $fillable = [
        'id',
        'state_id',
        'code',
        'desc',
        'status'
    ];

    public function hasState(){
        return $this->belongsTo(RefState::class,'state_id');
    }
}
