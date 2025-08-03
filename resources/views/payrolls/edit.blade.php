<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Slip Gaji') }}
        </h2>
    </x-slot>

    @include('partials._flash_messages')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('payrolls.update', $payroll->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- Karyawan -->
                        <div>
                            <x-input-label for="employee_id" :value="__('Karyawan')" />
                            <select id="employee_id" name="employee_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                                <option value="">Pilih Karyawan</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}" {{ old('employee_id', $payroll->employee_id) == $employee->id ? 'selected' : '' }}>
                                        {{ $employee->name }} ({{ $employee->employee_id }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('employee_id')" class="mt-2" />
                        </div>

                        <!-- Periode Gaji Mulai -->
                        <div class="mt-4">
                            <x-input-label for="pay_period_start" :value="__('Periode Gaji Mulai')" />
                            <x-text-input id="pay_period_start" class="block mt-1 w-full" type="date" name="pay_period_start" :value="old('pay_period_start', $payroll->pay_period_start->format('Y-m-d'))" required />
                            <x-input-error :messages="$errors->get('pay_period_start')" class="mt-2" />
                        </div>

                        <!-- Periode Gaji Selesai -->
                        <div class="mt-4">
                            <x-input-label for="pay_period_end" :value="__('Periode Gaji Selesai')" />
                            <x-text-input id="pay_period_end" class="block mt-1 w-full" type="date" name="pay_period_end" :value="old('pay_period_end', $payroll->pay_period_end->format('Y-m-d'))" required />
                            <x-input-error :messages="$errors->get('pay_period_end')" class="mt-2" />
                        </div>

                        <!-- Gaji Pokok -->
                        <div class="mt-4">
                            <x-input-label for="base_salary" :value="__('Gaji Pokok')" />
                            <x-text-input id="base_salary" class="block mt-1 w-full" type="number" step="0.01" name="base_salary" :value="old('base_salary', $payroll->base_salary)" required />
                            <x-input-error :messages="$errors->get('base_salary')" class="mt-2" />
                        </div>

                        <!-- Tunjangan -->
                        <div class="mt-4">
                            <x-input-label for="allowances" :value="__('Tunjangan')" />
                            <x-text-input id="allowances" class="block mt-1 w-full" type="number" step="0.01" name="allowances" :value="old('allowances', $payroll->allowances)" />
                            <x-input-error :messages="$errors->get('allowances')" class="mt-2" />
                        </div>

                        <!-- Potongan -->
                        <div class="mt-4">
                            <x-input-label for="deductions" :value="__('Potongan')" />
                            <x-text-input id="deductions" class="block mt-1 w-full" type="number" step="0.01" name="deductions" :value="old('deductions', $payroll->deductions)" />
                            <x-input-error :messages="$errors->get('deductions')" class="mt-2" />
                        </div>

                        <!-- Status -->
                        <div class="mt-4">
                            <x-input-label for="status" :value="__('Status')" />
                            <select id="status" name="status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                                <option value="pending" {{ old('status', $payroll->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="paid" {{ old('status', $payroll->status) == 'paid' ? 'selected' : '' }}>Dibayar</option>
                                <option value="failed" {{ old('status', $payroll->status) == 'failed' ? 'selected' : '' }}>Gagal</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <!-- Catatan -->
                        <div class="mt-4">
                            <x-input-label for="notes" :value="__('Catatan')" />
                            <textarea id="notes" name="notes" rows="3" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">{{ old('notes', $payroll->notes) }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('payrolls.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Kembali') }}
                            </a>
                            <x-primary-button class="ms-4">
                                {{ __('Update Slip Gaji') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
