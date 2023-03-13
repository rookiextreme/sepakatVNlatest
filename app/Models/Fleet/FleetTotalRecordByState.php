<?php

namespace App\Models\Fleet;

use App\Models\FleetPlacement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class FleetTotalRecordByState extends Model
{
    use HasFactory;
    protected $table = 'fleet.total_record_by_state_view';

    public function total(){
        $state_code = $this->code;
        $query = FleetDepartment::whereHas('hasFleetPlacement.hasState', function($q)use($state_code){
            $q->where('code', $state_code);
        });

        if($state_code == '01'){
            Log::info($query->toSql());
        }
        
        return $query->count();
    }

}
