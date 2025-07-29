<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Slip Gaji') }}
        </h2>
    </x-slot>

    @include('partials._flash_messages')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-xl font-semibold mb-4">Slip Gaji untuk {{ $payroll->employee->name ?? 'N/A' }}</h3>
                    <p class="mb-2"><strong>ID Karyawan:</strong> {{ $payroll->employee->employee_id ?? 'N/A' }}</p>
                    <p class="mb-2"><strong>Periode Gaji:</strong> {{ $payroll->pay_period_start->format('d M Y') }} - {{ $payroll->pay_period_end->format('d M Y') }}</p>
                    <p class="mb-2"><strong>Gaji Pokok:</strong> Rp{{ number_format($payroll->base_salary, 2, ',', '.') }}</p>
                    <p class="mb-2"><strong>Tunjangan:</strong> Rp{{ number_format($payroll->allowances, 2, ',', '.') }}</p>
                    <p class="mb-2"><strong>Potongan:</strong> Rp{{ number_format($payroll->deductions, 2, ',', '.') }}</p>
                    <p class="mb-2 text-lg font-bold"><strong>Gaji Bersih:</strong> Rp{{ number_format($payroll->net_salary, 2, ',', '.') }}</p>
                    <p class="mb-2"><strong>Status:</strong>
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
                    </p>
                    <p class="mb-2"><strong>Catatan:</strong> {{ $payroll->notes ?? '-' }}</p>
                    <p class="mb-2"><strong>Dibuat Pada:</strong> {{ $payroll->created_at->format('d M Y H:i:s') }}</p>
                    <p class="mb-2"><strong>Terakhir Diperbarui:</strong> {{ $payroll->updated_at->format('d M Y H:i:s') }}</p>

                    <div class="mt-6 flex items-center space-x-2">
                        {{-- Tombol Kembali (sesuaikan rute tergantung siapa yang melihat) --}}
                        @if(Auth::user()->role === 'employee' && Auth::user()->employee && Auth::user()->employee->id === $payroll->employee_id)
                            <a href="{{ route('payrolls.my-payrolls') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Kembali ke Slip Gaji Saya') }}
                            </a>
                        @else
                            <a href="{{ route('payrolls.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Kembali ke Daftar Penggajian') }}
                            </a>
                        @endif

                        {{-- Tombol Edit (hanya untuk Admin/HR) --}}
                        @can('manage-payrolls')
                            <a href="{{ route('payrolls.edit', $payroll->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-2">
                                {{ __('Edit Slip Gaji') }}
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
