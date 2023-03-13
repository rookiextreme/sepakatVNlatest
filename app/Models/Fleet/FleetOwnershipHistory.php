<?php
namespace App\Models\Fleet;

use App\Models\RefOwnerType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class FleetOwnershipHistory extends Model
{
    use HasFactory;

    protected $table = 'fleet.fleet_ownership_history';

    protected $fillable = [
        'owner_type_id',
        'created_by'
    ];

    public function hasOwnerType()
    {
        return $this->belongsTo(RefOwnerType::class, 'owner_type_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}