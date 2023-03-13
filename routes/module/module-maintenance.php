<?php

use App\Http\Controllers\Maintenance\MaintenanceDAO;

use App\Http\Controllers\Maintenance\Calendar\MaintenanceCalendarDAO;
use App\Http\Controllers\User\Detail\UserDetail;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

Route::group(['prefix' => 'maintenance', 'as' => 'maintenance', 'middleware' => 'auth'], function(){

    Route::get('/overview', function(){
        return view('maintenance.maintenance-overview');
    })->name('.overview');

    Route::get('/report', function(){
        return view('maintenance.maintenance-report');
    })->name('.report');




    //Start Evaluation

    require __DIR__.'/module-maintenance-evaluation.php';

    //End Evaluation

    require __DIR__.'/module-maintenance-job.php';

    require __DIR__.'/module-maintenance-warrant.php';

    Route::post('/vehicle-maintenance-generateForm', function(Request $request){
        $MaintenanceDAO = new MaintenanceDAO();
        return $MaintenanceDAO->generateForm($request);
    })->name('.vehicle-maintenance.generateForm');

    Route::post('/vehicle-generateLetter', function(Request $request){
        $MaintenanceDAO = new MaintenanceDAO();
        return $MaintenanceDAO->generateLetter($request);
    })->name('.vehicle-maintenance.generateLetter');

    Route::post('/vehicle-generateExamLetter', function(Request $request){
        $MaintenanceDAO = new MaintenanceDAO();
        return $MaintenanceDAO->generateExamLetter($request);
    })->name('.vehicle-maintenance.generateExamLetter');


    Route::get('/calendar', function(Request $request){


        $user_id = auth()->user()->id;
        Log::info("userId : ".$user_id);

        $userDetail = new UserDetail();
        $workshop_id = $userDetail->getWorkshopIdByUserId($user_id)[0]->workshop_id;
        Log::info("workshop_id : ".$workshop_id);

        $maintenanceCalendarDAO = new MaintenanceCalendarDAO();

        $listAppointments = $maintenanceCalendarDAO->getAppointmentByWorkshopId($workshop_id);

        return view('maintenance.calendar',['listAppointments' => $listAppointments]);

    })->name('.calendar');

    Route::get('/calendarmonth', function(){

        Log::info("calendarmonth");
        $selectedMonth = request('selectedMonth') ? request('selectedMonth') : '';
        $selectedYear = request('selectedYear') ? request('selectedYear') : '';

        $user_id = auth()->user()->id;
        Log::info("userId : ".$user_id);

        $userDetail = new UserDetail();
        $workshop_id = $userDetail->getWorkshopIdByUserId($user_id)[0]->workshop_id;

        $maintenanceCalendarDAO = new MaintenanceCalendarDAO();

        $listAppointments = $maintenanceCalendarDAO->getAppointmentByWorkshopId($workshop_id);

        return view('maintenance.calendarmonth',[
            'selectedMonth'=>$selectedMonth,
            'selectedYear'=>$selectedYear,
            'listAppointments' => $listAppointments]);
    })->name('.calendarmonth');

});
