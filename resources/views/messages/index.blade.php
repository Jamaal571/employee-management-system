<x-app-layout>
<x-slot name="header">
<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">Messages</h2>
</x-slot>

<div class="py-8 px-4 lg:px-8 animate-fade-in">
<div class="w-full bg-white dark:bg-gray-800 shadow-sm rounded-xl overflow-hidden">

@forelse ($conversations as $conv)
@if ($conv['is_admin_thread'])
<a href="{{ route('messages.admin') }}" class="flex items-center gap-4 px-6 py-4 border-b dark:border-gray-700 last:border-0 hover:bg-gray-50 dark:hover:bg-gray-700/50 row-hover">
<div class="w-10 h-10 rounded-full bg-purple-600 text-white flex items-center justify-center text-sm font-semibold shrink-0">A</div>
<div class="flex-1 min-w-0">
<div class="flex justify-between items-center">
<span class="flex items-center gap-2">
<span class="font-medium text-gray-800 dark:text-gray-100">Admin</span>
<span class="px-2 py-0.5 rounded text-xs bg-purple-100 text-purple-700">Admin</span>
</span>
@if ($conv['last_message'])
<span class="text-xs text-gray-400">{{ $conv['last_message']->created_at->diffForHumans() }}</span>
@endif
</div>
<p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ $conv['last_message'] ? $conv['last_message']->body : 'No messages yet' }}</p>
</div>
@if ($conv['unread_count'] > 0)
<span class="w-5 h-5 bg-brand-600 text-white text-xs rounded-full flex items-center justify-center shrink-0">{{ $conv['unread_count'] }}</span>
@endif
</a>
@else
<a href="{{ route('messages.show', $conv['user']) }}" class="flex items-center gap-4 px-6 py-4 border-b dark:border-gray-700 last:border-0 hover:bg-gray-50 dark:hover:bg-gray-700/50 row-hover">
<div class="w-10 h-10 rounded-full bg-brand-600 text-white flex items-center justify-center text-sm font-semibold shrink-0">{{ strtoupper(substr($conv['user']->name, 0, 1)) }}</div>
<div class="flex-1 min-w-0">
<div class="flex justify-between items-center">
<span class="flex items-center gap-2">
<span class="font-medium text-gray-800 dark:text-gray-100">{{ $conv['user']->name }}</span>
<span class="px-2 py-0.5 rounded text-xs
@if($conv['user']->role == 'board') bg-blue-100 text-blue-700
@else bg-gray-100 text-gray-600
@endif">
{{ ucfirst($conv['user']->role) }}
</span>
</span>
@if ($conv['last_message'])
<span class="text-xs text-gray-400">{{ $conv['last_message']->created_at->diffForHumans() }}</span>
@endif
</div>
<p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ $conv['last_message'] ? $conv['last_message']->body : 'No messages yet' }}</p>
</div>
@if ($conv['unread_count'] > 0)
<span class="w-5 h-5 bg-brand-600 text-white text-xs rounded-full flex items-center justify-center shrink-0">{{ $conv['unread_count'] }}</span>
@endif
</a>
@endif
@empty
<p class="text-gray-500 dark:text-gray-400 text-sm p-6">No conversations available.</p>
@endforelse

</div>
</div>
</x-app-layout>