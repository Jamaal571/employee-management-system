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
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">Attendance</h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <?php if(session('success')): ?>
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>

                <form method="GET" action="<?php echo e(route('attendance.index')); ?>" class="mb-6">
                    <label class="block mb-1 font-medium dark:text-gray-200">Select Date</label>
                    <div class="flex gap-2">
                        <input type="date" name="date" value="<?php echo e($date); ?>" class="border rounded p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white" onchange="this.form.submit()">
                    </div>
                </form>

                <table class="w-full border-collapse">
                    <thead>
                        <tr class="text-left border-b dark:border-gray-700 dark:text-gray-200">
                            <th class="py-2">Employee</th>
                            <th class="py-2">Department</th>
                            <th class="py-2">Time In</th>
                            <th class="py-2">Time Out</th>
                            <th class="py-2">Status</th>
                            <th class="py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $attendance = $employee->attendances->first();
                            ?>
                            <tr class="border-b dark:border-gray-700 dark:text-gray-300">
                                <td class="py-2"><?php echo e($employee->name); ?></td>
                                <td class="py-2"><?php echo e($employee->department->name ?? 'N/A'); ?></td>
                                <td class="py-2">
                                    <form method="POST" action="<?php echo e(route('attendance.store')); ?>" class="flex items-center gap-2">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="employee_id" value="<?php echo e($employee->id); ?>">
                                        <input type="hidden" name="date" value="<?php echo e($date); ?>">
                                        <input type="time" name="time_in" value="<?php echo e($attendance->time_in ?? ''); ?>" class="border rounded p-1 text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                </td>
                                <td class="py-2">
                                        <input type="time" name="time_out" value="<?php echo e($attendance->time_out ?? ''); ?>" class="border rounded p-1 text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                </td>
                                <td class="py-2">
                                        <select name="status" class="border rounded p-1 text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                            <option value="present" <?php echo e(($attendance->status ?? '') == 'present' ? 'selected' : ''); ?>>Present</option>
                                            <option value="late" <?php echo e(($attendance->status ?? '') == 'late' ? 'selected' : ''); ?>>Late</option>
                                            <option value="absent" <?php echo e(($attendance->status ?? '') == 'absent' ? 'selected' : ''); ?>>Absent</option>
                                        </select>
                                </td>
                                <td class="py-2">
                                        <button type="submit" class="px-3 py-1 bg-blue-600 text-white text-sm rounded">Save</button>
                                    </form>
                                    <a href="<?php echo e(route('attendance.history', $employee)); ?>" class="text-blue-600 text-sm ml-2">History</a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

            </div>
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
<?php endif; ?><?php /**PATH C:\Users\Muraadso\ems\resources\views/attendance/index.blade.php ENDPATH**/ ?>