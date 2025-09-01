<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DriverController extends Controller
{
    /**
     * Show drivers page (Blade view).
     */
    public function index()
    {
        return view('drivers'); // Make sure you have resources/views/drivers.blade.php
    }

    /**
     * Fetch all drivers (API for DataTable or JS fetch).
     */
    public function list()
    {
        $drivers = Driver::orderBy('created_at', 'desc')->get();
        return response()->json($drivers);
    }

    /**
     * Store a newly created driver.
     */
    public function register(Request $request)
{
    // Validate incoming request
    $validated = $request->validate([
        'full_name'      => 'required|string|max:255',
        'address'        => 'required|string|max:255',
        'date_of_birth'  => 'required|date',
        'email'          => 'required|email|unique:drivers,email',
        'phone_number'   => 'required|string',
        'driver_id'      => 'required|string|unique:drivers,driver_id',
        'password'       => 'required|string|min:6',
        'government_id'  => 'required|string',
        'license_front'  => 'required|file|mimes:jpg,jpeg,png',
        'license_back'   => 'required|file|mimes:jpg,jpeg,png',
        'gov_id_image'   => 'required|file|mimes:jpg,jpeg,png',
    ]);

    try {
        // Store uploaded files
        $licenseFront = $request->file('license_front')->store('licenses', 'public');
        $licenseBack  = $request->file('license_back')->store('licenses', 'public');
        $govIdImage   = $request->file('gov_id_image')->store('gov_ids', 'public');

        // Create driver record
        $driver = \App\Models\Driver::create([
            'full_name'     => $request->full_name,
            'address'       => $request->address,
            'date_of_birth' => $request->date_of_birth,
            'email'         => $request->email,
            'phone_number'  => $request->phone_number,
            'driver_id'     => $request->driver_id,
            'password'      => \Illuminate\Support\Facades\Hash::make($request->password),
            'government_id' => $request->government_id,
            'license_front' => $licenseFront,
            'license_back'  => $licenseBack,
            'gov_id_image'  => $govIdImage,
            'status'        => 'pending', // optional default status
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Driver registered successfully',
            'data'    => $driver
        ], 201);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Server error: ' . $e->getMessage()
        ], 500);
    }
}


    /**
     * Update driver status (approve/reject).
     */
    public function updateStatus(Request $request, $id)
    {
        $driver = Driver::findOrFail($id);
        $driver->status = $request->status;
        $driver->save();

        return response()->json(['success' => true, 'message' => 'Status updated successfully']);
    }
}
