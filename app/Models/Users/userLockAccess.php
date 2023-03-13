<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userLockAccess extends Model
{
    use HasFactory;

    protected $table = 'users.user_lock_access';

    protected $fillable = [
        'user_id',
        'ref_status_id',
        'from_dt',
        'end_dt',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
