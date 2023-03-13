<?php

namespace App\Models\Assessment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentOwnership extends Model
{
    use HasFactory;

    protected $table = 'assessment.assessment_ownership';

    protected $fillable = [
        'code',
        'name',
        'desc_en',
        'desc_bm',
        'created_by',
        'updated_by'
    ];

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(){
        return $this->belongsTo(User::class, 'updated_by');
    }

}
