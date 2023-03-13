<?php

namespace App\Models;

use App\Models\Fleet\FleetDepartment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefOwnerType extends Model
{
    use HasFactory;

    protected $table = 'ref_owner_type';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'code',
        'desc',
        'status',
        'display_for',
        'created_by'
    ];

    public function FleetDepartment()
    {
        return $this->hasMany(FleetDepartment::class, 'id', 'owner_type_id');
    }
}
