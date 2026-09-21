<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">Employees</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="flex justify-between items-center mb-4">
                    @if (auth()->user()->role === 'admin')
                        <p class="text-sm text-gray-500 dark:text-gray-400">To add a new employee, go to <a href="{{ route('users.create') }}" class="text-brand-600 underline">Create User</a> and select role "Employee".</p>
                    @else
                        <div></div>
                    @endif

                    <form method="GET" action="{{ route('employees.index') }}" class="flex items-center gap-2">
                        <input type="text" name="search" placeholder="Search by name..." value="{{ request('search') }}" class="border rounded p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <button type="submit" class="px-3 py-2 bg-gray-600 text-white rounded">Search</button>
                        <a href="{{ route('employees.export') }}" class="inline-block px-3 py-2 bg-green-600 text-white rounded text-sm">
                            Export to Excel
                        </a>
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
                        @foreach ($employees as $employee)
                            <tr class="border-b dark:border-gray-700 dark:text-gray-300">
                                <td class="py-2">
                                    @if ($employee->photo)
                                        <img src="{{ asset('storage/' . $employee->photo) }}" class="w-10 h-10 object-cover rounded-full cursor-pointer hover:opacity-80" onclick="openPhotoModal('{{ asset('storage/' . $employee->photo) }}')">
                                    @else
                                        <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-400 text-xs">N/A</div>
                                    @endif
                                </td>
                                <td class="py-2">{{ $employee->name }}</td>
                                <td class="py-2">{{ $employee->email }}</td>
                                <td class="py-2">{{ $employee->position }}</td>
                                <td class="py-2">{{ $employee->department->name ?? 'N/A' }}</td>
                                <td class="py-2">{{ $employee->currency == 'SLSH' ? number_format($employee->salary, 2) . ' SLSH' : '$' . number_format($employee->salary, 2) }}</td>
                                <td class="py-2">{{ $employee->hire_date }}</td>
                                <td class="py-2">
                                    @if (auth()->user()->role === 'admin')
                                        <a href="{{ route('employees.edit', $employee) }}" class="text-blue-600">Edit</a>
                                        <form action="{{ route('employees.destroy', $employee) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 ml-2">Delete</button>
                                        </form>
                                                                               @php
                                            $lastPayment = $employee->salaryPayments->first();
                                            $daysSincePaid = $lastPayment ? $lastPayment->paid_at->diffInDays(now()) : null;
                                            $canPay = !$lastPayment || $daysSincePaid >= 30;
                                        @endphp
                                        @if ($canPay)
                                            <form action="{{ route('salary-payments.store', $employee) }}" method="POST" class="inline" onsubmit="return confirm('Mark salary as paid for {{ $employee->name }}?')">
                                                @csrf
                                                <button type="submit" class="text-green-600 ml-2">Mark as Paid</button>
                                            </form>
                                        @else
                                            <span class="text-gray-400 ml-2 cursor-not-allowed" title="Already paid — next payment available in {{ 30 - $daysSincePaid }} day(s)">
                                                Paid ({{ 30 - $daysSincePaid }}d left)
                                            </span>
                                        @endif
                                    @else
                                        <span class="text-gray-400 text-sm">View only</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
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
</x-app-layout>