<?php

namespace App\Models\Maintenance;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarrantDetailStatement extends Model
{
    use HasFactory;

    protected $table = 'maintenance.warrant_detail_statement';

    protected $fillable = [
        'id',
        'wd_id',
        'expense',
        'advance',
        'note',
        'created_by',
        'expense_td'
    ];

    public function hasWarrantDetail(){
        return $this->belongsTo(WarrantDetail::class, 'wd_id');
    }

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }

}


