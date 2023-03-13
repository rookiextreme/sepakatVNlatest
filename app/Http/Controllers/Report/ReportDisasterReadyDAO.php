<?php

namespace App\Http\Controllers\Report;

use App\Exports\ReportDisasterReadyExportView;
use App\Http\Controllers\Controller;
use App\Models\RefCategory;
use App\Models\RefOwner;
use App\Models\RefState;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ReportDisasterReadyDAO extends Controller
{

    public function reportDisasterReadyByStateVType(){
        $totalByType = DB::select('select b."code" AS v_type_code, b."name" AS v_type_name, count(*) AS total_type from fleet.fleet_department a
        JOIN public.ref_sub_category_type b ON b.id = a.sub_category_type_id
        JOIN fleet.fleet_placement c ON c.id = a.placement_id
        JOIN public.ref_state d ON d.id = c.ref_state_id
        WHERE a.disaster_ready = true and d.code not in (\'10\',\'11\',\'16\')
        GROUP BY b.code, b."name"');

        $totalByState = DB::select('select d.desc, d."code" AS state_code, b."code" AS v_type_code, b."name" AS v_type_name, count(*) AS total from fleet.fleet_department a
        JOIN public.ref_sub_category_type b ON b.id = a.sub_category_type_id
        JOIN fleet.fleet_placement c ON c.id = a.placement_id
        JOIN public.ref_state d ON d.id = c.ref_state_id
        WHERE a.disaster_ready = true and d.code not in (\'10\',\'11\',\'16\')
        GROUP BY d.desc, d."code", b.code, b.name');

        $stateList = RefState::whereNotIn('code', ['10','11','16'])->get();
        $list = array();

        foreach ($stateList as $state) {
            $object = [
                'state_code' => $state->code,
                'state_name' => $state->desc,
                'total' => 0,
                'has_many_total' => []
            ];

            $objectTypes = [];
            $total_by_state = 0;

            foreach ($totalByState as $key) {

                if($key->state_code == $state->code){

                    $objectType['state_code'] = $state->code;
                    $objectType['type_code'] = $key->v_type_code;
                    $objectType['type_name'] = $key->v_type_name;
                    $objectType['total'] = $key->total;

                    Log::info($key->desc);
                    Log::info($key->v_type_name);
                    Log::info($key->total);

                    array_push($objectTypes, $objectType);

                    $total_by_state += $key->total;

                }
            }

            $object['total'] = $total_by_state;

            $object['has_many_total'] = $objectTypes;

            array_push($list, $object);
        }

        return [
            'total_state' => $stateList->count(),
            'totalByType' => $totalByType,
            'list' => $list
        ];
    }

    public function reportDisasterReadyByStateVcategories(){
        $categories = DB::select('select c.code AS cat_code, c."name" AS cat_name, count(*) AS total from fleet.fleet_department a
        join public.ref_owner_type b on b.id = a.owner_type_id
        join "public".ref_category c on c.id = a.category_id
        join "public".ref_state d on d.id = a.state_id
        WHERE a.disaster_ready = true and d.code not in (\'10\',\'11\',\'16\')
        GROUP BY c.code, c."name"');

        $categoriesByOwnerType = DB::select('select c.code AS cat_code, c."name" AS cat_name, b.code AS owner_type_code, b.desc_bm AS owner_type_name, count(*) AS total from fleet.fleet_department a
        join public.ref_owner_type b on b.id = a.owner_type_id
        join "public".ref_category c on c.id = a.category_id
        join "public".ref_state d on d.id = a.state_id
        WHERE a.disaster_ready = true and d.code not in (\'10\',\'11\',\'16\')
        GROUP BY c.code, c."name", b.code, b.desc_bm');

        $dataByStateAndType = DB::select('select b.code AS owner_type_code, b.desc_bm AS owner_type_name, c.code AS cat_code, c."name" AS cat_name, d.code AS state_code, d."desc" AS state_name, count(*) AS total from fleet.fleet_department a
        join public.ref_owner_type b on b.id = a.owner_type_id
        join "public".ref_category c on c.id = a.category_id
        join "public".ref_state d on d.id = a.state_id
        WHERE a.disaster_ready = true and d.code not in (\'10\',\'11\',\'16\')
        GROUP BY b.code, b.desc_bm, c.code, c."name", d.code, d."desc"');

        $stateList = RefState::whereNotIn('code', ['10','11','16'])->get();
        $list = [];

        foreach ($stateList as $state) {
            $object = [
                'state_code' => $state->code,
                'state_name' => $state->desc,
                'has_many_categories' => [],
                'total' => 0
            ];

            $total = 0;

            $has_many_categories = [];

            foreach ($dataByStateAndType as $key) {
                if($key->state_code == $state->code){

                    $total_federal = 0;
                    $total_state = 0;

                    if($key->owner_type_code == '01'){
                        $total_federal += $key->total;
                    } elseif($key->owner_type_code == '02'){
                        $total_state += $key->total;
                    }

                    $total += $key->total;

                    $obj = [
                        'state_code' => $key->state_code,
                        'cat_code' => $key->cat_code,
                        'cat_name' => $key->cat_name,
                        'total_federal' => $total_federal,
                        'total_state' => $total_state
                    ];
                    array_push($has_many_categories, $obj);
                }
            }

            $object['total'] = $total;
            $object['has_many_categories'] = $has_many_categories;

            array_push($list, $object);

        };

        return [
            'total_state' => $stateList->count(),
            'dataByStateAndType' => $dataByStateAndType,
            'categories' => $categories,
            'categoriesByOwnerType' => $categoriesByOwnerType,
            'state_list' => $list
        ];
    }

    public function reportDisasterReadyByStateVTypes(){

        $list = DB::select('select b.id, b.name from fleet.fleet_department a
        join "public".ref_category b ON b.id = a.category_id
        where a.disaster_ready = true
        group by b.id, b.name');

        $totalByState = DB::select('select d.id, d.code, d."desc" AS name, count(*) AS total from fleet.fleet_department a
        JOIN public.ref_state d ON d.id = a.state_id
        WHERE a.disaster_ready = true and d.code not in (\'10\',\'11\',\'16\')
        GROUP BY d.id, d.code, d."desc"');

        $categories = [];
        $listByState = [];
        $stateList = RefState::whereNotIn('code', ['10','11','16'])->get();

        foreach ($stateList as $key) {

            $objState = [
                'name' => $key->desc,
                'total' => 0
            ];

            foreach ($totalByState as $state) {

                if($state->id == $key->id){
                    $objState['total'] += $state->total;
                }

            }
            array_push($listByState, $objState);
        }

        foreach ($list as $key) {
            $obj = [
                'cat_name' => $key->name,
                'has_many_type' => []
            ];

            $has_many_type = [];

            $listType = DB::select('select b.id, b.name, count(*) AS total from fleet.fleet_department a
            join "public".ref_sub_category_type b ON b.id = a.sub_category_type_id
            join "public".ref_category c ON c.id = a.category_id
            join "public".ref_state d ON d.id = a.state_id
            where c.id = '.$key->id.' and a.disaster_ready = true
            and d.code not in (\'10\',\'11\',\'16\')
            group by b.id, b.name');

            foreach ($listType as $type) {
                $objType = [
                    'name' => $type->name,
                    'total' => $type->total,
                    'has_many_state' => []
                ];

                $hasManyState = DB::select('select d.id AS state_id, d.code, d.desc AS name, count(*) AS total from fleet.fleet_department a
                join "public".ref_sub_category_type b ON b.id = a.sub_category_type_id
                join "public".ref_category c ON c.id = a.category_id
                join "public".ref_state d ON d.id = a.state_id
                where b.id = '.$type->id.' and a.disaster_ready = true
                and d.code not in (\'10\',\'11\',\'16\')
                group by d.code, d.desc, d.id');

                $objType['has_many_state'] = $hasManyState;
                array_push($has_many_type, $objType);

            }

            $obj['has_many_type'] = $has_many_type;

            array_push($categories, $obj);
        }

        return [
            'totalByState' => $totalByState,
            'categories' => $categories,
            'total_state' => $stateList->count(),
            'state_list' => $stateList,
            'listByState' => $listByState,
        ];

    }

    public function reportSummonsSummaryBranch(){

        $list = RefOwner::whereHas('hasOwnerType', function($q){
            $q->where([
                'code' => '01',
                'display_for' => 'vehicle_register'
            ]);
        })->orderBy('rps_branch_sort', 'asc');

        return [
            'list' => $list->get(),
            'listCount' => $list->get()->count(),
        ];

    }

    public function excel($view, Request $request){
        $date = Carbon::now()->format('DFY-h:m:s');
        return Excel::download(new ReportDisasterReadyExportView($view,$request), $view.'-'.$date.'.xlsx');
    }

}
