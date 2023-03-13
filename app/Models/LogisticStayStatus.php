<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogisticStayStatus extends Model
{
    use HasFactory;

    protected $table = 'logistic.logistic_stay_status';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'code',
        'desc',
        'status',
        'created_by'
    ];
}
