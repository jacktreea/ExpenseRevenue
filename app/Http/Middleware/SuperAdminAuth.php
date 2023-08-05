<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {

//        if (Auth::guard('api')->check() && User::hasRole("super-admin")) {
//            return $next($request);
//
//        } else {
//            $message = ["message" => "Permission Denied"];
//            return response($message, 401);
//        }
        return $next($request);
    }
}
