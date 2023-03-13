<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefState extends Model
{
    use HasFactory;

    protected $table = 'ref_state';

    protected $fillable = [
        'id',
        'code',
        'desc',
        'status'
    ];

    public function branch()
    {
        return $this->hasMany('App\Models\ref_state');
    }
}
