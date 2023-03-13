<?php

namespace App\Models\Fleet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Fleet\FleetDepartment;

class FleetAudit extends Model
{
    use HasFactory;
    protected $table = 'audit.fleet_audit';
}
