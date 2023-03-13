<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportMaintenanceEvaluation extends Model
{
    use HasFactory;
    public function __construct(
        public string $component,
        public string $month,
        public string $count,
    ) {
    }
}
