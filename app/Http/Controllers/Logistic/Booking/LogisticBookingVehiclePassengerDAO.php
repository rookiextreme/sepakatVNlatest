<?php

namespace App\Http\Controllers\Logistic\Booking;

use App\Http\Controllers\Controller;
use App\Models\Logistic\LogisticBookingVehicle;
use App\Models\Logistic\LogisticPassenger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LogisticBookingVehiclePassengerDAO extends Controller
{

    public function insert(Request $request){

        $logistic_booking_vehicle_id = session()->get('current_booking_vehicle_id');
        $data = [
            'logistic_booking_vehicle_id' => $logistic_booking_vehicle_id,
            'created_by' => Auth::user()->id
        ];

        $response = [];

        $queryBookingVehicle = LogisticBookingVehicle::find($logistic_booking_vehicle_id);
        Log::info('hasManyPassenger --> '.$queryBookingVehicle->hasManyPassenger->count());
        Log::info('$queryBookingVehicle->total_passenger --> '.$queryBookingVehicle->total_passenger);
        if($queryBookingVehicle->hasManyPassenger->count() >= $queryBookingVehicle->total_passenger){
            $response = [
                'message' => 'Penumpang telah mencapai had',
                'code' => 405,
            ];
        } else {
            $query = LogisticPassenger::create($data);
            $response = [
                'query' => $query,
                'code' => 200,
                'message' => 'Maklumat berjaya ditambah',
                'id' => $query->id
            ];
        }

        Log::info($response);
        unset($response['query']);
        return $response;
    }

    public function update(Request $request){
        $id = $request->id;
        $query = LogisticPassenger::find($id);

        $data = [
            'name' => $request->name,
            'phone_no' => $request->phone_no,
            'updated_by' => Auth::user()->id
        ];

        $query->update($data);

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
        $query = LogisticPassenger::whereIn('id', $ids);
        $query->delete();
        // $query->update([
        //     'status' => 0
        // ]);
        Log::info($query->toSql());
        Log::info($query->get());

        $response = [
            'code' => 200,
            'message' => 'Maklumat berjaya dihapus'
        ];

        Log::info($response);
        return $response;
    }

}
