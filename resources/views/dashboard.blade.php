<x-admin-layout>
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
                     <h3 class="text-lg font-medium text-gray-900 mb-4">Ringkasan Sistem</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="bg-blue-100 p-4 rounded-lg shadow">
                            <h4 class="text-md font-semibold text-blue-800">Total Departemen</h4>
                            <p class="text-2xl font-bold text-blue-900">{{ $totalDepartments }}</p>
                        </div>
                        <div class="bg-green-100 p-4 rounded-lg shadow">
                            <h4 class="text-md font-semibold text-green-800">Total Karyawan</h4>
                            <p class="text-2xl font-bold text-green-900">{{ $totalEmployees }}</p>
                        </div>
                        <div class="bg-purple-100 p-4 rounded-lg shadow">
                            <h4 class="text-md font-semibold text-purple-800">Total User Terdaftar</h4>
                            <p class="text-2xl font-bold text-purple-900">{{ $totalUsers }}</p>
                        </div>
                    </div>
                    {{-- <h3 class="text-xl font-semibold mb-4">Ringkasan Sistem</h3>
                    <p>Total Departemen: <span class="font-bold">{{ $totalDepartments }}</span></p>
                    <p>Total Karyawan: <span class="font-bold">{{ $totalEmployees }}</span></p>
                    <p>Total User Terdaftar: <span class="font-bold">{{ $totalUsers }}</span></p> --}}

                    <h3 class="text-lg font-medium text-gray-900 mb-4">Karyawan per Departemen</h3>
                    <div class="overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Departemen</th>
                                    <th scope="col" class="px-6 py-3 text-right">Jumlah Karyawan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($employeesPerDepartment as $department)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $department->name }}
                                        </td>
                                        <td class="px-6 py-4 text-right whitespace-nowrap">
                                            {{ $department->employees_count }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="px-6 py-4 text-center text-gray-500">Tidak ada data departemen atau karyawan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
