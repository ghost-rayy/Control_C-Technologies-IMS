<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AutoLoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Log::info('AutoLoginMiddleware running.');

        // Check if user is already logged in
        if (!Auth::check()) {
            Log::info('User not logged in. Attempting auto-login.');
            // Attempt to find the main admin user
            $admin = User::where('email', 'admin@example.com')->first();
            
            // If specific admin not found, find any admin
            if (!$admin) {
                Log::info('Specific admin not found. Searching for any admin.');
                $admin = User::where('role', 'admin')->first();
            }

            // If we found a user, log them in
            if ($admin) {
                Log::info('Auto-login successful for admin user: ' . $admin->email);
                Auth::guard('web')->login($admin);
            } else {
                Log::error('No admin user found for auto-login.');
            }
        } else {
            Log::info('User already logged in.');
        }

        return $next($request);
    }
}
