<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Penggajian') }}
        </h2>
    </x-slot>

    @include('partials._flash_messages')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Daftar Slip Gaji</h3>
                        <a href="{{ route('payrolls.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            {{ __('Buat Slip Gaji Baru') }}
                        </a>
                    </div>

                    <div class="overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Karyawan</th>
                                    <th scope="col" class="px-6 py-3">Periode Gaji</th>
                                    <th scope="col" class="px-6 py-3">Gaji Pokok</th>
                                    <th scope="col" class="px-6 py-3">Tunjangan</th>
                                    <th scope="col" class="px-6 py-3">Potongan</th>
                                    <th scope="col" class="px-6 py-3">Gaji Bersih</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($payrolls as $payroll)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $payroll->employee->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $payroll->pay_period_start->format('d M Y') }} - {{ $payroll->pay_period_end->format('d M Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">Rp{{ number_format($payroll->base_salary, 2, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">Rp{{ number_format($payroll->allowances, 2, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">Rp{{ number_format($payroll->deductions, 2, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap font-bold">Rp{{ number_format($payroll->net_salary, 2, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($payroll->status == 'pending')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Pending
                                                </span>
                                            @elseif ($payroll->status == 'paid')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Dibayar
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Gagal
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right flex justify-end space-x-2">
                                            <a href="{{ route('payrolls.show', $payroll->id) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Lihat</a>
                                            <a href="{{ route('payrolls.edit', $payroll->id) }}" class="font-medium text-yellow-600 dark:text-yellow-500 hover:underline">Edit</a>
                                            <form action="{{ route('payrolls.destroy', $payroll->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus slip gaji ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">Belum ada slip gaji.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $payrolls->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
