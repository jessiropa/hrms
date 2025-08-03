<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengguna') }}
        </h2>
    </x-slot>

     @include('partials._flash_messages')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Daftar User</h3>
                        {{-- <div class="flex space-x-2"> --}}
                            
                            <a href="{{ route('users.create') }}">
                                <x-primary-button>
                                    {{ __('Tambah Pengguna') }}
                                </x-primary-button>
                            </a>
                        {{-- </div> --}}
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
                                    <th scope="col" class="px-6 py-3 text-right">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach ($users as $user)
                                <tr class="bg-white border-b ">
                                    <td class="px-6 py-4 font-medium">
                                        <a href="{{ route('users.show', $user->id) }}" class="text-blue-600 hover:underline">
                                                {{ $user->name }}
                                            </a>
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ $user->email ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('users.edit', $user->id) }}" class="font-medium text-yellow-600 dark:text-yellow-500 hover:underline mr-4">Edit</a>
                                        {{-- Form untuk tombol Hapus --}}
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
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
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>