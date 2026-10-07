@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-12 px-4 sm:px-6 lg:px-8">

    {{-- DETAIL KEGIATAN --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 sm:p-8 border border-yellow-300 mb-8">
        <h2 class="text-2xl sm:text-3xl font-extrabold text-yellow-600 mb-6">
            Detail Kegiatan
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <p><span class="font-semibold text-gray-700 dark:text-gray-300">Nama Kegiatan:</span> {{ $kegiatan->nama_kegiatan }}</p>
                <p><span class="font-semibold text-gray-700 dark:text-gray-300">Jenis Kegiatan:</span> {{ $kegiatan->jenis_kegiatan }}</p>
                <p><span class="font-semibold text-gray-700 dark:text-gray-300">Tanggal Kegiatan:</span> {{ \Carbon\Carbon::parse($kegiatan->tanggal_kegiatan)->format('d M Y') }}</p>
                <p><span class="font-semibold text-gray-700 dark:text-gray-300">Organisasi:</span> {{ $kegiatan->organisasi->nama_organisasi ?? '-' }}</p>
            </div>
            <div>
                <p class="mt-1 text-gray-600 dark:text-gray-200">{{ $kegiatan->deskripsi ?? '-' }}</p>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('kegiatan.tambahMahasiswaForm', ['kegiatan' => $kegiatan->id]) }}"
               class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
               + Tambah Mahasiswa
            </a>
        </div>
    </div>

    {{-- DAFTAR MAHASISWA --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 sm:p-8 border border-yellow-300">
        <h2 class="text-2xl font-extrabold text-yellow-600 mb-6">Daftar Mahasiswa</h2>

        @if($mahasiswas->isEmpty())
            <p class="text-gray-500 dark:text-gray-300">Belum ada mahasiswa yang terdaftar.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">NIM</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($mahasiswas as $mhs)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $mhs->nim }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $mhs->nama }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                                    <form action="{{ route('kegiatan.hapusMahasiswa', ['kegiatan' => $kegiatan->id, 'nim' => $mhs->nim]) }}"
                                          method="POST" class="inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                                class="text-red-600 hover:text-red-800 flex items-center gap-1 delete-btn"
                                                data-nama="{{ $mhs->nama }}">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

{{-- SweetAlert2 --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-btn');

        deleteButtons.forEach(btn => {
            btn.addEventListener('click', function () {
                const form = this.closest('.delete-form');
                const nama = this.dataset.nama;

                Swal.fire({
                    title: 'Hapus Mahasiswa?',
                    text: `Apakah kamu yakin ingin menghapus ${nama}?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e3342f',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endpush
@endsection