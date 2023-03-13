<?php

namespace App\Http\Controllers\Logistic\DisasterReady;

use App\Http\Controllers\Controller;
use App\Mail\module\logistic\SendEmailToUserWhenBookingStatusReject;
use App\Models\DisasterReady\DisasterReadyBooking;
use App\Models\DisasterReady\DisasterReadyBookingTaskScan;
use App\Models\DisasterReady\DisasterReadyDocument;
use App\Models\DisasterReadyBookingStatus;
use App\Models\Fleet\FleetDepartment;
use App\Models\Fleet\FleetLookupVehicle;
use App\Models\LogisticBookingStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

class DisasterReadyVehicleDAO extends Controller
{
    public $current_id = -1;
    public $detail;
    public $is_display = 0;
    public $disasterready_vehicle_list;
    public $mode = 0777;

    public function mount(){
        $query = FleetDepartment::where('disaster_ready', true);

        Log::info($query->toSql());

        $this->disasterready_vehicle_list = $query->paginate(5);
    }
}
