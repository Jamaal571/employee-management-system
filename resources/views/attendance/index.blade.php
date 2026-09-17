<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">Attendance</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="GET" action="{{ route('attendance.index') }}" class="mb-6">
                    <label class="block mb-1 font-medium dark:text-gray-200">Select Date</label>
                    <div class="flex gap-2">
                        <input type="date" name="date" value="{{ $date }}" class="border rounded p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white" onchange="this.form.submit()">
                    </div>
                </form>

                <table class="w-full border-collapse">
                    <thead>
                        <tr class="text-left border-b dark:border-gray-700 dark:text-gray-200">
                            <th class="py-2">Employee</th>
                            <th class="py-2">Department</th>
                            <th class="py-2">Time In</th>
                            <th class="py-2">Time Out</th>
                            <th class="py-2">Status</th>
                            <th class="py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $employee)
                            @php
                                $attendance = $employee->attendances->first();
                            @endphp
                            <tr class="border-b dark:border-gray-700 dark:text-gray-300">
                                <td class="py-2">{{ $employee->name }}</td>
                                <td class="py-2">{{ $employee->department->name ?? 'N/A' }}</td>
                                <td class="py-2">
                                    <form method="POST" action="{{ route('attendance.store') }}" class="flex items-center gap-2">
                                        @csrf
                                        <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                                        <input type="hidden" name="date" value="{{ $date }}">
                                        <input type="time" name="time_in" value="{{ $attendance->time_in ?? '' }}" class="border rounded p-1 text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                </td>
                                <td class="py-2">
                                        <input type="time" name="time_out" value="{{ $attendance->time_out ?? '' }}" class="border rounded p-1 text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                </td>
                                <td class="py-2">
                                        <select name="status" class="border rounded p-1 text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                            <option value="present" {{ ($attendance->status ?? '') == 'present' ? 'selected' : '' }}>Present</option>
                                            <option value="late" {{ ($attendance->status ?? '') == 'late' ? 'selected' : '' }}>Late</option>
                                            <option value="absent" {{ ($attendance->status ?? '') == 'absent' ? 'selected' : '' }}>Absent</option>
                                        </select>
                                </td>
                                <td class="py-2">
                                        <button type="submit" class="px-3 py-1 bg-blue-600 text-white text-sm rounded">Save</button>
                                    </form>
                                    <a href="{{ route('attendance.history', $employee) }}" class="text-blue-600 text-sm ml-2">History</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>