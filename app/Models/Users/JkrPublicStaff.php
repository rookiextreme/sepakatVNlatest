<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JkrPublicStaff extends Model
{
    use HasFactory;

    protected $table = 'users.jkr_public_staff';

    protected $fillable = [
        'detail_id'
    ];

    public function detail()
    {
        return $this->belongsTo('App\Models\Users\Detail');
    }
}
