<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            <?php echo e(__('Dashboard')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <?php if(auth()->user()->role === 'admin'): ?>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="text-gray-500 dark:text-gray-400 text-sm mb-1">Total Employees</div>
                        <div class="text-3xl font-bold text-blue-600 dark:text-blue-400"><?php echo e($totalEmployees); ?></div>
                        <a href="<?php echo e(route('employees.index')); ?>" class="inline-block mt-2 px-3 py-1.5 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">View All Employees</a>
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="text-gray-500 dark:text-gray-400 text-sm mb-1">Total Departments</div>
                        <div class="text-3xl font-bold text-green-600 dark:text-green-400"><?php echo e($totalDepartments); ?></div>
                        <a href="<?php echo e(route('departments.index')); ?>" class="inline-block mt-2 px-3 py-1.5 bg-green-600 text-white text-sm rounded hover:bg-green-700">View All Departments</a>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <?php echo e(__("Welcome to the Employee Management System.")); ?>

                    </div>
                </div>

            <?php else: ?>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                    <!-- Your Information -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Your Information</h3>

                        <?php if($employee): ?>
                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between border-b dark:border-gray-700 pb-2">
                                    <span class="text-gray-500 dark:text-gray-400">Name</span>
                                    <span class="text-gray-800 dark:text-gray-200 font-medium"><?php echo e($employee->name); ?></span>
                                </div>
                               <div class="flex justify-between border-b dark:border-gray-700 pb-2">
    <span class="text-gray-500 dark:text-gray-400">Salary</span>
    <span class="text-gray-800 dark:text-gray-200 font-medium"><?php echo e($employee->currency == 'SLSH' ? number_format($employee->salary, 2) . ' SLSH' : '$' . number_format($employee->salary, 2)); ?></span>
</div>
                                <div class="flex justify-between border-b dark:border-gray-700 pb-2">
                                    <span class="text-gray-500 dark:text-gray-400">Position</span>
                                    <span class="text-gray-800 dark:text-gray-200 font-medium"><?php echo e($employee->position); ?></span>
                                </div>
                                <div class="flex justify-between border-b dark:border-gray-700 pb-2">
                                    <span class="text-gray-500 dark:text-gray-400">Department</span>
                                    <span class="text-gray-800 dark:text-gray-200 font-medium"><?php echo e($employee->department->name ?? 'N/A'); ?></span>
                                </div>
                                <div class="flex justify-between border-b dark:border-gray-700 pb-2">
                                    <span class="text-gray-500 dark:text-gray-400">Salary</span>
                                    <span class="text-gray-800 dark:text-gray-200 font-medium"><?php echo e(number_format($employee->salary, 2)); ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500 dark:text-gray-400">Hire Date</span>
                                    <span class="text-gray-800 dark:text-gray-200 font-medium"><?php echo e($employee->hire_date); ?></span>
                                </div>
                            </div>
                        <?php else: ?>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">No employee record linked to your account yet.</p>
                        <?php endif; ?>
                    </div>

                    <!-- Your Attendance -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Your Attendance</h3>

                        <?php if($attendances->count()): ?>
                            <table class="w-full text-sm border-collapse">
                                <thead>
                                    <tr class="text-left border-b dark:border-gray-700 dark:text-gray-300">
                                        <th class="py-1">Date</th>
                                        <th class="py-1">Time In</th>
                                        <th class="py-1">Time Out</th>
                                        <th class="py-1">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $attendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="border-b dark:border-gray-700 dark:text-gray-300">
                                            <td class="py-1"><?php echo e($attendance->date); ?></td>
                                            <td class="py-1"><?php echo e($attendance->time_in ?? '-'); ?></td>
                                            <td class="py-1"><?php echo e($attendance->time_out ?? '-'); ?></td>
                                            <td class="py-1">
                                                <span class="px-2 py-0.5 rounded text-xs
                                                    <?php if($attendance->status == 'present'): ?> bg-green-100 text-green-700
                                                    <?php elseif($attendance->status == 'late'): ?> bg-yellow-100 text-yellow-700
                                                    <?php else: ?> bg-red-100 text-red-700
                                                    <?php endif; ?>">
                                                    <?php echo e(ucfirst($attendance->status)); ?>

                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">No attendance records yet.</p>
                        <?php endif; ?>
                    </div>

                </div>

            <?php endif; ?>

        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\Users\Muraadso\ems\resources\views/dashboard.blade.php ENDPATH**/ ?>