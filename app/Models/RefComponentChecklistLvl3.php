<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefComponentChecklistLvl3 extends Model
{

    use HasFactory;

    protected $table = 'ref_component_checklist_lvl3';

    protected $fillable = [
        'id',
        'code',
        'id_component_checklist_lvl1',
        'id_component_checklist_lvl2',
        'component',
        'status'
    ];

    public function hashComponentCheckListLvl2()
    {
        return $this->belongsTo(RefComponentChecklistLvl2::class, 'id_component_checklist_lvl2');
    }
}
