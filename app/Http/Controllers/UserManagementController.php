<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,employee',
        ]);

        $randomPassword = Str::random(10);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($randomPassword),
            'role' => $request->role,
            'must_change_password' => true,
        ]);

        return redirect()->route('users.index')
            ->with('success', "User created successfully.")
            ->with('generated_password', $randomPassword)
            ->with('generated_email', $user->email);
    }

    public function resetPassword(User $user)
    {
        $randomPassword = Str::random(10);

        $user->update([
            'password' => Hash::make($randomPassword),
            'must_change_password' => true,
        ]);

        return redirect()->route('users.index')
            ->with('success', "Password reset for {$user->name}.")
            ->with('generated_password', $randomPassword)
            ->with('generated_email', $user->email);
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')->with('error', 'You cannot delete your own account.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted.');
    }
}