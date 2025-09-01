<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|string',
            'driver_id' => 'required|string|unique:users,driver_id',
            'password' => 'required|string|min:6',
            'government_id' => 'required|string',
            'license_front' => 'required|file|mimes:jpg,jpeg,png',
            'license_back' => 'required|file|mimes:jpg,jpeg,png',
            'gov_id_image' => 'required|file|mimes:jpg,jpeg,png',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Store files
            $licenseFront = $request->file('license_front')->store('licenses', 'public');
            $licenseBack = $request->file('license_back')->store('licenses', 'public');
            $govId = $request->file('gov_id_image')->store('gov_ids', 'public');

            // Create user
            $driver = Driver::create([
                'full_name' => $request->full_name,
                'address' => $request->address,
                'date_of_birth' => $request->date_of_birth,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'driver_id' => $request->driver_id,
                'password' => Hash::make($request->password),
                'government_id' => $request->government_id,
                'license_front' => $licenseFront,
                'license_back' => $licenseBack,
                'gov_id_image' => $govId,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'User registered successfully',
                'data' => $driver
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server error: '.$e->getMessage()
            ], 500);
        }
    }
}