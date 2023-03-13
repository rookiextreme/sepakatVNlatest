<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleSubAccess extends Model
{
    use HasFactory;

    protected $table = 'module_sub_access';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name_bm',
        'name_en',
        'desc_bm',
        'desc_en',
        'mod_fleet_a',
        'mod_fleet_c',
        'mod_fleet_r',
        'mod_fleet_u',
        'mod_fleet_d',
        'mod_fleet_report',
        'fleet_has_limit',
        'module_sub_id',
        'role_id'
    ];

    public function underModuleSub()
    {
        return $this->belongsTo(ModuleSub::class, 'module_sub_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class);
    }

    public function hasRole(){
        return $this->belongsTo(ModelHasRole::class, 'role_id', 'role_id');
    }

    public function hasManyRole(){
        return $this->hasMany(ModelHasRole::class, 'role_id', 'role_id');
    }
}
