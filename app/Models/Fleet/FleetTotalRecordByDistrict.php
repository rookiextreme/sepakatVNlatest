<?php

namespace App\Models\Fleet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FleetTotalRecordByDistrict extends Model
{
    use HasFactory;
    protected $table = 'fleet.total_record_by_district_view';
}
