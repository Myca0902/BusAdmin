<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SuperAdminController extends Controller
{
    /**
     * Show all users except the currently logged-in one
     */
    public function index()
    {
        $currentUserId = Auth::id();

        $users = User::where('id', '!=', $currentUserId)
            ->orderBy('id', 'desc')
            ->get();

        return view('super_admin.superAdmin', compact('users'));
    }

    /**
     * Store new user
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role'     => 'required|string'
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->route('superadmin.dashboard')->with('success', 'User added successfully.');
    }

    /**
     * Update user
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|string'
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->role = $request->role;
        $user->save();

        return redirect()->route('superadmin.dashboard')->with('success', 'User updated successfully.');
    }

    /**
     * Delete user (revoke)
     */
    public function destroy($id)
    {
        $currentUserId = Auth::id();
        if ($id == $currentUserId) {
            return redirect()->route('superadmin.dashboard')->with('error', 'You cannot delete your own account.');
        }

        User::destroy($id);

        return redirect()->route('superadmin.dashboard')->with('success', 'User deleted successfully.');
    }
}
