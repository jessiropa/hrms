<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kehadiran Saya') }}
        </h2>
    </x-slot>

    @include('partials._flash_messages')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-xl font-semibold mb-4">Catat Kehadiran</h3>

                    <div class="flex space-x-4 mb-8">
                        {{-- @if (!$hasCheckedIn)
                            <form action="{{ route('attendances.check-in') }}" method="POST">
                                @csrf
                                <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-bold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('Check-in Sekarang') }}
                                </button>
                            </form> --}}
                        @if (!$hasCheckedIn)
                            <form action="{{ route('attendances.check-in') }}" method="POST">
                                @csrf
                                <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-bold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('Check-in Sekarang') }}
                                </button>
                            </form>
                        @elseif ($hasCheckedIn && !$hasCheckedOut)
                            <form action="{{ route('attendances.check-out') }}" method="POST">
                                @csrf
                                <button type="submit" class="px-6 py-3 bg-red-600 text-white font-bold rounded-lg shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('Check-out Sekarang') }}
                                </button>
                            </form>
                        @else
                            <p class="text-green-600 font-semibold">Anda sudah check-in dan check-out hari ini.</p>
                        @endif
                    </div>

                    <h3 class="text-xl font-semibold mb-4">Riwayat Kehadiran</h3>
                    <div class="overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Tanggal</th>
                                    <th scope="col" class="px-6 py-3">Check-in</th>
                                    <th scope="col" class="px-6 py-3">Check-out</th>
                                    <th scope="col" class="px-6 py-3">Durasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($attendances as $attendance)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->check_in_time->format('d M Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->check_in_time->format('H:i:s') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($attendance->check_out_time)
                                                {{ $attendance->check_out_time->format('H:i:s') }}
                                            @else
                                                <span class="text-yellow-500">Belum Check-out</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($attendance->check_in_time && $attendance->check_out_time)
                                                @php
                                                    $duration = $attendance->check_in_time->diff($attendance->check_out_time);
                                                    echo $duration->format('%h jam %i menit');
                                                @endphp
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada riwayat kehadiran.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $attendances->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
