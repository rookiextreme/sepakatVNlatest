<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceDocument extends Model
{
    use HasFactory;
    protected $table = 'maintenance.document';

    protected $fillable = [
        'id',
        'ref_id',
        'category',
        'doc_type',
        'doc_format',
        'doc_path',
        'doc_name',
        'created_by',
        'is_primary'
    ];

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }
}
