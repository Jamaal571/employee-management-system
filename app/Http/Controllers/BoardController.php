<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;

class BoardController extends Controller
{
    public function index()
    {
        $departments = Department::withCount('employees')->get();
        $totalEmployees = Employee::count();
        return view('board.index', compact('departments', 'totalEmployees'));
    }

    public function employees()
    {
        $employees = Employee::with('department')->get();
        return view('board.employees', compact('employees'));
    }
}