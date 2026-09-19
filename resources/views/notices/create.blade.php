<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">Post Notice</h2>
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

                <form action="{{ route('notices.store') }}" method="POST">
                    @csrf

                    <label class="block mb-1 font-medium dark:text-gray-200">Title</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="w-full border rounded p-2 mb-4 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>

                    <label class="block mb-1 font-medium dark:text-gray-200">Message</label>
                    <textarea name="message" rows="4" class="w-full border rounded p-2 mb-4 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>{{ old('message') }}</textarea>

                    <label class="block mb-1 font-medium dark:text-gray-200">Priority</label>
                    <select name="priority" class="w-full border rounded p-2 mb-4 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        <option value="normal" {{ old('priority') == 'normal' ? 'selected' : '' }}>Normal</option>
                        <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                    </select>

                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Post Notice</button>
                    <a href="{{ route('notices.index') }}" class="ml-2 text-gray-600 dark:text-gray-300">Cancel</a>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>