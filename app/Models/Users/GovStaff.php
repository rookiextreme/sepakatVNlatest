<?php

namespace App\Models\Users;

use App\Models\RefDivision;
use App\Models\RefSector;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GovStaff extends Model
{
    use HasFactory;

    protected $table = 'users.gov_staff';

    protected $fillable = [
        'detail_id',
        'designation',
        'sector_id',
        'branch_id',
        'unit'
    ];

    public function detail()
    {
        return $this->belongsTo('App\Models\Users\Detail');
    }

    public function hasDepartment()
    {
        return RefDivision::where('id', $this->branch_id)->first();
    }

    public function hasMinistry()
    {
        return RefSector::where('id', $this->sector_id)->first();
    }
}
