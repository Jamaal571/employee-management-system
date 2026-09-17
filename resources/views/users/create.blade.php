<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">Create User</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('users.store') }}" method="POST">
                    @csrf

                    <label class="block mb-1 font-medium dark:text-gray-200">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded p-2 mb-4 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>

                    <label class="block mb-1 font-medium dark:text-gray-200">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded p-2 mb-4 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>

                    <label class="block mb-1 font-medium dark:text-gray-200">Role</label>
                    <select name="role" class="w-full border rounded p-2 mb-4 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        <option value="">Select Role</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="employee" {{ old('role') == 'employee' ? 'selected' : '' }}>Employee</option>
                    </select>

                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">A random password will be generated automatically and shown once after creating this user.</p>

                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Create User</button>
                    <a href="{{ route('users.index') }}" class="ml-2 text-gray-600 dark:text-gray-300">Cancel</a>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>