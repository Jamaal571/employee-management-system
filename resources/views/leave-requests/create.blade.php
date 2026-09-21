<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">Request Leave</h2>
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

            <form action="{{ route('leave-requests.store') }}" method="POST">
                @csrf

                <label class="block mb-1 font-medium dark:text-gray-200">Start Date</label>
                <input type="date" name="start_date" value="{{ old('start_date') }}" class="w-full border rounded p-2 mb-4 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>

                <label class="block mb-1 font-medium dark:text-gray-200">End Date</label>
                <input type="date" name="end_date" value="{{ old('end_date') }}" class="w-full border rounded p-2 mb-4 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>

                <label class="block mb-1 font-medium dark:text-gray-200">Reason</label>
                <textarea name="reason" rows="3" class="w-full border rounded p-2 mb-4 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>{{ old('reason') }}</textarea>

                <button type="submit" class="px-4 py-2 bg-brand-600 text-white rounded-lg btn-press">Submit Request</button>
                <a href="{{ route('leave-requests.index') }}" class="ml-2 text-gray-600 dark:text-gray-300">Cancel</a>
            </form>

        </div>
    </div>
</x-app-layout>