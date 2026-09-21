<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">Salary Payments</h2>
    </x-slot>

    <div class="py-8 px-4 lg:px-8 animate-fade-in">
        <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 shadow-sm rounded-xl p-6">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
            @endif

            <table class="w-full border-collapse text-sm">
                <thead>
                    <tr class="text-left border-b dark:border-gray-700 dark:text-gray-200">
                        <th class="py-2">Employee</th>
                        <th class="py-2">Amount</th>
                        <th class="py-2">Phone</th>
                        <th class="py-2">Paid By</th>
                        <th class="py-2">Date & Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($payments as $payment)
                        <tr class="border-b dark:border-gray-700 dark:text-gray-300 row-hover">
                            <td class="py-2">{{ $payment->employee->name ?? 'N/A' }}</td>
                            <td class="py-2">{{ $payment->currency == 'SLSH' ? number_format($payment->amount, 2) . ' SLSH' : '$' . number_format($payment->amount, 2) }}</td>
                            <td class="py-2">{{ $payment->phone ?? '-' }}</td>
                            <td class="py-2">{{ $payment->paidBy->name ?? 'N/A' }}</td>
                            <td class="py-2">{{ $payment->paid_at->format('M d, Y - h:i A') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-4 text-center text-gray-500 dark:text-gray-400">No salary payments recorded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
</x-app-layout>