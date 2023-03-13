<?php

namespace App\Models;

use App\Models\Assessment\AssessmentFormCheckList;
use App\Models\Assessment\AssessmentFormCheckLvl2;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class RefComponentChecklistLvl2 extends Model
{
    use HasFactory;

    protected $table = 'ref_component_checklist_lvl2';

    protected $fillable = [
        'id',
        'code',
        'id_component_checklist_lvl1',
        'component',
        'status'
    ];

    public function hashComponentCheckListLvl1(){
        return $this->belongsTo(RefComponentChecklistLvl1::class, 'id_component_checklist_lvl1');
    }

    public function hasManyComponentChecklistLvl3(){
        return $this->hasMany(RefComponentChecklistLvl3::class, 'id_component_checklist_lvl2')->where('status', 1);
    }

    public function getComponentFormLVL2($vehicle_id, $component_lvl2_id){
        $query = AssessmentFormCheckLvl2::where([
            'vehicle_id' => $vehicle_id,
            'checklistlvl2_id' => $component_lvl2_id
        ])->first();
        return $query;
    }

    public function getComponentChecklistLvl3($vehicle_id, $component_lvl2_id){
        return AssessmentFormCheckList::where([
            'vehicle_id' => $vehicle_id,
            'checklistlvl2_id' => $component_lvl2_id
        ])->get();
    }

}
