<?php
namespace App\Models\Fleet;

use App\Models\RefOwnerType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FleetDepartmentView extends Model
{
    use HasFactory;

    protected $table = 'fleet.fleet_department_view As fd';

    protected $fillable = [];

}
