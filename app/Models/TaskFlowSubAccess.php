<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TaskFlowSubAccess extends Model
{
    use HasFactory;

    protected $table = 'taskflow_sub_access';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $fillable = [
        'name_bm',
        'name_en',
        'desc_bm',
        'desc_en',
        'mod_fleet_verify',
        'mod_fleet_appointment',
        'mod_fleet_approval',
        'mod_fleet_pass',
        'mod_fleet_can_edit_after_approve',
        'mod_fleet_can_dispose_federal',
        'mod_fleet_can_dispose_state',
        'taskflow_sub_id',
        'role_id'
    ];

    public function underTaskflowSub()
    {
        return $this->belongsTo(TaskFlowSub::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class);
    }

    public function hasManyRoles(){
        return $this->hasMany(ModelHasRole::class, 'role_id', 'role_id')->with('hasUser');
    }
}
