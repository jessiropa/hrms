<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Penilaian Kinerja Baru') }}
        </h2>
    </x-slot>

    @include('partials._flash_messages')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('performance_appraisals.store') }}">
                        @csrf

                        <!-- Karyawan yang Dinilai -->
                        <div>
                            <x-input-label for="employee_id" :value="__('Karyawan yang Dinilai')" />
                            <select id="employee_id" name="employee_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                                <option value="">Pilih Karyawan</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                        {{ $employee->name }} ({{ $employee->id }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('employee_id')" class="mt-2" />
                        </div>

                        <!-- Tanggal Penilaian -->
                        <div class="mt-4">
                            <x-input-label for="appraisal_date" :value="__('Tanggal Penilaian')" />
                            <x-text-input id="appraisal_date" class="block mt-1 w-full" type="date" name="appraisal_date" :value="old('appraisal_date', date('Y-m-d'))" required />
                            <x-input-error :messages="$errors->get('appraisal_date')" class="mt-2" />
                        </div>

                        <!-- Skor Keseluruhan -->
                        <div class="mt-4">
                            <x-input-label for="overall_score" :value="__('Skor Keseluruhan (1-5)')" />
                            <x-text-input id="overall_score" class="block mt-1 w-full" type="number" name="overall_score" :value="old('overall_score')" min="1" max="5" />
                            <x-input-error :messages="$errors->get('overall_score')" class="mt-2" />
                        </div>

                        <!-- Komentar -->
                        <div class="mt-4">
                            <x-input-label for="comments" :value="__('Komentar')" />
                            <textarea id="comments" name="comments" rows="4" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">{{ old('comments') }}</textarea>
                            <x-input-error :messages="$errors->get('comments')" class="mt-2" />
                        </div>

                        <!-- Status -->
                        <div class="mt-4">
                            <x-input-label for="status" :value="__('Status')" />
                            <select id="status" name="status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="submitted" {{ old('status') == 'submitted' ? 'selected' : '' }}>Submitted</option>
                                <option value="reviewed" {{ old('status') == 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('Simpan Penilaian') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
