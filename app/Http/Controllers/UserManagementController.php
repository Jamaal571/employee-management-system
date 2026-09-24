<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use App\Models\Department;
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
        $departments = Department::all();
        return view('users.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
                        'role' => 'required|in:admin,employee,board',
        ];

        if ($request->role === 'employee') {
            $rules['phone'] = 'nullable|string|max:20';
            $rules['position'] = 'required|string|max:255';
            $rules['salary'] = 'required|numeric|min:0';
            $rules['currency'] = 'required|in:USD,SLSH';
            $rules['hire_date'] = 'required|date';
            $rules['department_id'] = 'required|exists:departments,id';
            $rules['photo'] = 'nullable|image|max:2048';
        }

        $request->validate($rules);

        $randomPassword = Str::random(10);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($randomPassword),
            'role' => $request->role,
            'must_change_password' => true,
        ]);

        if ($request->role === 'employee') {
            $employeeData = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'position' => $request->position,
                'salary' => $request->salary,
                'currency' => $request->currency,
                'hire_date' => $request->hire_date,
                'department_id' => $request->department_id,
            ];

            if ($request->hasFile('photo')) {
                $employeeData['photo'] = $request->file('photo')->store('employee_photos', 'public');
            }

            Employee::create($employeeData);
        }

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