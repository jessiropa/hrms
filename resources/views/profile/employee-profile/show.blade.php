    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Profil Karyawan Saya') }}
            </h2>
        </x-slot>

        @include('partials._flash_messages')

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-xl font-semibold mb-4">Detail Karyawan</h3>
                        <p><strong>Nama:</strong> {{ $employee->name }}</p>
                        <p><strong>Email:</strong> {{ $employee->email }}</p>
                        <p><strong>Posisi:</strong> {{ $employee->position }}</p>
                        <p><strong>Departemen:</strong> {{ $employee->department->name ?? 'Tidak Ada Departemen' }}</p>
                        <p><strong>Tanggal Bergabung:</strong> {{ $employee->created_at->format('d M Y H:i') }}</p>

                        <div class="mt-6">
                            <a href="{{ route('my-profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Edit Profil Karyawan') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>