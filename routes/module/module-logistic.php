<?php

use App\Http\Controllers\Logistic\Booking\LogisticBookingDAO;
use App\Http\Controllers\Logistic\Booking\LogisticBookingVehicleDAO;
use App\Http\Controllers\Logistic\Booking\LogisticBookingVehiclePassengerDAO;
use App\Http\Controllers\Logistic\DisasterReady\DisasterReadyDAO;
use App\Http\Controllers\Logistic\DisasterReady\LogisticDisasterReadyVehicleDAO;
use App\Http\Controllers\Logistic\Task\LogisticTaskDriverDAO;
use App\Models\DisasterReady\DisasterReadyDocument;
use App\Models\Fleet\FleetDepartment;
use App\Models\Fleet\FleetLookupVehicle;
use App\Models\Fleet\FleetLookupVehicleDisasterReady;
use App\Models\GeneralRecordCount;
use App\Models\Logistic\LogisticBookingType;
use App\Models\Logistic\LogisticDocument;
use App\Models\RefOwner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

Route::group(['prefix' => 'logistic', 'as' => 'logistic', 'middleware' => 'auth'], function(){

    Route::get('/report', function(){
        return view('logistic.logistic-report');
    })->name('.report');

    Route::get('/overview', function(){
        $general_record_count_view = GeneralRecordCount::select('*')->first();
        return view('logistic.logistic-overview', [
            'general_record_count_view' => $general_record_count_view
        ]);
    })->name('.overview');

    Route::group(['prefix' => 'booking', 'as' => '.booking'], function(){

        Route::get('/ajax/getVehicleType', function(){

            $state_id = request('state_id') != null ? request('state_id') : null;
            $placement_id = request('placement_id') != null ? request('placement_id') : null;
            $branch_id = request('branch_id') != null ? request('branch_id') : null;
            $search = request('search') != null ? strtolower(request('search')) : null;
            $offset = request('offset') != null ? request('offset') : 0;
            $limit = request('limit') != null ? request('limit') : 5;

            $table = new FleetDepartment();
            $vehicleList = $table->setTable('fleet.fleet_department AS a')
            ->select(
                'f.ref_state_id',
                'a.cawangan_id as branch_id',
                'a.placement_id',
                'b.id AS category_id',
                'b.name AS category_name',
                'c.id AS sub_category_id',
                'c.name AS sub_category_name',
                'd.id AS sub_category_type_id',
                'd.name AS sub_category_type_name',
                DB::raw("(
                    select count(aa.id) from fleet.fleet_department aa
                    join ref_vehicle_status gg on gg.id = aa.vehicle_status_id
                        where
                        aa.sub_category_id = c.id
                        and aa.state_id = f.ref_state_id
                        and aa.placement_id = f.id
                        and gg.code = '01'
                    )
                as total_sub_unit"),
                DB::raw("(
                    select count(aa.id) from fleet.fleet_department aa
                    join ref_vehicle_status gg on gg.id = aa.vehicle_status_id
                        where
                        aa.sub_category_type_id = d.id
                        and aa.state_id = f.ref_state_id
                        and aa.placement_id = f.id
                        and gg.code = '01'
                    )
                as total_type_unit"),
                'e.desc AS state_name',
                'f.desc AS placement_name'
                )
            ->join('ref_category AS b', 'b.id', '=', 'a.category_id')
            ->leftJoin('ref_sub_category AS c', 'c.id', '=', 'a.sub_category_id')
            ->leftJoin('ref_sub_category_type AS d', 'd.id', '=', 'a.sub_category_type_id')
            ->join('fleet.fleet_placement AS f', 'f.id', '=', 'a.placement_id')
            ->leftJoin('ref_state AS e', 'e.id', '=', 'f.ref_state_id')
            ->join('ref_vehicle_status AS g', 'g.id', '=', 'a.vehicle_status_id');

            if($state_id){
                $vehicleList->where('f.ref_state_id',$state_id);
            }

            if($placement_id){
                $vehicleList->where('a.placement_id',$placement_id);
            }

            if($branch_id){
                $vehicleList->where('a.cawangan_id',$branch_id);
            }

            if($search){
                $vehicleList->whereRaw("(lower(b.name) LIKE '%".$search."%' OR lower(c.name) LIKE '%".$search."%' OR lower(d.name) LIKE '%".$search."%')");
            }

            $vehicleList->where([
                'g.code' => '01'
            ]);

            $vehicleList->whereNotNull('a.sub_category_type_id');

            $vehicleList->groupByRaw("d.id, f.id, a.cawangan_id, a.placement_id, c.id, b.id, e.id");

            $vehicleList->orderBy('d.id', 'desc');
            Log::info($vehicleList->toSql());

            return view('logistic.tab.ajax.vehicle-by-type-list', [
                'vehicleList' => $vehicleList->paginate($limit)
            ]);

        })->name('.ajax.getVehicleType');

        Route::get('/ajax/getVehicle', function(){

            $sub_category_type_id = request('sub_category_type_id') != null ? request('sub_category_type_id') : null;
            $state_id = request('state_id') != null ? request('state_id') : null;
            $placement_id = request('placement_id') != null ? request('placement_id') : null;
            $search = request('search') != null ? strtolower(request('search')) : null;
            $limit = request('limit') != null ? request('limit') : 5;

            $vehicleList = DB::table('fleet.fleet_department AS a')
            ->select(
                'a.id as id',
                'a.no_pendaftaran as no_pendaftaran',
                'a.vehicle_status_id as vehicle_status_id',
                'a.main_driver_id as main_driver_id',
                'b.name AS category_name',
                'c.name AS sub_category_name',
                'd.id AS sub_category_type_id',
                'd.name AS sub_category_type_name',
                'e.desc AS state_name',
                'f.desc AS placement_name',
                DB::raw('false AS is_grant')
                )
            ->join('ref_category AS b', 'b.id', '=', 'a.category_id')
            ->join('ref_sub_category AS c', 'c.id', '=', 'a.sub_category_id')
            ->join('ref_sub_category_type AS d', 'd.id', '=', 'a.sub_category_type_id')
            ->leftJoin('fleet.fleet_placement AS f', 'f.id', '=', 'a.placement_id')
            ->leftJoin('ref_state AS e', 'e.id', '=', 'f.ref_state_id')
            ->join('ref_vehicle_status AS g', 'g.id', '=', 'a.vehicle_status_id')
            ->leftJoin('users.users AS h', 'h.id', '=', 'a.main_driver_id');

            $vehicleGrantList = DB::table('fleet.fleet_grant AS a')
            ->select(
                'a.id as id',
                'a.no_pendaftaran as no_pendaftaran',
                'a.vehicle_status_id as vehicle_status_id',
                'a.main_driver_id as main_driver_id',
                'b.name AS category_name',
                'c.name AS sub_category_name',
                'd.id AS sub_category_type_id',
                'd.name AS sub_category_type_name',
                'e.desc AS state_name',
                'f.desc AS placement_name',
                DB::raw('true AS is_grant')
                )
            ->leftJoin('ref_category AS b', 'b.id', '=', 'a.category_id')
            ->leftJoin('ref_sub_category AS c', 'c.id', '=', 'a.sub_category_id')
            ->leftJoin('ref_sub_category_type AS d', 'd.id', '=', 'a.sub_category_type_id')
            ->leftJoin('fleet.fleet_placement AS f', 'f.id', '=', 'a.placement_id')
            ->leftJoin('ref_state AS e', 'e.id', '=', 'f.ref_state_id')
            ->leftJoin('ref_vehicle_status AS g', 'g.id', '=', 'a.vehicle_status_id')
            ->leftJoin('users.users AS h', 'h.id', '=', 'a.main_driver_id');

            if($state_id){
                $vehicleList->where('f.ref_state_id',$state_id);
                $vehicleGrantList->where('f.ref_state_id',$state_id);
            }

            if($placement_id){
                $vehicleList->where('a.placement_id',$placement_id);
                $vehicleGrantList->where('a.placement_id',$placement_id);
            }

            if($sub_category_type_id){
                $vehicleList->where('a.sub_category_type_id',$sub_category_type_id);
                //$vehicleGrantList->where('a.sub_category_type_id',$sub_category_type_id);
            }

            if($search){
                Log::info(request('search'));

                $vehicleList->whereRaw("(lower(a.no_pendaftaran) LIKE '%".$search."%' OR lower(b.name) LIKE '%".$search."%' OR lower(c.name) LIKE '%".$search."%' OR lower(d.name) LIKE '%".$search."%')");
                $vehicleGrantList->whereRaw("(lower(a.no_pendaftaran) LIKE '%".$search."%' OR lower(b.name) LIKE '%".$search."%' OR lower(c.name) LIKE '%".$search."%' OR lower(d.name) LIKE '%".$search."%')");
            }

            $vehicleList->where([
                'a.is_maintenance' => false,
                'a.is_evaluation' => false,
                'g.code' => '01'
            ]);

            $vehicleGrantList->where([
                'a.is_maintenance' => false,
                'a.is_evaluation' => false
            ]);

            $vehicleList->union($vehicleGrantList);

            $vehicleList->orderBy('id', 'desc');
            Log::info($vehicleList->toSql());

            return view('logistic.tab.ajax.vehicle-list', [
                'vehicleList' => $vehicleList->paginate($limit)
            ]);

        })->name('.ajax.getVehicle');

        Route::get('/vehicle-grant-list', function(Request $request){
            $LogisticBookingDAO = new LogisticBookingDAO();
            return view('logistic.booking-vehicle-grant-list',[
                'booking_vehicle_grant_list' => $LogisticBookingDAO->vehicleGrantList($request),
            ]);
        })->name('.vehicle.grant.list');

        Route::post('/vehicle-save', function(Request $request){
            $LogisticBookingVehicleDAO = new LogisticBookingVehicleDAO();
            $LogisticBookingVehicleDAO->insert($request);
        })->name('.vehicle.save');

        Route::post('/vehicle-delete', function(Request $request){
            $LogisticBookingVehicleDAO = new LogisticBookingVehicleDAO();
            return $LogisticBookingVehicleDAO->delete($request);
        })->name('.vehicle.delete');

        Route::post('/vehicle-assign', function(Request $request){
            $LogisticBookingVehicleDAO = new LogisticBookingVehicleDAO();
            $LogisticBookingVehicleDAO->assign($request);
        })->name('.vehicle.assign');

        Route::post('/vehicle-passenger-save', function(Request $request){
            $LogisticBookingVehicleDAO = new LogisticBookingVehicleDAO();
            $LogisticBookingVehicleDAO->savePassenger($request);
        })->name('.vehicle.passenger.save');

        Route::post('/vehicle-passenger-upload', function(Request $request){
            $LogisticBookingVehicleDAO = new LogisticBookingVehicleDAO();
            $LogisticBookingVehicleDAO->uploadPassengerDoc($request);
        })->name('.vehicle.passenger.upload');

        Route::get('/vehicle-type-list', function(Request $request){
            $LogisticBookingDAO = new LogisticBookingDAO();
            $vehicleTypeList = $LogisticBookingDAO->vehicleTypeList($request);
            return view('logistic.tab.booking-vehicle-type-list', [
                'vehicleTypeList' => $vehicleTypeList
            ]);
        })->name('.vehicle-type.list');

        Route::get('/vehicle-type-unit-list', function(){

            $limit = request('limit') != null ? request('limit') : 5;
            $search = request('search') != null ? strtolower(request('search')) : null;
            $state_id = request('state_id') != null ? request('state_id') : null;
            $placement_id = request('placement_id') != null ? request('placement_id') : null;
            $branch_id = request('branch_id') != null ? request('branch_id') : null;
            $category_id = request('category_id') != null ? request('category_id') : null;
            $sub_category_id = request('sub_category_id') != null ? request('sub_category_id') : null;
            $vehicle_type_id = request('vehicle_type_id') != null ? request('vehicle_type_id') : null;

            $vehicleList = DB::table('fleet.fleet_department AS a')
            ->select(
                'a.id',
                'a.acqDt AS acqDt',
                'a.no_chasis AS chasis_no',
                'a.no_engine AS engine_no',
                'a.no_pendaftaran AS plat_number',
                'h.name AS brand_name',
                'i.name AS model_name',
                'b.name AS category_name',
                'c.name AS sub_category_name',
                'd.id AS sub_category_type_id',
                'd.name AS sub_category_type_name',
                'e.desc AS state_name',
                'f.desc AS placement_name',
                'g.doc_path_thumbnail AS thumb_url',
                'g.doc_name AS doc_name',
                'g.is_primary AS img_is_primary'
                )
            ->join('ref_category AS b', 'b.id', '=', 'a.category_id')
            ->leftJoin('ref_sub_category AS c', 'c.id', '=', 'a.sub_category_id')
            ->leftJoin('ref_sub_category_type AS d', 'd.id', '=', 'a.sub_category_type_id')
            ->leftJoin('fleet.fleet_placement AS f', 'f.id', '=', 'a.placement_id')
            ->leftJoin('ref_state AS e', 'e.id', '=', 'f.ref_state_id')
            ->leftJoin('kenderaans.dokumens AS g', function($join){
                $join->on('g.fleet_department_id', '=', 'a.id')
                ->where('g.is_primary', '=', true);
            })
            ->leftJoin('vehicles.brands AS h', 'h.id', '=' , 'a.brand_id')
            ->leftJoin('vehicles.vehicle_models AS i', 'i.id', '=' , 'a.model_id')
            ->join('ref_vehicle_status AS j', 'j.id', '=', 'a.vehicle_status_id');

            if($state_id){
                $vehicleList->where('a.state_id',$state_id);
            }

            if($placement_id){
                $vehicleList->where('a.placement_id',$placement_id);
            }

            if($branch_id){
                $vehicleList->where('a.cawangan_id',$branch_id);
            }

            if($category_id){
                $vehicleList->where('a.category_id',$category_id);
            }

            if($sub_category_id){
                $vehicleList->where('a.sub_category_id',$sub_category_id);
            }

            if($vehicle_type_id){
                $vehicleList->where('a.sub_category_type_id',$vehicle_type_id);
            }

            $vehicleList->where([
                'j.code' => '01'
            ]);

            if($search){
                Log::info(request('search'));

                $vehicleList->whereRaw("(lower(a.no_pendaftaran) LIKE '%".$search."%' OR lower(b.name) LIKE '%".$search."%' OR lower(c.name) LIKE '%".$search."%' OR lower(d.name) LIKE '%".$search."%')");
            }

            return view('logistic.tab.ajax.vehicle-by-type-unit-list', [
                'vehicleList' => $vehicleList->paginate($limit)
            ]);

        })->name('.vehicle-type-unit.list');

        Route::post('/vehicle-checkIsNeedDriver', function(Request $request){
            $LogisticBookingVehicleDAO = new LogisticBookingVehicleDAO();
            return $LogisticBookingVehicleDAO->checkIsNeedDriver($request);
        })->name('.vehicle.checkIsNeedDriver');

        Route::post('/vehicle-need-driver', function(Request $request){
            $LogisticBookingVehicleDAO = new LogisticBookingVehicleDAO();
            return $LogisticBookingVehicleDAO->needDriver($request);
        })->name('.vehicle.need.driver');

        Route::post('/vehicle-passenger-insert', function(Request $request){
            $LogisticBookingVehicleDAO = new LogisticBookingVehiclePassengerDAO();
            return $LogisticBookingVehicleDAO->insert($request);
        })->name('.vehicle.passenger.insert');

        Route::post('/vehicle-passenger-update', function(Request $request){
            $LogisticBookingVehicleDAO = new LogisticBookingVehiclePassengerDAO();
            return $LogisticBookingVehicleDAO->update($request);
        })->name('.vehicle.passenger.update');

        Route::post('/vehicle-passenger-delete', function(Request $request){
            $LogisticBookingVehicleDAO = new LogisticBookingVehiclePassengerDAO();
            return $LogisticBookingVehicleDAO->delete($request);
        })->name('.vehicle.passenger.delete');

        Route::get('/vehicle-type-with-passenger-list', function(Request $request){
            $LogisticBookingDAO = new LogisticBookingDAO();
            $passengerList = $LogisticBookingDAO->vehicleTypePassengerList($request);
            return view('logistic.tab.booking-vehicle-type-with-passenger-list', [
                'passengerList' => $passengerList
            ]);
        })->name('.vehicle-type-with-passenger.list');

        Route::get('/', function(Request $request){
            $LogisticBookingDAO = new LogisticBookingDAO();
            $LogisticBookingDAO->mount($request);
            $booking_list = $LogisticBookingDAO->booking_list;
            $search = $request->search ? $request->search : null;
            $search_date = $request->search_date ? $request->search_date : null;
            $searchid = $request->searchid ? $request->searchid : null;
            $page = $request->page;
            $limit = $request->limit;
            $offset = ($page - 1)*$limit;

            $totalProcess = $LogisticBookingDAO->totalProcess;
            $totalDraft = $LogisticBookingDAO->totalDraft;
            $totalVerification = $LogisticBookingDAO->totalVerification;
            $totalApproval = $LogisticBookingDAO->totalApproval;
            $totalCompleted = $LogisticBookingDAO->totalCompleted;
            $totalRejected = 0;

            $status_code = $request->status_code ? $request->status_code : 'all_inprogress';

            return view('logistic.booking-list',[
                'status_code' => $status_code,
                'totalProcess' => $totalProcess,
                'totalDraft' => $totalDraft,
                'totalVerification' => $totalVerification,
                'totalApproval' => $totalApproval,
                'totalCompleted' => $totalCompleted,
                'totalRejected' => $totalRejected,
                'booking_list' => $booking_list,
                'search' => $search,
                'page' => $page,
                'limit' => $limit,
                'offset' => $offset,
                'searchid' => $searchid,
                'search_date' => $search_date,
            ]);
        })->name('.list');

        Route::get('/register', function(){

            $booking_type_list = LogisticBookingType::all();
            $branches = RefOwner::whereHas('hasOwnerType', function($q){
                $q->where([
                    'status' => 1,
                    'display_for' => 'vehicle_register'
                ])->whereIn('code', ['01','02']);
            })->orderByRaw('code=\'0125\' desc, name asc')->get();

            return view('logistic.booking-register', [
                'booking_type_list' => $booking_type_list,
                'branches' => $branches
            ]);
        })->name('.register');

        Route::get('/register/{id}', function(){

            $booking_type_list = LogisticBookingType::all();
            $branches = RefOwner::whereHas('hasOwnerType', function($q){
                $q->where([
                    'status' => 1,
                    'display_for' => 'vehicle_register'
                ])->whereIn('code', ['01','02']);
            })->orderByRaw('code=\'0125\' desc, name asc')->get();

            return view('logistic.booking-register', [
                'booking_type_list' => $booking_type_list,
                'branches' => $branches
            ]);
        })->name('.detail');

        Route::post('/register-save', function(Request $request){

            $section = $request->input('section');
            $LogisticBookingDAO = new LogisticBookingDAO();
            switch ($section) {
                case 'detail':
                    return $LogisticBookingDAO->saveDetail($request);
                    break;

                case 'journey':
                    return $LogisticBookingDAO->saveJourney($request);
                    break;

                case 'info':
                    return $LogisticBookingDAO->saveInfo($request);
                    break;
            }
        })->name('.register.save');

        Route::post('/delete', function(Request $request){
            $LogisticBookingDAO = new LogisticBookingDAO();
            return $LogisticBookingDAO->delete($request);
        })->name('.delete');

        Route::post('/approval', function(Request $request){
            $LogisticBookingDAO = new LogisticBookingDAO();
            return $LogisticBookingDAO->submitForApproval($request);
        })->name('.approval');

        Route::post('/reject', function(Request $request){
            $LogisticBookingDAO = new LogisticBookingDAO();
            return $LogisticBookingDAO->reject($request);
        })->name('.reject');

        Route::post('/approve', function(Request $request){
            $LogisticBookingDAO = new LogisticBookingDAO();
            return $LogisticBookingDAO->approve($request);
        })->name('.approve');

        Route::get('/slip', function(Request $request){
            $LogisticBookingDAO = new LogisticBookingDAO();
            $qrImgUrl = $LogisticBookingDAO->generateQRCode($request);
            Log::info($qrImgUrl);
            return view('logistic.booking-slip', [
                'qrImgUrl' => $qrImgUrl
            ]);
        })->name('.slip');

    });

    Route::get('/ajax/getSupportDocs', function(){

        $is_display = request('is_display') ? request('is_display') : 0;
        $id = session()->get('booking_current_detail_id');
        $doc_type = 'booking_support_doc';
        $supportDocs = LogisticDocument::where([
            'ref_id' => $id,
            'doc_type' => $doc_type
        ]);

        Log::info($supportDocs);
        return view('logistic.tab.detail-support-docs', [
            'supportDocs' => $supportDocs,
            'is_display' => $is_display
        ]);
    })->name('.ajax.getSupportDocs');

    Route::post('/add-vehicle-type', function(Request $request){
        $LogisticBookingDAO = new LogisticBookingVehicleDAO();
        return $LogisticBookingDAO->insert($request);
    })->name('.add-vehicle-type');

    Route::get('/driver-task-list', function(){
        return view('logistic.driver-task.driver-tasklist');
    })->name('.driver-task');

    Route::get('/driver-task-detail', function(){
        return view('logistic.driver-task.driver-task');
    })->name('.driver-task.detail');

    Route::get('/driver-task-vehicle-list', function(Request $request){
        $LogisticTaskDriverDAO = new LogisticTaskDriverDAO();
        return view('logistic.driver-task.driver-task-vehicle-list', [
            'task_list' => $LogisticTaskDriverDAO->taskVehicleList($request)
        ]);
    })->name('.driver-task-vehicle');

    Route::get('/driver-task-vehicle-detail', function(){
        return view('logistic.driver-task.driver-task-vehicle');
    })->name('.driver-task-vehicle.detail');

    Route::post('/driver-task-scanqr', function(Request $request){
        $LogisticTaskDriverDAO = new LogisticTaskDriverDAO();
        return $LogisticTaskDriverDAO->scanQR($request);
    })->name('.driver.task.scanqr');

    Route::post('/driver-task-update', function(Request $request){
        $section = $request->section;
        $LogisticTaskDriverDAO = new LogisticTaskDriverDAO();
        switch ($section) {
        case 'update_task':
            return $LogisticTaskDriverDAO->driverUpdateTask($request);
            break;
        }
    })->name('.driver.task.update');

    Route::post('/driver-task-vehicle-update', function(Request $request){
        $section = $request->section;
        $LogisticTaskDriverDAO = new LogisticTaskDriverDAO();
        switch ($section) {
        case 'update_task':
            return $LogisticTaskDriverDAO->driverUpdateTaskVehicle($request);
            break;
        }
    })->name('.driver.task.vehicle.update');

    Route::post('/driver-task-done', function(Request $request){
        $LogisticTaskDriverDAO = new LogisticTaskDriverDAO();
        return $LogisticTaskDriverDAO->driverTaskDone($request);
    })->name('.driver.task.done');

    Route::post('/driver-task-vehicle-done', function(Request $request){
        $LogisticTaskDriverDAO = new LogisticTaskDriverDAO();
        return $LogisticTaskDriverDAO->driverTaskVehicleDone($request);
    })->name('.driver.task.vehicle.done');

    Route::group(['prefix' => 'disasterready', 'as' => '.disasterready'], function(){

        Route::get('/ajax/getVehicle', function(){

            $state_id = request('state_id') != null ? request('state_id') : null;
            $placement_id = request('placement_id') != null ? request('placement_id') : null;
            $search = request('search') != null ? strtolower(request('search')) : null;
            $limit = request('limit') != null ? request('limit') : 5;

            $vehicleList = DB::table('fleet.fleet_department AS a')
            ->select(
                'a.id',
                'a.no_pendaftaran',
                'a.main_driver_id',
                'b.name AS category_name',
                'c.name AS sub_category_name',
                'd.id AS sub_category_type_id',
                'd.name AS sub_category_type_name',
                'e.desc AS state_name',
                'f.desc AS placement_name',
                )
            ->join('ref_category AS b', 'b.id', '=', 'a.category_id')
            ->join('ref_sub_category AS c', 'c.id', '=', 'a.sub_category_id')
            ->join('ref_sub_category_type AS d', 'd.id', '=', 'a.sub_category_type_id')
            ->leftJoin('fleet.fleet_placement AS f', 'f.id', '=', 'a.placement_id')
            ->leftJoin('ref_state AS e', 'e.id', '=', 'f.ref_state_id')
            ->join('ref_vehicle_status AS g', 'g.id', '=', 'a.vehicle_status_id')
            ->leftJoin('users.users AS h', 'h.id', '=', 'a.main_driver_id');

            if($state_id){
                $vehicleList->where('f.ref_state_id',$state_id);
            }

            if($placement_id){
                $vehicleList->where('a.placement_id',$placement_id);
            }

            if($search){
                Log::info($search);

                $vehicleList->whereRaw("(lower(a.no_pendaftaran) LIKE '%".$search."%' OR lower(b.name) LIKE '%".$search."%' OR lower(c.name) LIKE '%".$search."%' OR lower(d.name) LIKE '%".$search."%')");
            }

            $vehicleList->where([
                'a.disaster_ready' => true,
                'a.is_maintenance' => false,
                'a.is_evaluation' => false,
                'g.code' => '01'
            ]);

            $vehicleList->orderBy('a.id', 'desc');
            Log::info($vehicleList->toSql());

            return view('logistic.tab.ajax.vehicle-list', [
                'vehicleList' => $vehicleList->paginate($limit)
            ]);

        })->name('.ajax.getVehicle');

        Route::get('/ajax/getVehicleType', function(){

            Log::info('masuk sini');

            $state_id = request('state_id') != null ? request('state_id') : null;
            $placement_id = request('placement_id') != null ? request('placement_id') : null;
            $branch_id = request('branch_id') != null ? request('branch_id') : null;
            $search = request('search') != null ? strtolower(request('search')) : null;
            $offset = request('offset') != null ? request('offset') : 0;
            $limit = request('limit') != null ? request('limit') : 5;

            $table = new FleetDepartment();
            $vehicleList = $table->setTable('fleet.fleet_department AS a')
            ->select(
                'f.ref_state_id',
                'a.cawangan_id as branch_id',
                'a.placement_id',
                'b.id AS category_id',
                'b.name AS category_name',
                'c.id AS sub_category_id',
                'c.name AS sub_category_name',
                'd.id AS sub_category_type_id',
                'd.name AS sub_category_type_name',
                DB::raw("(
                    select count(aa.id) from fleet.fleet_department aa
                    join ref_vehicle_status gg on gg.id = aa.vehicle_status_id
                        where
                        aa.sub_category_id = c.id
                        and aa.state_id = f.ref_state_id
                        and aa.placement_id = f.id
                        and gg.code = '01'
                        and aa.disaster_ready = true
                        and aa.sub_category_type_id is not null
                    )
                as total_sub_unit"),
                DB::raw("(
                    select count(aa.id) from fleet.fleet_department aa
                    join ref_vehicle_status gg on gg.id = aa.vehicle_status_id
                        where
                        aa.sub_category_type_id = d.id
                        and aa.state_id = f.ref_state_id
                        and aa.placement_id = f.id
                        and gg.code = '01'
                        and aa.disaster_ready = true
                        and aa.sub_category_type_id is not null
                    )
                as total_type_unit"),
                'e.desc AS state_name',
                'f.desc AS placement_name'
                )
            ->join('ref_category AS b', 'b.id', '=', 'a.category_id')
            ->leftJoin('ref_sub_category AS c', 'c.id', '=', 'a.sub_category_id')
            ->leftJoin('ref_sub_category_type AS d', 'd.id', '=', 'a.sub_category_type_id')
            ->join('fleet.fleet_placement AS f', 'f.id', '=', 'a.placement_id')
            ->leftJoin('ref_state AS e', 'e.id', '=', 'f.ref_state_id')
            ->join('ref_vehicle_status AS g', 'g.id', '=', 'a.vehicle_status_id');

            if($state_id){
                $vehicleList->where('a.state_id',$state_id);
            }

            if($placement_id){
                $vehicleList->where('a.placement_id',$placement_id);
            }

            if($branch_id){
                $vehicleList->where('h.id',$branch_id);
            }

            if($search){
                Log::info(request('search'));

                $vehicleList->whereRaw("(lower(b.name) LIKE '%".$search."%' OR lower(c.name) LIKE '%".$search."%' OR lower(d.name) LIKE '%".$search."%')");
            }

            $vehicleList->where([
                'a.disaster_ready' => true,
                'g.code' => '01'
            ]);

            $vehicleList->whereNotNull('a.sub_category_type_id');

            $vehicleList->groupByRaw("d.id, f.id, a.cawangan_id, a.placement_id, c.id, b.id, e.id");

            $vehicleList->orderBy('d.id', 'desc');
            Log::info($vehicleList->toSql());

            return view('logistic.tab.ajax.vehicle-by-type-list', [
                'vehicleList' => $vehicleList->paginate($limit)
            ]);

        })->name('.ajax.getVehicleType');

        Route::get('/vehicle-type-unit-list', function(){

            $limit = request('limit') != null ? request('limit') : 5;
            $search = request('search') != null ? strtolower(request('search')) : null;
            $state_id = request('state_id') != null ? request('state_id') : null;
            $placement_id = request('placement_id') != null ? request('placement_id') : null;
            $vehicle_type_id = request('vehicle_type_id') != null ? request('vehicle_type_id') : null;

            $vehicleList = DB::table('fleet.fleet_department AS a')
            ->select(
                'a.id',
                'a.acqDt AS acqDt',
                'a.no_chasis AS chasis_no',
                'a.no_engine AS engine_no',
                'a.no_pendaftaran AS plat_number',
                'h.name AS brand_name',
                'i.name AS model_name',
                'b.name AS category_name',
                'c.name AS sub_category_name',
                'd.id AS sub_category_type_id',
                'd.name AS sub_category_type_name',
                'e.desc AS state_name',
                'f.desc AS placement_name',
                'g.doc_path_thumbnail AS thumb_url',
                'g.doc_name AS doc_name',
                'g.is_primary AS img_is_primary'
                )
            ->join('ref_category AS b', 'b.id', '=', 'a.category_id')
            ->leftJoin('ref_sub_category AS c', 'c.id', '=', 'a.sub_category_id')
            ->leftJoin('ref_sub_category_type AS d', 'd.id', '=', 'a.sub_category_type_id')
            ->leftJoin('fleet.fleet_placement AS f', 'f.id', '=', 'a.placement_id')
            ->leftJoin('ref_state AS e', 'e.id', '=', 'f.ref_state_id')
            ->leftJoin('kenderaans.dokumens AS g', function($join){
                $join->on('g.fleet_department_id', '=', 'a.id')
                ->where('g.is_primary', '=', true);
            })
            ->leftJoin('vehicles.brands AS h', 'h.id', '=' , 'a.brand_id')
            ->leftJoin('vehicles.vehicle_models AS i', 'i.id', '=' , 'a.model_id');

            if($state_id){
                $vehicleList->where('f.ref_state_id',$state_id);
            }

            if($placement_id){
                $vehicleList->where('a.placement_id',$placement_id);
            }

            if($vehicle_type_id){
                $vehicleList->where('a.sub_category_type_id',$vehicle_type_id);
            }

            if($search){
                Log::info(request('search'));

                $vehicleList->whereRaw("(lower(a.no_pendaftaran) LIKE '%".$search."%' OR lower(b.name) LIKE '%".$search."%' OR lower(c.name) LIKE '%".$search."%' OR lower(d.name) LIKE '%".$search."%')");
            }

            $vehicleList->where('a.disaster_ready',true);

            return view('logistic.tab.ajax.vehicle-by-type-unit-list', [
                'vehicleList' => $vehicleList->paginate($limit)
            ]);

        })->name('.vehicle-type-unit.list');

        Route::get('/ajax/getVehicle/total', function(){

            $search = request('search') != null ? request('search') : null;
            $offset = request('offset') != null ? request('offset') : 0;
            $limit = request('limit') != null ? request('limit') : 5;

            $vehicleList = FleetLookupVehicleDisasterReady::orderBy('id');
            if($search){
                Log::info(request('search'));
                $vehicleList->whereRaw("upper(no_pendaftaran) LIKE '%".strtoupper($search)."%' ");
            }

            return [
                'total' => $vehicleList->count()
            ];

        })->name('.ajax.getVehicle.total');

        Route::get('/', function(Request $request){
            $DisasterReadyDAO = new DisasterReadyDAO();
            $DisasterReadyDAO->mount($request);
            $booking_list = $DisasterReadyDAO->booking_list;
            $search = $request->search;
            $page = $request->page;
            $limit = $request->limit;
            $offset = ($page - 1)*$limit;

            $totalProcess = $DisasterReadyDAO->totalProcess;
            $totalDraft = $DisasterReadyDAO->totalDraft;
            $totalVerification = $DisasterReadyDAO->totalVerification;
            $totalApproval = $DisasterReadyDAO->totalApproval;
            $totalCompleted = $DisasterReadyDAO->totalCompleted;
            $totalRejected = 0;

            $status_code = $request->status_code ? $request->status_code : 'all_inprogress';

            return view('logistic.disasterready-list',[
                'status_code' => $status_code,
                'totalProcess' => $totalProcess,
                'totalDraft' => $totalDraft,
                'totalVerification' => $totalVerification,
                'totalApproval' => $totalApproval,
                'totalCompleted' => $totalCompleted,
                'totalRejected' => $totalRejected,
                'booking_list' => $booking_list,
                'search' => $search,
                'page' => $page,
                'limit' => $limit,
                'offset' => $offset,
            ]);
        })->name('.list');

        Route::get('/register', function () {
            return view('logistic.disasterready-register');
        })->name('.register');

        Route::get('/register/{id}', function(){
            return view('logistic.disasterready-register');
        })->name('.detail');

        Route::post('/vehicle-checkIsNeedDriver', function(Request $request){
            $LogisticDisasterReadyVehicleDAO = new LogisticDisasterReadyVehicleDAO();
            return $LogisticDisasterReadyVehicleDAO->checkIsNeedDriver($request);
        })->name('.vehicle.checkIsNeedDriver');

        Route::post('/vehicle-need-driver', function(Request $request){
            $LogisticDisasterReadyVehicleDAO = new LogisticDisasterReadyVehicleDAO();
            return $LogisticDisasterReadyVehicleDAO->needDriver($request);
        })->name('.vehicle.need.driver');

        Route::post('/vehicle-save', function(Request $request){
            $LogisticBookingVehicleDAO = new LogisticDisasterReadyVehicleDAO();
            return $LogisticBookingVehicleDAO->insert($request);
        })->name('.vehicle.save');

        Route::post('/vehicle-delete', function(Request $request){
            $LogisticDisasterReadyVehicleDAO = new LogisticDisasterReadyVehicleDAO();
            return $LogisticDisasterReadyVehicleDAO->delete($request);
        })->name('.vehicle.delete');

        Route::post('/vehicle-assign', function(Request $request){
            $LogisticBookingVehicleDAO = new LogisticDisasterReadyVehicleDAO();
            $LogisticBookingVehicleDAO->assign($request);
        })->name('.vehicle.assign');

        Route::post('/register-save', function(Request $request){

            $section = $request->input('section');
            $DisasterReadyDAO = new DisasterReadyDAO();
            switch ($section) {
                case 'detail':
                    return $DisasterReadyDAO->saveDetail($request);
                    break;

                case 'journey':
                    return $DisasterReadyDAO->saveJourney($request);
                    break;
            }
        })->name('.register.save');

        Route::post('/delete', function(Request $request){
            $DisasterReadyDAO = new DisasterReadyDAO();
            return $DisasterReadyDAO->delete($request);
        })->name('.delete');

        Route::post('/approval', function(Request $request){
            $DisasterReadyDAO = new DisasterReadyDAO();
            return $DisasterReadyDAO->submitForApproval($request);
        })->name('.approval');

        Route::post('/reject', function(Request $request){
            $DisasterReadyDAO = new DisasterReadyDAO();
            return $DisasterReadyDAO->reject($request);
        })->name('.reject');

        Route::post('/approve', function(Request $request){
            $DisasterReadyDAO = new DisasterReadyDAO();
            return $DisasterReadyDAO->approve($request);
        })->name('.approve');

        Route::get('/slip', function(Request $request){
            $DisasterReadyDAO = new DisasterReadyDAO();
            $qrImgUrl = $DisasterReadyDAO->generateQRCode($request);
            Log::info($qrImgUrl);
            return view('logistic.disasterready-slip', [
                'qrImgUrl' => $qrImgUrl
            ]);
        })->name('.slip');

        Route::get('/vehicle-list', function(Request $request){
            $DisasterReadyDAO = new DisasterReadyDAO();
            return view('logistic.disasterready-vehicle-list',[
                'disasterready_vehicle_list' => $DisasterReadyDAO->vehicleList($request),
            ]);
        })->name('.vehicle.list');

        Route::get('/vehicle-list-excel', function(Request $request){
            $DisasterReadyDAO = new DisasterReadyDAO();
            $obj = $DisasterReadyDAO->vehicleReportList($request);
            return view('logistic.disasterready-vehicle-list-excel', $obj);
        })->name('.vehicle.list.excel');

        Route::get('/vehicle-type-list', function(Request $request){
            $DisasterReadyDAO = new DisasterReadyDAO();
            $vehicleTypeList = $DisasterReadyDAO->vehicleTypeList($request);
            return view('logistic.tab.disasterready-vehicle-type-list', [
                'vehicleTypeList' => $vehicleTypeList
            ]);
        })->name('.vehicle-type.list');

    });

    Route::get('/ajax/getDRSupportDocs', function(){

        $is_display = request('is_display') ? request('is_display') : 0;
        $id = session()->get('disasterready_current_detail_id');
        $doc_type = 'booking_support_doc';
        $supportDocs = DisasterReadyDocument::where([
            'ref_id' => $id,
            'doc_type' => $doc_type
        ]);

        Log::info($supportDocs);
        return view('logistic.tab.detail-disasterready-support-docs.blade', [
            'supportDocs' => $supportDocs,
            'is_display' => $is_display
        ]);
    })->name('.ajax.getDRSupportDocs');

});
