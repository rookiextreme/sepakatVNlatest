<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefComponentChecklistLvl1Selection extends Model
{
    use HasFactory;
    protected $table = 'ref_component_checklist_lvl1_selection';

    protected $fillable = [
        'ref_component_checklist_lvl1_id',
        'selection_id',
        'table_selection_id',
    ];

    public function hasSelectionType(){
        return $this->belongsTo(RefSelection::class, 'selection_id');
    }

    public function hasTableSelection(){
        return $this->belongsTo(RefTableSelection::class, 'table_selection_id');
    }
}
