@if (session('success') || session('error'))
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" class="fixed top-4 right-4 z-50 toast-enter">
    <div class="flex items-center gap-3 px-4 py-3 rounded-lg shadow-lg {{ session('success') ? 'bg-green-600' : 'bg-red-600' }} text-white max-w-sm">
        @if (session('success'))
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
        @else
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        @endif
        <span class="text-sm">{{ session('success') ?? session('error') }}</span>
        <button @click="show = false" class="ml-auto text-white/80 hover:text-white">&times;</button>
    </div>
</div>
@endif