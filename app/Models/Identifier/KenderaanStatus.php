<?php

namespace App\Models\Identifier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KenderaanStatus extends Model
{
    use HasFactory;

    protected $table = 'identifiers.vapp_status';

    protected $fillable = [
        'id',
        'code',
        'name'
    ];

    public function statusSemakan()
    {
        return $this->hasMany('App\Models\Kenderaan\StatusSemakan');
    }

}
