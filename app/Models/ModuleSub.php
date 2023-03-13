<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class ModuleSub extends Model
{
    use HasFactory;

    protected $table = 'module_sub';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'code',
        'name_bm',
        'name_en',
        'desc_bm',
        'desc_en',
        'level'
    ];

    public function hasModule(){
        return $this->belongsTo(Module::class, 'module_id', 'id');
    }

    public function getAccess($role_id)
    {
        $data = $this;
        if($role_id != 'register'){
            $data = $this->hasOne('App\Models\ModuleSubAccess')->where('role_id', $role_id)->first();
            if(empty($data)){
                $data = $this;
            }
        }
        return $data;
    }

    public function hasAccess(){
        $role_ids = [];

        foreach (auth()->user()->roles as $roles) {
            array_push($role_ids, $roles->id);
        }
        return $this->belongsTo(ModuleSubAccess::class, 'id', 'module_sub_id')->whereIn('role_id', $role_ids);
    }

    public function hasManyAccess(){
        return $this->hasMany(ModuleSubAccess::class, 'module_sub_id');
    }
}
