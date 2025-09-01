    <?php

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\DriverController; 

    /*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    | These routes are loaded by the RouteServiceProvider within a group
    | which is assigned the "api" middleware group.
    | Enjoy building your API!
    |--------------------------------------------------------------------------
    */

    // Simple test route
    Route::get('/ping', fn() => response()->json(['status' => 'pong']));

    // Another test route
    Route::get('/test', fn() => response()->json(['message' => 'API works']));

    // Register route (AuthController)
    Route::post('/register', [AuthController::class, 'register']);
    Route::middleware('api')->post('/register', [DriverController::class, 'register']);
    //dd('API file loaded');
    Route::post('/register-test', function() {
        return response()->json(['status' => 'working']);
    });

    Route::get('/test-json', function() {
    return response()->json(['status' => 'ok']);
});

