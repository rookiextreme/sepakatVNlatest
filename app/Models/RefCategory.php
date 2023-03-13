<?php

namespace App\Models;

use App\Models\Fleet\FleetDepartment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class RefCategory extends Model
{
    use HasFactory;

    protected $table = 'ref_category';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'code',
        'name',
        'status'
    ];

    public function byUser(){

        return $this->belongsTo(User::class);

    }

    public function totalByFederal(){
        Log::info("message".$this->id);
        return $this->hasMany(FleetDepartment::class, 'owner_type_id')->where('code', '03')->count();
    }

    public function totalByState(){
        return $this->hasMany(FleetDepartment::class, 'owner_type_id')->where('code', '04')->count();
    }

}
