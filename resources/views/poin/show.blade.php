@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">

    <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-gray-100">
        Detail Poin Mahasiswa
    </h1>

    <!-- INFO MAHASISWA -->
    <div class="grid grid-cols-1 md:grid-cols-6 gap-4 mb-6">

        <!-- NIM -->
        <div class="p-4 bg-gray-100 dark:bg-gray-700 rounded-2xl text-center shadow-md">
            <p class="text-gray-600 dark:text-gray-300 font-semibold">NIM</p>
            <p class="mt-2 text-xl font-bold text-gray-800 dark:text-gray-100">
                {{ $poin->nim }}
            </p>
        </div>

        <!-- Nama -->
        <div class="p-4 bg-gray-100 dark:bg-gray-700 rounded-2xl text-center shadow-md">
            <p class="text-gray-600 dark:text-gray-300 font-semibold">Nama</p>
            <p class="mt-2 text-xl font-bold text-gray-800 dark:text-gray-100">
                {{ $poin->nama }}
            </p>
        </div>

        <!-- Fakultas -->
        <div class="p-4 bg-gray-100 dark:bg-gray-700 rounded-2xl text-center shadow-md">
            <p class="text-gray-600 dark:text-gray-300 font-semibold">Fakultas</p>
            <p class="mt-2 text-xl font-bold text-gray-800 dark:text-gray-100">
                {{ $poin->fakultas ?? '-' }}
            </p>
        </div>

        <!-- Prodi -->
        <div class="p-4 bg-gray-100 dark:bg-gray-700 rounded-2xl text-center shadow-md">
            <p class="text-gray-600 dark:text-gray-300 font-semibold">Prodi</p>
            <p class="mt-2 text-xl font-bold text-gray-800 dark:text-gray-100">
                {{ $poin->prodi ?? '-' }}
            </p>
        </div>

        <!-- Total Poin -->
        <div class="p-4 bg-gray-100 dark:bg-gray-700 rounded-2xl text-center shadow-md relative">
            <p class="text-gray-600 dark:text-gray-300 font-semibold">Total Poin</p>

            <p class="mt-2 text-2xl font-bold text-gray-800 dark:text-gray-100">
                {{ $poin->poin }}
            </p>

            @if($poin->poin >= 1000)
                <span class="absolute top-0 right-0 mt-2 mr-2 bg-yellow-400 text-gray-900 px-2 py-1 rounded-full text-sm font-semibold shadow-md">
                    🏅 Master
                </span>
            @endif
        </div>

        <!-- Poin Tambahan -->
        <div class="p-4 bg-yellow-100 dark:bg-yellow-700 rounded-2xl text-center shadow-md">
            <p class="text-gray-700 dark:text-gray-200 font-semibold">
                Poin Tambahan (WAREK)
            </p>

            <p class="mt-2 text-2xl font-bold text-yellow-700 dark:text-white">
                ⭐ {{ $poin->poin_tambahan ?? 0 }}
            </p>
        </div>

    </div>

    <!-- TOMBOL BUAT SKPI -->
    @if($poin->poin >= 1000)
    <div class="mb-8 text-center">
        <a href="{{ url('/skpi') }}"
           class="inline-block bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-2xl shadow-md font-semibold transition transform hover:scale-105">
            🎓 Buat SKPI
        </a>
    </div>
    @endif


    <!-- ================= POIN KEGIATAN ================= -->
    <div class="mb-8 bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-md">

        <h2 class="text-2xl font-semibold mb-4 text-gray-800 dark:text-gray-100">
            🔴 Poin dari Kegiatan
        </h2>

        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">

            <thead>
                <tr class="bg-gray-100 dark:bg-gray-700">
                    <th class="px-4 py-2">Nama Kegiatan</th>
                    <th class="px-4 py-2">Jenis Kegiatan</th>
                    <th class="px-4 py-2">Tanggal</th>
                    <th class="px-4 py-2 text-right">Poin</th>
                </tr>
            </thead>

            <tbody>

                @forelse($kegiatans as $kegiatan)

                <tr>

                    <td class="px-4 py-2">
                        {{ $kegiatan->nama_kegiatan }}
                    </td>

                    <td class="px-4 py-2">
                        {{ $kegiatan->jenis_kegiatan ?? '-' }}
                    </td>

                    <td class="px-4 py-2">
                        {{ $kegiatan->tanggal_kegiatan ?? '-' }}
                    </td>

                    <td class="px-4 py-2 text-right">
                        <span class="bg-red-500 text-white px-3 py-1 rounded-full font-semibold">
                            🔴 {{ $kegiatan->poin_kegiatan }}
                        </span>
                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="4" class="text-center text-gray-500">
                        Belum ada kegiatan.
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    <!-- ================= POIN ORGANISASI ================= -->
    <div class="mb-8 bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-md">

        <h2 class="text-2xl font-semibold mb-4 text-gray-800 dark:text-gray-100">
            🟢 Poin dari Organisasi
        </h2>

        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">

            <thead>

                <tr class="bg-gray-100 dark:bg-gray-700">

                    <th class="px-4 py-2">Nama Organisasi</th>
                    <th class="px-4 py-2">Jabatan</th>
                    <th class="px-4 py-2">Tanggal Bergabung</th>
                    <th class="px-4 py-2">Tanggal Berakhir</th>
                    <th class="px-4 py-2">Periode</th>
                    <th class="px-4 py-2 text-right">Poin</th>

                </tr>

            </thead>

            <tbody>

                @forelse($organisasis as $organisasi)

                <tr>

                    <td class="px-4 py-2">
                        {{ $organisasi->nama_organisasi }}
                    </td>

                    <td class="px-4 py-2">
                        {{ $organisasi->jabatan }}
                    </td>

                    <td class="px-4 py-2">
                        {{ $organisasi->tanggal_bergabung
                            ? \Carbon\Carbon::parse($organisasi->tanggal_bergabung)->format('d F Y')
                            : '-' }}
                    </td>

                    <td class="px-4 py-2">
                        {{ $organisasi->tanggal_berakhir
                            ? \Carbon\Carbon::parse($organisasi->tanggal_berakhir)->format('d F Y')
                            : '-' }}
                    </td>

                    <!-- PERIODE -->
                    <td class="px-4 py-2">
                        @if($organisasi->tanggal_bergabung)

                            {{ \Carbon\Carbon::parse($organisasi->tanggal_bergabung)->format('Y') }}
                            -
                            {{ $organisasi->tanggal_berakhir
                                ? \Carbon\Carbon::parse($organisasi->tanggal_berakhir)->format('Y')
                                : 'Sekarang' }}

                        @else
                            -
                        @endif
                    </td>

                    <td class="px-4 py-2 text-right">

                        <span class="bg-green-500 text-white px-3 py-1 rounded-full font-semibold">
                            🟢 {{ $organisasi->poin_organisasi ?? 250 }}
                        </span>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="6" class="text-center text-gray-500">
                        Belum ada organisasi.
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    <!-- TOMBOL KEMBALI -->
    <div class="text-center mb-8">

        <a href="{{ route('poin.index') }}"
           class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl shadow-md font-semibold transition transform hover:scale-105">
            ← Kembali
        </a>

    </div>

</div>
@endsection