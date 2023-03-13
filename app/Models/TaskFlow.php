<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskFlow extends Model
{
    use HasFactory;

    protected $table = 'taskflow';

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
        'is_verify',
        'is_verify_bm',
        'is_verify_en',
    ];

    public function getListTaskFlowSub()
    {
        return $this->hasMany('App\Models\TaskFlowSub', 'taskflow_id', 'id');
    }
}
