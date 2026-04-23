<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StatusMiddleware
{
    /**
     * handle incoming request
     */
    public function handle(Request $request, Closure $next): Response
    {
        // check if user is logged in
        if (!$request->user()) {
            return $next($request);
        }

        // check if user is active
        if ($request->user()->status !== 'active') {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Your account has been deactivated.');
        }

        return $next($request);
    }
}