<?php

namespace App\Http\Controllers\Logistic\DisasterReady;

use App\Http\Controllers\Controller;
use App\Models\DisasterReady\DisasterReadyBooking;
use App\Models\Fleet\FleetDepartment;
use App\Models\Fleet\FleetLookupVehicle;
use App\Models\Logistic\LogisticBooking;
use App\Models\Logistic\LogisticBookingVehicle;
use App\Models\Logistic\LogisticDisasterReadyVehicle;
use App\Models\LogisticBookingStatus;
use App\Models\LogisticVehicleStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LogisticDisasterReadyVehicleDAO extends Controller
{
    public $is_need_driver = false;

    private function bookingStatus($code){
        $status = LogisticBookingStatus::where('code',$code)->first();

        return $status->id;
    }

    public function insert(Request $request){

        $booking_id = session()->get('disasterready_current_detail_id');

        if($request->is_need_driver == 1){
            $this->is_need_driver = true;
        }

        $currentAvailable = FleetDepartment::whereHas('hasManyCatType', function($q) use($request){
            $q->where('id', $request->vehicle_type_id);
        })->where('disaster_ready', 1);

        Log::info('$request->total_unit_need => '.$request->total_unit_need);
        Log::info('$currentAvailable->count() '.$currentAvailable->count());

        if($currentAvailable->count() < $request->total_unit_need){

            Log::info('kurang!!');

            return response()->json(['success' => false, 'errors' => [
                'total_unit_need' => ['Jumlah Unit kurang daripada '.$request->total_unit_need]
            ]], 422);

        }

        if(empty($booking_id)){
            $inserted = DisasterReadyBooking::create([
                'booking_by' => Auth::user()->id,
                'created_by' => Auth::user()->id,
                'status_id' => $this->bookingStatus('01')
            ]);
            $booking_id = $inserted->id;
            session()->put('disasterready_current_detail_id', $booking_id);
        }

        $data = [
            'booking_id' => $booking_id,
            'placement_id' => $request->placement_id,
            'vehicle_type_id' => $request->vehicle_type_id,
            // 'total_passenger' => $request->total_passenger,
            'is_need_driver' => $this->is_need_driver,
            'driver_id' => $request->driver_id,
            'status_id' => $this->disasterVehicleStatus('01'),
            'created_by' => Auth::user()->id
        ];

        $dataBatch = [];

        if($request->total_unit_need > 0){

            for ($i=0; $i < $request->total_unit_need; $i++) {
                Log::info($i);
                array_push($dataBatch, $data);
            }
        }

        $query = null;
        $query = LogisticDisasterReadyVehicle::insert($dataBatch);

        $response = [
            'query' => $query,
            'code' => 200,
            'message' => 'Maklumat berjaya ditambah'
        ];

        unset($response['query']);
        return $response;
    }

    public function delete(Request $request){
        $ids = $request->ids;
        Log::info($ids);
        $query = LogisticDisasterReadyVehicle::whereIn('id', $ids);
        $query->update([
            'status_id' => $this->disasterVehicleStatus('00')
        ]);
        Log::info($query->toSql());
        Log::info($query->get());

        $response = [
            'code' => 200,
            'message' => 'Maklumat berjaya dihapus'
        ];

        Log::info($response);
        return $response;
    }

    public function checkIsNeedDriver(Request $request){
        $id = $request->id;
        $query = LogisticDisasterReadyVehicle::find($id);
        return [
            'is_need_driver' => $query->is_need_driver
        ];
    }

    public function needDriver(Request $request){
        $id = $request->id;
        $is_need_driver = $request->is_need_driver;
        Log::info($id);
        $query = LogisticDisasterReadyVehicle::find($id);
        $query->update([
            'is_need_driver' => $is_need_driver,
            'update_at' => Carbon::now()
        ]);
    }

    public function assign(Request $request){

        $id = $request->vehicle_type_id;
        $vehicle_id = $request->vehicle_id;
        $driver_id = $request->driver_id;
        $driver_phone_no = $request->driver_phone_no;

        $vehicleDetail = FleetLookupVehicle::find($vehicle_id);

        $query = LogisticDisasterReadyVehicle::find($id);
        $data = [
            'vehicle_id' => $vehicle_id,
            'driver_id' => $driver_id,
            'driver_phone_no' => $driver_phone_no
        ];

        // if(!$vehicleDetail->hasMainDriver){
        //     $data['is_need_driver'] = true;
        // }

        if($vehicleDetail->hasSubCategoryType()){
            $data['vehicle_type_id'] = $vehicleDetail->hasSubCategoryType()->id;
        }
        $query->update($data);

    }

    private function disasterVehicleStatus($code){
        $status = LogisticVehicleStatus::where('code',$code)->first();

        return $status->id;
    }

}
