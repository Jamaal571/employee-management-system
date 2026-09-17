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
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">Employees</h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <?php if(session('success')): ?>
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>

                <div class="flex justify-between items-center mb-4">
                    <?php if(auth()->user()->role === 'admin'): ?>
                        <a href="<?php echo e(route('employees.create')); ?>" class="inline-block px-4 py-2 bg-blue-600 text-white rounded">
                            + Add Employee
                        </a>
                    <?php else: ?>
                        <div></div>
                    <?php endif; ?>

                    <form method="GET" action="<?php echo e(route('employees.index')); ?>">
                        <input type="text" name="search" placeholder="Search by name..." value="<?php echo e(request('search')); ?>" class="border rounded p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <button type="submit" class="px-3 py-2 bg-gray-600 text-white rounded">Search</button>
                    </form>
                </div>

                <table class="w-full border-collapse">
                    <thead>
                        <tr class="text-left border-b dark:border-gray-700 dark:text-gray-200">
                            <th class="py-2">Photo</th>
                            <th class="py-2">Name</th>
                            <th class="py-2">Email</th>
                            <th class="py-2">Position</th>
                            <th class="py-2">Department</th>
                            <th class="py-2">Salary</th>
                            <th class="py-2">Hire Date</th>
                            <th class="py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b dark:border-gray-700 dark:text-gray-300">
                                <td class="py-2">
                                    <?php if($employee->photo): ?>
                                        <img src="<?php echo e(asset('storage/' . $employee->photo)); ?>" class="w-10 h-10 object-cover rounded-full cursor-pointer hover:opacity-80" onclick="openPhotoModal('<?php echo e(asset('storage/' . $employee->photo)); ?>')">
                                    <?php else: ?>
                                        <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-400 text-xs">N/A</div>
                                    <?php endif; ?>
                                </td>
                                <td class="py-2"><?php echo e($employee->name); ?></td>
                                <td class="py-2"><?php echo e($employee->email); ?></td>
                                <td class="py-2"><?php echo e($employee->position); ?></td>
                                <td class="py-2"><?php echo e($employee->department->name ?? 'N/A'); ?></td>
                                <td cl<td class="py-2"><?php echo e($employee->currency == 'SLSH' ? number_format($employee->salary, 2) . ' SLSH' : '$' . number_format($employee->salary, 2)); ?></td>
                                <td class="py-2"><?php echo e($employee->hire_date); ?></td>
                                <td class="py-2">
                                    <?php if(auth()->user()->role === 'admin'): ?>
                                        <a href="<?php echo e(route('employees.edit', $employee)); ?>" class="text-blue-600">Edit</a>
                                        <form action="<?php echo e(route('employees.destroy', $employee)); ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="text-red-600 ml-2">Delete</button>
                                        </form>
                                    <?php else: ?>
                                        <span class="text-gray-400 text-sm">View only</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <!-- Photo Modal -->
    <div id="photoModal" class="fixed inset-0 bg-black bg-opacity-75 hidden items-center justify-center z-50" onclick="closePhotoModal()">
        <img id="modalImage" src="" class="max-w-lg max-h-[80vh] rounded-lg shadow-2xl">
    </div>

    <script>
        function openPhotoModal(src) {
            document.getElementById('modalImage').src = src;
            document.getElementById('photoModal').classList.remove('hidden');
            document.getElementById('photoModal').classList.add('flex');
        }

        function closePhotoModal() {
            document.getElementById('photoModal').classList.add('hidden');
            document.getElementById('photoModal').classList.remove('flex');
        }
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\Users\Muraadso\ems\resources\views/employees/index.blade.php ENDPATH**/ ?>