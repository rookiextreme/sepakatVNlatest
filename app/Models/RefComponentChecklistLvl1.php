<?php

namespace App\Models;

use App\Models\Assessment\AssessmentType;
use App\Models\Maintenance\MaintenanceType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RefComponentChecklistLvl1 extends Model
{

    use HasFactory;

    protected $table = 'ref_component_checklist_lvl1';

    protected $fillable = [
        'id',
        'code',
        'component',
        'component_shortname',
        'status',
        // 'code_assessment',
        'assessment_type_id',
        'maintenance_type_id'

    ];

    public function hasTotalCompCheck($month){
        $query = DB::select('select count(*) FROM 
        (
            select d.component as component, a.updated_at as comp_updated_at from maintenance.form_checklist_lvl3 a 
            join maintenance.form_checklist_lvl2 b on b.id = a.formchecklistlvl2_id
            join maintenance.form_checklist_lvl1 c on c.id = b.formchecklistlvl1_id
            join ref_component_checklist_lvl1 d on d.id = c.checklistlvl1_id
            where a.is_pass = true AND EXTRACT(MONTH FROM a.updated_at) = '.$month.' AND d.id = '.$this->id.'
            union
            select c.component as component, a.updated_at as comp_updated_at from maintenance.form_checklist_lvl2 a 
            join maintenance.form_checklist_lvl1 b on b.id = a.formchecklistlvl1_id
            join ref_component_checklist_lvl1 c on c.id = b.checklistlvl1_id
            where a.is_pass = true AND EXTRACT(MONTH FROM a.updated_at) = '.$month.' AND c.id = '.$this->id.'
        ) 
        as com_list');
        return $query[0]->count;
    }

    public function hasManySelection(){
        return $this->hasMany(RefComponentChecklistLvl1Selection::class, 'ref_component_checklist_lvl1_id');
    }

    public function hasManyComponentChecklistLvl2(){
        return $this->hasMany(RefComponentChecklistLvl2::class, 'id_component_checklist_lvl1')->where('status', 1);
    }

    public function hasAssessmentType(){

        return $this->belongsTo(AssessmentType::class, 'assessment_type_id');

    }

    public function hasMaintenanceType(){

        return $this->belongsTo(MaintenanceType::class, 'maintenance_type_id');

    }
}
