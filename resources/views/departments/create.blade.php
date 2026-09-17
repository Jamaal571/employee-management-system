<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">Add Department</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('departments.store') }}" method="POST">
                    @csrf
                    <label class="block mb-2 font-medium dark:text-gray-200">Department Name</label>
                    <input type="text" name="name" class="w-full border rounded p-2 mb-4 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>

                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
                    <a href="{{ route('departments.index') }}" class="ml-2 text-gray-600 dark:text-gray-300">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>