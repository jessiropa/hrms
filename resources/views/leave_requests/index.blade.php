
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Permintaan Cuti') }}
        </h2>
    </x-slot>

    @include('partials._flash_messages')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-xl font-semibold mb-4">Daftar Semua Permintaan Cuti</h3>
                    <div class="overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Karyawan</th>
                                    <th scope="col" class="px-6 py-3">Jenis Cuti</th>
                                    <th scope="col" class="px-6 py-3">Tanggal Mulai</th>
                                    <th scope="col" class="px-6 py-3">Tanggal Berakhir</th>
                                    <th scope="col" class="px-6 py-3">Alasan</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($leaveRequests as $request)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $request->user->name }}</td>
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
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($request->status == 'pending')
                                                <button type="button"
                                                        class="open-modal-btn text-green-600 hover:text-green-900 mr-2"
                                                        data-request-id="{{ $request->id }}"
                                                        data-status="approved">
                                                    Setujui
                                                </button>
                                                <button type="button"
                                                        class="open-modal-btn text-red-600 hover:text-red-900"
                                                        data-request-id="{{ $request->id }}"
                                                        data-status="rejected">
                                                    Tolak
                                                </button>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">Tidak ada permintaan cuti.</td>
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

     <!-- Modal untuk Catatan Admin/HR -->
    <div id="adminNotesModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden flex items-center justify-center">
        {{-- <div class="relative p-5 border w-96 shadow-lg rounded-md bg-white"> --}}
        <div class="relative p-5 border shadow-lg rounded-md bg-white w-11/12 md:w-1/2 lg:w-1/3">
            <div class="text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modalTitle">Tambah Catatan Admin</h3>
                <div class="mt-2 px-7 py-3">
                    <form id="adminNotesForm" method="POST" action="">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" id="modalStatusInput">
                        <textarea name="admin_notes" id="adminNotesTextarea" rows="4" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-2" placeholder="Masukkan catatan (opsional)"></textarea>
                        <x-input-error :messages="$errors->get('admin_notes')" class="mt-2" />
                    </form>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="submitModalBtn" class="px-4 py-2 bg-blue-600 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Kirim
                    </button>
                    <button id="closeModalBtn" class="mt-3 px-4 py-2 bg-gray-200 text-gray-800 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

     <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('adminNotesModal');
            const openModalBtns = document.querySelectorAll('.open-modal-btn');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const submitModalBtn = document.getElementById('submitModalBtn');
            const adminNotesForm = document.getElementById('adminNotesForm');
            const modalTitle = document.getElementById('modalTitle');
            const modalStatusInput = document.getElementById('modalStatusInput');
            const adminNotesTextarea = document.getElementById('adminNotesTextarea');

            openModalBtns.forEach(btn => {
                btn.addEventListener('click', function () {
                    const requestId = this.dataset.requestId;
                    const status = this.dataset.status; // 'approved' or 'rejected'
                    
                    // Set action form modal
                    adminNotesForm.action = `/leave-requests/${requestId}/status`;
                    modalStatusInput.value = status;
                    adminNotesTextarea.value = ''; // Clear previous notes

                    // Update modal title
                    if (status === 'approved') {
                        modalTitle.textContent = 'Setujui Permintaan Cuti';
                        submitModalBtn.textContent = 'Setujui';
                        submitModalBtn.classList.remove('bg-red-600', 'hover:bg-red-700');
                        submitModalBtn.classList.add('bg-blue-600', 'hover:bg-blue-700');
                    } else {
                        modalTitle.textContent = 'Tolak Permintaan Cuti';
                        submitModalBtn.textContent = 'Tolak';
                        submitModalBtn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                        submitModalBtn.classList.add('bg-red-600', 'hover:bg-red-700');
                    }
                    
                    modal.classList.remove('hidden');
                });
            });

            closeModalBtn.addEventListener('click', function () {
                modal.classList.add('hidden');
            });

            submitModalBtn.addEventListener('click', function () {
                adminNotesForm.submit(); // Submit the form inside the modal
            });

            // Close modal when clicking outside of it
            window.addEventListener('click', function (event) {
                if (event.target === modal) {
                    modal.classList.add('hidden');
                }
            });
        });
    </script>
</x-app-layout>
