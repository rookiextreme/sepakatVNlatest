<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceEvaluationLetterStatus extends Model
{
    use HasFactory;
    protected $table = 'maintenance.evaluation_letter_status';

    protected $fillable = [
        'id',
        'code',
        'desc',
        'created_by',
    ];
}
