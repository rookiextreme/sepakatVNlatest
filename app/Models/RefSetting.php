<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class RefSetting extends Model
{
    use HasFactory;

    protected $table = 'ref_setting';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'code',
        'name'
    ];

    public function hasSettingSub()
    {
        $data = RefSettingSub::where('setting_id', $this->id);
        $data->orderBy('code', 'asc');
        Log::info($data->toSql());
        return $data->get();
    }

    public function hasSub()
    {
        return $this->hasMany(RefSettingSub::class, 'setting_id');
    }

    public function hasActiveSettingSub()
    {
        $data = RefSettingSub::where([
            'setting_id' => $this->id,
            'status' => 1
        ])->first();
        return $data;
    }
        public function createdBy()
    {
        return $this->belongsTo(User::class);
    }

}
