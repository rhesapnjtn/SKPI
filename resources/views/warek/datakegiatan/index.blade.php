@extends('layouts.dashboard_warek_utama')

@section('content')
<div class="p-4 sm:p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md animate-fadeIn">
    <h1 class="text-xl sm:text-2xl font-bold text-primary mb-4">
        Data Kegiatan WR III
    </h1>

    {{-- Alert Success --}}
    @if(session('success'))
        <div class="mb-4 p-3 sm:p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABLE RESPONSIVE --}}
    <div class="relative overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
        <table class="min-w-[900px] w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-200 uppercase">
                        No
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-200 uppercase">
                        Nama Kegiatan
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-200 uppercase">
                        Tanggal
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-200 uppercase">
                        Jenis Kegiatan
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-200 uppercase">
                        Penyelenggara
                    </th>
                    
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-200 uppercase">
                        Aksi
                    </th>
                </tr>
            </thead>

            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($kegiatan as $index => $item)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <td class="px-4 py-3 whitespace-nowrap">
                        {{ $index + 1 }}
                    </td>

                    <td class="px-4 py-3 font-medium whitespace-nowrap">
                        {{ $item->nama_kegiatan }}
                    </td>

                    <td class="px-4 py-3 whitespace-nowrap">
                        {{ \Carbon\Carbon::parse($item->tanggal_kegiatan)->format('d-m-Y') }}
                    </td>

                    <td class="px-4 py-3 whitespace-nowrap">
                        @if(strtolower($item->jenis_kegiatan) === 'major')
                            <span class="text-white bg-blue-600 px-2 py-1 rounded-full text-xs font-semibold">Major</span>
                        @elseif(strtolower($item->jenis_kegiatan) === 'reguler')
                            <span class="text-white bg-green-600 px-2 py-1 rounded-full text-xs font-semibold">Reguler</span>
                        @else
                            <span class="text-gray-500 text-xs">-</span>
                        @endif
                    </td>

                    <td class="px-4 py-3 whitespace-nowrap">
                        {{ $item->organisasi->nama_organisasi ?? '-' }}
                    </td>

                   

                    <td class="px-4 py-3">
                        <div class="flex flex-col sm:flex-row gap-2">
                            {{-- Lihat --}}
                            <a href="{{ route('warek.datakegiatan.show', $item->id) }}"
                               class="px-3 py-1 text-center bg-blue-500 text-white rounded hover:bg-blue-600 transition">
                                Lihat
                            </a>

                            {{-- Edit --}}
                            <a href="{{ route('warek.datakegiatan.edit', $item->id) }}"
                               class="px-3 py-1 text-center bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
                                Edit
                            </a>

                            {{-- Hapus --}}
                            <form action="{{ route('warek.datakegiatan.destroy', $item->id) }}"
                                  method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                    class="w-full px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition delete-btn">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                        Tidak ada data kegiatan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('.delete-form');

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: 'Data kegiatan akan dihapus permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#2563eb',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal',
                background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff',
                color: document.documentElement.classList.contains('dark') ? '#ffffff' : '#000000'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>
@endsection
