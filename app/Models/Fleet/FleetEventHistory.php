<?php
namespace App\Models\Fleet;

use App\Models\RefEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class FleetEventHistory extends Model
{
    use HasFactory;

    protected $table = 'fleet.fleet_event_history';

    protected $fillable = [
        'vehicle_id',
        'event_id',
        'event_dt'
    ];

    public function hasEvent()
    {
        Log::info($this->event_id);
        $query = RefEvent::find($this->event_id);
        Log::info($query->toSql());
        return $query;
    }
}
