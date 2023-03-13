<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefSettingSub extends Model
{
    use HasFactory;

    protected $table = 'ref_setting_sub';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'id',
        'name',
        'status',
        'type',
        'function_for',
        'setting_id',
        'value'
    ];

    public function getSetting()
    {
       return $this->belongsTo(RefSetting::class);
    }


    public function createdBy()
    {
        return $this->belongsTo(User::class);
    }
}
