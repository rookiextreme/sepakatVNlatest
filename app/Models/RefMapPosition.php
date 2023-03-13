<?php

namespace App\Models;

use App\Models\Fleet\FleetDepartment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RefMapPosition extends Model
{
    use HasFactory;

    protected $table = 'ref_map_position';

    protected $fillable = [
        'id',
        'code',
        'map_id',
        'placement_id',
        'map_position_left',
        'map_position_right',
        'map_position_top',
        'desc_bm',
        'desc_en',
        'status'
    ];

    public function hasMap(){
        return $this->belongsTo(RefMap::class, 'map_id');
    }

    public function hasPlacement(){
        return $this->belongsTo(FleetPlacement::class, 'placement_id');
    }

    public function hasTotal(){
        $state_id = $this->hasMap->state_id;
        return FleetDepartment::where('placement_id', $this->placement_id)
        ->whereHas('hasFleetPlacement', function($q)use($state_id){
            $q->where('ref_state_id', $state_id);
        })
        ->count();
    }

}
