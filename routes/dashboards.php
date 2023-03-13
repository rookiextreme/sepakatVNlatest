<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    if (Auth::user()->roleAccess()->code == '01') {
        return redirect()->route('access.admin');
    } else if(Auth::user()->roleAccess()->code == '02'){
        return redirect()->route('access.management');
    } else if(Auth::user()->roleAccess()->code == '03'){
        return redirect()->route('access.operation');
    } else {
        return redirect()->route('access.public');
    }
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/dashboard/admin.php';
require __DIR__.'/dashboard/management.php';
require __DIR__.'/dashboard/operation.php';
require __DIR__.'/dashboard/public.php';