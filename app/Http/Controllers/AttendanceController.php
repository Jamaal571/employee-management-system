<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->input('date', now()->toDateString());

        $employees = Employee::with(['attendances' => function ($query) use ($date) {
            $query->where('date', $date);
        }])->get();

        return view('attendance.index', compact('employees', 'date'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'time_in' => 'nullable|date_format:H:i',
            'time_out' => 'nullable|date_format:H:i',
            'status' => 'required|in:present,late,absent',
        ]);

        $data = $request->all();

        // Auto-mark as late if time_in is after 9:00 AM
        if ($request->status === 'present' && $request->time_in && $request->time_in > '09:00') {
            $data['status'] = 'late';
        }

        Attendance::updateOrCreate(
            ['employee_id' => $request->employee_id, 'date' => $request->date],
            $data
        );

        return redirect()->route('attendance.index', ['date' => $request->date])
            ->with('success', 'Attendance recorded successfully.');
    }

    public function history(Employee $employee)
    {
        $attendances = $employee->attendances()->orderBy('date', 'desc')->paginate(15);
        return view('attendance.history', compact('employee', 'attendances'));
    }
}