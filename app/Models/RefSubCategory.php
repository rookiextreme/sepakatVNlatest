<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefSubCategory extends Model
{
    use HasFactory;

    protected $table = 'ref_sub_category';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'category_id'
    ];

    public function hasCategory(){
        return $this->belongsTo(RefCategory::class, 'category_id');
    }

    public function byUser(){

        return $this->belongsTo(User::class);

    }
}
