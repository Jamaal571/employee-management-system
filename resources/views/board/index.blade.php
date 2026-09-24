<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">Company Overview</h2>
    </x-slot>

    <div class="py-8 px-4 lg:px-8 animate-fade-in">

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl p-6 card-hover mb-6">
            <div class="text-gray-500 dark:text-gray-400 text-sm mb-1">Total Employees</div>
            <div class="text-3xl font-bold text-brand-600 dark:text-brand-400">{{ $totalEmployees }}</div>
            <a href="{{ route('board.employees') }}" class="inline-block mt-3 px-4 py-2 bg-brand-600 text-white text-sm rounded-lg hover:bg-brand-700 btn-press">View Employee List</a>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl p-6 card-hover">
            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200 mb-4">Employees per Department</h3>
            <table class="w-full border-collapse text-sm">
                <thead>
                    <tr class="text-left border-b dark:border-gray-700 dark:text-gray-200">
                        <th class="py-2">Department</th>
                        <th class="py-2">Employee Count</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($departments as $dept)
                        <tr class="border-b dark:border-gray-700 dark:text-gray-300 row-hover">
                            <td class="py-2">{{ $dept->name }}</td>
                            <td class="py-2">{{ $dept->employees_count }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="py-4 text-center text-gray-500 dark:text-gray-400">No departments yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>