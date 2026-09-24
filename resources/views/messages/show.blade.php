<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('messages.index') }}" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight flex items-center gap-2">
    {{ $user->name }}
    <span class="px-2 py-0.5 rounded text-xs
        @if($user->role == 'admin') bg-purple-100 text-purple-700
        @elseif($user->role == 'board') bg-blue-100 text-blue-700
        @else bg-gray-100 text-gray-600
        @endif">
        {{ ucfirst($user->role) }}
    </span>
</h2>
        </div>
    </x-slot>

    <div class="py-8 px-4 lg:px-8 animate-fade-in" x-data="chatBox()" x-init="init()">
     <div class="w-full bg-white dark:bg-gray-800 shadow-sm rounded-xl overflow-hidden flex flex-col" style="height: 65vh;">

            <div class="flex-1 overflow-y-auto p-6 space-y-3" id="chat-scroll">
                <template x-for="message in messages" :key="message.id">
                    <div>
                        <div x-show="message.is_mine" class="flex justify-end group">
                            <div class="flex items-end gap-1">
                                <form :action="'/messages/' + message.id" method="POST" @submit.prevent="deleteMessage(message.id)" x-show="!message.is_deleted" class="opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button type="submit" class="text-gray-400 hover:text-red-500 text-xs">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </form>
                                <div :class="message.is_deleted ? 'bg-gray-200 dark:bg-gray-600 italic text-gray-500 dark:text-gray-400' : 'bg-brand-600 text-white'" class="px-4 py-2 rounded-2xl rounded-br-sm max-w-xs">
                                    <p class="text-sm" x-text="message.is_deleted ? 'This message was deleted' : message.body"></p>
                                    <div class="flex items-center justify-end gap-1 mt-1">
                                        <span :class="message.is_deleted ? 'text-gray-400' : 'text-brand-100'" class="text-xs" x-text="message.time"></span>
                                        <template x-if="!message.is_deleted">
                                            <div class="flex -space-x-1.5">
                                                <svg class="w-3.5 h-3.5" :class="message.is_read ? 'text-sky-300' : 'text-brand-200'" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4 12l4 4L18 6" /></svg>
                                                <svg class="w-3.5 h-3.5" :class="message.is_read ? 'text-sky-300' : 'text-brand-200'" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4 12l4 4L18 6" /></svg>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div x-show="!message.is_mine" class="flex justify-start">
                            <div :class="message.is_deleted ? 'bg-gray-100 dark:bg-gray-700 italic text-gray-400' : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100'" class="px-4 py-2 rounded-2xl rounded-bl-sm max-w-xs">
                                <p class="text-sm" x-text="message.is_deleted ? 'This message was deleted' : message.body"></p>
                                <p class="text-xs text-gray-400 mt-1" x-text="message.time"></p>
                            </div>
                        </div>
                    </div>
                </template>
                <p x-show="messages.length === 0" class="text-gray-500 dark:text-gray-400 text-sm text-center mt-10">No messages yet. Say hello!</p>
            </div>

            <form @submit.prevent="sendMessage()" class="border-t dark:border-gray-700 p-4 flex gap-2">
                <input type="text" x-model="newBody" placeholder="Type a message..." class="flex-1 border rounded-lg p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required autofocus>
                <button type="submit" class="px-4 py-2 bg-brand-600 text-white rounded-lg hover:bg-brand-700 btn-press">Send</button>
            </form>

        </div>
    </div>

    <script>
        function chatBox() {
            return {
                messages: [],
                newBody: '',
                pollUrl: '{{ route('messages.poll', $user) }}',
                storeUrl: '{{ route('messages.store', $user) }}',

                init() {
                    this.fetchMessages();
                    setInterval(() => this.fetchMessages(), 3000);
                },

                fetchMessages() {
                    fetch(this.pollUrl)
                        .then(res => res.json())
                        .then(data => {
                            const wasAtBottom = this.isNearBottom();
                            this.messages = data;
                            if (wasAtBottom) {
                                this.$nextTick(() => this.scrollToBottom());
                            }
                        });
                },

                sendMessage() {
                    if (!this.newBody.trim()) return;
                    const body = this.newBody;
                    this.newBody = '';

                    fetch(this.storeUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ body: body }),
                    }).then(() => {
                        this.fetchMessages();
                        this.$nextTick(() => this.scrollToBottom());
                    });
                },

                deleteMessage(id) {
                    if (!confirm('Delete this message?')) return;

                    fetch('/messages/' + id, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                    }).then(() => this.fetchMessages());
                },

                isNearBottom() {
                    const el = document.getElementById('chat-scroll');
                    if (!el) return true;
                    return el.scrollHeight - el.scrollTop - el.clientHeight < 100;
                },

                scrollToBottom() {
                    const el = document.getElementById('chat-scroll');
                    if (el) el.scrollTop = el.scrollHeight;
                }
            }
        }
    </script>
</x-app-layout>