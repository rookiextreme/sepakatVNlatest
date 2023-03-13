<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefSector extends Model
{
    use HasFactory;

    protected $table = 'ref_sector';

    protected $fillable = [
        'id',
        'code',
        'desc',
        'status'
    ];

    public function branch()
    {
        return $this->hasMany('App\Models\RefBranch');
    }
}
