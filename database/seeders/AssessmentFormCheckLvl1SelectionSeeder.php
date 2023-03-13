<?php

namespace Database\Seeders;

use App\Models\Assessment\AssessmentFormCheckLvl1Selection;
use App\Models\RefComponentChecklistLvl1;
use App\Models\RefComponentChecklistLvl1Selection;
use App\Models\RefSelection;
use App\Models\RefTableSelection;
use Illuminate\Database\Seeder;

class AssessmentFormCheckLvl1SelectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $RefComponentChecklistLvl1List = RefComponentChecklistLvl1::where('has_selection', true)->get();
        foreach ($RefComponentChecklistLvl1List as $RefComponentChecklistLvl1) {

            switch ($RefComponentChecklistLvl1->code) {
                //Engine
                case '02':
                    $codeTableSelection = ['01','02','03'];
                    $tableSelectionList = RefTableSelection::whereIn('code', $codeTableSelection)->get();

                    foreach ($tableSelectionList as $tableSelection) {
                        $data = [
                            'ref_component_checklist_lvl1_id' => $RefComponentChecklistLvl1->id,
                            'table_selection_id' => $tableSelection->id,
                            'selection_id' => RefSelection::where('code', '01')->first()->id
                        ];
                        RefComponentChecklistLvl1Selection::create($data);
                    }
                    break;
                
                default:
                    # code...
                    break;
            }
            
        }
    }
}
