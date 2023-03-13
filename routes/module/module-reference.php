<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

    Route::group(['prefix' => 'reference', 'as' => 'reference', 'middleware' => 'auth'], function(){

    //agency/branch/division/unit
    require __DIR__.'/../reference/agency.php';
    //vehicle-category
    require __DIR__.'/../reference/vehicle-category.php';
    //vehicle-category
    require __DIR__.'/../reference/vehicle-component.php';
    //vehicle-refevent
    require __DIR__.'/../reference/vehicle-refevent.php';
    //vehicle-branchowner
    require __DIR__.'/../reference/vehicle-branchowner.php';
    //component-checklist
    require __DIR__.'/../reference/component-checklist.php';
    //vehicle-brand
    require __DIR__.'/../reference/vehicle-brand.php';
    //placement-location
    require __DIR__.'/../reference/placement-location.php';
    //engine type
    require __DIR__.'/../reference/engine-type.php';
    // //fuel type
    require __DIR__.'/../reference/fuel-type.php';
    // //cooling system
    require __DIR__.'/../reference/cooling-system.php';
    // //transmission type
    require __DIR__.'/../reference/transmission-type.php';
    // //suspension type
    require __DIR__.'/../reference/suspension-type.php';
    //vehicle-agency
    require __DIR__.'/../reference/vehicle-agency.php';
    //depreciation
    require __DIR__.'/../reference/depreciation.php';
    });

?>
