<?php

namespace App\Models\Kenderaan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    use HasFactory;

    protected $table = 'kenderaans.dokumens';

    protected $fillable = [
        'id',
        'pendaftaran_id',
        'fleet_department_id',
        'fleet_public_id',
        'fleet_disposal_id',
        'doc_type',
        'doc_path',
        'doc_path_thumbnail',
        'doc_name',
        'doc_desc',
        'is_primary'
    ];

    public function pendaftaran()
    {
        return $this->belongsTo('App\Models\Kenderaan\Pendaftaran');
    }
}
