<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">Edit Employee</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
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

                <form action="{{ route('employees.update', $employee) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <label class="block mb-1 font-medium dark:text-gray-200">Name</label>
                    <input type="text" name="name" value="{{ $employee->name }}" class="w-full border rounded p-2 mb-4 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>

                    <label class="block mb-1 font-medium dark:text-gray-200">Email</label>
                    <input type="email" name="email" value="{{ $employee->email }}" class="w-full border rounded p-2 mb-4 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>

                    <label class="block mb-1 font-medium dark:text-gray-200">Phone</label>
                    <input type="text" name="phone" value="{{ $employee->phone }}" class="w-full border rounded p-2 mb-4 dark:bg-gray-700 dark:border-gray-600 dark:text-white">

                    <label class="block mb-1 font-medium dark:text-gray-200">Position</label>
                    <input type="text" name="position" value="{{ $employee->position }}" class="w-full border rounded p-2 mb-4 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>

                    <label class="block mb-1 font-medium dark:text-gray-200">Salary</label>
                    <div class="flex gap-2 mb-4">
                        <input type="number" step="0.01" name="salary" value="{{ $employee->salary }}" class="flex-1 border rounded p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        <select name="currency" class="border rounded p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="USD" {{ $employee->currency == 'USD' ? 'selected' : '' }}>USD ($)</option>
                            <option value="SLSH" {{ $employee->currency == 'SLSH' ? 'selected' : '' }}>SLSH</option>
                        </select>
                    </div>

                    <label class="block mb-1 font-medium dark:text-gray-200">Hire Date</label>
                    <input type="date" name="hire_date" value="{{ $employee->hire_date }}" class="w-full border rounded p-2 mb-4 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>

                    <label class="block mb-1 font-medium dark:text-gray-200">Department</label>
                    <select name="department_id" class="w-full border rounded p-2 mb-4 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}" {{ $employee->department_id == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>

                    <label class="block mb-1 font-medium dark:text-gray-200">Photo</label>
                    @if ($employee->photo)
                        <img src="{{ asset('storage/' . $employee->photo) }}" class="w-20 h-20 object-cover rounded mb-2">
                    @endif
                    <input type="file" name="photo" accept="image/*" class="w-full border rounded p-2 mb-4 dark:bg-gray-700 dark:border-gray-600 dark:text-white">

                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
                    <a href="{{ route('employees.index') }}" class="ml-2 text-gray-600 dark:text-gray-300">Cancel</a>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>