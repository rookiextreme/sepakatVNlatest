<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskFlowSub extends Model
{
    use HasFactory;

    protected $table = 'taskflow_sub';

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
        'taskflow_id',
        'is_multi'
    ];

    public function getAccess($role_id)
    {
        $data = $this;
        if($role_id != 'register'){
            $data = $this->hasOne('App\Models\TaskFlowSubAccess', 'taskflow_sub_id', 'id')->where('role_id', $role_id)->first();
            if(empty($data)){
                $data = $this;
            }
        }
        return $data;
    }
}
