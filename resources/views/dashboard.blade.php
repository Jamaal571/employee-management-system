<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8 px-4 lg:px-8 animate-fade-in">

        @if (auth()->user()->role === 'admin')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl p-6 card-hover">
                    <div class="flex items-center justify-between mb-3">
                        <div class="text-gray-500 dark:text-gray-400 text-sm">Total Employees</div>
                        <div class="w-14 h-14 bg-brand-100 dark:bg-brand-900/40 rounded-lg flex items-center justify-center">
                            <svg class="w-7 h-7 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-5.13a4 4 0 11-8 0 4 4 0 018 0zm6 3a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                  <div class="text-3xl font-bold text-brand-600 dark:text-brand-400" x-data="{ count: 0 }" x-init="let target = {{ $totalEmployees }}; let step = Math.max(1, Math.ceil(target/30)); let interval = setInterval(() => { count += step; if (count >= target) { count = target; clearInterval(interval); } }, 30)" x-text="count"></div>
                    <a href="{{ route('employees.index') }}" class="inline-block mt-3 px-4 py-2 bg-brand-600 text-white text-sm rounded-lg hover:bg-brand-700 btn-press">View All Employees</a>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl p-6 card-hover">
                    <div class="flex items-center justify-between mb-3">
                        <div class="text-gray-500 dark:text-gray-400 text-sm">Total Departments</div>
                        <div class="w-14 h-14 bg-green-100 dark:bg-green-900/40 rounded-lg flex items-center justify-center">
                            <svg class="w-7 h-7 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5" />
                            </svg>
                        </div>
                    </div>
                    <div class="text-3xl font-bold text-green-600 dark:text-green-400" x-data="{ count: 0 }" x-init="let target = {{ $totalDepartments }}; let step = Math.max(1, Math.ceil(target/30)); let interval = setInterval(() => { count += step; if (count >= target) { count = target; clearInterval(interval); } }, 30)" x-text="count"></div>
                    <a href="{{ route('departments.index') }}" class="inline-block mt-3 px-4 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 btn-press">View All Departments</a>
                </div>
            </div>

       

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl card-hover">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Welcome to the Employee Management System.") }}
                </div>
            </div>


        @else

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl p-6 card-hover">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Your Information</h3>

                    @if ($employee)
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between border-b dark:border-gray-700 pb-2">
                                <span class="text-gray-500 dark:text-gray-400">Name</span>
                                <span class="text-gray-800 dark:text-gray-200 font-medium">{{ $employee->name }}</span>
                            </div>
                            <div class="flex justify-between border-b dark:border-gray-700 pb-2">
                                <span class="text-gray-500 dark:text-gray-400">Email</span>
                                <span class="text-gray-800 dark:text-gray-200 font-medium">{{ $employee->email }}</span>
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
                                <span class="text-gray-800 dark:text-gray-200 font-medium">{{ $employee->currency == 'SLSH' ? number_format($employee->salary, 2) . ' SLSH' : '$' . number_format($employee->salary, 2) }}</span>
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

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl p-6 card-hover">
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
                                    <tr class="border-b dark:border-gray-700 dark:text-gray-300 row-hover hover:bg-gray-50 dark:hover:bg-gray-700/50">
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
</x-app-layout>