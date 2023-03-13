<?php

namespace App\Models\Assessment;

use App\Models\RefSelection;
use App\Models\RefTableSelection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentFormCheckLvl1Selection extends Model
{
    use HasFactory;
    protected $table = 'assessment.assessment_form_check_lvl1_selection';

    protected $fillable = [
        'assessment_form_check_lvl1_id',
        'selection_id',
        'table_selection_id',
        'selected_id',
        'selected_ids'
    ];

    public function hasSelectionType(){
        return $this->belongsTo(RefSelection::class, 'selection_id');
    }

    public function hasTableSelection(){
        return $this->belongsTo(RefTableSelection::class, 'table_selection_id');
    }
}
