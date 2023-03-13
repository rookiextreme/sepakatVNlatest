<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefBranch extends Model
{
    use HasFactory;

    protected $table = 'ref_branch';

    protected $fillable = [
        'id',
        'code',
        'desc',
        'status',
        'sector_id'
    ];

    public function sector()
    {
        return $this->belongsTo('App\Models\RefSector');
    }
}
