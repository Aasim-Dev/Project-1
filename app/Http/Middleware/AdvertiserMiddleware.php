<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdvertiserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check()){
            if(Auth::user()->user_type == "Advertiser"){
                return $next($request);
            }else{
                Auth::logout();
                return redirectTo('auth.login');
            }
        }else{
                Auth::logout();
                return redirectTo('auth.login');
            }
    }

    

    
}

//this is for the advertiser dashboard when i create the orders file.
