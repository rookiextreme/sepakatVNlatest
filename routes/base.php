<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'base'], function(){

    Route::get('/', function(){
        return view('admin.auth.login');
    });

    Route::get('/login', function(){
        return view('admin.auth.login');
    });

    Route::group(['prefix' => 'control', 'as' => 'control', 'middleware' => 'auth'], function(){

        Route::get('/', function(){
            return view('admin.dashboards.dashboard');
        });
        Route::get('/department', function(){
            return view('admin.dashboards.department-list');
        })->name('.department');

        Route::get('/department/{id}', function(){
            return view('admin.dashboards.department.detail');
        })->name('.department.detail');
        
    });

});