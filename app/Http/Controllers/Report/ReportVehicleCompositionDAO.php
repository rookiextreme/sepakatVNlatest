<?php

namespace App\Http\Controllers\Report;

use App\Exports\ReportVehicleExport;
use App\Http\Controllers\Controller;
use App\Models\Fleet\FleetDepartment;
use App\Models\Fleet\FleetDepartmentView;
use App\Models\Fleet\FleetDisposalView;
use App\Models\Fleet\FleetPublicView;
use App\Models\RefCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;



class ReportVehicleCompositionDAO extends Controller
{

    public $categoryList;

    public function mount(){
        $this->categoryList = RefCategory::all();
    }

    public function getCompositionBy(Request $request){

        $composition_by = $request->composition_by;
        // dd($composition_by);
        Log::info('composition_by --> '.$composition_by);

        switch ($composition_by) {
            case 'vehicle_type':

                if($request->sub_category_id > 0){
                    $query = DB::table('fleet.fleet_department AS a')->select('b.name AS name', DB::raw('count(*) AS total'))
                    ->join('ref_sub_category_type AS b', 'b.id', '=', 'a.sub_category_type_id')
                    ->where('b.sub_category_id', $request->sub_category_id)
                    ->groupBy('b.name')
                    ->orderBy('total', 'desc');
                    Log::info($query->toSql());
                    return $query->get();
                } else {
                    $query = DB::table('fleet.fleet_department AS a')->select('ref_sub_category.name AS name', DB::raw('count(*) AS total'))
                    ->join('ref_sub_category', 'ref_sub_category.id', '=', 'a.sub_category_id')
                    ->where('a.category_id', $request->category_id)
                    ->groupBy('ref_sub_category.name')
                    ->orderBy('total', 'desc');

                    Log::info($query->toSql());
                    return $query->get();
                }

                break;

            case 'brand':

                $query = FleetDepartment::select('vehicles.brands.name AS name', DB::raw('count(*) AS total'))
                        ->groupBy('vehicles.brands.name')
                        ->join('vehicles.brands', 'brands.id', '=', 'fleet.fleet_department.brand_id')
                        ->orderBy('total', 'desc');
                        Log::info($query->toSql());
                return $query->get();
                break;

            case 'age':

                // $query = FleetDepartment::select('manufacture_year as name', DB::raw('count(*) as total'))
                // ->groupBy('manufacture_year')
                // ->whereNotNull('manufacture_year')
                // ->orderBy('total', 'desc');

                $query = DB::select(DB::raw('WITH ranges AS (
                    SELECT (fromAge)::text||\'-\'||(untilAge)::text AS range,
                  fromAge AS r_min, untilAge AS r_max
                      FROM (VALUES (0,1),(2,5),(6,10),(11,20),(21,30),(31,50),(51,100)) AS t(fromAge, untilAge) )
                SELECT r.r_min, r.range AS "name", count(fd.*) AS total
                  FROM ranges r
                  LEFT JOIN "fleet"."fleet_department" fd ON (date_part(\'year\', CURRENT_DATE)-fd.manufacture_year)
                  BETWEEN r.r_min AND r.r_max
                 GROUP BY r.range, r.r_min
                 ORDER BY r.r_min ASC'));

                Log::info($query);
                return $query;
                break;

            case 'branch':
                $query = FleetDepartment::select('b.name as name', (DB::raw('count(*) AS total')))
                        ->join('ref_owner AS b', 'b.id', '=', 'cawangan_id')
                        ->groupBy('b.name')
                        ->orderBy('total', 'desc');
                        Log::info($query->toSql());
                return $query->get();
                break;

            case 'ownership':
                $query = FleetDepartment::select('b.desc_bm as name', (DB::raw('count(*) AS total')))
                        ->join('ref_owner_type AS b', 'b.id', '=', 'owner_type_id')
                        ->groupBy('b.desc_bm')
                        ->orderBy('total', 'desc');
                        Log::info($query->toSql());
                return $query->get();
                break;

            case 'state';
                $query = FleetDepartment::select('b.desc as name', (DB::raw('count(*) AS total')))
                        ->join('ref_state AS b', 'b.id', '=', 'state_id')
                        ->groupBy('b.desc')
                        ->orderBy('total', 'desc');
                        Log::info($query->toSql());
                return $query->get();
                break;

            default:
                # code...
                break;
        }
    }

    public function summonSummary(){
        $list = DB::select(DB::raw('SELECT
        "fleet"."fleet_placement"."desc",
        "saman"."status_saman"."name",
        "public"."ref_summon_agency"."desc" AS agency,
        count(*) AS total
        FROM
            "saman"."maklumat_kenderaan_saman"
            LEFT JOIN "saman"."maklumat_saman" ON "saman"."maklumat_saman"."maklumat_kenderaan_saman_id" = "saman"."maklumat_kenderaan_saman"."id"
            LEFT JOIN "fleet"."fleet_lookup_vehicle_view" ON "fleet"."fleet_lookup_vehicle_view"."id" = "saman"."maklumat_kenderaan_saman"."pendaftaran_id"
            LEFT JOIN "fleet"."fleet_placement" ON "fleet"."fleet_placement"."id" = "fleet"."fleet_lookup_vehicle_view"."placement_id"
            JOIN "saman"."status_saman" ON "saman"."status_saman"."id" = "saman"."maklumat_kenderaan_saman"."status_saman_id"
            JOIN "public"."ref_summon_agency" ON "public"."ref_summon_agency"."id" = "saman"."maklumat_saman"."summon_agency_id"
        WHERE
            "saman"."status_saman"."code" IN (\'02\',\'03\')
            GROUP BY
            "fleet"."fleet_placement"."desc",
            "saman"."status_saman"."name",
            "public"."ref_summon_agency"."desc"

            ORDER BY "fleet"."fleet_placement"."desc","public"."ref_summon_agency"."desc"'));
        return $list;
    }

    public function getFleet(Request $request)
    {
        if($request->fleet_view == 'department'){
            $query = FleetDepartmentView::query();
            if($request->search){
                $query->whereRaw($this->checkXid($request->xid, $request->search));
            }

            if($request->ownership == 'jkr'){
                $query->where("HAK MILIK",'PERSEKUTUAN');
            } else if($request->ownership == 'state'){
                $query->where("HAK MILIK",'NEGERI');
            }

            Log::info($query->toSql());

            $query = $query->paginate($request->limit);

        }
        elseif($request->fleet_view == 'public'){
            // dd($request->all());
            if(!empty($request->search)){
                $query = FleetPublicView::whereRaw($this->checkXid($request->xid, $request->search))->paginate($request->limit);
            }else{
                $query = FleetPublicView::paginate($request->limit);
            }

        }elseif($request->fleet_view == 'disposal'){
            if(!empty($request->search)){
                $query = FleetDisposalView::whereRaw($this->checkXid($request->xid, $request->search))->paginate($request->limit);
            }else{
                $query = FleetDisposalView::paginate($request->limit);
            }

        }
        else{
            $query = FleetDepartmentView::paginate($request->limit);
        }

        return $query;
    }

    public function checkXid($xid, $search){
        if($xid == 0){
            $query = "upper(\"NO.PENDAFTARAN\") LIKE '%".strtoupper($search)."%' ";
        }elseif($xid == 1){
            $query = "upper(\"NO.PENDAFTARAN\") LIKE '%".strtoupper($search)."%' ";
        }elseif($xid == 2){
            $query = "upper(\"NO.JKR\") LIKE '%".strtoupper($search)."%' ";
        }elseif($xid == 3){
            $query = "upper(\"LOKASI PENEMPATAN\") LIKE '%".strtoupper($search)."%' ";
        }elseif($xid == 4){
            $query = "upper(\"HAK MILIK\") LIKE '%".strtoupper($search)."%' ";
        }elseif($xid == 5){
            $query = "upper(\"JENIS\") LIKE '%".strtoupper($search)."%' ";
        }elseif($xid == 6){
            $query = "upper(\"PEMBUAT\") LIKE '%".strtoupper($search)."%' ";
        }elseif($xid == 7){
            $query = "upper(\"NEGERI\") LIKE '%".strtoupper($search)."%' ";
        }elseif($xid == 8){
            $query = "upper(\"CAWANGAN\") LIKE '%".strtoupper($search)."%' ";
        }else{
            $query = "upper(\"NO.PENDAFTARAN\") LIKE '%".strtoupper($search)."%' ";
        }

        return $query;
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new ReportVehicleExport($request), 'vehicles.xlsx');
    }
}

