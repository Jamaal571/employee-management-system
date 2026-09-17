<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (auth()->user()->role === 'admin')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="text-gray-500 dark:text-gray-400 text-sm mb-1">Total Employees</div>
                        <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $totalEmployees }}</div>
                        <a href="{{ route('employees.index') }}" class="inline-block mt-2 px-3 py-1.5 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">View All Employees</a>
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="text-gray-500 dark:text-gray-400 text-sm mb-1">Total Departments</div>
                        <div class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $totalDepartments }}</div>
                        <a href="{{ route('departments.index') }}" class="inline-block mt-2 px-3 py-1.5 bg-green-600 text-white text-sm rounded hover:bg-green-700">View All Departments</a>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{ __("Welcome to the Employee Management System.") }}
                    </div>
                </div>

            @else

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                    <!-- Your Information -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Your Information</h3>

                        @if ($employee)
                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between border-b dark:border-gray-700 pb-2">
                                    <span class="text-gray-500 dark:text-gray-400">Name</span>
                                    <span class="text-gray-800 dark:text-gray-200 font-medium">{{ $employee->name }}</span>
                                </div>
                               <div class="flex justify-between border-b dark:border-gray-700 pb-2">
    <span class="text-gray-500 dark:text-gray-400">Salary</span>
    <span class="text-gray-800 dark:text-gray-200 font-medium">{{ $employee->currency == 'SLSH' ? number_format($employee->salary, 2) . ' SLSH' : '$' . number_format($employee->salary, 2) }}</span>
</div>
                                <div class="flex justify-between border-b dark:border-gray-700 pb-2">
                                    <span class="text-gray-500 dark:text-gray-400">Position</span>
                                    <span class="text-gray-800 dark:text-gray-200 font-medium">{{ $employee->position }}</span>
                                </div>
                                <div class="flex justify-between border-b dark:border-gray-700 pb-2">
                                    <span class="text-gray-500 dark:text-gray-400">Department</span>
                                    <span class="text-gray-800 dark:text-gray-200 font-medium">{{ $employee->department->name ?? 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between border-b dark:border-gray-700 pb-2">
                                    <span class="text-gray-500 dark:text-gray-400">Salary</span>
                                    <span class="text-gray-800 dark:text-gray-200 font-medium">{{ number_format($employee->salary, 2) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500 dark:text-gray-400">Hire Date</span>
                                    <span class="text-gray-800 dark:text-gray-200 font-medium">{{ $employee->hire_date }}</span>
                                </div>
                            </div>
                        @else
                            <p class="text-gray-500 dark:text-gray-400 text-sm">No employee record linked to your account yet.</p>
                        @endif
                    </div>

                    <!-- Your Attendance -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Your Attendance</h3>

                        @if ($attendances->count())
                            <table class="w-full text-sm border-collapse">
                                <thead>
                                    <tr class="text-left border-b dark:border-gray-700 dark:text-gray-300">
                                        <th class="py-1">Date</th>
                                        <th class="py-1">Time In</th>
                                        <th class="py-1">Time Out</th>
                                        <th class="py-1">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($attendances as $attendance)
                                        <tr class="border-b dark:border-gray-700 dark:text-gray-300">
                                            <td class="py-1">{{ $attendance->date }}</td>
                                            <td class="py-1">{{ $attendance->time_in ?? '-' }}</td>
                                            <td class="py-1">{{ $attendance->time_out ?? '-' }}</td>
                                            <td class="py-1">
                                                <span class="px-2 py-0.5 rounded text-xs
                                                    @if($attendance->status == 'present') bg-green-100 text-green-700
                                                    @elseif($attendance->status == 'late') bg-yellow-100 text-yellow-700
                                                    @else bg-red-100 text-red-700
                                                    @endif">
                                                    {{ ucfirst($attendance->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-gray-500 dark:text-gray-400 text-sm">No attendance records yet.</p>
                        @endif
                    </div>

                </div>

            @endif

        </div>
    </div>
</x-app-layout>