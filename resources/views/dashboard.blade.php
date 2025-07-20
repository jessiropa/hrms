<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

@include('partials._flash_messages')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-xl font-semibold mb-4">Ringkasan Sistem</h3>
                    <p>Total Departemen: <span class="font-bold">{{ $totalDepartments }}</span></p>
                    <p>Total Karyawan: <span class="font-bold">{{ $totalEmployees }}</span></p>
                    <p>Total User Terdaftar: <span class="font-bold">{{ $totalUsers }}</span></p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
