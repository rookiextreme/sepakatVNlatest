<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingAnnouncement extends Model
{
    use HasFactory;

    protected $table = 'announcement';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title_bm',
        'title_en',
        'desc_bm_1',
        'desc_bm_2',
        'desc_en_1',
        'desc_en_2',
        'start_dt',
        'end_dt',
        'type_announce_id',
        'created_by',
        'status',
        'sorting',
    ];

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }
}
