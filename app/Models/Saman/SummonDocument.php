<?php

namespace App\Models\Saman;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SummonDocument extends Model
{
    use HasFactory;
    protected $table = 'saman.summon_document';

    protected $fillable = [
        'id',
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
