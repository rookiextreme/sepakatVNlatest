<?php

namespace App\Models\Vehicle;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleModel extends Model
{
    use HasFactory;

    protected $table = 'vehicles.vehicle_models';

    protected $fillable = [
        'brand_id',
        'name',
    ];

    public function brand(){
        return $this->belongsTo('App\Models\Vehicle\Brand');
    }
}
