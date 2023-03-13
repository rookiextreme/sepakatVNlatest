<?php

use App\Http\Controllers\Assessment\FileUploadMobileDAO;
use App\Http\Controllers\Test\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/uploadFile', function(Request $request){
    Log::info("uploadFile request id->".$request->id);
    Log::info("uploadFile request lvl ->".$request->lvl);
    Log::info("uploadFile request vehicle_id ->".$request->vehicle_id);
    Log::info("uploadFile request user_id ->".$request->user_id);
    Log::info("uploadFile request file ->".$request->file);
    $FileUploadMobileDAO = new FileUploadMobileDAO();
    return $FileUploadMobileDAO->saveFormFile($request);
});

Route::post('/uploadMtnFile', function(Request $request){
    Log::info("uploadFile request id->".$request->id);
    Log::info("uploadFile request lvl ->".$request->lvl);
    Log::info("uploadFile request vehicle_id ->".$request->vehicle_id);
    Log::info("uploadFile request user_id ->".$request->user_id);
    Log::info("uploadFile request file ->".$request->file);
    $FileUploadMobileDAO = new FileUploadMobileDAO();
    return $FileUploadMobileDAO->saveMtnFormFile($request);
});

Route::post('/addVehicleDamage', function(Request $request){
    // Log::info("saveForm request ->".dd($request->all()));
    $FileUploadMobileDAO = new FileUploadMobileDAO();
    return $FileUploadMobileDAO->addVehicleDamage($request);
});

Route::post('/deleteUploadFile', function(Request $request){
    // Log::info("saveForm request ->".dd($request->all()));
    $FileUploadMobileDAO = new FileUploadMobileDAO();
    return $FileUploadMobileDAO->deleteFormFile($request);
});

Route::post('/saveMonitoringInfo', function(Request $request){
    $FileUploadMobileDAO = new FileUploadMobileDAO();
    return $FileUploadMobileDAO->saveMonitoringInfo($request);
});

Route::post('/deleteMonitoringInfo', function(Request $request){
    $FileUploadMobileDAO = new FileUploadMobileDAO();
    return $FileUploadMobileDAO->deleteMonitoringInfo($request);
});

Route::post('/saveSignature', function(Request $request){
    $FileUploadMobileDAO = new FileUploadMobileDAO();
    return $FileUploadMobileDAO->saveSignature($request);
});
