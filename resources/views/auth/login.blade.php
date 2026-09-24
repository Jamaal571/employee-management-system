<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ config('app.name', 'Laravel') }} - Login</title>
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=figtree:400,500,600|playfair-display:400,600&display=swap" rel="stylesheet" />
@vite(['resources/css/app.css', 'resources/js/app.js'])
<style>.serif{font-family:'Playfair Display',serif;}</style>
</head>
<body class="font-sans antialiased">
<div class="min-h-screen flex flex-col lg:flex-row">

<div class="lg:w-1/2 bg-brand-800 flex items-center justify-center p-10 lg:p-16 relative overflow-hidden lg:rounded-r-[80px]">
<div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 20% 30%, white 1px, transparent 1px); background-size: 24px 24px;"></div>
<div class="relative z-10 max-w-md">
<div class="w-14 h-14 bg-brand-50 rounded-full flex items-center justify-center mb-8">
<svg class="w-7 h-7 text-brand-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
</div>
<h1 class="serif text-4xl lg:text-5xl text-brand-50 leading-tight mb-4">Manage Your<br>Employees</h1>
<p class="text-brand-200 text-sm uppercase tracking-widest">Work Smarter</p>
</div>
</div>

<div class="lg:w-1/2 bg-cream flex items-center justify-center p-10 lg:p-16">
<div class="w-full max-w-sm">

@if (session('status'))
<div class="mb-4 p-3 bg-green-100 text-green-700 rounded text-sm">{{ session('status') }}</div>
@endif

<h2 class="serif text-3xl text-brand-800 mb-2">Welcome Back</h2>
<p class="text-brand-600 text-sm mb-8">Sign in to your account</p>

<form method="POST" action="{{ route('login') }}" class="space-y-5">
@csrf

<div>
<label for="email" class="block text-sm font-medium text-brand-800 mb-1">Email</label>
<input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="w-full border border-brand-300 bg-white/60 rounded-lg p-3 text-brand-900 focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
@error('email')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
</div>

<div>
<label for="password" class="block text-sm font-medium text-brand-800 mb-1">Password</label>
<input id="password" type="password" name="password" required autocomplete="current-password" class="w-full border border-brand-300 bg-white/60 rounded-lg p-3 text-brand-900 focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
@error('password')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
</div>

<div class="flex items-center justify-between">
<label class="inline-flex items-center">
<input id="remember_me" type="checkbox" name="remember" class="rounded border-brand-300 text-brand-600 focus:ring-brand-500">
<span class="ms-2 text-sm text-brand-700">Remember me</span>
</label>
@if (Route::has('password.request'))
<a class="text-sm text-brand-700 underline" href="{{ route('password.request') }}">Forgot password?</a>
@endif
</div>

<button type="submit" class="w-full bg-brand-700 hover:bg-brand-800 text-white rounded-lg py-3 font-medium btn-press">Log In</button>
</form>

</div>
</div>

</div>
</body>
</html>