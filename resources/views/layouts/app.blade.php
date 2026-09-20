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
                    <div class="w-9 h-9 bg-white rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-brand-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    </div>
                    <span class="text-white font-semibold text-sm">EMS</span>
                </div>
                <nav class="px-3 py-4 space-y-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-white/10 text-white' : 'text-brand-100 hover:bg-white/5' }}">Dashboard</a>
                    <a href="{{ route('notices.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('notices.*') ? 'bg-white/10 text-white' : 'text-brand-100 hover:bg-white/5' }}">Notices</a>
                    <a href="{{ route('messages.index') }}" class="flex items-center justify-between gap-3 px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('messages.*') ? 'bg-white/10 text-white' : 'text-brand-100 hover:bg-white/5' }}">
    <span>Messages</span>
    @if (($unreadMessageCount ?? 0) > 0)
        <span class="bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">{{ $unreadMessageCount }}</span>
    @endif
</a>
                    @if (auth()->user()->role === 'admin')
                        <div class="pt-4 mt-4 border-t border-white/10">
                            <p class="px-3 text-xs font-semibold text-brand-300 uppercase tracking-wider mb-2">Management</p>
                        </div>
                        <a href="{{ route('departments.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('departments.*') ? 'bg-white/10 text-white' : 'text-brand-100 hover:bg-white/5' }}">Departments</a>
                        <a href="{{ route('employees.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('employees.*') ? 'bg-white/10 text-white' : 'text-brand-100 hover:bg-white/5' }}">Employees</a>
                        <a href="{{ route('attendance.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('attendance.*') ? 'bg-white/10 text-white' : 'text-brand-100 hover:bg-white/5' }}">Attendance</a>
                        <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('users.*') ? 'bg-white/10 text-white' : 'text-brand-100 hover:bg-white/5' }}">Users</a>
                    @endif
                </nav>
            </aside>
            <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-20 lg:hidden" x-cloak></div>
            <div class="flex-1 flex flex-col min-w-0">
                <header class="h-16 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between px-4 lg:px-8">
                    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-gray-500 dark:text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                    </button>
                    <div class="flex-1"></div>
                    <div class="flex items-center gap-4">
                        <button @click="dark = !dark" class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                            <svg x-show="!dark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
                            <svg x-show="dark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        </button>
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-200">
                                    <div class="w-8 h-8 rounded-full bg-brand-600 text-white flex items-center justify-center text-xs font-semibold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                                    <span class="hidden sm:block">{{ Auth::user()->name }}</span>
                                </button>
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