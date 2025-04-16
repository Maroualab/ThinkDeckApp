<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Show the registration form.
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Handle user registration.
     */
    public function register(StoreAuthRequest $request)
    {
        // Get validated data from the request
        $validated = $request->validated();
        
        // Hash the password with bcrypt
        $validated['password'] = Hash::make($validated['password']);
        
        // Create user
        $user = User::create($validated);

        // Log the user in
        Auth::login($user);

        // Redirect to dashboard or home
        return redirect()->intended('/dashboard');
    }

    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        // Validate login credentials
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        // Attempt to log in
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        // Authentication failed
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
    
    /**
     * Show the password reset request form.
     */
    public function showPasswordRequestForm()
    {
        return view('auth.forgot-password');
    }
}