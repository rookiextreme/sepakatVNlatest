<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userAuditLog extends Model
{
    use HasFactory;

    protected $table = 'users.user_audit_log';

    protected $fillable = [
        'user_id',
        'action_by',
        'ref_status_id',
        'comment',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'action_by', 'id');
    }

    public function userLockAccess()
    {
        return $this->belongsTo('App\Models\Users\userLockAccess', 'user_id', 'user_id');
    }
}
