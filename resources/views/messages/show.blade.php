<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('messages.index') }}" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">{{ $user->name }}</h2>
        </div>
    </x-slot>

    <div class="py-8 px-4 lg:px-8 animate-fade-in" x-data="chatBox()" x-init="init()">
        <div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 shadow-sm rounded-xl overflow-hidden flex flex-col" style="height: 65vh;">

            <div class="flex-1 overflow-y-auto p-6 space-y-3" id="chat-scroll">
                <template x-for="message in messages" :key="message.id">
                    <div :class="message.is_mine ? 'flex justify-end' : 'flex justify-start'">
                        <div :class="message.is_mine ? 'bg-brand-600 text-white rounded-br-sm' : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100 rounded-bl-sm'" class="px-4 py-2 rounded-2xl max-w-xs">
                            <p class="text-sm" x-text="message.body"></p>
                            <p :class="message.is_mine ? 'text-brand-100' : 'text-gray-400'" class="text-xs mt-1" x-text="message.time"></p>
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