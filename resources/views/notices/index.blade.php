<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">Notices</h2>
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
                    <a href="{{ route('notices.create') }}" class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded">
                        + Post Notice
                    </a>
                @endif

                @forelse ($notices as $notice)
                    <div class="mb-4 p-4 rounded border-l-4 {{ $notice->priority == 'urgent' ? 'border-red-500 bg-red-50 dark:bg-red-900/20' : 'border-blue-500 bg-blue-50 dark:bg-blue-900/20' }}">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-semibold text-gray-800 dark:text-gray-100">
                                    {{ $notice->title }}
                                    @if ($notice->priority == 'urgent')
                                        <span class="ml-2 px-2 py-0.5 text-xs bg-red-600 text-white rounded">URGENT</span>
                                    @endif
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">{{ $notice->message }}</p>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">
                                    Posted by {{ $notice->creator->name ?? 'Admin' }} on {{ $notice->created_at->format('M d, Y - h:i A') }}
                                </p>
                            </div>
                            @if (auth()->user()->role === 'admin')
                                <form action="{{ route('notices.destroy', $notice) }}" method="POST" onsubmit="return confirm('Delete this notice?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 text-sm">Delete</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400 text-sm">No notices posted yet.</p>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>