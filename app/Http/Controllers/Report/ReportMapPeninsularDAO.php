<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Fleet\FleetDepartment;
use App\Models\Fleet\FleetLookupVehicle;
use App\Models\Fleet\FleetTotalRecordByState;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReportMapPeninsularDAO extends Controller
{

    public $total_record_by_state;

    public function mount(){
        $this->total_record_by_state = FleetTotalRecordByState::all();
    }

    public function getReportByState($state_id){


        return FleetLookupVehicle::find();
    }

    public function getTotalDistrictByStateCode($stateCode){

        $query = DB::select(DB::raw('
            SELECT fp.map_order AS "order", fp.desc AS description, count(fd.id) AS total_fleet, fd.placement_id as placement_id
            FROM fleet.fleet_placement fp
            JOIN "public".ref_state rs ON rs.id = fp.ref_state_id
            JOIN fleet.fleet_department fd ON fd.placement_id=fp.id
            WHERE  rs.code = ? AND is_district_of_state IS true
            AND fd.vapp_status_id = 7 AND fp.map_order > 0
            GROUP BY "order", description, placement_id

        '),[$stateCode]);

        Log::info($query);
        return $query;

    }

}
