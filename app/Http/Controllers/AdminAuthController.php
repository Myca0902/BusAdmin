<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\UserContact;

class AdminAuthController extends Controller
{
    // Show register form
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->intended(route('dashboard'));
        }

        return view('admin.register');
    }

    // Store new user + contact info
    public function store(Request $request)
    {
        $request->validate([
            // Personal info
            'fname'         => 'required|string|max:255',
            'lname'         => 'required|string|max:255',
            'middle_name'   => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'gender'        => 'nullable|string|max:50',
            'email'         => 'required|string|email|max:255|unique:users,email',


            // Contact info
            'phone_number'  => 'nullable|string|max:20',
            'street_address'=> 'nullable|string|max:255',
            'city'          => 'nullable|string|max:100',
            'state'         => 'nullable|string|max:100',
            'zip_code'      => 'nullable|string|max:20',

            // Account
            'password'      => 'required|string|confirmed|min:6',
        ]);

        // Save user (personal information)
        $user = User::create([
            'fname'         => $request->fname,
            'lname'         => $request->lname,
            'middle_name'    => $request->middle_name,
            'date_of_birth' => $request->date_of_birth,
            'gender'        => $request->gender,
            'password'      => Hash::make($request->password),
            'email'         => $request->email,

        
        ]);

        // Save contact info
        UserContact::create([
            'user_id'       => $user->id,
            'phone_number'  => $request->phone_number,
            'street_address'=> $request->street_address,
            'city'          => $request->city,
            'state'         => $request->state,
            'zip_code'      => $request->zip_code,
        ]);

        return redirect()->route('admin.login')->with('success', 'Account created successfully!');
    }

    // Show login form
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->intended(route('dashboard'));
        }

        return view('admin.login');
    }

    // Handle login
   public function login(Request $request)
{
    $credentials = $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    $remember = $request->has('remember');

    if (Auth::attempt($credentials, $remember)) {
        $request->session()->regenerate();
        $request->session()->put('admin_name', Auth::user()->fname . ' ' . Auth::user()->lname);
        return redirect()->route('dashboard');
    }

    return back()->withErrors([
        'email' => 'Invalid email or password.',
    ]);
}

}
