<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-300">
        For security, you must set a new password before continuing.
    </div>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.force-update') }}">
        @csrf

        <label class="block mb-1 font-medium dark:text-gray-200">New Password</label>
        <input type="password" name="password" class="w-full border rounded p-2 mb-4 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>

        <label class="block mb-1 font-medium dark:text-gray-200">Confirm New Password</label>
        <input type="password" name="password_confirmation" class="w-full border rounded p-2 mb-4 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>

        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded w-full">Set New Password</button>
    </form>
</x-guest-layout>