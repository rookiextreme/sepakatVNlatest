<?php

namespace App\Models;

use App\Models\Fleet\FleetDepartment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefSubCategoryType extends Model
{
    use HasFactory;

    protected $table = 'ref_sub_category_type';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'code',
        'name',
        'category_id',
        'sub_category_id'
    ];

    public function hasCategory(){
        return $this->belongsTo(RefCategory::class);
    }

    public function hasSubCategory(){
        return $this->belongsTo(RefSubCategory::class, 'sub_category_id');
    }

    public function byUser(){

        return $this->belongsTo(User::class);

    }

    public function hasTotalByState($code, $owner_type_code){
        return $this->hasMany(FleetDepartment::class, 'sub_category_type_id')
        ->whereHas('hasState', function($q)use($code){
            $q->where('code', $code);
        })
        ->whereHas('hasOwnerType', function($q) use($owner_type_code){
            $q->where([
                'code' => $owner_type_code,
                'display_for' => 'vehicle_register',
            ]);
        })
        ->count();
    }
}
