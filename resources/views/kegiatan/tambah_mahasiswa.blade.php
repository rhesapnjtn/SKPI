@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto mt-10 px-4 sm:px-6 lg:px-8">
    <h2 class="text-xl sm:text-2xl font-bold mb-6 text-yellow-600">
        🔍 Cari Mahasiswa untuk Kegiatan:
        <span class="text-gray-800 dark:text-gray-200">{{ $kegiatan->nama_kegiatan }}</span>
    </h2>

    {{-- FORM SEARCH --}}
    <form method="GET" action="{{ route('kegiatan.tambahMahasiswaForm', ['kegiatan' => $kegiatan->id]) }}" class="mb-6 flex gap-2">
        <input type="text" name="cari" placeholder="Cari Mahasiswa..." value="{{ request('cari') }}"
               class="flex-1 px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
        <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition">
            Cari
        </button>
    </form>

    {{-- LIST MAHASISWA --}}
    @if($mahasiswa->isEmpty())
        <p class="text-gray-500 dark:text-gray-300">🙁 Tidak ada mahasiswa ditemukan.</p>
    @else
        <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow ring-1 ring-gray-200 dark:ring-gray-700">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                <thead class="bg-yellow-500 text-white uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3 text-left">NIM</th>
                        <th class="px-6 py-3 text-left">Nama</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach($mahasiswa as $mhs)
                        <tr class="hover:bg-yellow-50 dark:hover:bg-yellow-900 transition">
                            <td class="px-6 py-3 whitespace-nowrap text-gray-800 dark:text-gray-200">{{ $mhs->nim }}</td>
                            <td class="px-6 py-3 whitespace-nowrap text-gray-800 dark:text-gray-200">{{ $mhs->nama }}</td>
                            <td class="px-6 py-3 text-center">
                                <form method="POST"
                                      action="{{ route('kegiatan.tambahMahasiswaStore', ['kegiatan' => $kegiatan->id]) }}"
                                      class="form-tambah-mahasiswa inline-block">
                                    @csrf
                                    <input type="hidden" name="nim" value="{{ $mhs->nim }}">
                                    <button type="submit"
                                            class="inline-flex items-center gap-1 text-green-600 hover:text-green-800 font-semibold transition">
                                        ➕ Tambah
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="mt-6">
            {{ $mahasiswa->appends(['cari' => request('cari')])->links() }}
        </div>
    @endif

    {{-- TOMBOL KEMBALI --}}
    <div class="mt-8">
        <a href="{{ route('kegiatan.show', ['kegiatan' => $kegiatan->id]) }}"
           class="inline-block text-sm bg-blue-600 text-white px-4 py-2
                  rounded hover:bg-blue-700 transition">
            ← Kembali ke Detail Kegiatan
        </a>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.form-tambah-mahasiswa').forEach(form => {
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        Swal.fire({
            title: 'Tambah Mahasiswa?',
            text: 'Mahasiswa ini akan ditambahkan ke kegiatan.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#16a34a',
            cancelButtonColor: '#dc2626',
            confirmButtonText: 'Ya, Tambahkan',
            cancelButtonText: 'Batal',
            backdrop: true,
            customClass: { popup: 'rounded-xl shadow-xl' }
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endpush
@endsection