<?php

namespace App\Models\Logistic;

use App\Models\RefOwner;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogisticApplicant extends Model
{
    use HasFactory;

    protected $table = 'logistic.logistic_applicant';

    protected $fillable = [
        'name',
        'tel_no',
        'email',
        'department_id'
    ];

    public function hasDepartment(){
        return $this->belongsTo(RefOwner::class, 'department_id');
    }
}
