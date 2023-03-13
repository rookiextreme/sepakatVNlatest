<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $table = 'module';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name_bm',
        'name_en',
        'desc_bm',
        'desc_en'
    ];

    public function getListModuleSub()
    {
        return $this->hasMany(ModuleSub::class, 'module_id');
    }

}
