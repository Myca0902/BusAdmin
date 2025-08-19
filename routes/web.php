<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\SuperAdminController;

/*
|--------------------------------------------------------------------------
| Redirect root to login
|--------------------------------------------------------------------------
*/
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');


/*
|--------------------------------------------------------------------------
| Dashboard - must be logged in
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $user = Auth::user();

    if ($user->role === 'super_admin') {
    return redirect()->route('superadmin.dashboard');
    }
    elseif($user->role === 'dispatcher'){
        return view('dispatcher_views.dispatcher');
    }
    elseif($user->role === 'finance'){
        return view('finance.financeAccount');
    }
    elseif($user->role === 'suspended'){
        return view('suspended.index');
    }

    return view('dashboard'); // Normal admin view
})->name('admin.dashboard')->middleware('auth');
/*
|--------------------------------------------------------------------------
| Guest Routes (only for not logged in users)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

    // Register
    Route::get('/admin/register', [AdminAuthController::class, 'showRegisterForm'])->name('admin.register');
    Route::post('/admin/register', [AdminAuthController::class, 'store'])->name('admin.register.store');

    // Forgot Password Form
    Route::get('/admin/forgot-password', function () {
        return view('admin.forgot-password');
    })->name('admin.forgot-password');

    // Handle Forgot Password
    Route::post('/admin/forgot-password', function (Request $request) {
        $request->validate([
            'email' => 'required|email'
        ]);

        // Check if email exists
        $exists = DB::table('users')->where('email', $request->email)->exists();
        if (!$exists) {
            return back()->withErrors(['email' => 'Email does not exist in our records.']);
        }

        // Log request
        DB::table('forgot_password_requests')->insert([
            'email' => $request->email,
            'requested_at' => now()
        ]);

        // Generate token
        $token = bin2hex(random_bytes(32));
        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => now()]
        );

        // Reset link
        $resetLink = url("/admin/reset-password?token={$token}&email=" . urlencode($request->email));

        // Send email using PHPMailer
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'myca.oribio@lorma.edu';
             $mail->Password   = 'levl yojj lgob nbys';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom(env('MAIL_FROM_ADDRESS', 'noreply@example.com'), 'Admin Pitco');
            $mail->addAddress($request->email);
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $userData = DB::table('users')->where('email', $request->email)->first();
            $userName = $userData ? $userData->name : 'User';
            $mail->Body = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Password Reset</title>
</head>
<body style="background-color:#f8f9fa; font-family:Arial, sans-serif; padding:20px;">

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:600px; margin:auto; background-color:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.1);">
        <tr>
            <td style="background-color:#0d6efd; padding:20px; text-align:center;">
                <h1 style="color:#ffffff; margin:0; font-size:24px;">Admin Pitco</h1>
            </td>
        </tr>
        <tr>
            <td style="padding:30px; color:#212529;">
                <p style="font-size:16px; margin-bottom:20px;">Hello, ' . htmlspecialchars($userName) . '!</p>
                <p style="font-size:16px; line-height:1.5; margin-bottom:20px;">
                    We received a request to reset your password. Click the button below to set a new one.
                </p>
                <p style="text-align:center; margin-bottom:30px;">
                    <a href="' . $resetLink . '" style="display:inline-block; padding:12px 20px; font-size:16px; color:#ffffff; background-color:#0d6efd; border-radius:6px; text-decoration:none;">
                        Reset Password
                    </a>
                </p>
                <p style="font-size:14px; color:#6c757d;">
                    If you didn’t request this, you can ignore this email.
                </p>
            </td>
        </tr>
        <tr>
            <td style="background-color:#f1f3f5; padding:15px; text-align:center; font-size:12px; color:#6c757d;">
                &copy; ' . date("Y") . ' Admin Pitco. All rights reserved.
            </td>
        </tr>
    </table>

</body>
</html>
';


            $mail->send();
            return back()->with('success', 'If this email exists, a reset link has been sent.');
        } catch (Exception $e) {
            return back()->withErrors(['email' => 'Mailer Error: ' . $mail->ErrorInfo]);
        }
    })->name('admin.forgot-password.submit');

    // Reset Password Form
    Route::get('/admin/reset-password', function (Request $request) {
        return view('admin.reset-password', [
            'token' => $request->token,
            'email' => $request->email
        ]);
    })->name('admin.reset-password');

    // Handle Reset Password
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


Route::middleware(['auth', 'is_super_admin'])->group(function () {
    // Main superadmin page
 Route::get('/superadmin', [SuperAdminController::class, 'index'])->name('superadmin.dashboard');

    // User management
    Route::post('/superadmin/users/store', [SuperAdminController::class, 'store'])->name('superadmin.users.store');
    Route::post('/superadmin/users/{id}/update', [SuperAdminController::class, 'update'])->name('superadmin.users.update');
    Route::delete('/superadmin/users/{id}/delete', [SuperAdminController::class, 'destroy'])->name('superadmin.users.delete');
});



/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('admin.login');
})->name('logout');
