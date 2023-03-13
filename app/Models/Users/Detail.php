<?php

namespace App\Models\Users;

use App\Models\FleetPlacement;
use App\Models\RefAgency;
use App\Models\RefOwner;
use App\Models\RefOwnerType;
use App\Models\RefRole;
use App\Models\RefState;
use App\Models\RefWorkshop;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    use HasFactory;

    protected $table = 'users.details';

    protected $fillable = [
        'user_id',
        'identity_type_id',
        'ref_status_id',
        'ref_role_id',
        'identity_no',
        'telpejabat',
        'telbimbit',
        'address',
        'postcode',
        'state_id',
        'register_purpose',
        'comment_status',
        'workshop_id',
        'doc_image_path',
        'doc_signature_path',
        'doc_image',
        'doc_signature',
        'agency_id',
        'branch_id',
        'department_name',
        'updated_by',
        'placement_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function identityType()
    {
        return $this->belongsTo('App\Models\Identifier\IdentityType');
    }

    public function refStatus()
    {
        return $this->belongsTo('App\Models\RefStatus');
    }

    public function userAuditLog()
    {
        return $this->belongsTo('App\Models\Users\userAuditLog', 'user_id', 'user_id');
    }

    public function isLocked()
    {
        return $this->belongsTo('App\Models\Users\userLockAccess', 'ref_status_id', 'ref_status_id')->where('status',true);
    }

    public function jkrStaff()
    {
        return $this->hasOne('App\Models\Users\JkrStaff');
    }

    public function jkrPublicStaff()
    {
        return $this->hasOne('App\Models\Users\JkrPublicStaff');
    }

    public function govAgencyStaff()
    {
        return $this->hasOne('App\Models\Users\GovAgencyStaff');
    }

    public function contractorStaff()
    {
        return $this->hasOne('App\Models\Users\ContractorStaff');
    }

    public function publicStaff()
    {
        return $this->hasOne('App\Models\Users\PublicStaff');
    }

    public function refRole()
    {
        return $this->belongsTo(RefRole::class, 'ref_role_id');
    }
    public function hasWorkshop(){
        return $this->belongsTo(RefWorkshop::class, 'workshop_id');
    }

    public function hasAgency(){
        return $this->belongsTo(RefAgency::class, 'agency_id');
    }

    public function hasState(){
        return $this->belongsTo(RefState::class, 'state_id');
    }

    public function hasOwnerType(){
        return $this->belongsTo(RefOwnerType::class, 'owner_type_id');
    }

    public function updatedBy(){
        return $this->belongsTo(User::class, 'updated_by');
    }
    
    public function hasPlacement(){
        return $this->belongsTo(FleetPlacement::class, 'placement_id');
    }

    public function hasBranch(){
        return $this->belongsTo(RefOwner::class, 'branch_id');
    }
}
