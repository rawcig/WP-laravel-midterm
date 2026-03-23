<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        // Redirect if already authenticated
        if (Auth::check()) {
            return redirect()->route('home');
        }
        
        return view('backend.auth.login');
    }

    /**
     * Handle a login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'Please enter your password.',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            // Get user info for success message
            $user = Auth::user();
            $role = ucfirst($user->role);
            
            return redirect()->intended(route('home'))
                ->with('success', "Welcome back, {$user->name}! Logged in as {$role}.");
        }

        // Failed login attempt - log for security
        \Log::warning('Failed login attempt for email: ' . $request->email);

        return back()
            ->withErrors([
                'email' => 'The email or password you entered is incorrect. Please try again.',
            ])
            ->withInput($request->only('email'))
            ->with('error', 'Invalid credentials. Please check your email and password.');
    }

    /**
     * Log the user out.
     */
    public function logout(Request $request)
    {
        $userName = Auth::user()->name ?? 'User';
        
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', "Goodbye, {$userName}! You have been successfully logged out.");
    }
}
