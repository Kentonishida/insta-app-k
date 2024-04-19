<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; //this is use for authentication
use App\Models\User; //represents the users table that contains our lists of users

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** 
         * the Auth::check() is going to check if the user is logged-in, it will return true if the user is logged-in
         */
        if (Auth::check() && Auth::user()->role_id == User::ADMIN_ROLE_ID) {
            return $next($request);    
        }

        return redirect()->route('index');
    }
}
