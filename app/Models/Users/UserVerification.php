<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVerification extends Model
{
    use HasFactory;
    protected $table = 'users.user_verification';

    protected $fillable = [
        'user_id',
        'token',
        'expired_token',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
