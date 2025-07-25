<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Cuti Saya') }}
        </h2>
    </x-slot>

    @include('partials._flash_messages')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('leave_requests.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            {{ __('Ajukan Cuti Baru') }}
                        </a>
                    </div>

                    <h3 class="text-xl font-semibold mb-4">Riwayat Permintaan Cuti</h3>
                    <div class="overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Jenis Cuti</th>
                                    <th scope="col" class="px-6 py-3">Tanggal Mulai</th>
                                    <th scope="col" class="px-6 py-3">Tanggal Berakhir</th>
                                    <th scope="col" class="px-6 py-3">Alasan</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3">Catatan Admin</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($leaveRequests as $request)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $request->leaveType->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $request->start_date->format('d M Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $request->end_date->format('d M Y') }}</td>
                                        <td class="px-6 py-4">{{ Str::limit($request->reason, 50) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($request->status == 'pending')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Pending
                                                </span>
                                            @elseif ($request->status == 'approved')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Disetujui
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Ditolak
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">{{ Str::limit($request->admin_notes ?? 'N/A', 50) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada permintaan cuti.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $leaveRequests->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
