<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">Employee List</h2>
    </x-slot>

    <div class="py-8 px-4 lg:px-8 animate-fade-in">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl p-6">

            <a href="{{ route('board.index') }}" class="text-brand-600 text-sm mb-4 inline-block">&larr; Back to Overview</a>

            <table class="w-full border-collapse text-sm">
                <thead>
                    <tr class="text-left border-b dark:border-gray-700 dark:text-gray-200">
                        <th class="py-2">Name</th>
                        <th class="py-2">Position</th>
                        <th class="py-2">Department</th>
                        <th class="py-2">Hire Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($employees as $employee)
                        <tr class="border-b dark:border-gray-700 dark:text-gray-300 row-hover">
                            <td class="py-2">{{ $employee->name }}</td>
                            <td class="py-2">{{ $employee->position }}</td>
                            <td class="py-2">{{ $employee->department->name ?? 'N/A' }}</td>
                            <td class="py-2">{{ $employee->hire_date }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-4 text-center text-gray-500 dark:text-gray-400">No employees yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
</x-app-layout>