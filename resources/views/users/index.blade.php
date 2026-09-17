<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">Manage Users</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('generated_password'))
                    <div class="mb-4 p-4 bg-yellow-100 text-yellow-800 rounded border border-yellow-300">
                        <strong>Login credentials — copy these now, shown only once:</strong><br>
                        Email: <span class="font-mono">{{ session('generated_email') }}</span><br>
                        Password: <span class="font-mono font-bold">{{ session('generated_password') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                <a href="{{ route('users.create') }}" class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded">
                    + Create User
                </a>

                <table class="w-full border-collapse">
                    <thead>
                        <tr class="text-left border-b dark:border-gray-700 dark:text-gray-200">
                            <th class="py-2">Name</th>
                            <th class="py-2">Email</th>
                            <th class="py-2">Role</th>
                            <th class="py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="border-b dark:border-gray-700 dark:text-gray-300">
                                <td class="py-2">{{ $user->name }}</td>
                                <td class="py-2">{{ $user->email }}</td>
                                <td class="py-2 capitalize">{{ $user->role }}</td>
                                <td class="py-2">
                                    <form action="{{ route('users.reset-password', $user) }}" method="POST" class="inline" onsubmit="return confirm('Reset password for this user?')">
                                        @csrf
                                        <button type="submit" class="text-blue-600 text-sm">Reset Password</button>
                                    </form>
                                    @if ($user->id !== auth()->id())
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline ml-2" onsubmit="return confirm('Delete this user?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 text-sm">Delete</button>
                                        </form>
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