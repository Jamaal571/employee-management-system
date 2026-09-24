<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ dark: localStorage.getItem('darkMode') === 'true' }" x-init="$watch('dark', val => localStorage.setItem('darkMode', val))" :class="{ 'dark': dark }">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ config('app.name', 'Laravel') }}</title>
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased dark:bg-gray-900" x-data="{ sidebarOpen: false }">
<div class="min-h-screen flex bg-gray-50 dark:bg-gray-900">
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-30 w-64 bg-brand-900 dark:bg-gray-950 transform transition-transform duration-200 lg:translate-x-0 lg:static lg:inset-0">
<div class="flex items-center gap-3 px-6 h-16 border-b border-white/10">
<span class="text-white font-semibold text-sm">EMS</span>
</div>
<nav class="px-3 py-4 space-y-1">
@if (auth()->user()->role === 'board')
<a href="{{ route('board.index') }}" class="block px-3 py-2 rounded-lg text-sm text-brand-100">Company Overview</a>
<a href="{{ route('messages.index') }}" class="block px-3 py-2 rounded-lg text-sm text-brand-100">Messages</a>
<a href="{{ route('reports.index') }}" class="block px-3 py-2 rounded-lg text-sm text-brand-100">Reports</a>
@else
<a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-lg text-sm text-brand-100">Dashboard</a>
<a href="{{ route('notices.index') }}" class="block px-3 py-2 rounded-lg text-sm text-brand-100">Notices</a>
<a href="{{ route('messages.index') }}" class="block px-3 py-2 rounded-lg text-sm text-brand-100">Messages</a>
<a href="{{ route('leave-requests.index') }}" class="block px-3 py-2 rounded-lg text-sm text-brand-100">Leave Requests</a>
@if (auth()->user()->role === 'admin')
<a href="{{ route('departments.index') }}" class="block px-3 py-2 rounded-lg text-sm text-brand-100">Departments</a>
<a href="{{ route('employees.index') }}" class="block px-3 py-2 rounded-lg text-sm text-brand-100">Employees</a>
<a href="{{ route('attendance.index') }}" class="block px-3 py-2 rounded-lg text-sm text-brand-100">Attendance</a>
<a href="{{ route('users.index') }}" class="block px-3 py-2 rounded-lg text-sm text-brand-100">Users</a>
<a href="{{ route('salary-payments.index') }}" class="block px-3 py-2 rounded-lg text-sm text-brand-100">Salary Payments</a>
<a href="{{ route('reports.index') }}" class="block px-3 py-2 rounded-lg text-sm text-brand-100">Reports</a>
@endif
@endif
</nav>
</aside>
<div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-20 lg:hidden" x-cloak></div>
<div class="flex-1 flex flex-col min-w-0">
<header class="h-16 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between px-4 lg:px-8">
<button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-gray-500">Menu</button>
<div class="flex-1"></div>
<div class="flex items-center gap-4">
<button @click="dark = !dark" class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
    <svg x-show="!dark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
    <svg x-show="dark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
</button>
<x-dropdown align="right" width="48">
<x-slot name="trigger">
<button class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-200">{{ Auth::user()->name }}</button>
</x-slot>
<x-slot name="content">
<x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
<form method="POST" action="{{ route('logout') }}">
@csrf
<x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</x-dropdown-link>
</form>
</x-slot>
</x-dropdown>
</div>
</header>
@isset($header)
<div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 px-4 lg:px-8 py-4">{{ $header }}</div>
@endisset
<main class="flex-1 overflow-y-auto">{{ $slot }}</main>
</div>
</div>
</body>
</html>