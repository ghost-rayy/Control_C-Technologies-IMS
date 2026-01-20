<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StaffMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isStaff()) {
            return redirect('/')->with('error', 'Unauthorized access. Staff access required.');
        }

        if (!auth()->user()->isActive()) {
            auth()->logout();
            return redirect('/login')->with('error', 'Your account has been deactivated.');
        }

        return $next($request);
    }
}
