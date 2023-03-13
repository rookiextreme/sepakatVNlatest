<?php

namespace App\Models;

use App\Models\Assessment\AssessmentAccident;
use App\Models\Assessment\AssessmentCurrvalue;
use App\Models\Assessment\AssessmentDisposal;
use App\Models\Assessment\AssessmentGovLoan;
use App\Models\Assessment\AssessmentNew;
use App\Models\Assessment\AssessmentSafety;
use App\Models\Fleet\FleetDepartment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefWorkshop extends Model
{
    use HasFactory;

    protected $table = 'ref_workshop';

    protected $fillable = [
        'id',
        'code',
        'desc',
        'code_warrant_ofs',
        'ref_code',
        'state_id',
        'status',
    ];

    public function sector()
    {
        return $this->belongsTo('App\Models\RefWorkshop');
    }

    public function hasNew()
    {
        return $this->hasMany(AssessmentNew::class, 'workshop_id');
    }

    public function hasAccident()
    {
        return $this->hasMany(AssessmentAccident::class, 'workshop_id');
    }

    public function hasDisposal()
    {
        return $this->hasMany(AssessmentDisposal::class, 'workshop_id');
    }

    public function hasCurrvalue()
    {
        return $this->hasMany(AssessmentCurrvalue::class, 'workshop_id');
    }

    public function hasGovLoan()
    {
        return $this->hasMany(AssessmentGovLoan::class, 'workshop_id');
    }

    public function hasSafety()
    {
        return $this->hasMany(AssessmentSafety::class, 'workshop_id');
    }

    public function hasState(){
        return $this->belongsTo(RefState::class, 'state_id');
    }

    public function hasTotalByCategory($code){
        return $this->hasMany(FleetDepartment::class, 'state_id', 'state_id')
        ->whereHas('category', function($q)use($code){
            $q->where('code', $code);
        })->count();
    }

    public function hasTotalByCategoryOwnership($code, $ownership_code){
        return $this->hasMany(FleetDepartment::class, 'state_id', 'state_id')
        ->whereHas('category', function($q)use($code){
            $q->where('code', $code);
        })->whereHas('hasOwnerType', function($q)use($ownership_code){
            $q->where([
                'display_for' => 'vehicle_register',
                'code' => $ownership_code,
            ]);
        })
        ->count();
    }


}
