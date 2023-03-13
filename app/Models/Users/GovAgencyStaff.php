<?php

namespace App\Models\Users;

use App\Models\RefAgency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GovAgencyStaff extends Model
{
    use HasFactory;

    protected $table = 'users.gov_agency_staff';

    protected $fillable = [
        'detail_id',
        'designation',
        'division_desc',
        'agency_id',
    ];

    public function detail()
    {
        return $this->belongsTo('App\Models\Users\Detail');
    }

    public function hasAgency(){
        return $this->belongsTo(RefAgency::class, 'agency_id');
    }
}
