<?php

namespace App\Http\Controllers\Logistic\Task;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Logistic\DisasterReady\DisasterReadyDAO;
use App\Http\Controllers\Logistic\DisasterReady\DisasterReadyVehicleDAO;
use App\Models\DisasterReady\DisasterReadyBooking;
use App\Models\DisasterReadyBookingStatus;
use App\Models\Logistic\LogisticBooking;
use App\Models\Logistic\LogisticBookingTaskScan;
use App\Models\Logistic\LogisticBookingVehicle;
use App\Models\Logistic\LogisticDisasterReadyVehicle;
use App\Models\Logistic\LogisticDisasterTaskScan;
use App\Models\Logistic\LogisticDocument;
use App\Models\LogisticBookingStatus;
use App\Models\LogisticVehicleStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use PDO;

class LogisticTaskDriverDAO extends Controller
{
    public $current_id = -1;
    public $current_vehicle_id = -1;
    public $detail;
    public $vehicle;
    public $is_display = 0;
    public $task_list;

    public function mount(){
        $queryBooking = LogisticBooking::select('logistic.logistic_booking.id AS booking_id', 'destination', 'reason','start_datetime','end_datetime','logistic.logistic_booking.created_at', 'a.code AS status_code', 'a.name AS status_name', DB::raw("concat('booking') as category"));

        if(Auth::user()->isDriver()){
            $queryBooking->whereHas('hasManyAssignedVehicle', function($q){
                $q->where([
                    'is_need_driver' => true,
                    'driver_id' => Auth::user()->id
                ]);
            });
        }

        $queryBooking->join('logistic.logistic_booking_status AS a', 'a.id', '=', 'status_id');
        $queryBooking->whereIn('a.code', ['06','07']);

        $queryDisasterReady = DisasterReadyBooking::select('logistic.disasterready_booking.id AS booking_id', 'destination', 'reason','start_datetime','end_datetime','logistic.disasterready_booking.created_at', 'a.code AS status_code', 'a.name AS status_name', DB::raw("concat('disaster') as category"));

        if(Auth::user()->isDriver()){
            Log::info('saya driver');
            $queryDisasterReady->where('driver_id', auth()->user()->id);
        }

        $queryDisasterReady->join('logistic.disasterready_booking_status AS a', 'a.id', '=', 'status_id');
        $queryDisasterReady->whereIn('a.code', ['06','07']);

        $list = $queryBooking->union($queryDisasterReady);

        Log::info($queryDisasterReady->toSql());

        $this->task_list = $list->paginate(5);
    }

    public function read($id, $category){

        Log::info($id);

        if($category == 'booking'){
            $query = LogisticBooking::find($id);
        } else {
            $query = DisasterReadyBooking::find($id);
        }

        Log::info($query);

        session()->put('booking_current_detail_id', $id);
        $this->current_id = $id;
        $this->detail = $query;

        if(auth()->user()->isDriver() && $query->hasBookingStatus->code == '07'){
            $this->is_display = 1;
        }
        return $this->detail;
    }

    public function readVehicle($id, $category){

        Log::info($id);

        if($category == 'booking'){
            $query = LogisticBookingVehicle::find($id);
        } else {
            $query = LogisticDisasterReadyVehicle::find($id);
        }

        Log::info($query);

        session()->put('current_vehicle_id', $id);
        $this->current_id = $id;
        $this->vehicle = $query;

        Log::info($query->hasStatus->code);

        if($query->hasStatus->code == '04'){
            $this->is_display = 1;
        }
        return $this->vehicle;
    }

