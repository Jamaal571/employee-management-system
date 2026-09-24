<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">Create User</h2>
    </x-slot>

    <div class="py-8 px-4 lg:px-8 animate-fade-in">
        <div class="max-w-lg mx-auto bg-white dark:bg-gray-800 shadow-sm rounded-xl p-6">

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" x-data="{ role: '{{ old('role', '') }}' }">
                @csrf

                <label class="block mb-1 font-medium dark:text-gray-200">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded p-2 mb-4 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>

                <label class="block mb-1 font-medium dark:text-gray-200">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded p-2 mb-4 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>

                <label class="block mb-1 font-medium dark:text-gray-200">Role</label>
              <select name="role" x-model="role" class="w-full border rounded p-2 mb-4 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
    <option value="">Select Role</option>
    <option value="admin">Admin</option>
    <option value="employee">Employee</option>
    <option value="board">Board Member</option>
</select>

                <div x-show="role === 'employee'" x-cloak class="border-t dark:border-gray-700 pt-4 mt-2 space-y-4">
                    <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Employee Details</p>

                    <div>
                        <label class="block mb-1 font-medium dark:text-gray-200">Phone</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="w-full border rounded p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>

                    <div>
                        <label class="block mb-1 font-medium dark:text-gray-200">Position</label>
                        <input type="text" name="position" value="{{ old('position') }}" class="w-full border rounded p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>

                    <div>
                        <label class="block mb-1 font-medium dark:text-gray-200">Salary</label>
                        <div class="flex gap-2">
                            <input type="number" step="0.01" name="salary" value="{{ old('salary') }}" class="flex-1 border rounded p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <select name="currency" class="border rounded p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="USD">USD ($)</option>
                                <option value="SLSH">SLSH</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block mb-1 font-medium dark:text-gray-200">Hire Date</label>
                        <input type="date" name="hire_date" value="{{ old('hire_date') }}" class="w-full border rounded p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>

                    <div>
                        <label class="block mb-1 font-medium dark:text-gray-200">Department</label>
                        <select name="department_id" class="w-full border rounded p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">Select Department</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block mb-1 font-medium dark:text-gray-200">Photo</label>
                        <input type="file" name="photo" accept="image/*" class="w-full border rounded p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                </div>

                <p class="text-sm text-gray-500 dark:text-gray-400 my-4">A random password will be generated automatically and shown once after creating this user.</p>

                <button type="submit" class="px-4 py-2 bg-brand-600 text-white rounded-lg btn-press">Create User</button>
                <a href="{{ route('users.index') }}" class="ml-2 text-gray-600 dark:text-gray-300">Cancel</a>
            </form>

        </div>
    </div>
</x-app-layout>