<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $isBoard = auth()->user()->role === 'board';
        $type = $request->input('type', 'departments');

        $data = [];

        if ($type === 'employees') {
            $data['employees'] = Employee::with('department')->get();
        }

        if ($type === 'departments') {
            $data['departmentReport'] = Department::withCount('employees')
                ->with('employees')
                ->get()
                ->map(function ($dept) {
                    return [
                        'name' => $dept->name,
                        'count' => $dept->employees_count,
                        'total_salary' => $dept->employees->sum('salary'),
                    ];
                });
        }

        if ($type === 'salary' && !$isBoard) {
            $data['salaryByDept'] = Department::with('employees')->get()->map(function ($dept) {
                return [
                    'name' => $dept->name,
                    'total' => $dept->employees->sum('salary'),
                    'avg' => $dept->employees->count() ? round($dept->employees->avg('salary'), 2) : 0,
                ];
            });
            $data['totalPayroll'] = Employee::sum('salary');
        }

        if ($type === 'leave') {
            $data['leaveReport'] = [
                'pending' => LeaveRequest::where('status', 'pending')->count(),
                'approved' => LeaveRequest::where('status', 'approved')->count(),
                'rejected' => LeaveRequest::where('status', 'rejected')->count(),
            ];
        }

        if ($type === 'attendance') {
            $data['attendanceReport'] = [
                'present' => Attendance::where('status', 'present')->count(),
                'late' => Attendance::where('status', 'late')->count(),
                'absent' => Attendance::where('status', 'absent')->count(),
            ];
        }

        return view('reports.index', array_merge($data, ['type' => $type, 'isBoard' => $isBoard]));
    }
}