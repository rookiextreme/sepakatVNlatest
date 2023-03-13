<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FleetPlacement extends Model
{
    use HasFactory;

    protected $table = 'fleet.fleet_placement';

    protected $fillable = [
        'id',
        'code',
        'desc',
        'status',
        'ref_state_id'
    ];

    public function branch()
    {
        return $this->hasMany('App\Models\fleet_placement');
    }

    public function hasState()
    {
        return $this->belongsTo(RefState::class, 'ref_state_id');
    }
}
