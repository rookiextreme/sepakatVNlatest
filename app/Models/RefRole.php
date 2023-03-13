<?php

namespace App\Models;

use App\Models\Users\Detail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class RefRole extends Model
{
    use HasFactory;

    protected $table = 'ref_role';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'desc_bm',
        'desc_en',
        'task_desc_bm',
        'task_desc_en',
        'ref_role_access_id',
        'workshop_id',
        'can_delete'
    ];

    public function hasManyRoles(){
        return $this->hasMany(ModelHasRole::class, 'role_id')
        ->whereHas('hasUser', function($q){
            $q->whereNotNull('username')->whereHas('detail', function($q2){
                $q2->whereHas('refStatus', function($q3){
                    $q3->where('code', ['06']);
                });
            });
        });
    }

    public function hasTotalRoles(){
        return $this->hasMany(ModelHasRole::class, 'role_id')
        ->whereHas('hasUser', function($q){
            $q->whereNotNull('username')->whereHas('detail', function($q2){
                $q2->whereHas('refStatus', function($q3){
                    $q3->where('code', ['06']);
                });
            });
        })->count();
    }

    public function detail($code)
    {
        $role = Role::where("name", $code)->first();
        Log::info($role);
        return $role;
    }

    public function hasWorkshop(){
        return $this->belongsTo(RefWorkshop::class, 'workshop_id');
    }

    public function roleAccess(){
        return $this->belongsTo(RefRoleAccess::class, 'ref_role_access_id', 'id');
    }

    public function hasManyModuleAccess(){
        return $this->hasMany(ModuleSubAccess::class, 'role_id', 'id');
    }

    public function moduleAccess(){
        return $this->belongsTo(ModuleSubAccess::class, 'role_id', 'id');
    }

    public function totalOnThisPosition($code)
    {
        $this->code = $code;
        return User::whereHas(
            'roles', function($q){
                $q->where('name', $this->code);
            }
        )->whereHas('detail', function($q){
            $q->whereHas('refStatus', function($q2){
                $q2->where('code', '06');
            });
        })->get();
    }
}
