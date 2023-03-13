<?php

use App\Http\Controllers\SSO\SSOLoginDAO;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

Route::get('/ssoLogin', function(Request $request){
    $SSOLoginDAO = new SSOLoginDAO();
    return $SSOLoginDAO->ssoLogin($request);
})->name('ssoLogin');

Route::get('/cb-sso-login', function(Request $request){

    if (!Auth::check()) {
        //return Redirect::to('https://sso.jkr.gov.my/nidp/idff/sso?option=credential&target='.route('cb.sso.login'));
        // return Redirect::to('https://sso.jkr.gov.my/nidp/idff/sso?option=credential&target=https://spark.jkr.gov.my/index.php?r=site/utama');
        // return Redirect::to('https://sso.jkr.gov.my/nidp/idff/sso?id=107&sid=2&option=credential&target='.route('cb.sso.login'));
    }
    $SSOLoginDAO = new SSOLoginDAO();
    return $SSOLoginDAO->cbSSOLogin2($request);
})->name('cb.sso.login');

Route::get('/cb-sso-login-action', function(Request $request){
    if (Auth::check()) {
        if (Auth::user()->roleAccess()->code == '01') {
            return Redirect::to(route('access.admin'));
        } else if(Auth::user()->roleAccess()->code == '02'){
            return Redirect::to(route('access.management'));
        } else if(Auth::user()->roleAccess()->code == '03'){
            return Redirect::to(route('access.operation'));
        } else {
            return Redirect::to(route('access.public'));
        }
    } else {
        return Redirect::to('/');
    }
});

Route::post('/cb-sso-login-action', function(Request $request){
    Log::info('masuk /cb-sso-login-action');
    
    $SSOLoginDAO = new SSOLoginDAO();
    return $SSOLoginDAO->cbSSOLoginAction($request);
})->name('cb.sso.login.action');

Route::get('/cb-sso-login-response', function(){
    return view('auth.sso-login-response');
})->middleware('guest')->name("cb.sso.login.response");