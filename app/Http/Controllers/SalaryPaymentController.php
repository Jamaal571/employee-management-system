<?php

namespace App\Http\Controllers;

use App\Models\SalaryPayment;
use App\Models\Employee;
use Illuminate\Http\Request;

class SalaryPaymentController extends Controller
{
    public function index()
    {
        $payments = SalaryPayment::with(['employee', 'paidBy'])->orderBy('paid_at', 'desc')->get();
        return view('salary-payments.index', compact('payments'));
    }

    public function store(Employee $employee)
    {
        SalaryPayment::create([
            'employee_id' => $employee->id,
            'amount' => $employee->salary,
            'currency' => $employee->currency,
            'phone' => $employee->phone,
            'paid_by' => auth()->id(),
            'paid_at' => now(),
        ]);

        return back()->with('success', "Salary marked as paid for {$employee->name}.");
    }
}