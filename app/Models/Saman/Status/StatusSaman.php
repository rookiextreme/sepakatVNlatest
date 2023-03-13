<?php

namespace App\Models\Saman\Status;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusSaman extends Model
{
    use HasFactory;

    protected $table = 'saman.status_saman';

    protected $fillable = [
        'code',
        'status_semakan'
    ];

    public function maklumatKenderaanSaman()
    {
        return $this->hasMany('App\Models\Saman\MaklumatKenderaanStatus');
    }
}
