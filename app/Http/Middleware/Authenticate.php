<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Log;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            $url = route('login');
            Log::info('ada redirect x ? '.Request('redirectTo'));
            if(Request('redirectTo')){
                session()->put('session_redirectTo', Request('redirectTo'));
            }
            return $url;
        }
    }
}
