<?php

namespace App\Models\Users;

use App\Models\RefOwner;
use App\Models\RefOwnerType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JkrStaff extends Model
{
    use HasFactory;

    protected $table = 'users.jkr_staff';

    protected $fillable = [
        'detail_id',
        'designation',
        'division_desc',
        'branch_id',
        'owner_type_id'
    ];

    public function detail()
    {
        return $this->belongsTo('App\Models\Users\Detail');
    }

    public function hasOwnerType()
    {
        return $this->belongsTo(RefOwnerType::class, 'owner_type_id');
    }

    public function hasBranch()
    {
        return $this->belongsTo(RefOwner::class, 'branch_id');
    }
}
