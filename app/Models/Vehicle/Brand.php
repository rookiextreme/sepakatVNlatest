<?php

namespace App\Models\Vehicle;

use App\Models\Fleet\FleetDepartment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $table = 'vehicles.brands';

    protected $fillable = [
        'id',
        'code',
        'name'
    ];

    public function vehicleModel()
    {
        return $this->hasMany('App\Models\Vehicle\VehicleModel');
    }

    // public function FleetDepartment()
    // {
    //     return $this->belongsTo(FleetDepartment::class);
    // }
}
