<x-app-layout>
<x-slot name="header">
<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">Report Center</h2>
</x-slot>

<div class="py-8 px-4 lg:px-8 animate-fade-in space-y-6">

<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl p-6">
<form method="GET" action="{{ route('reports.index') }}" class="flex items-center gap-3">
<label class="text-sm font-medium text-gray-700 dark:text-gray-200">Select Report</label>
<select name="type" onchange="this.form.submit()" class="border rounded p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
<option value="departments" {{ $type == 'departments' ? 'selected' : '' }}>Department Summary</option>
<option value="employees" {{ $type == 'employees' ? 'selected' : '' }}>Employee List</option>
@if (!$isBoard)
<option value="salary" {{ $type == 'salary' ? 'selected' : '' }}>Salary Report</option>
@endif
<option value="leave" {{ $type == 'leave' ? 'selected' : '' }}>Leave Requests</option>
<option value="attendance" {{ $type == 'attendance' ? 'selected' : '' }}>Attendance</option>
</select>
</form>
</div>

@if ($type == 'departments')
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl p-6">
<h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200 mb-4">Department Headcount{{ !$isBoard ? ' & Salary Totals' : '' }}</h3>
<table class="w-full border-collapse text-sm">
<thead>
<tr class="text-left border-b dark:border-gray-700 dark:text-gray-200">
<th class="py-2">Department</th>
<th class="py-2">Employees</th>
@if (!$isBoard)
<th class="py-2">Total Salary</th>
@endif
</tr>
</thead>
<tbody>
@forelse ($departmentReport as $dept)
<tr class="border-b dark:border-gray-700 dark:text-gray-300">
<td class="py-2">{{ $dept['name'] }}</td>
<td class="py-2">{{ $dept['count'] }}</td>
@if (!$isBoard)
<td class="py-2">${{ number_format($dept['total_salary'], 2) }}</td>
@endif
</tr>
@empty
<tr><td colspan="3" class="py-4 text-center text-gray-500">No departments yet.</td></tr>
@endforelse
</tbody>
</table>
</div>
@endif

@if ($type == 'employees')
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl p-6">
<h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200 mb-4">Employee List</h3>
<table class="w-full border-collapse text-sm">
<thead>
<tr class="text-left border-b dark:border-gray-700 dark:text-gray-200">
<th class="py-2">Name</th>
<th class="py-2">Position</th>
<th class="py-2">Department</th>
<th class="py-2">Hire Date</th>
@if (!$isBoard)
<th class="py-2">Salary</th>
@endif
</tr>
</thead>
<tbody>
@forelse ($employees as $employee)
<tr class="border-b dark:border-gray-700 dark:text-gray-300">
<td class="py-2">{{ $employee->name }}</td>
<td class="py-2">{{ $employee->position }}</td>
<td class="py-2">{{ $employee->department->name ?? 'N/A' }}</td>
<td class="py-2">{{ $employee->hire_date }}</td>
@if (!$isBoard)
<td class="py-2">{{ $employee->currency == 'SLSH' ? number_format($employee->salary, 2) . ' SLSH' : '$' . number_format($employee->salary, 2) }}</td>
@endif
</tr>
@empty
<tr><td colspan="5" class="py-4 text-center text-gray-500">No employees yet.</td></tr>
@endforelse
</tbody>
</table>
</div>
@endif

@if ($type == 'salary' && !$isBoard)
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl p-6">
<h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Total Payroll: ${{ number_format($totalPayroll, 2) }}</h3>
<table class="w-full border-collapse text-sm mt-4">
<thead>
<tr class="text-left border-b dark:border-gray-700 dark:text-gray-200">
<th class="py-2">Department</th>
<th class="py-2">Total Salary</th>
<th class="py-2">Average Salary</th>
</tr>
</thead>
<tbody>
@forelse ($salaryByDept as $dept)
<tr class="border-b dark:border-gray-700 dark:text-gray-300">
<td class="py-2">{{ $dept['name'] }}</td>
<td class="py-2">${{ number_format($dept['total'], 2) }}</td>
<td class="py-2">${{ number_format($dept['avg'], 2) }}</td>
</tr>
@empty
<tr><td colspan="3" class="py-4 text-center text-gray-500">No departments yet.</td></tr>
@endforelse
</tbody>
</table>
</div>
@endif

@if ($type == 'leave')
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl p-6">
<h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200 mb-4">Leave Request Summary</h3>
<div class="grid grid-cols-3 gap-4 text-center">
<div class="p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
<div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $leaveReport['pending'] }}</div>
<div class="text-xs text-gray-500 dark:text-gray-400">Pending</div>
</div>
<div class="p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
<div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $leaveReport['approved'] }}</div>
<div class="text-xs text-gray-500 dark:text-gray-400">Approved</div>
</div>
<div class="p-4 bg-red-50 dark:bg-red-900/20 rounded-lg">
<div class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $leaveReport['rejected'] }}</div>
<div class="text-xs text-gray-500 dark:text-gray-400">Rejected</div>
</div>
</div>
</div>
@endif

@if ($type == 'attendance')
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl p-6">
<h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200 mb-4">Attendance Summary (All Time)</h3>
<div class="grid grid-cols-3 gap-4 text-center">
<div class="p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
<div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $attendanceReport['present'] }}</div>
<div class="text-xs text-gray-500 dark:text-gray-400">Present</div>
</div>
<div class="p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
<div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $attendanceReport['late'] }}</div>
<div class="text-xs text-gray-500 dark:text-gray-400">Late</div>
</div>
<div class="p-4 bg-red-50 dark:bg-red-900/20 rounded-lg">
<div class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $attendanceReport['absent'] }}</div>
<div class="text-xs text-gray-500 dark:text-gray-400">Absent</div>
</div>
</div>
</div>
@endif

</div>
</x-app-layout>