    public function taskVehicleList(Request $request){
        $tableLBV = new LogisticBookingVehicle();
        $tableLBV->setTable('logistic.logistic_booking_vehicle AS lbv');
        $queryVBooking = $tableLBV->select('lb.id AS booking_id', 'lbv.id', 'lbv.vehicle_id', 'lb.destination AS destination', 'lb.reason AS reason', 'lb.start_datetime AS start_datetime', 'lbs.name AS status_name', 'lbs.code AS status_code', DB::raw("concat('booking') as category"))->orderBy('lbv.updated_by', 'desc');
        $queryVBooking->join('logistic.logistic_booking as lb', 'lb.id', 'lbv.booking_id');
        $queryVBooking->join('logistic.vehicle_status as lbs', 'lbs.id', 'lbv.status_id');

        $queryVBooking->where('lbv.is_need_driver', true);
        $queryVBooking->whereIn('lbs.code', ['01','02','03','04']);

        if(Auth::user()->isDriver()){
            Log::info('saya driver');
            $queryVBooking->where('lbv.driver_id', auth()->user()->id);
        } 
        
        // elseif(Auth::user()->isEngineer()){
        //     $queryVBooking->whereHas('hasDriver', function($q){
        //         $q->whereHas('hasWorkshop', function($q2){
        //             $q2->where('id', Auth::user()->id);
        //         });
        //     });
        // }

        $tableLDV = new LogisticDisasterReadyVehicle();
        $tableLDV->setTable('logistic.logistic_disasterready_vehicle AS ldv');
        $queryVDisasterReady = $tableLDV->select('ld.id AS booking_id', 'ldv.id', 'ldv.vehicle_id', 'ld.destination AS destination', 'ld.reason AS reason', 'ld.start_datetime AS start_datetime', 'lbs.name AS status_name', 'lbs.code AS status_code', DB::raw("concat('disaster') as category"))->orderBy('ldv.updated_by', 'desc');
        $queryVDisasterReady->join('logistic.disasterready_booking as ld', 'ld.id', 'ldv.booking_id');
        $queryVDisasterReady->join('logistic.vehicle_status as lbs', 'lbs.id', 'ldv.status_id');

        $queryVDisasterReady->where('ldv.is_need_driver', true);
        $queryVBooking->whereIn('lbs.code', ['01','02','03','04']);

        if(Auth::user()->isDriver()){
            Log::info('saya driver');
            $queryVDisasterReady->where('ldv.driver_id', auth()->user()->id);
        }

        // elseif(Auth::user()->isEngineer()){
        //     $queryVBooking->whereHas('hasDriver', function($q){
        //         $q->whereHas('hasWorkshop', function($q2){
        //             $q2->where('id', Auth::user()->id);
        //         });
        //     });
        // }

        $TaskList = $queryVBooking->union($queryVDisasterReady);
        
        return $TaskList->paginate(5);
    }

    public function scanQR(Request $request){

        $BookingId = $request->booking_id;
        $fingerPrintId = $request->finger_print_id;
        $category = $request->category;

        $isDriver = 0;
        $is_scan = 0;

        Log::info('category --> '.$category);

        $queryCheckValid = "";

        if($category == 'booking'){
            $queryCheckValid = LogisticBookingTaskScan::where([
                'booking_id' => $BookingId
            ])->whereHas('hasBooking', function($q){
                $q->where('driver_id', Auth::user()->id);
            })->first();
        } else if($category == 'disaster'){
            Log::info('masuk disaster');
            $queryCheckValid = LogisticDisasterTaskScan::where([
                'booking_id' => $BookingId
            ])->whereHas('hasBooking', function($q){
                $q->where('driver_id', Auth::user()->id);
            })->first();
        }
        Log::info($queryCheckValid);

        if($queryCheckValid){
            $isDriver = 1;

            Log::info($queryCheckValid->finger_print_id);
            Log::info($fingerPrintId);

            if($queryCheckValid->finger_print_id == $fingerPrintId){
                Log::info('scan ...');
                $queryCheckValid->update([
                    'is_scan' => 1
                ]);
                $is_scan = $queryCheckValid->is_scan;
            }
        }

        return [
            'is_scan' => $is_scan,
            'isDriver' => $isDriver
        ];
    }

    public function driverUpdateTask(Request $request){
        $this->current_id = session()->get('booking_current_detail_id');

        Log::info($this->current_id);
        Log::info($request);

        $data = [
            'spare_driver_name' => $request['spare_driver_name'],
            'before_odometer' => $request['before_odometer'],
            'after_odometer' => $request['after_odometer'],
            'task_datetime' => $request['task_datetime'],
            'task_end_datetime' => $request['task_end_datetime'],
            'total_price_tng_used' => $request['total_price_tng_used'],
            'oil_used' => $request['oil_used']
        ];

        Log::info('/driverUpdateTask');
        Log::info($data);

        if($request->category == 'booking'){
            $LogisticTask = LogisticBooking::find($this->current_id);
        } else if($request->category == 'disaster'){
            $LogisticTask = DisasterReadyBooking::find($this->current_id);
        }

        if($request->fuel_receipt){
            $fuel_receipt_id = $this->createDoc($request->fuel_receipt, $request->category, 'fuel_receipt')->id;
            $data['fuel_receipt_id'] = $fuel_receipt_id;
        }

        $LogisticTask->update($data);

        return [
            'url' => route('logistic.driver-task.detail', [ 'booking_id' => $this->current_id, 'category' => $request->category, 'tab' => 2])
        ];
    }

