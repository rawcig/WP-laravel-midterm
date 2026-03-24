<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * handle incoming request
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // check if user is logged in
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // check if user has required role
        if (!in_array($request->user()->role, $roles)) {
            abort(403, 'unauthorized action.' );
        }

        return $next($request);
    }
}
