<?php

namespace App\Models\Users;

use App\Models\RefAgency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractorStaff extends Model
{
    use HasFactory;

    protected $table = 'users.contractor_staff';

    protected $fillable = [
        'detail_id',
        'company_name',
        'ssm_no',
        'latest_project_name',
        'ministry_id'
    ];

    public function detail()
    {
        return $this->belongsTo('App\Models\Users\Detail');
    }

    public function hasMinistry(){
        return $this->belongsTo(RefAgency::class, 'ministry_id');
    }
}
