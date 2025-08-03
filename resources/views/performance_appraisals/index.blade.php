<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Penilaian Kinerja') }}
        </h2>
    </x-slot>

    @include('partials._flash_messages')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-xl font-semibold mb-4">Daftar Semua Penilaian Kinerja</h3>
                    <div class="overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Karyawan</th>
                                    <th scope="col" class="px-6 py-3">Reviewer</th>
                                    <th scope="col" class="px-6 py-3">Tanggal Penilaian</th>
                                    <th scope="col" class="px-6 py-3">Skor</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3">Komentar</th>
                                    <th scope="col" class="px-6 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($appraisals as $appraisal)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $appraisal->employee->first_name ?? 'N/A' }} {{ $appraisal->employee->last_name ?? '' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $appraisal->reviewer->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $appraisal->appraisal_date->format('d M Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $appraisal->overall_score ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($appraisal->status == 'draft')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                    Draft
                                                </span>
                                            @elseif ($appraisal->status == 'submitted')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Submitted
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Reviewed
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">{{ Str::limit($appraisal->comments ?? 'N/A', 50) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('performance_appraisals.edit', $appraisal) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</a>
                                            {{-- Tambahkan tombol hapus jika diperlukan di masa mendatang --}}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">Tidak ada penilaian kinerja.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $appraisals->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
