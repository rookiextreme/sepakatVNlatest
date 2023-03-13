<?php

use App\Http\Controllers\Vehicle\Summon\FormMaklumatKenderaan;
use App\Http\Controllers\Vehicle\Summon\FormMaklumatSaman;
use App\Http\Controllers\Vehicle\Summon\PembayaranSaman;
use App\Http\Controllers\Vehicle\VehicleDAO;
use App\Http\Controllers\Vehicle\VehicleHistoryDAO;
use App\Http\Controllers\Vehicle\VehicleRegister;
use App\Models\Fleet\FleetDepartment;
use App\Models\Fleet\FleetEventHistory;
use App\Models\Fleet\FleetLookupVehicle;
use App\Models\Fleet\FleetPublic;
use App\Models\FleetPlacement;
use App\Models\Kenderaan\Pendaftaran;
use App\Models\Location\Daerah;
use App\Models\RefBranch;
use App\Models\RefCategory;
use App\Models\RefDistrict;
use App\Models\RefDivision;
use App\Models\RefOwner;
use App\Models\RefOwnerType;
use App\Models\RefSubCategory;
use App\Models\RefSubCategoryType;
use App\Models\Saman\MaklumatKenderaanSaman;
use App\Models\Saman\MaklumatSaman;
use App\Models\Saman\Pengguna\DokumenPembayaran;
use App\Models\Saman\Pengguna\MaklumatPembayaran;
use App\Models\Saman\Status\StatusSaman;
use App\Models\Saman\SummonDocument;
use App\Models\User;
use App\Models\Vehicle\VehicleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Calculation\LookupRef\Offset;

