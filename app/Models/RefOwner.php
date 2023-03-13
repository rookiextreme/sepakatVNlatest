<?php

namespace App\Models;

use App\Models\Fleet\FleetDepartment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RefOwner extends Model
{
    use HasFactory;

    protected $table = 'ref_owner';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'code',
        'name',
        'owner_type_id',
        'email1',
        'email2',
        'rps_branch_sort'
    ];

    public function byUser(){

        return $this->belongsTo(User::class);

    }

    public function hasOwnerType(){

        return $this->belongsTo(RefOwnerType::class, 'owner_type_id');

    }

    public function hasManySummon($which_is){
        $total = 0;
        $query = DB::table('fleet.fleet_department AS a')
                ->join('saman.maklumat_kenderaan_saman AS b', 'b.pendaftaran_id', 'a.id')
                ->join('saman.maklumat_saman AS c', 'c.maklumat_kenderaan_saman_id', 'b.id')
                ->join('public.ref_summon_agency AS d', 'd.id', 'c.summon_agency_id')
                ->join('saman.status_saman AS e', 'e.id', 'b.status_saman_id');

        switch ($which_is) {
            case 'pdrm':

                $query->where([
                    'cawangan_id' => $this->id,
                    'd.code' => '01'
                ])->whereIn('e.code', ['02','03','04','05']);

                $total = $query->count();
                break;

            case 'jpj':

                $query->where([
                    'cawangan_id' => $this->id,
                    'd.code' => '02'
                ])->whereIn('e.code', ['02','03','04','05']);

                $total = $query->count();
                break;

            case 'pbt':
                $query->where([
                    'cawangan_id' => $this->id,
                    'd.code' => '03'
                ])->whereIn('e.code', ['02','03','04','05']);

                $total = $query->count();
                break;

            case 'done':
                $query->where([
                    'cawangan_id' => $this->id,
                ])->whereIn('e.code', ['03','04']);

                $total = $query->count();
                break;

            case 'notyet':
                $query->where([
                    'cawangan_id' => $this->id
                ])->whereIn('e.code', ['02','05']);

                $total = $query->count();
                break;

            default:
                # code...
                break;
        }

        return $total;
    }
}
