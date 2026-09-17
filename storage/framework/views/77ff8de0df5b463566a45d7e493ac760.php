<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e(config('app.name', 'Laravel')); ?></title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center min-h-screen">
    <div class="text-center px-6">
        <div class="mb-6">
            <svg class="w-16 h-16 mx-auto text-blue-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-5.13a4 4 0 11-8 0 4 4 0 018 0zm6 3a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
        </div>

        <h1 class="text-5xl font-extrabold text-gray-800 mb-3 tracking-tight">Employee Management System</h1>
        <p class="text-lg text-gray-500 mb-10">Manage your departments and employees with ease.</p>

        <?php if(Route::has('login')): ?>
    <div class="space-x-4">
        <?php if(auth()->guard()->check()): ?>
            <a href="<?php echo e(url('/dashboard')); ?>" class="inline-block px-10 py-4 text-lg font-semibold bg-blue-600 text-white rounded-xl shadow-lg hover:bg-blue-700 hover:shadow-2xl hover:-translate-y-1 active:translate-y-0 active:shadow-md transform transition duration-200">Go to Dashboard</a>
        <?php else: ?>
            <a href="<?php echo e(route('login')); ?>" class="inline-block px-10 py-4 text-lg font-semibold bg-blue-600 text-white rounded-xl shadow-lg hover:bg-blue-700 hover:shadow-2xl hover:-translate-y-1 active:translate-y-0 active:shadow-md transform transition duration-200">Log in</a>
            
        <?php endif; ?>
    </div>
<?php endif; ?>
    </div>
</body>
</html><?php /**PATH C:\Users\Muraadso\ems\resources\views/welcome.blade.php ENDPATH**/ ?>