<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\Employee;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'admin') {
            $leaveRequests = LeaveRequest::with('employee')->orderBy('created_at', 'desc')->get();
            return view('leave-requests.index', compact('leaveRequests'));
        }

        $employee = Employee::where('email', auth()->user()->email)->first();
        $leaveRequests = $employee
            ? LeaveRequest::where('employee_id', $employee->id)->orderBy('created_at', 'desc')->get()
            : collect();

        return view('leave-requests.my-requests', compact('leaveRequests', 'employee'));
    }

    public function create()
    {
        $employee = Employee::where('email', auth()->user()->email)->first();
        return view('leave-requests.create', compact('employee'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:500',
        ]);

        $employee = Employee::where('email', auth()->user()->email)->first();

        if (!$employee) {
            return redirect()->route('leave-requests.index')->with('error', 'No employee record linked to your account.');
        }

        LeaveRequest::create([
            'employee_id' => $employee->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return redirect()->route('leave-requests.index')->with('success', 'Leave request submitted.');
    }

    public function approve(LeaveRequest $leaveRequest)
    {
        $leaveRequest->update(['status' => 'approved']);
        return back()->with('success', 'Leave request approved.');
    }

    public function reject(Request $request, LeaveRequest $leaveRequest)
    {
        $leaveRequest->update([
            'status' => 'rejected',
            'admin_note' => $request->admin_note,
        ]);
        return back()->with('success', 'Leave request rejected.');
    }
}