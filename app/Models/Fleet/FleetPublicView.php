<?php
namespace App\Models\Fleet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FleetPublicView extends Model
{
    use HasFactory;

    protected $table = 'fleet.fleet_public_view';

    protected $fillable = [];

}
