<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Fleet\FleetAudit;
use App\Models\Fleet\FleetDepartment;
use App\Models\RefCategory;
use App\Models\Vehicle\Brand;
use App\Models\Vehicle\VehicleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PHPJasper\PHPJasper;



class ReportSummonsCompositionDAO extends Controller
{

    public $categoryList;

    public function mount(){
        $this->categoryList = RefCategory::all();
    }

    public function getIssuedBy(Request $request){

        $issued_by = $request->issued_by;
        // dd($composition_by);
        Log::info('issued_by --> '.$issued_by);

        switch ($issued_by) {
            case 'pengeluar':

                $query = DB::select(DB::raw('
                SELECT rsa.desc AS name, count(ms.id) AS total
                FROM saman.maklumat_saman ms
                LEFT JOIN public.ref_summon_agency rsa ON rsa.id = ms.summon_agency_id
                JOIN saman.maklumat_kenderaan_saman mks ON mks.id=ms.maklumat_kenderaan_saman_id
                WHERE mks.status_saman_id IN (3,4,5)
                GROUP BY rsa.desc
                '));

                Log::info($query);
                return $query;


                break;


            default:
                # code...
                break;
        }
    }
}
