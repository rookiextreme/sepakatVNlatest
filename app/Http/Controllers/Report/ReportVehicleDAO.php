<?php

namespace App\Http\Controllers\Report;

use App\Exports\ReportVehicleExportView;
use App\Http\Controllers\Controller;
use App\Models\RefCategory;
use App\Models\RefOwner;
use App\Models\RefState;
use App\Models\RefSubCategoryType;
use App\Models\RefWorkshop;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ReportVehicleDAO extends Controller
{

    public function reportVehicleByWorkshop(){

        $list = RefWorkshop::where('status', 1); 

        $object = [
            'list' => $list->get(),
        ];

        return $object;
    }

    public function reportVehicleByWorkshopOwnership(){

        $list = RefWorkshop::where('status', 1); 

        $object = [
            'list' => $list->get(),
        ];

        return $object;
    }

    public function reportVehicleByCatType(Request $request){

        $state_list = RefState::query();
        $list = RefSubCategoryType::where('status', 1)->orderBy('code'); 

        if($request->owner_type_code == '02'){
            $state_list->whereNotIn('code', ['14','15','16']);
        }

        $object = [
            'state_list' => $state_list->get(),
            'list' => $list->get(),
        ];

        return $object;
    }

    public function excel(Request $request){
        $date = Carbon::now()->format('DFY-h:m:s');
        return Excel::download(new ReportVehicleExportView($request), $request->view.'-'.$date.'.xlsx');
    }

}
