<?php

namespace App\Models\Saman;

use App\Models\Location\Daerah;
use App\Models\Location\Negeri;
use App\Models\RefSummonAgency;
use App\Models\RefSummonType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaklumatSaman extends Model
{
    use HasFactory;

    protected $table = 'saman.maklumat_saman';

    protected $fillable = [
        'maklumat_kenderaan_saman_id',
        'change_summon_owner',
        'summon_agency_id',
        'summon_type_id',
        'state_id',
        'district_id',
        'branch_id',
        'summon_notice_no',
        'notice_date',
        'receive_notice_date',
        'mistake_date',
        'mistake_time',
        'mistake_location',
        'driver_id',
        'total_compound',
        'compound_reason',
        'created_by',
        'change_summon_owner',
        'change_summon_owner_note',
        'owner_name',
        'pic_name1',
        'pic_email1',
        'pic_name2',
        'pic_email2'
    ];

    public function maklumatKenderaanSaman()
    {
        return $this->belongsTo('App\Models\Saman\MaklumatKenderaanSaman');
    }

    public function negeri()
    {
        return $this->belongsTo(Negeri::class, 'state_id', 'id');
    }

    public function daerah()
    {
        return $this->belongsTo(Daerah::class, 'district_id', 'id');
    }

    public function cawangan()
    {
        return $this->belongsTo('App\Models\Location\Cawangan');
    }

    public function hasSummonAgency(){
        return $this->belongsTo(RefSummonAgency::class, 'summon_agency_id');
    }

    public function hasSummonType(){
        return $this->belongsTo(RefSummonType::class, 'summon_type_id');
    }

    public function hasDriver(){
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }

}
