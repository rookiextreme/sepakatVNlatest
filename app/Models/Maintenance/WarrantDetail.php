<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarrantDetail extends Model
{
    use HasFactory;

    protected $table = 'maintenance.warrant_detail';

    protected $fillable = [
        'id',
        'state',
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
        'percent_financial',
        'waran_type_id',
        'osol_type_id',
        'year',
        'month',
        'note_expense',
        'workshop_id',
        'warrant_received_dt'
    ];
}
