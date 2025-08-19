<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminAuthController extends Controller
{
    public function showRegisterForm()
{
    if (Auth::check()) {
        // If already logged in, redirect back or to dashboard
        return redirect()->intended(route('admin.dashboard'));
    }

    return view('admin.register');
}
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:6',
            'role'     => 'required|string',
        ]);

        User::create([
            'name'           => $request->name,
            'email'          => $request->email,
            'password'       => Hash::make($request->password),
            'role'           => $request->role,
            'remember_token' => Str::random(60),
        ]);

        return redirect()->route('admin.login')->with('success', 'Admin account created successfully!');
    }

    public function showLoginForm()
{
    if (Auth::check()) {
        // If already logged in, redirect back or to dashboard
        return redirect()->intended(route('admin.dashboard'));
    }

    return view('admin.login');
}
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $request->session()->put('admin_name', Auth::user()->name); // store name in session
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ]);
    }
}