Route::group(['prefix' => 'vehicle', 'as' => 'vehicle', 'middleware' => 'auth'], function(){

Route::get('/ajax/list/', function(){

    $xmode = request('xmode') ? request('xmode') : 'list';
    $status = request('status') ? request('status') : '';
    $ownership = request('ownership') ? request('ownership') : 'jkr';
    $fleetView = request('fleet_view') ? request('fleet_view') : 'department';

    $vehicleDAO = new VehicleDAO();
    Log::info($fleetView);
    Log::info('$status --> '.$status);

    if($status){
        $hasPaging = false;
        $vehicleList = $vehicleDAO->getList($status, $hasPaging);
    } else {
        switch ($fleetView) {
            case 'department':
                $vehicleList = $vehicleDAO->getFleetDepartment($xmode);
                break;
            case 'public':
                $vehicleList = $vehicleDAO->getFleetPublic($xmode);
                break;
            case 'disposal':
                $vehicleList = $vehicleDAO->getFleetDisposal($xmode);
                break;
        }
    }

    return $vehicleList;
})->name('.ajax.list');

Route::get('/list', function(){

    $searchParam = request('searchParam') != null ? request('searchParam') : '';

    Log::info($searchParam);

    return view('vehicle.vehicle-list', ['searchParam' => $searchParam]);
})->name('.list');

Route::get('/list-alternate', function(Request $request){
//    echo '<pre>';
//    print_r($request->all());
//    echo '</pre>';
//    die();
    $ownerId = $request->owner_id ? $request->owner_id : null;

    if(Auth::user()->detail->branch_id){
        $ownerId = Auth::user()->detail->branch_id;
    }

    Log::info('$ownerId => '.$ownerId);

    if($ownerId > 0){
        session()->put('session_v_list_owner_id', $ownerId);
    } else {
        session()->put('session_v_list_owner_id', null);
    }

    if($request->state_id > 0){
        session()->put('session_v_list_state_id', $request->state_id);
    } else {
        session()->put('session_v_list_state_id', null);
    }

    if($request->type_id > 0){
        session()->put('session_v_list_type_id', $request->type_id);
    } else {
        session()->put('session_v_list_type_id', null);
    }

    $fleet_view = $request->fleet_view;
    $search = $request->search;
    $limit = $request->limit ? $request->limit : 10;
    $page = $request->page ? $request->page : 0;
    $offset = $page > 0 ? $limit * $page: 0;
    $xid = $request->xid;
    $status = $request->status ? $request->status: 'approved';
    $owner_type_code = $request->owner_type_code ? $request->owner_type_code : '00';
    $ownerType = RefOwnerType::where([
        'display_for' => 'vehicle_register',
        'code' => $owner_type_code
    ])->first();

    $queryOwner = "";
    $queryState = "";

    if($ownerId){
        $queryOwner = " and a.cawangan_id =".$ownerId;
    }

    if($ownerId && $request->state_id){
        $queryState = " and a.state_id =".$request->state_id." and a.cawangan_id =".$ownerId;
    }elseif($ownerId){
        $queryState = " and a.cawangan_id =".$ownerId;
    }elseif($request->state_id){
        $queryState = " and a.state_id =".$request->state_id;
    }

    $mapStatus = [
        'draf' => '2',
        'verification' => '3',
        'approval' => '4',
        'approved' => '7'
    ];

    $queryOwnerTypeBy = "";

    if($ownerType){
        $queryOwnerTypeBy = "and a.owner_type_id =".$ownerType->id;
    }

//    print_r($queryOwner);
//    die();
    $ownerList = DB::select('select b.id, b."name", count(*) AS total from fleet.fleet_department a
    JOIN public.ref_owner b ON b.id = a.cawangan_id
    where a.vapp_status_id IN ('.$mapStatus[$status].')
    '.$queryOwnerTypeBy.'
    GROUP BY b.id, b."name"
    ORDER BY b.code');

    $stateList = DB::select('select b.id, b."desc" AS name, count(*) AS total from fleet.fleet_department a
    JOIN public.ref_state b ON b.id = a.state_id
    where a.vapp_status_id IN ('.$mapStatus[$status].')
    '.$queryOwner.'
    '.$queryOwnerTypeBy.'
    GROUP BY b.id, b."desc"
    ORDER BY b.code');

    $typeList = DB::select('select b.id, b."name", count(*) AS total from fleet.fleet_department a
    JOIN public.ref_sub_category_type b ON b.id = a.sub_category_type_id
    where a.vapp_status_id IN ('.$mapStatus[$status].')
    '.$queryState.'
    '.$queryOwnerTypeBy.'
    GROUP BY b.id, b."name"
    ORDER BY b.code');

    if($fleet_view == null){
        $fleet_view = 'department';
    }

    if($limit == null){
        $limit = 10;
    }

    if($search == null || $search == ''){
        $search = '';
    }

    $vehicleDAO = new VehicleDAO();
    $listFleets = $vehicleDAO->getTotalVehicle($status,$search,$fleet_view,$offset,$limit, $xid, $ownerType, $request);
    $totalFleet = $vehicleDAO->getTotalVehicleNoOffset($status,$search,$fleet_view, $xid, $ownerType, $request);

    Log::info("search param : ".$search);

    $ownerListMsg = [];
    $ownerListRaw = RefOwner::whereHas('hasOwnerType', function($q){
        $q->where([
            'display_for' => 'vehicle_register'
        ])->whereIn('code', ['01','02'])->orderBy('code');
    });
    foreach ($ownerListRaw->get() as $key) {
        $obj = array(
            'id' => $key->id,
            'name' => $key->name,
            'total' => 0
        );

        foreach ($ownerList as $owner) {
           if($owner->id == $key->id){
                $obj['total'] = $owner->total;
           }
        }

        array_push($ownerListMsg, $obj);
    }

    return view('vehicle.vehicle-list-alternate', [
        'ownerList' => $ownerListMsg,
        'stateList' => $stateList,
        'typeList' => $typeList,
        'searchParam' => $search,
        'listFleets' => $listFleets,
        'page' => $page,
        'offset'=> $offset,
        'limit'=> $limit,
        'fleet_view' => $fleet_view,
        'total_fleet' => count($totalFleet),
        'owner_type_code' => $owner_type_code,
    ]);
})->name('.list-alternate');


Route::get('/list-external-count', function(Request $request){

    $plateNumber = $request->plateNumber;
    $fleetId = $request->fleetId;
    $vehicleDAO = new VehicleDAO();

    $results = $vehicleDAO->externalCount($plateNumber, $fleetId);

    return $results[0];

})->name('.list-external-count');


Route::get('/export/excel', function(Request $request){
    $vehicleDAO = new VehicleDAO();
    return $vehicleDAO->exportExcel($request);
})->name('.export.excel');

Route::get('/register', function(Request $request){
    if($request->fleet_view == 'grant') {
        return view('vehicle.vehicle-grant-register');
    } else {
        return view('vehicle.vehicle-register');
    }
    
})->name('.register');

Route::get('/history', function(){
    return view('vehicle.vehicle-history');
})->name('.history');

Route::get('/onepagedetail', function(){
    return view('vehicle.vehicle-detail');
})->name('.onepagedetail');


Route::post('/addEventHistory', function(Request $request){
    $VehicleHistoryDAO = new VehicleHistoryDAO();
    return $VehicleHistoryDAO->addEventHistory($request);
})->name('.addEventHistory');

Route::get('/history-next-activity', function(Request $request){
    $eventHistoryList = FleetEventHistory::whereIn('id', $request->event_ids)->get();
    $fleet_view = $request->fleet_view;
    return view('vehicle.vehicle-history-month.next_activity_list', ['eventHistoryList' => $eventHistoryList, 'fleet_view' => $fleet_view]);
})->name('.history.next-activity');

Route::get('/ajax/getCategory', function(){
    $category = RefCategory::where('id', request('category'));
    Log::info("category : ".$category->toSql());
    return $category->first();
})->name('.ajax.getCategory');

Route::get('/ajax/getSubCategory', function(){
    $subcategoryList = RefSubCategory::where([
        'category_id' => request('category_id'),
        'status' => 1
    ]);
    Log::info("subcategoryList : ".$subcategoryList->toSql());
    return $subcategoryList->get();
})->name('.ajax.getSubCategory');

Route::get('/ajax/getSubCategoryType', function(){
    $subcategoryTypeList = RefSubCategoryType::where([
        'sub_category_id' => request('sub_category_id'),
        'status' => 1
    ]);
    Log::info("subcategoryTypeList : ".$subcategoryTypeList->toSql());

    return $subcategoryTypeList->get();
})->name('.ajax.getSubCategoryType');

Route::get('/ajax/getVehicleModel', function(){
    $vehicleModelList = VehicleModel::where('brand_id', request('brand_id'));
    Log::info("vehicleModelList : ".$vehicleModelList->toSql());
    return $vehicleModelList->get();
})->name('.ajax.getVehicleModel');

Route::get('/ajax/getModalVehicleImages', function(Request $request){
    $fleetView = $request->fleet_view ? $request->fleet_view : 'department';
    $vehicleId = $request->vehicle_id ? $request->vehicle_id : session()->get('vehicle_current_detail_id');
    Log::info($vehicleId);
    Log::info($fleetView);

    $doc_type = "gambarKenderaan";

    switch ($fleetView) {
        case 'department':
            $vehicleImages = DB::select(DB::raw("select b.id, b.fleet_department_id AS vehicle_id, b.doc_name, b.doc_desc, b.doc_path, b.doc_path_thumbnail AS thumb_url, b.is_primary from fleet.fleet_department a
            join kenderaans.dokumens b ON b.fleet_department_id = a.id
            where a.id = ".$vehicleId." and b.doc_type = '".$doc_type."' order by b.is_primary desc"));
            break;
        case 'public':
            $vehicleImages = DB::select(DB::raw("select b.id, b.fleet_public_id AS vehicle_id, b.doc_name, b.doc_desc, b.doc_path, b.doc_path_thumbnail AS thumb_url, b.is_primary from fleet.fleet_public a
            join kenderaans.dokumens b ON b.fleet_public_id = a.id
            where a.id = ".$vehicleId." and b.doc_type = '".$doc_type."' order by b.is_primary desc"));
            break;
    }

    Log::info($vehicleImages);
    return view('vehicle.vehicle-images', [
        'vehicleImages' => $vehicleImages
    ]);
})->name('.ajax.getModalVehicleImages');

Route::get('/ajax/getVehicleImages', function(Request $request){
    $fleetView = $request->fleet_view ? $request->fleet_view : 'department';
    $is_display = $request->is_display ? $request->is_display : 0;
    $vehicleId = $request->vehicle_id ? $request->vehicle_id : session()->get('vehicle_current_detail_id');
    Log::info($vehicleId);
    Log::info($fleetView);

    $doc_type = "gambarKenderaan";

    switch ($fleetView) {
        case 'department':
            $vehicleImages = DB::select(DB::raw("select b.id, b.fleet_department_id AS vehicle_id, b.doc_name, b.doc_desc, b.doc_path, b.doc_path_thumbnail AS thumb_url, b.is_primary from fleet.fleet_department a
            join kenderaans.dokumens b ON b.fleet_department_id = a.id
            where a.id = ".$vehicleId." and b.doc_type = '".$doc_type."' order by b.is_primary desc"));
            break;
        case 'public':
            $vehicleImages = DB::select(DB::raw("select b.id, b.fleet_public_id AS vehicle_id, b.doc_name, b.doc_desc, b.doc_path, b.doc_path_thumbnail AS thumb_url, b.is_primary from fleet.fleet_public a
            join kenderaans.dokumens b ON b.fleet_public_id = a.id
            where a.id = ".$vehicleId." and b.doc_type = '".$doc_type."' order by b.is_primary desc"));
            break;
        case 'disposal':
            $vehicleImages = DB::select(DB::raw("select b.id, b.fleet_disposal_id AS vehicle_id, b.doc_name, b.doc_desc, b.doc_path, b.doc_path_thumbnail AS thumb_url, b.is_primary from fleet.fleet_disposal a
            join kenderaans.dokumens b ON b.fleet_disposal_id = a.id
            where a.id = ".$vehicleId." and b.doc_type = '".$doc_type."' order by b.is_primary desc"));
            break;
    }

    Log::info($vehicleImages);
    return view('vehicle.tab.detail-vehicle-images', [
        'vehicleImages' => $vehicleImages,
        'is_display' => $is_display
    ]);
})->name('.ajax.getVehicleImages');

Route::get('/ajax/getBranchOwner', function(Request $request){
    $branchOwnerList = RefOwner::where([
        'owner_type_id' => $request->owner_type_id,
        'status' => 1
    ])->get();
    Log::info($branchOwnerList);
    return $branchOwnerList;
})->name('.ajax.getBranchOwner');

Route::get('/ajax/getDivision', function(){
    $branchList = RefDivision::where('branch_id', request('reg_negeri'))->get();
    return $branchList;
})->name('.ajax.getDivision');

Route::get('/ajax/getDistrict', function(){
    $districtList = RefDistrict::select('id', 'desc', 'code', 'state_id')->where('state_id', request('state_id'))->get();
    return $districtList;
})->name('.ajax.getDistrict');

Route::get('/ajax/getPlacement', function(){
    $branchList = FleetPlacement::where('ref_state_id', request('reg_negeri'))->get();
    return $branchList;
})->name('.ajax.getPlacement');

Route::post('/checkExistColumnValue', function(Request $request){
    Log::info('/checkExistColumnValue :: vehicle_current_detail_id -->'.session()->get('vehicle_current_detail_id'));
    $queryCheckExistColumnValue = FleetLookupVehicle::where($request->column, $request->value)
    ->whereNotNull($request->column)
    ->where('id', '!=', session()->get('vehicle_current_detail_id'))
    ->whereHas('vAppStatus', function($q){
        $q->whereNotIn('code', ['00']);
    });
    Log::info($queryCheckExistColumnValue->toSql());
    Log::info($queryCheckExistColumnValue->first());
    return $queryCheckExistColumnValue->first() ? 1 : 0;
})->name('.checkExistColumnValue');

Route::post('/checkExistRegNumber', function(Request $request){
    $queryRegNumberIsExisted = FleetLookupVehicle::where('no_pendaftaran', $request->reg_no)
    ->where('id', '!=', session()->get('vehicle_current_detail_id'))
    ->whereHas('vAppStatus', function($q){
        $q->whereNotIn('code', ['00']);
    })
    ;
    Log::info($queryRegNumberIsExisted->toSql());
    return $queryRegNumberIsExisted->first() ? 1 : 0;
})->name('.checkExistRegNumber');

Route::post('/checkExistRegNumberPublic', function(Request $request){
    $queryRegNumberIsExisted = FleetPublic::where('no_pendaftaran', $request->reg_no)->where('id', '!=', session()->get('vehicle_current_detail_id'))
                                            ->whereUserId(auth()->user()->id);
    Log::info($queryRegNumberIsExisted->toSql());
    return $queryRegNumberIsExisted->first() ? 1 : 0;
})->name('.checkExistRegNumberPublic');

Route::post('/register-save', function(Request $request){

    $section = $request->input('section');
    $VehicleRegisterDAO = new VehicleRegister();
    switch ($section) {
        case 'detail':

            return $VehicleRegisterDAO->saveDetail($request);
            break;

        case 'info':
            return $VehicleRegisterDAO->saveInfo($request);
            break;

        case 'addon':
            return $VehicleRegisterDAO->saveAddon($request);
            break;
    }
})->name('.register.save');

Route::post('/upload-image', function(Request $request){
    $VehicleRegisterDAO = new VehicleRegister();
    return $VehicleRegisterDAO->uploadVehicleImage($request);
})->name('.upload.image');

Route::post('/delete-image', function(Request $request){
    $VehicleRegisterDAO = new VehicleRegister();
    return $VehicleRegisterDAO->deleteVehicleImage($request);
})->name('.delete.image');

Route::post('/verification', function(Request $request){
    $VehicleRegisterDAO = new VehicleRegister();
    return $VehicleRegisterDAO->submitForVerification($request);
})->name('.verification');

Route::post('/approval', function(Request $request){
    $VehicleRegisterDAO = new VehicleRegister();
    return $VehicleRegisterDAO->submitForApproval($request);
})->name('.approval');

Route::post('/approve', function(Request $request){
    $VehicleRegisterDAO = new VehicleRegister();
    return $VehicleRegisterDAO->approve($request);
})->name('.approve');

Route::post('/delete', function(Request $request){

    $VehicleRegisterDAO = new VehicleRegister();
    return $VehicleRegisterDAO->deleteVehicle($request);

})->name('.delete');

Route::post('/change-ownership', function(Request $request){
    $VehicleRegisterDAO = new VehicleRegister();
    return $VehicleRegisterDAO->changeOwnerShip($request);
})->name('.changeOwnerShip');

Route::post('/declareForDisasterReady', function(Request $request){

    $VehicleRegisterDAO = new VehicleRegister();
    return $VehicleRegisterDAO->declareForDisasterReady($request);

})->name('.declareForDisasterReady');

Route::post('/undeclareForDisasterReady', function(Request $request){

    $VehicleRegisterDAO = new VehicleRegister();
    return $VehicleRegisterDAO->undeclareForDisasterReady($request);

})->name('.undeclareForDisasterReady');

Route::post('/dispose', function(Request $request){
    $VehicleRegisterDAO = new VehicleRegister();
    return $VehicleRegisterDAO->dispose($request);
})->name('.dispose.save');

Route::post('/undispose', function(Request $request){
    $VehicleRegisterDAO = new VehicleRegister();
    return $VehicleRegisterDAO->undispose($request);
})->name('.undispose.save');

Route::get('/register/{id}', function(Request $request){
    if($request->fleet_view == 'grant') {
        return view('vehicle.vehicle-grant-register');
    } else {
        return view('vehicle.vehicle-register');
    }
})->name('.register.detail');

Route::get('/archive', function(){
    return view('vehicle.archive');
})->name('.archive');

Route::get('/overview', function(){
    return view('vehicle.vehicle-overview');
})->name('.overview');

Route::get('/report', function(){
    return view('vehicle.vehicle-report');
})->name('.report');

Route::group(['prefix' => 'saman', 'as' => '.saman', 'middleware' => 'auth'], function(){

    Route::get('/rekod', function(Request $request){

        $branchid = $request->branch_id ? $request->branch_id : null;

        if(Auth::user()->detail->hasBranch){
            $branchid = Auth::user()->detail->hasBranch->id;
        }

        $summon_list = MaklumatKenderaanSaman::whereHas('pendaftaran')->orderBy('created_at', 'desc');

        if($request->vehicle_id){
            $summon_list->where('pendaftaran_id', $request->vehicle_id);
        }

        Log::info(' $branchid=> '.$branchid);

        if($branchid){
            $summon_list->whereHas('pendaftaran', function($q) use($branchid){
                $q->where('cawangan_id', $branchid);
            });
        }

        switch ($request->status) {
            case 'in_progress':
                $summon_list->whereHas('statusSaman', function($q){
                    return $q->whereIn('code', ["02","05"]);
                });
                break;
            case 'all_done':
                $summon_list->whereHas('statusSaman', function($q){
                    return $q->whereIn('code', ["03","04"]);
                });
                break;
            case 'payment_done':
                $summon_list->whereHas('statusSaman', function($q){
                    return $q->whereIn('code', ["03"]);
                });
                break;

            case 'is_chg_ownership':
                $summon_list->whereHas('statusSaman', function($q){
                    return $q->whereIn('code', ["04"]);
                });
                break;

            default:
                $summon_list->whereHas('statusSaman', function($q){
                    return $q->whereIn('code', ["01","02","03","04","05"]);
                });
                break;
        }

        if($request->search){
            $summon_list->whereHas('pendaftaran', function($q) use($request){
                return $q->whereRaw("upper(no_pendaftaran) LIKE '%".strtoupper($request->search)."%' ");
            });
        }

        $branch_list = RefOwner::whereHas('hasOwnerType', function($q){
            $q->where([
                'display_for' => 'vehicle_register'
            ])->whereIn('code', ['01','02'])->orderBy('code');
        });

        return view('vehicle.saman.rekod-saman', [
            'branch_list' => $branch_list->get(),
            'summon_list' => $summon_list->paginate($request->limit ?: 5)
        ]);
    })->name('.rekod');

    Route::get('/export/excel', function(Request $request){
        $vehicleSummonDAO = new FormMaklumatSaman();
        return $vehicleSummonDAO->exportExcel($request);
    })->name('.export.excel');

    Route::get('/daftar', function(){
        return view('vehicle.saman.daftar-saman');
    })->name('.daftar');

    Route::get('/rekodbayar', function(){
        $summon_list = MaklumatKenderaanSaman::orderBy('created_at', 'desc')

        ->whereHas('statusSaman', function($q){
            $q->whereIn('code', ["02","03","04"]);
            return $q;
        });

        // $summon_list->whereHas('pendaftaran', function($q){
        //     $q->where('person_incharge_id', Auth::user()->id);
        // });

        $summon_list->whereHas('pendaftaran', function($q){
            $q->where('user_id', Auth::user()->id);
        });

        //$summon_list->where('user_id', Auth::user()->id);

        if(Request('vehicle_id')){
            $summon_list->where('pendaftaran_id', Request('vehicle_id'));
        }

        Log::info($summon_list->toSql());

        return view('vehicle.saman.rekod-bayar', [
            'summon_list' => $summon_list->paginate(5)
        ]);
    })->name('.rekodbayar');

    Route::get('/daftarbayar/{id}', function(){
        return view('vehicle.saman.daftar-bayar');
    })->name('.daftarbayar');

    Route::post('/receipt/upload', function(Request $request){
        $PembayaranSamanDAO = new PembayaranSaman();
        return $PembayaranSamanDAO->imageUploadPost($request);
    })->name('.receipt.upload.post');

    Route::get('/ajax/getVehicle', function(){

        $search = request('search') != null ? request('search') : null;
        $limit = request('limit') != null ? request('limit') : 5;

        //$vehicleList = Pendaftaran::offset($offset*$limit)->limit($limit)->orderBy('created_at', 'asc');
        $vehicleList = FleetLookupVehicle::orderBy('id', 'desc');
        Log::info($vehicleList->toSql());
        if($search){
            Log::info(request('search'));
            $vehicleList->whereRaw("upper(no_pendaftaran) LIKE '%".strtoupper($search)."%' ");
            return view('vehicle.saman.ajax.vehicle-list', [
                'vehicleList' => $vehicleList->paginate($limit)
            ]);
        } else {
            return view('vehicle.saman.ajax.vehicle-list', [
                'vehicleList' => $vehicleList->where('id',-1)->paginate($limit)
            ]);
        }


    })->name('.ajax.getVehicle');

    Route::get('/ajax/getVehicle/total', function(){

        $search = request('search') != null ? request('search') : null;
        $offset = request('offset') != null ? request('offset') : 0;
        $limit = request('limit') != null ? request('limit') : 5;

        $vehicleList = FleetLookupVehicle::orderBy('id');
        if($search){
            Log::info(request('search'));
            $vehicleList->whereRaw("upper(no_pendaftaran) LIKE '%".strtoupper($search)."%' ");
        }

        return [
            'total' => $vehicleList->count()
        ];

    })->name('.ajax.getVehicle.total');

    Route::post('/register-save', function(Request $request){

        $section = $request->input('section');
        switch ($section) {
            case 'detail':
                $SummonFormVehicleDAO = new FormMaklumatKenderaan();
                return $SummonFormVehicleDAO->store($request);
                break;
            // case 'detail':
            //     $FormMaklumatSamanDAO = new FormMaklumatSaman();
            //     return $FormMaklumatSamanDAO->store($request);
            //     break;

            default:
                # code...
                break;
        }
    })->name('.register.save');

    Route::get('/daftar/{id}', function(){
        return view('vehicle.saman.daftar-saman');
    })->name('.daftar.save');

    //upload support Docs

    Route::post('/upload-suport-doc', function(Request $request){
        $FormMaklumatSamanDAO = new FormMaklumatSaman();
        return $FormMaklumatSamanDAO->uploadSupportDoc($request);
    })->name('.upload.support_doc');

    //getSupportDocs

    Route::get('/ajax/checkExistSupportDocs', function () {

        $checkExistSupportDocs = false;
        $session_summon_id = session()->get('session_summon_id');

        $checkQuery = SummonDocument::where([
            'ref_id' => $session_summon_id,
            'doc_type' => 'dokumen_sokongan'
        ])->count();

        if($checkQuery > 0){
            $checkExistSupportDocs = true;
        }

        return [
            'is_existed' => $checkExistSupportDocs
        ];

    })->name('.ajax.checkExistSupportDocs');

    //getPaymentDocs

    Route::get('/ajax/checkExistPaymentDocs', function () {

        $checkExistPaymentDocs = false;
        $session_summon_id = session()->get('session_summon_id');

        $childDB = MaklumatPembayaran::where('maklumat_kenderaan_saman_id', $session_summon_id)->exists();
        if($childDB){
            $childDB = MaklumatPembayaran::where('maklumat_kenderaan_saman_id', $session_summon_id)->get()->first();
            $checkQuery = DokumenPembayaran::where([
                'maklumat_pembayaran_id' => $childDB->id,
            ])->count();
            if($checkQuery > 0){
                $checkExistPaymentDocs = true;
            }
        }
        else{

        }

        return [
            'is_existed' => $checkExistPaymentDocs
        ];

    })->name('.ajax.checkExistPaymentDocs');

    Route::get('/ajax/getSupportDocs', function(Request $request){

        $is_display = $request->is_display;
        $session_summon_id = session()->get('session_summon_id');

        $supportDocs = SummonDocument::where([
            'ref_id' => $session_summon_id,
            'doc_type' => 'dokumen_sokongan'
        ])->get();

        Log::info($supportDocs);
        return view('vehicle.saman.tab.saman-support-docs', [
            'supportDocs' => $supportDocs,
            'is_display' => $is_display
        ]);
    })->name('.ajax.getSupportDocs');

    Route::post('/delete-SupportDoc', function(Request $request){
        $PembayaranSamanDAO = new PembayaranSaman();
        return $PembayaranSamanDAO->deleteSupportDoc($request);
    })->name('.delete.supportDoc');

    Route::post('/changeSummonOwner', function(Request $request){
        $PembayaranSamanDAO = new PembayaranSaman();
        return $PembayaranSamanDAO->tukarMilik($request);
    })->name('.changeSummonOwner');

    Route::post('/submitForPayment', function(Request $request){

        $request->validate([
            'summon_agency_id' => 'required',
            'summon_type_id' => 'required',
            'summon_notice_no' => 'required',
            'notice_date' => 'required',
            'receive_notice_date' => 'required',
            'mistake_date' => 'required',
            // 'mistake_time' => 'required',
            // 'state_id' => 'required',
            'mistake_location' => 'required',
            // 'driver_id' => 'required',
            'total_compound' => 'required',
            'compound_reason' => 'required',
        ], [
            'summon_agency_id.required' => 'Sila pilih pengeluaran saman',
            'summon_type_id.required' => 'Sila pilih jenis saman',
            'summon_notice_no.required' => 'Sila masukkan nombor notis saman',
            'notice_date.required' => 'Sila masukkan tarikh notis',
            'receive_notice_date.required' => 'Sila masukkan tarikh terima saman dari CDPK',
            'mistake_date.required' => 'Sila masukkan tarikh kesalahan',
            // 'mistake_time.required' => 'Sila masukkan masa kesalahan',
            // 'state_id.required' => 'Sila pilih negeri',
            'mistake_location.required' => 'Sila masukkan lokasi kesalahan',
            // 'driver_id.required' => 'Sila pilih pemandu',
            'total_compound.required' => 'Sila masukkan jumlah kompaun',
            'compound_reason.required' => 'Sila masukkan sebab kompuan',
        ]);

        $update = [
            'code' => '',
            'message' => ''
        ];

        $summonId = session()->get('session_summon_id');
        $summonDetail = MaklumatKenderaanSaman::find($summonId);
        $summonStatus = StatusSaman::where('code', '02')->first();
        // $totalUpdated = 1;
        $totalUpdated = $summonDetail->update([
            'status_saman_id' => $summonStatus->id
        ]);

        $summonDetail->maklumatSaman->update([
            'pic_name1' => $request->pic_name1,
            'pic_email1' => $request->pic_email1,
            'pic_name2' => $request->pic_name2,
            'pic_email2' => $request->pic_email2
        ]);

        if($totalUpdated == 1){
            $FormMaklumatKenderaanDAO = new FormMaklumatKenderaan();
            $FormMaklumatKenderaanDAO->emailNotifyToVehiclePIC($summonDetail->pendaftaran_id, $summonDetail->id);
            $update['code'] = '200';
            $update['message'] = 'Maklumat Berjaya dihantar untuk pembayaran saman';
        };

        return $update;

    })->name('.submitForPayment');

    Route::post('/submitForPaymentConfirm', function(Request $request){

        $summonId = session()->get('session_summon_id');
        $summonDetail = MaklumatKenderaanSaman::find($summonId);

        if($request->saman_info == 3){
            $summonStatus = StatusSaman::where('code', '05')->first();
        } else {
            $summonStatus = StatusSaman::where('code', '03')->first();
        }

        // $totalUpdated = 1;
        $totalUpdated = $summonDetail->update([
            'status_saman_id' => $summonStatus->id
        ]);

        if($totalUpdated == 1){
            $FormMaklumatKenderaanDAO = new FormMaklumatKenderaan();
            $FormMaklumatKenderaanDAO->emailNotifyToVehiclePIC($summonDetail->pendaftaran_id, $summonDetail->id);
            $update['code'] = '200';
            $update['message'] = 'Maklumat Berjaya dihantar untuk pembayaran saman';
        };

        return $update;
    })->name('.submitForPaymentConfirm');

    Route::post('/delete', function(Request $request){

        $update = [
            'code' => '',
            'message' => ''
        ];
        $totalUpdated = 0;
        $checkedList = isset($request['checkedList']) ? $request['checkedList'] : [];

        if(count($checkedList)){
            $summonList = MaklumatKenderaanSaman::whereIn('id', $checkedList);
            $summonStatus = StatusSaman::where('code', '00')->first();
            $totalUpdated = $summonList->update([
                'status_saman_id' => $summonStatus->id
            ]);
        }

        if(count($checkedList) == $totalUpdated){
            $update['code'] = '200';
            $update['message'] = 'Maklumat Berjaya dihapuskan';
        };

        return $update;
    })->name('.delete');

    Route::get('/generate-letter', function (Request $request) {

        $issuerId = $request->issuer;

        $issuer = '';
        switch ($issuerId) {
            case 1:
                $issuer = 'Polis Diraja Malaysia (PDRM)';
                break;
            case 2:
                $issuer = 'Jabatan Pengangkutan Jalan (JPJ)' ;
                break;
            case 3:
                $issuer = 'Pihak Berkuasa Tempatan (PBT)';
                break;
            default:
                $issuer = 'Polis Diraja Malaysia (PDRM)';
                break;

        }

        $detail = MaklumatKenderaanSaman::find($request->id);
        return view('vehicle.saman.tab.saman-detail-letter', [
            'detail' => $detail,
            'issuer' => $issuer

        ]);
    })->name('.generate.letter');

    Route::post('/check/summon-no', function(Request $request){
        $is_existed = 0;

        $hasSummonNo = MaklumatSaman::where('summon_notice_no', $request->summon_notice_no)->first();

        if($hasSummonNo){
            $is_existed = 1;
        }

        return $is_existed;

    })->name('.check.summon-no');

});

});
