<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class ModelHasRole extends Model
{
    use HasFactory;

    protected $table = 'model_has_roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $fillable = [
        'role_id',
        'model_type',
        'model_id'
    ];

    public function hasUser(){
        return $this->belongsTo(User::class, 'model_id');
    }

    public function hasManyUser(){
        return $this->hasMany(User::class, 'id', 'model_id');
    }

    public function hasRole(){
        return $this->hasOne(ModelRoles::class, 'id', 'role_id')->with('hasRefRole');
    }

}
