<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">Departments</h2>
    </x-slot>

    <div class="py-12">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('departments.create') }}" class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded">
                        + Add Department
                    </a>
                @endif

                <table class="w-full border-collapse">
                    <thead>
                        <tr class="text-left border-b dark:border-gray-700 dark:text-gray-200">
                            <th class="py-2">ID</th>
                            <th class="py-2">Name</th>
                            <th class="py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($departments as $department)
                            <tr class="border-b dark:border-gray-700 dark:text-gray-300">
                                <td class="py-2">{{ $department->id }}</td>
                                <td class="py-2">{{ $department->name }}</td>
                                <td class="py-2">
                                    @if (auth()->user()->role === 'admin')
                                        <a href="{{ route('departments.edit', $department) }}" class="text-blue-600">Edit</a>
                                        <form action="{{ route('departments.destroy', $department) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 ml-2">Delete</button>
                                        </form>
                                    @else
                                        <span class="text-gray-400 text-sm">View only</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>