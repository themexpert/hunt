<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class Dev
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
        if (! User::developer(Auth::user()->email)) {
            if($request->wantsJson()) {
                return response()->json(['message' => 'Access denied'], 403);
            }

            return redirect('/dashboard');
        }

        return $next($request);
    }
}
