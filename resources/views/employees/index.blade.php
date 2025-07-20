<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Karyawan') }}
        </h2>
    </x-slot>

     @include('partials._flash_messages')
     
     

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('employees.index') }}" method="GET" class="mb-4 flex items-center">
                        <x-text-input type="text" name="search" placeholder="Cari karyawan..." class="flex-grow mr-2" value="{{ request('search') }}" />
                        <x-primary-button type="submit">Cari</x-primary-button>
                        @if(request('search'))
                            <a href="{{ route('employees.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 ml-2">Reset</a>
                        @endif
                    </form>
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Daftar Karyawan</h3>
                        <a href="{{ route('employees.create') }}">
                            <x-primary-button>
                                {{ __('Tambah Karyawan') }}
                            </x-primary-button>
                        </a>
                    </div>
                    
                    <div class="overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 border-b">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Nama
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Email
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Posisi
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Departemen
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $employee)
                                <tr class="bg-white border-b ">

                                    {{-- <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <a href="{{ route('employees.show', $employee->id) }}" class="text-blue-600 hover:underline">
                                            {{ dd($employee->name) }}
                                            {{ $employee->name }}
                                        </a>
                                    </td> --}}

                                     <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-black">
                                            <a href="{{ route('employees.show', $employee->id) }}" class="text-blue-600 hover:underline">
                                                {{ $employee->name }}
                                            </a>
                                            {{-- {{ $employee->name }} --}}
                                        </td>


                                    <td class="px-6 py-4">
                                        {{ $employee->email ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $employee->position ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{-- {{ $employee->department_id ?? '-' }} --}}
                                        {{ $employee->department->name ?? 'Tidak Ada Departemen' }}
                                    </td>

                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('employees.edit', $employee->id) }}" class="font-medium text-yellow-600 dark:text-yellow-500 hover:underline mr-4">Edit</a>
                                        {{-- Form untuk tombol Hapus --}}
                                        <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline" onclick="return confirm('Apakah Anda yakin ingin menghapus karyawan ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $employees->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>