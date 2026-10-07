@extends('layouts.dashboard_organisasi')

@section('title', 'Tambah Mahasiswa ke Kegiatan')

@section('content')
<div class="p-6 max-w-5xl mx-auto bg-white dark:bg-gray-800 rounded shadow space-y-6">

    <!-- Judul -->
    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
        Tambah Mahasiswa ke {{ $kegiatan->nama_kegiatan }}
    </h1>

    <!-- Error -->
    @if(session('error'))
        <div class="bg-red-200 text-red-800 p-3 rounded">
            {{ session('error') }}
        </div>
    @endif

    <!-- SEARCH BAR -->
    <div>
        <input
            type="text"
            id="searchMahasiswa"
            placeholder="🔍 Cari NIM atau Nama Mahasiswa..."
            class="w-full px-4 py-2 border rounded focus:ring focus:ring-blue-300
                   dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600"
        >
    </div>

    <!-- TABEL MAHASISWA -->
    <div class="border rounded p-4 dark:border-gray-700">
        <h2 class="text-lg font-semibold mb-4 text-gray-700 dark:text-gray-200">
            Daftar Mahasiswa
        </h2>

        <div class="overflow-x-auto">
            <table class="min-w-full border text-sm" id="mahasiswaTable">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-2 border text-left w-16">No</th>
                        <th class="px-4 py-2 border text-left">NIM</th>
                        <th class="px-4 py-2 border text-left">Nama</th>
                        <th class="px-4 py-2 border text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mahasiswas as $index => $mahasiswa)
                        <tr class="mahasiswa-row hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 border nim">{{ $mahasiswa->nim }}</td>
                            <td class="px-4 py-2 border nama">{{ $mahasiswa->nama }}</td>
                            <td class="px-4 py-2 border text-center">
                                <form action="{{ route('kegiatan-self.storeMahasiswa', $kegiatan->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="mahasiswa_nim" value="{{ $mahasiswa->nim }}">
                                    <button type="submit"
                                        class="bg-green-600 text-white px-3 py-1 rounded text-xs hover:bg-green-700 transition">
                                        Tambah
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                                Tidak ada data mahasiswa
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Kembali -->
    <a href="{{ route('kegiatan-self.show', $kegiatan->id) }}"
       class="inline-block text-blue-600 hover:underline">
        ← Kembali ke Detail Kegiatan
    </a>

</div>

<!-- SCRIPT SEARCH -->
<script>
    document.getElementById('searchMahasiswa').addEventListener('keyup', function () {
        let keyword = this.value.toLowerCase();
        let rows = document.querySelectorAll('.mahasiswa-row');

        rows.forEach(row => {
            let nim = row.querySelector('.nim').textContent.toLowerCase();
            let nama = row.querySelector('.nama').textContent.toLowerCase();

            row.style.display = (nim.includes(keyword) || nama.includes(keyword))
                ? ''
                : 'none';
        });
    });
</script>
@endsection
