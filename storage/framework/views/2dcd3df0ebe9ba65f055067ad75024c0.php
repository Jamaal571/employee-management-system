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
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">Add Employee</h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <?php if($errors->any()): ?>
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                        <ul>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="<?php echo e(route('employees.store')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>

                    <label class="block mb-1 font-medium dark:text-gray-200">Name</label>
                    <input type="text" name="name" value="<?php echo e(old('name')); ?>" class="w-full border rounded p-2 mb-4 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>

                    <label class="block mb-1 font-medium dark:text-gray-200">Email</label>
                    <input type="email" name="email" value="<?php echo e(old('email')); ?>" class="w-full border rounded p-2 mb-4 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>

                    <label class="block mb-1 font-medium dark:text-gray-200">Phone</label>
                    <input type="text" name="phone" value="<?php echo e(old('phone')); ?>" class="w-full border rounded p-2 mb-4 dark:bg-gray-700 dark:border-gray-600 dark:text-white">

                    <label class="block mb-1 font-medium dark:text-gray-200">Position</label>
                    <input type="text" name="position" value="<?php echo e(old('position')); ?>" class="w-full border rounded p-2 mb-4 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>

                    <label class="block mb-1 font-medium dark:text-gray-200">Salary</label>
                    <div class="flex gap-2 mb-4">
                        <input type="number" step="0.01" name="salary" value="<?php echo e(old('salary')); ?>" class="flex-1 border rounded p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        <select name="currency" class="border rounded p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="USD" <?php echo e(old('currency') == 'USD' ? 'selected' : ''); ?>>USD ($)</option>
                            <option value="SLSH" <?php echo e(old('currency') == 'SLSH' ? 'selected' : ''); ?>>SLSH</option>
                        </select>
                    </div>

                    <label class="block mb-1 font-medium dark:text-gray-200">Hire Date</label>
                    <input type="date" name="hire_date" value="<?php echo e(old('hire_date')); ?>" class="w-full border rounded p-2 mb-4 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>

                    <label class="block mb-1 font-medium dark:text-gray-200">Department</label>
                    <select name="department_id" class="w-full border rounded p-2 mb-4 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        <option value="">Select Department</option>
                        <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($department->id); ?>" <?php echo e(old('department_id') == $department->id ? 'selected' : ''); ?>>
                                <?php echo e($department->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>

                    <label class="block mb-1 font-medium dark:text-gray-200">Photo</label>
                    <input type="file" name="photo" accept="image/*" class="w-full border rounded p-2 mb-4 dark:bg-gray-700 dark:border-gray-600 dark:text-white">

                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
                    <a href="<?php echo e(route('employees.index')); ?>" class="ml-2 text-gray-600 dark:text-gray-300">Cancel</a>
                </form>

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
<?php endif; ?><?php /**PATH C:\Users\Muraadso\ems\resources\views/employees/create.blade.php ENDPATH**/ ?>