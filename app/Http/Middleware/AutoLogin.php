<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AutoLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $verifyUserId = $request->route('id');

        // Support cross-user verification.
        if ($request->user() && $request->user() != $verifyUserId) {
            Auth::logout();
        }

        // Support guest verification.
        if (! $request->user()) {
            Auth::loginUsingId($verifyUserId, true);
        }

        return $next($request);
    }
}
