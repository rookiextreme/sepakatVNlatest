<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitoringInfo extends Model
{
    use HasFactory;

    protected $table = 'maintenance.monitoring_info';

    protected $fillable = [
        'id',
        'form_id',
        'jve_form_repair_id',
        'ref_info_id',
        'monitoring_dt',
        'note',
        'doc_type',
        'doc_format',
        'doc_path',
        'doc_name',
        'doc_path_thumbnail',
        'created_by',
        'updated_by'
    ];

    public function hasRefInfo(){
        return $this->belongsTo(RefMonitoringInfo::class, 'ref_info_id');
    }

}
