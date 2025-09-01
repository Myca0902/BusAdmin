<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\DriverController;


Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');


Route::get('/', function () {
    $user = Auth::user();

    if ($user->role === 'dispatcher') {
        return view('dispatcher_views.dispatcher');
    } elseif ($user->role === 'finance') {
        return view('finance.financeAccount');
    } elseif ($user->role === 'suspended') {
        return view('suspended.index');
    }

    return view('dashboard'); // Normal admin view
})->name('dashboard')->middleware('auth');


Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

    Route::get('/admin/register', [AdminAuthController::class, 'showRegisterForm'])->name('admin.register');
    Route::post('/admin/register', [AdminAuthController::class, 'store'])->name('admin.register.store');

    Route::get('/admin/forgot-password', function () {
        return view('admin.forgot-password');
    })->name('admin.forgot-password');

    Route::post('/admin/forgot-password', function (Request $request) {
        $request->validate(['email' => 'required|email']);

        $exists = DB::table('users')->where('email', $request->email)->exists();
        if (!$exists) {
            return back()->withErrors(['email' => 'Email does not exist in our records.']);
        }

        DB::table('forgot_password_requests')->insert([
            'email' => $request->email,
            'requested_at' => now()
        ]);

        $token = bin2hex(random_bytes(32));
        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => now()]
        );

        $resetLink = url("/admin/reset-password?token={$token}&email=" . urlencode($request->email));

        // Send email using PHPMailer (same as before)
        // ... [Email sending code remains unchanged]

    })->name('admin.forgot-password.submit');

    // Reset Password
    Route::get('/admin/reset-password', function (Request $request) {
        return view('admin.reset-password', [
            'token' => $request->token,
            'email' => $request->email
        ]);
    })->name('admin.reset-password');

    Route::post('/admin/reset-password', function (Request $request) {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:6|confirmed'
        ]);

        $reset = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$reset) {
            return back()->withErrors(['email' => 'Invalid token or email.']);
        }

        DB::table('users')->where('email', $request->email)->update([
            'password' => bcrypt($request->password)
        ]);

        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()->route('admin.login')->with('success', 'Password successfully reset.');
    })->name('admin.reset-password.submit');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/buses', function () {
        return view('buses');  
    })->name('buses');

    Route::get('/routes', function () {
        return view('routes');  
    })->name('routes');

Route::get('/drivers', [DriverController::class, 'index'])->name('drivers'); // For Blade view
Route::get('/drivers/list', [DriverController::class, 'list'])->name('drivers.list'); // For JS fetch
Route::post('/drivers', [DriverController::class, 'store'])->name('drivers.store');
Route::patch('/drivers/{id}/status', [DriverController::class, 'updateStatus'])->name('drivers.updateStatus');


    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('admin.login');
    })->name('logout');
});
