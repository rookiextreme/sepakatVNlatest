<?php

namespace App\Http\Controllers\Logistic\Booking;

use App\Http\Controllers\Controller;
use App\Mail\module\logistic\SendEmailToUserWhenBookingStatusReject;
use App\Models\Fleet\FleetGrant;
use App\Models\Fleet\FleetLookupVehicle;
use App\Models\Logistic\LogisticApplicant;
use App\Models\Logistic\LogisticBooking;
use App\Models\Logistic\LogisticBookingTaskScan;
use App\Models\Logistic\LogisticBookingVehicle;
use App\Models\Logistic\LogisticDocument;
use App\Models\LogisticBookingStatus;
use App\Models\LogisticBookingVehicleStatus;
use App\Models\LogisticStayStatus;
use App\Models\LogisticVehicleStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

class LogisticBookingVehicleDAO extends Controller
{

    public $is_need_driver = false;

    private function bookingStatus($code){
        $status = LogisticBookingStatus::where('code',$code)->first();

        return $status->id;
    }


    public function insert(Request $request){

        $booking_id = session()->get('booking_current_detail_id');

        if($request->is_need_driver == 1){
            $this->is_need_driver = true;
        }

        if(empty($booking_id)){
            $inserted = LogisticBooking::create([
                'booking_by' => Auth::user()->id,
                'created_by' => Auth::user()->id,
                'status_id' => $this->bookingStatus('01')
            ]);
            $booking_id = $inserted->id;
            session()->put('booking_current_detail_id', $booking_id);
        }

        $data = [
            'booking_id' => $booking_id,
            'branch_id' => $request->branch_id,
            'placement_id' => $request->placement_id,
            'sub_category_id' => $request->sub_category_id,
            'vehicle_type_id' => $request->vehicle_type_id,
            'total_passenger' => $request->total_passenger,
            'is_need_driver' => $this->is_need_driver,
            'driver_id' => $request->driver_id,
            'status_id' => $this->bookingVehicleStatus('01'),
            'created_by' => Auth::user()->id
        ];

        $dataBatch = [];

        if($request->total_unit_need > 0){

            for ($i=0; $i < $request->total_unit_need; $i++) {
                array_push($dataBatch, $data);
            }
        }

        Log::info($dataBatch);
        $query = null;
        $query = LogisticBookingVehicle::insert($dataBatch);

        $response = [
            'query' => $query,
            'code' => 200,
            'message' => 'Maklumat berjaya ditambah'
        ];

        Log::info($response);
        unset($response['query']);
        return $response;
    }

    public function update(Request $request){
        $id = $request->id;
        $name = $request->name;
        $query = LogisticBookingVehicle::find($id);
        $query->update([
            'name' => $name
        ]);

        $response = [
            'query' => $query,
            'code' => 200,
            'message' => 'Maklumat berjaya disimpan'
        ];

        Log::info($response);
        unset($response['query']);
        return $response;
    }

    public function delete(Request $request){
        $ids = $request->ids;
        Log::info($ids);
        $query = LogisticBookingVehicle::whereIn('id', $ids);
        $query->update([
            'status_id' => $this->bookingVehicleStatus('00')
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
        $query = LogisticBookingVehicle::find($id);
        return [
            'is_need_driver' => $query->is_need_driver
        ];
    }

    public function needDriver(Request $request){
        $id = $request->id;
        $is_need_driver = $request->is_need_driver;
        Log::info($id);
        $query = LogisticBookingVehicle::find($id);
        $query->update([
            'is_need_driver' => $is_need_driver,
            'update_at' => Carbon::now()
        ]);
    }

    public function assign(Request $request){

        $fleet_table = $request->fleet_table ? $request->fleet_table : 'department';
        $id = $request->vehicle_type_id;
        $vehicle_id = $request->vehicle_id;
        $driver_id = $request->driver_id;
        $driver_phone_no = $request->driver_phone_no;

        $query = LogisticBookingVehicle::find($id);

        if($request->fleet_table == 'grant'){
            $vehicleDetail = FleetGrant::find($vehicle_id);
        } else {
            $vehicleDetail = FleetLookupVehicle::find($vehicle_id);
        }
        
        $data = [
            'fleet_table' => $fleet_table,
            'vehicle_id' => $vehicle_id,
            'driver_id' => $driver_id,
            'driver_phone_no' => $driver_phone_no,
            'update_at' => Carbon::now(),
        ];

        // if(!$vehicleDetail->hasMainDriver){
        //     $data['is_need_driver'] = true;
        // }

        if($vehicleDetail && $vehicleDetail->hasSubCategoryType()){
            $data['vehicle_type_id'] = $vehicleDetail->hasSubCategoryType()->id;
        }
        $query->update($data);

    }

    public function savePassenger(Request $request){
        
        $query = LogisticBookingVehicle::find($request->booking_vehicle_id);
        foreach ($query->hasManyPassenger as $passenger) {
            $passenger->update([
                'name' => $request['name_'.$passenger->id],
                'phone_no' => $request['phone_no_'.$passenger->id]
            ]);
       }
    }

    private function createDoc($file, $doc_type){
        $docFormat = $file->getClientOriginalExtension();
        $fileName = Str::random(9).'.'.$docFormat;

        if($file != null){

            Log::info($file);
            Log::info($docFormat);

            $path = 'public/dokumen/logistic/booking/';

            $file->storeAs($path, $fileName);

            $data = [
                'doc_path' => 'dokumen/logistic/booking/',
                'doc_type' => $doc_type,
                'doc_format' => $docFormat,
                'doc_name' => $fileName,
                'created_by' => auth()->user()->id,
            ];

            return LogisticDocument::create($data);
        }
    }

    private function deletePrevDoc($id){
        $query = LogisticDocument::find($id);
        if($query){
            $query->delete();
            $path = public_path().'/storage/'.$query->doc_path.$query->doc_name;
            unlink($path);
            flush();
        }
    }

    public function uploadPassengerDoc(Request $request){

        $query = LogisticBookingVehicle::find($request->booking_vehicle_id);

        if($query){
            if($request->vehicle_passenger_doc){
                $vehicle_passenger_doc_id = $this->createDoc($request->vehicle_passenger_doc, 'vehicle_passenger_doc')->id;
                
                if($query->vehicle_passenger_doc_id){
                    $this->deletePrevDoc($query->vehicle_passenger_doc_id);
                }

                $data['vehicle_passenger_doc_id'] = $vehicle_passenger_doc_id;
            } else {
                if($query->vehicle_passenger_doc_id){
                    $data['vehicle_passenger_doc_id'] = $query->vehicle_passenger_doc_id;
                }
            }
    
            $query->update($data);
        } 
        
    }

    private function bookingVehicleStatus($code){
        $status = LogisticVehicleStatus::where('code',$code)->first();

        return $status->id;
    }

}