    public function driverUpdateTaskVehicle(Request $request){
        $this->current_vehicle_id = session()->get('current_vehicle_id');

        Log::info($this->current_vehicle_id);
        Log::info($request);

        $data = [
            'spare_driver_name' => $request['spare_driver_name'],
            'before_odometer' => $request['before_odometer'],
            'next_odometer' => $request['next_odometer'],
            'task_datetime' => $request['task_datetime'],
            'task_end_datetime' => $request['task_end_datetime'],
            'total_price_tng_used' => $request['total_price_tng_used'],
            'oil_used' => $request['oil_used']
        ];

        Log::info('/driverUpdateTaskVehicle');
        Log::info($data);

        if($request->category == 'booking'){
            $LogisticTask = LogisticBookingVehicle::find($this->current_vehicle_id);
        } else if($request->category == 'disaster'){
            $LogisticTask = LogisticDisasterReadyVehicle::find($this->current_vehicle_id);
        }

        if($request->fuel_receipt){
            $fuel_receipt_id = $this->createDoc($request->fuel_receipt, $request->category, 'fuel_receipt')->id;
            $data['fuel_receipt_id'] = $fuel_receipt_id;
        }

        $LogisticTask->update($data);

        return [
            'url' => route('logistic.driver-task-vehicle.detail', [ 'booking_id' => $this->current_id, 'vehicle_id' => $this->current_vehicle_id, 'category' => $request->category, 'tab' => 2])
        ];
    }

    private function bookingStatus($code, $category){

        $table = LogisticBookingStatus::class;
        if($category == 'booking'){
            $table = LogisticBookingStatus::class;
        } else if($category == 'disaster'){
            $table = DisasterReadyBookingStatus::class;
        }
        $status = $table::where('code',$code)->first();

        return $status->id;
    }

    private function bookingVehicleStatus($code){

        $status = LogisticVehicleStatus::where('code',$code)->first();

        return $status->id;
    }

    public function driverTaskDone(Request $request)
    {
        $result = 0;
        $ids = $request->ids;
        $category = $request->category;
        $table = LogisticBooking::class;

        if($category == 'booking'){
            $table = LogisticBooking::class;
        } else if($category == 'disaster'){
            $table = DisasterReadyBooking::class;
        }
        $query = $table::whereIn('id', $ids);
        $result = $query->update([
            'status_id' => $this->bookingStatus('07', $category)
        ]);

        Log::info($result);

        return [
            'url' => route('logistic.driver-task')
        ];
    }

    public function driverTaskVehicleDone(Request $request)
    {
        $result = 0;
        $ids = $request->ids;
        $category = $request->category;
        $table = LogisticBookingVehicle::class;

        if($category == 'booking'){
            $table = LogisticBookingVehicle::class;
        } else if($category == 'disaster'){
            $table = LogisticDisasterReadyVehicle::class;
        }
        $this->current_vehicle_id = session()->get('current_vehicle_id');
        $query = $table::find($this->current_vehicle_id);
        $result = $query->update([
            'status_id' => $this->bookingVehicleStatus('04', $category)
        ]);

        Log::info($result);

        return [
            'url' => route('logistic.driver-task-vehicle')
        ];
    }

    private function createDoc($file, $category, $doc_type){
        $docFormat = $file->getClientOriginalExtension();
        $fileName = Str::random(9).'.'.$docFormat;

        if($file != null){

            Log::info($file);
            Log::info($docFormat);

            $path = 'public/dokumen/logistic/'.$category.'/';

            $file->storeAs($path, $fileName);

            $data = [
                'doc_path' => 'dokumen/logistic/'.$category.'/',
                'doc_type' => $doc_type,
                'doc_format' => $docFormat,
                'doc_name' => $fileName,
                'created_by' => auth()->user()->id,
            ];

            Log::info($data);

            return LogisticDocument::create($data);
        }
    }

}
