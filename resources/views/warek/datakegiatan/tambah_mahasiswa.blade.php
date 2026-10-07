@extends('layouts.dashboard_warek_utama')

@section('title', 'Tambah Mahasiswa ke Kegiatan')

@section('content')

<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">
        🔍 Cari Mahasiswa untuk Kegiatan: 
        <span class="text-blue-600">{{ $kegiatan->nama_kegiatan }}</span>
    </h1>

    <!-- Form Search -->
    <form action="{{ route('warek.datakegiatan.tambahanggota.create', $kegiatan->id) }}" 
          method="GET" 
          class="mb-4">
        <input type="text"
               name="search"
               placeholder="Cari berdasarkan NIM atau Nama"
               value="{{ request('search') }}"
               class="w-full p-3 rounded border border-gray-300 focus:ring focus:ring-blue-200">
    </form>

    <!-- Tabel Mahasiswa -->
    <div class="bg-white p-6 rounded shadow">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border-b p-3">NIM</th>
                    <th class="border-b p-3">Nama</th>
                    <th class="border-b p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $search = request('search');
                    $filteredMahasiswa = $mahasiswa->filter(function($m) use ($search) {
                        return !$search
                            || str_contains($m->nim, $search)
                            || str_contains(strtolower($m->nama), strtolower($search));
                    });
                @endphp

                @forelse($filteredMahasiswa as $m)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="border-b p-3">{{ $m->nim }}</td>
                        <td class="border-b p-3">{{ $m->nama }}</td>
                        <td class="border-b p-3 text-center">

                            @if($kegiatan->mahasiswa->contains('nim', $m->nim))
                                <span class="text-green-600 font-semibold">
                                    ✔ Sudah ditambahkan
                                </span>
                            @else
                                <form action="{{ route('warek.datakegiatan.tambahanggota.store', $kegiatan->id) }}"
                                      method="POST"
                                      class="inline">
                                    @csrf
                                    <input type="hidden" name="nim" value="{{ $m->nim }}">

                                    <button type="button"
                                            onclick="confirmTambah('{{ $m->nim }}', '{{ $m->nama }}', this)"
                                            class="px-4 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                        ➕ Tambah
                                    </button>
                                </form>
                            @endif

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="p-4 text-center text-gray-500">
                            Tidak ada mahasiswa ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Tombol Kembali -->
    <a href="{{ route('warek.datakegiatan.show', $kegiatan->id) }}"
       class="inline-block mt-6 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">
       ← Kembali ke Detail Kegiatan
    </a>
</div>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Popup Konfirmasi Tambah -->
<script>
    function confirmTambah(nim, nama, btn) {
        Swal.fire({
            title: 'Tambah Mahasiswa?',
            html: `
                <div class="text-left">
                    <p><b>NIM:</b> ${nim}</p>
                    <p><b>Nama:</b> ${nama}</p>
                </div>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Tambahkan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#2563eb',
            cancelButtonColor: '#6b7280',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                btn.closest('form').submit();
            }
        });
    }
</script>

<!-- Popup Success -->
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: "{{ session('success') }}",
        timer: 2000,
        showConfirmButton: false
    });
</script>
@endif

<!-- Popup Error -->
@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: "{{ session('error') }}"
    });
</script>
@endif

@endsection
