<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Attendance History — {{ $employee->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <a href="{{ route('attendance.index') }}" class="text-blue-600 text-sm mb-4 inline-block">&larr; Back to Attendance</a>

                <table class="w-full border-collapse">
                    <thead>
                        <tr class="text-left border-b dark:border-gray-700 dark:text-gray-200">
                            <th class="py-2">Date</th>
                            <th class="py-2">Time In</th>
                            <th class="py-2">Time Out</th>
                            <th class="py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($attendances as $attendance)
                            <tr class="border-b dark:border-gray-700 dark:text-gray-300">
                                <td class="py-2">{{ $attendance->date }}</td>
                                <td class="py-2">{{ $attendance->time_in ?? '-' }}</td>
                                <td class="py-2">{{ $attendance->time_out ?? '-' }}</td>
                                <td class="py-2">
                                    <span class="px-2 py-1 rounded text-xs
                                        @if($attendance->status == 'present') bg-green-100 text-green-700
                                        @elseif($attendance->status == 'late') bg-yellow-100 text-yellow-700
                                        @else bg-red-100 text-red-700
                                        @endif">
                                        {{ ucfirst($attendance->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-4 text-center text-gray-500 dark:text-gray-400">No attendance records yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $attendances->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>