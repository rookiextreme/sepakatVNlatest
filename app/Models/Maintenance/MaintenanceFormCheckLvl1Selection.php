<?php

namespace App\Models\Maintenance;

use App\Models\RefTableSelection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceFormCheckLvl1Selection extends Model
{
    use HasFactory;
    protected $table = 'maintenance.form_checklist_lvl1_selection';

    protected $fillable = [
        'form_checklist_lvl1_id',
        'selection_id',
        'table_selection_id',
        'selected_id'
    ];

    public function hasTableSelection(){
        return $this->belongsTo(RefTableSelection::class, 'table_selection_id');
    }
}
