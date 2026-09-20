<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('messages.index') }}" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">{{ $user->name }}</h2>
        </div>
    </x-slot>

    <div class="py-8 px-4 lg:px-8 animate-fade-in">
        <div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 shadow-sm rounded-xl overflow-hidden flex flex-col" style="height: 65vh;">

            <div class="flex-1 overflow-y-auto p-6 space-y-3">
                @forelse ($messages as $message)
                    @if ($message->sender_id === auth()->id())
                        <div class="flex justify-end">
                            <div class="bg-brand-600 text-white px-4 py-2 rounded-2xl rounded-br-sm max-w-xs animate-slide-up">
                                <p class="text-sm">{{ $message->body }}</p>
                                <p class="text-xs text-brand-100 mt-1">{{ $message->created_at->format('h:i A') }}</p>
                            </div>
                        </div>
                    @else
                        <div class="flex justify-start">
                            <div class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100 px-4 py-2 rounded-2xl rounded-bl-sm max-w-xs animate-slide-up">
                                <p class="text-sm">{{ $message->body }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $message->created_at->format('h:i A') }}</p>
                            </div>
                        </div>
                    @endif
                @empty
                    <p class="text-gray-500 dark:text-gray-400 text-sm text-center mt-10">No messages yet. Say hello!</p>
                @endforelse
            </div>

            <form action="{{ route('messages.store', $user) }}" method="POST" class="border-t dark:border-gray-700 p-4 flex gap-2">
                @csrf
                <input type="text" name="body" placeholder="Type a message..." class="flex-1 border rounded-lg p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required autofocus>
                <button type="submit" class="px-4 py-2 bg-brand-600 text-white rounded-lg hover:bg-brand-700 btn-press">Send</button>
            </form>

        </div>
    </div>
</x-app-layout>