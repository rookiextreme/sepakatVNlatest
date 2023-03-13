<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceJobDoc extends Model
{
    use HasFactory;
    protected $table = 'maintenance.job_doc';

    protected $fillable = [
        'ref_id',
        'category',
        'doc_type',
        'doc_format',
        'doc_path',
        'doc_path_thumbnail',
        'doc_name',
        'created_by',
        'is_primary'
    ];

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }
}
