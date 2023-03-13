<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OsolDetail extends Model
{
    use HasFactory;

    protected $table = 'maintenance.osol_detail';

    protected $fillable = [
        'id',
        'allocation',
        'addition',
        'deduct',
        'total_allocation',
        'expense',
        'advance',
        'total_expense',
        'balance',
        'percent_expense',
        'percent_advance',
        'percent_financial'
    ];
}
