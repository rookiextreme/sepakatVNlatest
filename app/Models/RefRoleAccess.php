<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefRoleAccess extends Model
{
    use HasFactory;

    protected $table = 'ref_role_access';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 
        'code',
        'desc_bm',
        'desc_en'
    ];

    public function detail()
    {
        return $this->belongsTo(RefRole::class);
    }

}
