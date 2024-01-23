<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // if (Auth::check() && Auth::user()->user_type == '1') {
        //     return $next($request);
        // } else {
        //     abort(401);
        // }
        if ($request->user()->user_type !== $role) {
            abort(401);
        }

        return $next($request);
    }
}
