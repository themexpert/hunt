<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class VerifyEmailActivation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if($request->user()->is_active == 0) {
           return response()->json([
               'message' => 'Confirm your email address',
               'status_code' => 403
           ], 403);
        }

        return $next($request);
    }
}
