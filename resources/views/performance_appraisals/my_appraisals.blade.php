<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Penilaian Kinerja Saya') }}
        </h2>
    </x-slot>

    @include('partials._flash_messages')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- Tombol "Buat Penilaian Baru" (hanya untuk Admin/HR) --}}
                    @can('create-appraisal')
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('performance_appraisals.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            {{ __('Buat Penilaian Baru') }}
                        </a>
                    </div>
                    @endcan

                    {{-- Bagian Penilaian yang Diterima (Untuk Karyawan) --}}
                    @if(Auth::user()->employee)
                    <h3 class="text-xl font-semibold mb-4">Penilaian yang Saya Terima (Sebagai Karyawan)</h3>
                    <div class="overflow-x-auto shadow-md sm:rounded-lg mb-8">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Reviewer</th>
                                    <th scope="col" class="px-6 py-3">Tanggal Penilaian</th>
                                    <th scope="col" class="px-6 py-3">Skor Keseluruhan</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3">Komentar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($myAppraisals as $appraisal)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
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
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada penilaian yang Anda terima.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $myAppraisals->links() }}
                    </div>
                    @endif

                    {{-- Bagian Penilaian yang Dibuat (Hanya untuk Admin/HR) --}}
                    @can('create-appraisal') {{-- <<< PASTIKAN BLOK INI ADA DI SINI >>> --}}
                    <h3 class="text-xl font-semibold mb-4 @if(Auth::user()->employee) mt-8 @endif">Penilaian yang Saya Buat (Sebagai Reviewer)</h3>
                    <div class="overflow-x-auto shadow-md sm:rounded-lg mb-8">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Karyawan</th>
                                    <th scope="col" class="px-6 py-3">Tanggal Penilaian</th>
                                    <th scope="col" class="px-6 py-3">Skor Keseluruhan</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3">Komentar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($reviewedAppraisals as $appraisal)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $appraisal->employee->name ?? 'N/A' }} </td>
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
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada penilaian yang Anda buat.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $reviewedAppraisals->links() }}
                    </div>
                    @endcan {{-- <<< AKHIR BLOK INI >>> --}}
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
