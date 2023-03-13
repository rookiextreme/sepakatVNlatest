<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceEvaluationLetterType extends Model
{
    use HasFactory;

    protected $table = 'maintenance.evaluation_letter_type';

    protected $fillable = [
        'id',
        'code',
        'desc'
    ];
}
