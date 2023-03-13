<?php

namespace App\Http\Controllers\Report;

use App\Exports\ReportBookingExport;
use App\Http\Controllers\Controller;
use App\Models\Fleet\FleetDepartment;
use App\Models\Fleet\FleetDepartmentView;
use App\Models\RefCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;



class ReportLogisticCompositionDAO extends Controller
{

    public function exportExcelCarBooking(Request $request)
    {
        return Excel::download(new ReportBookingExport($request), 'tempahankenderaan.xlsx');
    }
}

