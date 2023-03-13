<?php

use App\Http\Controllers\Setting\SettingAnnounceDAO;
use App\Http\Controllers\Setting\SettingGeneralDAO;
use App\Http\Controllers\Assessment\Depreciation\VehicleDepreciationDAO;
use App\Models\RefAgency;
use App\Models\RefOwner;
use App\Models\RefOwnerType;
use App\Models\RefState;
use App\Models\Vehicle\Brand;
use App\Models\RefWorkshop;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'settings', 'as' => 'settings', 'middleware' => 'auth'], function(){

    Route::get('/announce', function(){
        return view('settings.announce');
    })->name('.announce');

    Route::get('/update-password', function(Request $request){

        $password = $request->currentPassword;
        $newPassword = $request->newPassword;

        $settingGeneralDAO = new SettingGeneralDAO();
        $validatePasswordStatus = $settingGeneralDAO->validatePassword($password);

        Log::info($validatePasswordStatus);

        $updatePasswordStatus = 0;
        if($validatePasswordStatus){
            Log::info("valiatePassword success");
            //$updatePasswordStatus =1;
            $updatePasswordStatus = $settingGeneralDAO->updatePassword($newPassword);
        }else{
            Log::info("valiatePassword failed");
            $updatePasswordStatus = 2;
        }




        return $updatePasswordStatus;

    })->name('.update.password');


    Route::get('/user-profile', function(){

        $ownerTypeId = 1;
        if(Auth::user()->detail->owner_type_id){
            $ownerTypeId = Auth::user()->detail->owner_type_id;
        }

        return view('settings.user-profile', [
            'state_list' => RefState::all(),
            'workshop_list' => RefWorkshop::all(),
            'agency_list' => RefAgency::all(),
            'owner_type_list' => RefOwnerType::where([
                'display_for' => 'user_register'
            ])->get(),
            'owner_branch_list' => RefOwner::where('owner_type_id', $ownerTypeId)->get(),
            'ministry_list' => RefAgency::all()
        ]);
    })->name('.user-profile');

    Route::post('/announce-list', function(){
        $SettingAnnounceDAO = new SettingAnnounceDAO();
        return view('settings.announce-list-sorting', [
            'announce_list' => $SettingAnnounceDAO->getList()
        ]);
    })->name('.announce.list');

    Route::post('/update-sorting', function(Request $request){
        $SettingAnnounceDAO = new SettingAnnounceDAO();
        $SettingAnnounceDAO->updateSorting($request);
        return true;
    })->name('.announce.update.sorting');

    Route::post('/announce-preview', function(){
        $SettingAnnounceDAO = new SettingAnnounceDAO();
        return view('settings.preview-announcement', [
            'announce_list' => $SettingAnnounceDAO->getList()
        ]);
    })->name('.announce.preview');

    Route::post('/announce-set-active', function(Request $request){
        $SettingAnnounceDAO = new SettingAnnounceDAO();
        return $SettingAnnounceDAO->setActive($request);
    })->name('.announce.set.active');

    Route::post('/announce-set-sessionID', function(Request $request){
        $SettingAnnounceDAO = new SettingAnnounceDAO();
        return $SettingAnnounceDAO->setSessionDetailID($request);
    })->name('.announce.set.sessionID');

    Route::post('/announce/save', function(Request $request){
        $SettingAnnounceDAO = new SettingAnnounceDAO();
        return $SettingAnnounceDAO->save($request);
    })->name('.announce.save');

    Route::get('/general', function(){
        return view('settings.general');
    })->name('.general');

    Route::post('/general/save', function(Request $request){
        $SettingGeneralDAO = new SettingGeneralDAO();
        return $SettingGeneralDAO->save($request);
    })->name('.general.save');

    Route::post('/general/saveDetails', function(Request $request){
        $SaveDetails = new SettingGeneralDAO();
        return $SaveDetails->saveDetails($request);
    })->name('.save.details');


    Route::get('/depreciation', function(){

        $vehicleDepreciationDAO = new VehicleDepreciationDAO();
        $listKelas = $vehicleDepreciationDAO->getKelas();
        $listArrayKelas = [];
        foreach($listKelas as $kelas){
            Log::info("kelas->kelas_id : ".$kelas->kelas_id);
            $listDataKelas = $vehicleDepreciationDAO->getDataByKelas($kelas->kelas_id);
            array_push($listArrayKelas, $listDataKelas);
        }

        Log::info("listArrayKelas size : ".count($listArrayKelas));

        $listKenderaan = $vehicleDepreciationDAO->getKenderaan();
        $listArrayKenderaan = [];
        foreach($listKenderaan as $kenderaan){
            Log::info("kenderaan->brand_id : ".$kenderaan->brand_id);
            $listKelasKenderaan = $vehicleDepreciationDAO->getKelasKenderaan($kenderaan->brand_id);

            array_push($listArrayKenderaan, $listKelasKenderaan);
        }

        $listKenderaanNotYetDefined = $vehicleDepreciationDAO->getKenderaanNotYetDefined();
        $listAllKenderaan = $vehicleDepreciationDAO->getAllKenderaan();
        $highestClass = $vehicleDepreciationDAO->getCurrentHighestClass();

        $highestClassInRoman = $vehicleDepreciationDAO->numberToRomanRepresentation($highestClass);

        $listBrand = Brand::orderBy('name', 'ASC')->get();

        Log::info("highestClassInRoman : ".$highestClassInRoman);

        return view('settings.depreciation-table', [
            'listArrayKenderaan' => $listArrayKenderaan,
            'listArrayKelas' => $listArrayKelas,
            'listKenderaanNotYetDefined' => $listKenderaanNotYetDefined,
            'highestClassInRoman' => $highestClassInRoman,
            'highestClass' => $highestClass,
            'listKelas' => $listKelas,
            'listAllKenderaan' => $listAllKenderaan,
            'listBrand' => $listBrand

        ]);

    })->name('.depreciation');

    Route::get('/calculate-depreciation', function(Request $request){

        $value = $request->value;
        $modelId = $request->model_id;
        $age = $request->age;

        $vehicleDepreciationDAO = new VehicleDepreciationDAO();
        $resultClass = $vehicleDepreciationDAO->getPercentage($modelId, $age);


        return $resultClass;


    })->name('.calculate-depreciation');


    Route::get('/updatePercentageClass', function(Request $request){

        $classNumberData = $request->classNumberData;
        $classAgeData = $request->classAgeData;
        $classPercentage = $request->classPercentage;

        $vehicleDepreciationDAO = new VehicleDepreciationDAO();
        $updateStatus = $vehicleDepreciationDAO -> updatePercentageClass($classNumberData, $classAgeData, $classPercentage);




        Log::info("in updatePercentageClass");

        Log::info("in classNumberData : ".$classNumberData);
        Log::info("in classAgeData : ".$classAgeData);
        Log::info("in classPercentage : ".$classPercentage);
        Log::info("updateStatus : ".$updateStatus);

        return $updateStatus;
    })->name('.updatePercentageClass');

    Route::post('/updateVehicleClass', function(Request $request){
        $vehicleAge = $request->vehicleAge;
        $vehicleModelId = $request->vehicleModelId;
        $vehicleClass = $request->vehicleClass;

        $vehicleDepreciationDAO = new VehicleDepreciationDAO();
        $updateStatus = $vehicleDepreciationDAO -> updateVehicleClass($vehicleModelId, $vehicleAge, $vehicleClass);

        Log::info("in vehicleAge : ".$vehicleAge);
        Log::info("in vehicleModelId : ".$vehicleModelId);
        Log::info("in vehicleClass : ".$vehicleClass);
        Log::info("updateStatus : ".$updateStatus);

        return $updateStatus;
    })->name('.updateVehicleClass');

    Route::get('/addVehicleClass', function(Request $request){

        Log::info("in addVehicleClass");

        $vehicleId = $request->vehicleId;
        Log::info("in vehicleId : ".$vehicleId);
        $arrayVehicleClassString = $request->arrayVehicleClass;

        Log::info("in arrayVehicleClassString : ".$arrayVehicleClassString);

        $arrayVehicleClass = explode(",", $arrayVehicleClassString);

        $vehicleDepreciationDAO = new VehicleDepreciationDAO();
        foreach($arrayVehicleClass as $index=>$vehicleClass){

            Log::info("vehicleId, vehicleClass, index : ".$vehicleId.'-'.$vehicleClass.'-'.($index+1));
            $updateStatus = $vehicleDepreciationDAO -> addVehicleClass($vehicleId, $vehicleClass, $index+1);
        }

        Log::info("updateStatus : ".$updateStatus);
        return $updateStatus;
    })->name('.addVehicleClass');

    Route::get('/addNewClass', function(Request $request){

        Log::info("in addNewClass");

        $latestClass = $request->latestClass;
        $vehicleDepreciationDAO = new VehicleDepreciationDAO();
        $latestClassInRoman = $vehicleDepreciationDAO->numberToRomanRepresentation($latestClass);
        $latestClassDesc ='Kelas '.$latestClassInRoman;

        Log::info("in latestClass : ".$latestClass);
        $arrayPercentageString = $request->arrayPercentage;

        Log::info("in arrayPercentageString : ".$arrayPercentageString);

        $arrayPercentage = explode(",", $arrayPercentageString);

        $updateStatus = $vehicleDepreciationDAO -> addClass($latestClass, $latestClassInRoman, $latestClassDesc);

        foreach($arrayPercentage as $index=>$percentage){

            Log::info("latestClass, percentage, age : ".$latestClass.'-'.$percentage.'-'.($index+1));

            $updateStatus = $vehicleDepreciationDAO -> addClassPercentage($latestClass, $index+1, $percentage);

        }

        Log::info("updateStatus : ".$updateStatus);
        return $updateStatus;
    })->name('.addNewClass');

    Route::get('/calculateDepreciationValue', function(Request $request){

        $age = $request->selectedAge;
        $brandId = $request->selectedBrand;

        if($age != null && $age>15){

            $age = 15;
        }

        Log::info("age : ".$age." -- brandId : ".$brandId);


        $vehicleDepreciationDAO = new VehicleDepreciationDAO();
        $isBrandIdExist = $vehicleDepreciationDAO ->checkIfVehicleBrandExistInDepreciationRecord($brandId);

        if($isBrandIdExist != null && $isBrandIdExist[0]->exist == 1){

            $resultDepreciation = $vehicleDepreciationDAO -> getResultDepreciation($brandId, $age);

        }else{
            $resultDepreciation = $vehicleDepreciationDAO -> getResultDepreciationModelNoRecord($age, 4);
        }


        // $p = DB::select(DB::raw('
        // SELECT percentage FROM vehicles.kelas_susut_nilai
        // WHERE nombor_kelas = 4 and age = ?
        // '),[$age]);

        // // Log::info("in updateVehicleClass : classname : ".$resultDepreciation[0]->classname);
        // // Log::info("in updateVehicleClass : percentage : ".$resultDepreciation[0]->percentage);

        // if (empty($resultDepreciation)){
        //     $resultDepreciation[0] = ["classname" => "Kelas IV", "percentage" => $p[0]->percentage];
        // }

        // Log::info("in newVehicleClass : classname : ".$resultDepreciation[0]->classname);
        // Log::info("in newVehicleClass : percentage : ".$resultDepreciation[0]->percentage);

        return $resultDepreciation[0];
    })->name('.calculateDepreciationValue');


});
