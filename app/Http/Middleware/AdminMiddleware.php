<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return redirect('/')->with('error', 'Unauthorized access. Admin access required.');
        }

        if (!auth()->user()->isActive()) {
            auth()->logout();
            return redirect('/login')->with('error', 'Your account has been deactivated.');
        }

        return $next($request);
    }
}
