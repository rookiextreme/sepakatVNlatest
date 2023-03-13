<?php

namespace App\Http\Controllers\Report;

use App\Exports\ReportSummonExportView;
use App\Http\Controllers\Controller;
use App\Models\RefCategory;
use App\Models\RefOwner;
use App\Models\RefState;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ReportSummonDAO extends Controller
{

    public function reportSummonSummaryByBranch(){

        $list = RefOwner::whereHas('hasOwnerType', function($q){
            $q->where([
                'code' => '01',
                'display_for' => 'vehicle_register'
            ]);
        })->orderBy('rps_branch_sort', 'asc');

        return [
            'list' => $list->get()
        ];
    }

    public function reportSummonByBranch(){

        $owner_list = RefOwner::whereHas('hasOwnerType', function($q){
            $q->where([
                'code' => '01',
                'display_for' => 'vehicle_register'
            ]);
        })->orderByRaw("code='0125' desc")->orderBy("name","asc");

        $samanList = []; 

        $queryByBranch = DB::select('select d.id AS state_id, d."desc" AS state_name, e."id" AS branch_id, e."name" AS branch_name from saman.maklumat_saman a
        join saman.maklumat_kenderaan_saman b ON b.id = a.maklumat_kenderaan_saman_id
        join fleet.fleet_department c ON c.id = b.pendaftaran_id
        join public.ref_state d ON d.id = c.state_id
        join ref_owner e ON e.id = c.cawangan_id
        where b.status_saman_id IN (3,6)
        GROUP BY d.id, d."desc", e.id');

        $querySummonByState = DB::select('select e.id AS branch_id, c.id, c.no_pendaftaran, a.summon_notice_no, a.mistake_date, a.receive_notice_date, a.notice_date, d.id AS state_id, f.code AS summon_code, f.desc AS summon_agency, g.desc AS summon_type, b.status_saman_id, count(*) AS total from saman.maklumat_saman a
        join saman.maklumat_kenderaan_saman b ON b.id = a.maklumat_kenderaan_saman_id
        join fleet.fleet_department c ON c.id = b.pendaftaran_id
        join public.ref_state d ON d.id = c.state_id
        join ref_owner e ON e.id = c.cawangan_id
        join public.ref_summon_agency f ON f.id = a.summon_agency_id
        join public.ref_summon_type g ON g.id = a.summon_type_id
        where b.status_saman_id IN (3,6)
        GROUP BY e.id, c.id, c.no_pendaftaran, a.summon_notice_no, a.mistake_date, a.receive_notice_date, a.notice_date, d.id, f.code, f.desc, g.desc, b.status_saman_id');

        foreach ($owner_list->get() as $owner) {
            $objOwner = [
                'name' => $owner->name,
                'code' => $owner->code,
                'has_many_state' => [],
                'total_summon' => 0,
                'rowspan' => 0
            ];

            $has_many_state = [];
            $total_summon = 0;
            $rowspan = 0;

            foreach ($queryByBranch as $branch) {
                if($branch->branch_id == $owner->id){

                    $objState = [
                        'id' => $branch->state_id,
                        'name' => $branch->state_name,
                        'has_many_summon' => []
                    ];

                    $has_many_summon = [];

                    foreach ($querySummonByState as $summonByState) {
                        if($summonByState->state_id == $objState['id'] && ($summonByState->branch_id == $owner->id)){
                            $rowspan++;
                            $total_summon++;
                            $objectSummon = $summonByState;
                            array_push($has_many_summon, $objectSummon);
                        }
                        $objState['has_many_summon'] = $has_many_summon;
                    }

                    array_push($has_many_state, $objState);
                }
            }

            $objOwner['has_many_state'] = $has_many_state;
            $objOwner['total_summon'] = $total_summon;
            $objOwner['rowspan'] = $rowspan;

            array_push($samanList, $objOwner);
        }

        Log::info($samanList);

        $object = [
            'samanList' => $samanList
        ];

        return $object;
    }

    public function excel($view){
        $date = Carbon::now()->format('DFY-h:m:s');
        return Excel::download(new ReportSummonExportView($view), $view.'-'.$date.'.xlsx');
    }

}
