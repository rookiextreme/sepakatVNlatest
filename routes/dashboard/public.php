<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/public', function () {
    if (Auth::user()->roleAccess()->code != '04') {
       return 'Somthing went wrong'; 
    }
    return view('dashboards.dashboard');
})->middleware(['auth'])->name('access.public');

Route::group(['prefix' => 'public', 'as' => 'access.public', 'middleware' => 'auth'], function(){

    Route::get('/dashboard', function () {

        $carbon = new Carbon();
        $carbon->setLocale('ms');
        
        if (Auth::user()->roleAccess()->code != '04') {
           return 'Somthing went wrong'; 
        }
        return view('access_public.dashboard');
        //return view('vehicle.vehicle-overview');
    })->middleware(['auth'])->name('.dashboard');

    Route::get('/dashboard/info', function () {
        if (Auth::user()->roleAccess()->code != '04') {
           return 'Somthing went wrong'; 
        }
        return view('access_public.info.dashboard-info');
        //return view('vehicle.vehicle-overview');
    })->name('.dashboard.info');

});