<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">My Leave Requests</h2>
    </x-slot>

    <div class="py-8 px-4 lg:px-8 animate-fade-in">
       <div class="w-full bg-white dark:bg-gray-800 shadow-sm rounded-xl p-6">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">{{ session('error') }}</div>
            @endif

            <a href="{{ route('leave-requests.create') }}" class="inline-block mb-4 px-4 py-2 bg-brand-600 text-white rounded-lg btn-press">
                + Request Leave
            </a>

            <table class="w-full border-collapse text-sm">
                <thead>
                    <tr class="text-left border-b dark:border-gray-700 dark:text-gray-200">
                        <th class="py-2">Start Date</th>
                        <th class="py-2">End Date</th>
                        <th class="py-2">Reason</th>
                        <th class="py-2">Status</th>
                        <th class="py-2">Admin Note</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($leaveRequests as $req)
                        <tr class="border-b dark:border-gray-700 dark:text-gray-300 row-hover">
                            <td class="py-2">{{ $req->start_date }}</td>
                            <td class="py-2">{{ $req->end_date }}</td>
                            <td class="py-2">{{ $req->reason }}</td>
                            <td class="py-2">
                                <span class="px-2 py-0.5 rounded text-xs
                                    @if($req->status == 'approved') bg-green-100 text-green-700
                                    @elseif($req->status == 'rejected') bg-red-100 text-red-700
                                    @else bg-yellow-100 text-yellow-700
                                    @endif">
                                    {{ ucfirst($req->status) }}
                                </span>
                            </td>
                            <td class="py-2 text-gray-500 dark:text-gray-400">{{ $req->admin_note ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-4 text-center text-gray-500 dark:text-gray-400">No leave requests yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
</x-app-layout>