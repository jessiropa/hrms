<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Slip Gaji') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="space-y-4">
                        <h3 class="text-xl font-bold">{{ __('Slip Gaji untuk') }} {{ $payroll->employee->name ?? 'N/A' }}</h3>
                        <p class="text-gray-600">ID Karyawan: <strong>{{ $payroll->employee->employee_id ?? 'N/A' }}</strong></p>

                        <!-- Pengecekan untuk mencegah error jika data null -->
                        @if ($payroll->pay_period_start && $payroll->pay_period_end)
                            <p>Periode Gaji: <strong>{{ $payroll->pay_period_start->format('d M Y') }} - {{ $payroll->pay_period_end->format('d M Y') }}</strong></p>
                        @else
                            <p>Periode Gaji: <strong>N/A</strong></p>
                        @endif

                        <hr class="my-4">

                        <p>Gaji Pokok: <strong>{{ 'Rp' . number_format($payroll->base_salary, 2, ',', '.') }}</strong></p>
                        <p>Tunjangan: <strong>{{ 'Rp' . number_format($payroll->allowances, 2, ',', '.') }}</strong></p>
                        <p>Potongan: <strong>{{ 'Rp' . number_format($payroll->deductions, 2, ',', '.') }}</strong></p>

                        <hr class="my-4 border-dashed">

                        <h4 class="font-bold text-lg">{{ __('Gaji Bersih:') }} <span class="text-green-600">{{ 'Rp' . number_format($payroll->net_salary, 2, ',', '.') }}</span></h4>

                        <div class="mt-4">
                            Status: 
                            @if ($payroll->status === 'pending')
                                <span class="inline-flex items-center px-2 py-1 me-2 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    {{ __('Pending') }}
                                </span>
                            @elseif ($payroll->status === 'paid')
                                <span class="inline-flex items-center px-2 py-1 me-2 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    {{ __('Dibayar') }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 me-2 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                    {{ __('Gagal') }}
                                </span>
                            @endif
                        </div>

                        <p class="mt-4 text-sm text-gray-500">Catatan: {{ $payroll->notes ?? 'Tidak ada catatan.' }}</p>
                    </div>

                    <div class="flex justify-end mt-6">
                        <a href="{{ route('payrolls.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('Kembali') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
