@extends('layouts.dashboard_warek_utama')

@section('title', 'Detail Organisasi')

@section('content')
<div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md">

    {{-- HEADER ORGANISASI --}}
    <h1 class="text-2xl font-bold mb-2 text-gray-800 dark:text-gray-100">📄 Detail Organisasi</h1>
    <p class="text-gray-700 dark:text-gray-300 mb-6">
        <strong>Nama Organisasi:</strong> {{ $organisasi->nama_organisasi }}
    </p>
    
    <div class="mb-6 flex gap-6 text-gray-600 dark:text-gray-300 text-sm">
        <p>Dibuat: {{ \Carbon\Carbon::parse($organisasi->created_at)->format('d M Y') }}</p>
        <p>Terakhir Update: {{ \Carbon\Carbon::parse($organisasi->updated_at)->format('d M Y') }}</p>
    </div>

    {{-- HEADER ANGGOTA + TOMBOL TAMBAH --}}
    <div class="mb-4 flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">👥 Anggota Organisasi</h2>

        <a href="{{ route('warek.dataorganisasi.anggota.create', $organisasi->id) }}"
           class="bg-green-500 hover:bg-green-400 text-white px-4 py-2 rounded-lg transition">
            ➕ Tambah Anggota
        </a>
    </div>

    {{-- FILTER STATUS & PERIODE --}}
    <form method="GET" class="mb-4 flex gap-4 items-center">
        <input type="hidden" name="id" value="{{ $organisasi->id }}">
        
        <label class="text-gray-700 dark:text-gray-300">Status:</label>
        <select name="status" class="border p-2 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
            <option value="" {{ request('status') == '' ? 'selected' : '' }}>Semua</option>
            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
        </select>

        <label class="text-gray-700 dark:text-gray-300">Periode:</label>
        <select name="tahun" class="border p-2 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
            <option value="">Semua</option>
            @php
                $tahunList = $anggota->pluck('tanggal_bergabung')->map(function($tgl){
                    return \Carbon\Carbon::parse($tgl)->format('Y');
                })->unique()->sortDesc();
            @endphp
            @foreach($tahunList as $tahun)
                <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                    {{ $tahun }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="bg-blue-500 hover:bg-blue-400 text-white px-3 py-1 rounded-lg">
            Filter
        </button>
    </form>

    {{-- TABEL ANGGOTA --}}
    @php
        $anggota = $anggota ?? collect();
    @endphp

    @if($anggota->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">

                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600 dark:text-gray-200">NIM</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600 dark:text-gray-200">Nama Mahasiswa</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600 dark:text-gray-200">Jabatan</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600 dark:text-gray-200">Status</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600 dark:text-gray-200">Tanggal Bergabung</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600 dark:text-gray-200">Tanggal Berakhir</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600 dark:text-gray-200">Periode</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600 dark:text-gray-200">Aksi</th>
                    </tr>
                </thead>

                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">

                    @foreach($anggota as $item)
                    <tr>

                        <td class="px-4 py-2">{{ $item->nim }}</td>

                        <td class="px-4 py-2">{{ $item->nama }}</td>

                        <td class="px-4 py-2">{{ $item->jabatan }}</td>

                        <td class="px-4 py-2">
                            {{ ucfirst($item->status_keanggotaan) }}
                        </td>

                        {{-- TANGGAL BERGABUNG --}}
                        <td class="px-4 py-2">
                            {{ \Carbon\Carbon::parse($item->tanggal_bergabung)->format('d M Y') }}
                        </td>

                        {{-- TANGGAL BERAKHIR --}}
                        <td class="px-4 py-2">
                            {{ $item->tanggal_berakhir 
                                ? \Carbon\Carbon::parse($item->tanggal_berakhir)->format('d M Y') 
                                : '-' }}
                        </td>

                        {{-- PERIODE OTOMATIS 1 TAHUN --}}
                        <td class="px-4 py-2 font-semibold text-indigo-600 dark:text-indigo-400">
                            {{ \Carbon\Carbon::parse($item->tanggal_bergabung)->format('Y') }}
                            -
                            {{ \Carbon\Carbon::parse($item->tanggal_bergabung)->addYear()->format('Y') }}
                        </td>

                        <td class="px-4 py-2 space-x-2 flex items-center">

                            <a href="{{ route('warek.dataorganisasi.anggota.edit', $item->id) }}"
                               class="text-blue-500 hover:underline">
                               Edit
                            </a>

                            <form action="{{ route('warek.dataorganisasi.anggota.destroy', $item->id) }}"
                                  method="POST" class="delete-form inline">

                                @csrf
                                @method('DELETE')

                                <button type="button"
                                        class="delete-btn text-red-500 hover:underline">
                                        Hapus
                                </button>

                            </form>

                        </td>

                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    @else
        <p class="text-gray-700 dark:text-gray-300">
            Belum ada anggota terdaftar.
        </p>
    @endif

</div>


{{-- SWEETALERT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {

    const deleteButtons = document.querySelectorAll('.delete-btn');

    deleteButtons.forEach(button => {

        button.addEventListener('click', function() {

            const form = this.closest('.delete-form');

            Swal.fire({
                title: 'Yakin ingin menghapus anggota ini?',
                text: "Data anggota akan hilang permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#fff',
                color: document.documentElement.classList.contains('dark') ? '#fff' : '#000'
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