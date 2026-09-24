<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\ForcePasswordController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\SalaryPaymentController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        $totalEmployees = \App\Models\Employee::count();
        $totalDepartments = \App\Models\Department::count();
        return view('dashboard', compact('totalEmployees', 'totalDepartments'));
    }

    if (auth()->user()->role === 'board') {
        return redirect()->route('board.index');
    }

    $employee = \App\Models\Employee::where('email', auth()->user()->email)->first();
    $attendances = $employee
        ? $employee->attendances()->orderBy('date', 'desc')->take(10)->get()
        : collect();

    return view('dashboard', compact('employee', 'attendances'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/force-password', [ForcePasswordController::class, 'show'])->name('password.force-change');
    Route::post('/force-password', [ForcePasswordController::class, 'update'])->name('password.force-update');
});

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/board', [BoardController::class, 'index'])->name('board.index');
    Route::get('/board/employees', [BoardController::class, 'employees'])->name('board.employees');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/employees-export', [EmployeeController::class, 'export'])->name('employees.export');
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::get('/attendance/{employee}/history', [AttendanceController::class, 'history'])->name('attendance.history');
    Route::get('/notices', [NoticeController::class, 'index'])->name('notices.index');
       Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/admin', [MessageController::class, 'showAdmin'])->name('messages.admin');
    Route::post('/messages/admin', [MessageController::class, 'storeAdmin'])->name('messages.admin.store');
    Route::get('/messages/admin/poll', [MessageController::class, 'pollAdmin'])->name('messages.admin.poll');
    Route::get('/messages/{user}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{user}', [MessageController::class, 'store'])->name('messages.store');
    Route::delete('/messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');
    Route::get('/messages/{user}/poll', [MessageController::class, 'poll'])->name('messages.poll');
    Route::get('/leave-requests', [LeaveRequestController::class, 'index'])->name('leave-requests.index');
    Route::get('/leave-requests/create', [LeaveRequestController::class, 'create'])->name('leave-requests.create');
    Route::post('/leave-requests', [LeaveRequestController::class, 'store'])->name('leave-requests.store');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
    Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
    Route::get('/employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');

    Route::get('/departments/create', [DepartmentController::class, 'create'])->name('departments.create');
    Route::post('/departments', [DepartmentController::class, 'store'])->name('departments.store');
    Route::get('/departments/{department}/edit', [DepartmentController::class, 'edit'])->name('departments.edit');
    Route::put('/departments/{department}', [DepartmentController::class, 'update'])->name('departments.update');
    Route::delete('/departments/{department}', [DepartmentController::class, 'destroy'])->name('departments.destroy');

    Route::get('/notices/create', [NoticeController::class, 'create'])->name('notices.create');
    Route::post('/notices', [NoticeController::class, 'store'])->name('notices.store');
    Route::delete('/notices/{notice}', [NoticeController::class, 'destroy'])->name('notices.destroy');

    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserManagementController::class, 'create'])->name('users.create');
    Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');
    Route::post('/users/{user}/reset-password', [UserManagementController::class, 'resetPassword'])->name('users.reset-password');
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');

    Route::post('/leave-requests/{leaveRequest}/approve', [LeaveRequestController::class, 'approve'])->name('leave-requests.approve');
    Route::post('/leave-requests/{leaveRequest}/reject', [LeaveRequestController::class, 'reject'])->name('leave-requests.reject');

    Route::get('/salary-payments', [SalaryPaymentController::class, 'index'])->name('salary-payments.index');
    Route::post('/salary-payments/{employee}', [SalaryPaymentController::class, 'store'])->name('salary-payments.store');
});