<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function store(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email|string',
                'password' => 'required|string',
            ], [
                'email.required' => 'Email address is required.',
                'email.email' => 'Please provide a valid email address.',
                'password.required' => 'Password is required.',
            ]);

            \Log::info('Login attempt for email: ' . $credentials['email']);

            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                \Log::info('Auth successful for user: ' . $user->email . ', role: ' . $user->role . ', active: ' . $user->is_active);

                // Check if account is active
                if (!$user->is_active) {
                    Auth::logout();
                    $request->session()->invalidate();
                    \Log::warning('Login failed: account not active for ' . $user->email);
                    return back()->withInput($request->only('email'))
                        ->with('error', 'Your account has been deactivated. Please contact the system administrator for assistance.');
                }

                $request->session()->regenerate();

                // Redirect to admin dashboard
                \Log::info('Login successful, redirecting to dashboard for ' . $user->email);
                return redirect()->route('admin.dashboard')->with('success', 'Welcome back! You have been logged in successfully.');
            }

            // Authentication failed
            \Log::warning('Login failed: invalid credentials for ' . $credentials['email']);
            return back()->withInput($request->only('email'))
                ->with('error', 'Invalid email or password. Please check your credentials and try again.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Login validation error: ' . $e->getMessage());
            return back()->withInput($request->only('email'))
                ->withErrors($e->errors());
        } catch (\Exception $e) {
            \Log::error('Login error: ' . $e->getMessage());
            return back()->withInput($request->only('email'))
                ->with('error', 'An unexpected error occurred during login. Please try again later.');
        }
    }

    public function destroy(Request $request)
    {
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('success', 'You have been logged out successfully.');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'An error occurred during logout.');
        }
    }
}
