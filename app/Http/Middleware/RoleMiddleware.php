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
        $userRole = $request->user()->role;
        if (!in_array($userRole, $roles)) {
            // redirect based on user role
            if ($userRole === 'user') {
                return redirect()->route('events.public')->with('error', 'You do not have permission to access this page.');
            } elseif ($userRole === 'organizer') {
                return redirect()->route('home')->with('error', 'You do not have permission to access this page.');
            }
            return redirect()->route('home')->with('error', 'Unauthorized action.');
        }

        return $next($request);
    }
}
