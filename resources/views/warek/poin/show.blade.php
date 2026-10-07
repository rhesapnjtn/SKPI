@extends('layouts.dashboard_warek_utama')

@section('title','Portal Mahasiswa')

@section('content')

<div class="p-6 space-y-8">

    {{-- HEADER --}}
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">
            🎓 Portal Mahasiswa
        </h1>

        <a href="{{ route('warek.poin.index') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
            🔍 Cari Mahasiswa
        </a>
    </div>


    {{-- PROFILE CARD --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl p-6">
        <div class="flex flex-col md:flex-row gap-6 items-center">

            {{-- Avatar --}}
            <div class="w-24 h-24 rounded-full bg-blue-600 flex items-center justify-center text-white text-4xl font-bold shadow">
                {{ strtoupper(substr($mahasiswa->nama,0,1)) }}
            </div>

            {{-- Identity --}}
            <div class="flex-1">

                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                    {{ $mahasiswa->nama }}
                </h2>

                <p class="text-gray-500 dark:text-gray-400">
                    NIM {{ $mahasiswa->nim }}
                </p>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4 text-sm">

                    <div>
                        <p class="text-gray-400">Jenis Kelamin</p>
                        <p class="font-semibold text-gray-800 dark:text-white">
                            {{ $mahasiswa->sex ?? '-' }}
                            {{ $mahasiswa->sex == 'Laki-laki' ? '👨' : ($mahasiswa->sex == 'Perempuan' ? '👩' : '') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-400">Agama</p>
                        <p class="font-semibold text-gray-800 dark:text-white">
                            {{ $mahasiswa->agama ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-400">Hobi</p>
                        <p class="font-semibold text-gray-800 dark:text-white">
                            {{ $mahasiswa->hobi ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-400">Angkatan</p>
                        <p class="font-semibold text-gray-800 dark:text-white">
                            {{ $mahasiswa->angkatan ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-400">Tempat Lahir</p>
                        <p class="font-semibold text-gray-800 dark:text-white">
                            {{ $mahasiswa->temp_lahir ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-400">Tanggal Lahir</p>
                        <p class="font-semibold text-gray-800 dark:text-white">
                            {{ $mahasiswa->tgl_lahir ? \Carbon\Carbon::parse($mahasiswa->tgl_lahir)->format('d F Y') : '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-400">Email</p>
                        <p class="font-semibold text-gray-800 dark:text-white">
                            {{ $mahasiswa->email ?? '-' }}
                        </p>
                    </div>

                </div>

            </div>
        </div>
    </div>


    {{-- INFORMASI AKADEMIK + STATISTIK --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- INFORMASI AKADEMIK --}}
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow">

            <h3 class="font-bold text-lg mb-4 text-gray-800 dark:text-white">
                🎓 Informasi Akademik
            </h3>

            <div class="space-y-3 text-sm">

                <p>
                    <span class="text-gray-400">Fakultas</span><br>
                    <span class="font-semibold text-gray-800 dark:text-white">
                        {{ $mahasiswa->fakultas ?? '-' }}
                    </span>
                </p>

                <p>
                    <span class="text-gray-400">Program Studi</span><br>
                    <span class="font-semibold text-gray-800 dark:text-white">
                        {{ $mahasiswa->prodi ?? '-' }}
                    </span>
                </p>

            </div>

        </div>


        {{-- STATISTIK POIN --}}
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow">

            <h3 class="font-bold text-lg mb-4 text-gray-800 dark:text-white">
                📊 Statistik SKPI
            </h3>

            <div class="space-y-4">

                <div>
                    <p class="text-gray-400 text-sm">Total Poin</p>
                    <p class="text-3xl font-bold text-green-500">
                        {{ $totalPoin }}
                    </p>
                </div>

                <div>
                    <p class="text-gray-400 text-sm">Poin Tambahan Warek</p>
                    <p class="text-xl font-semibold text-blue-500">
                        {{ $poinTambahan }}
                    </p>
                </div>

                {{-- Progress --}}
                @php
                    $progress = min(($totalPoin/1000)*100,100);
                @endphp

                <div>
                    <p class="text-gray-400 text-sm mb-1">
                        Progress SKPI (Target 1000)
                    </p>

                    <div class="w-full bg-gray-200 rounded-full h-3 dark:bg-gray-700">
                        <div class="bg-green-500 h-3 rounded-full transition-all"
                             style="width: {{ $progress }}%">
                        </div>
                    </div>
                </div>

                @if($totalPoin >= 1000)
                    <span class="bg-green-500 text-white px-3 py-1 rounded-lg text-sm">
                        ✅ SKPI Siap Diproses
                    </span>
                @else
                    <span class="bg-red-500 text-white px-3 py-1 rounded-lg text-sm">
                        ❌ Belum Memenuhi Syarat
                    </span>
                @endif

            </div>
        </div>

    </div>


    {{-- POIN TAMBAHAN (DIPISAH 2 CARD) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- CARD RIWAYAT POIN --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">

            <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">
                ⭐ Riwayat Poin Tambahan
            </h2>

            @if($poinTambahanData->isEmpty())

                <p class="text-gray-500 dark:text-gray-400">
                    Belum ada poin tambahan
                </p>

            @else

                <div class="space-y-3">

                    @foreach($poinTambahanData as $item)

                        <div class="flex justify-between border-b pb-2 border-gray-200 dark:border-gray-700">

                            <span class="text-gray-400 text-sm">
                                {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y H:i') }}
                            </span>

                            <span class="text-green-500 font-bold">
                                +{{ $item->poin_tambahan }} poin
                            </span>

                        </div>

                    @endforeach

                </div>

            @endif

        </div>


        {{-- CARD ALASAN --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">

            <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">
                📝 Alasan Pemberian Poin
            </h2>

            @if($poinTambahanData->isEmpty())

                <p class="text-gray-500 dark:text-gray-400">
                    Belum ada alasan
                </p>

            @else

                <ul class="space-y-3">

                    @foreach($poinTambahanData as $item)

                        <li class="border-b pb-2 border-gray-200 dark:border-gray-700">

                            <p class="text-gray-700 dark:text-gray-300">
                                {{ $item->alasan ?? '-' }}
                            </p>

                            <p class="text-xs text-gray-400">
                                {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y H:i') }}
                            </p>

                        </li>

                    @endforeach

                </ul>

            @endif

        </div>

    </div>


    {{-- RIWAYAT KEGIATAN --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">

        <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">
            📅 Riwayat Kegiatan
        </h2>

        @if($kegiatan->isEmpty())

            <p class="text-gray-500 dark:text-gray-400">
                Belum ada kegiatan
            </p>

        @else

            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-gray-200 dark:bg-gray-700">
                        <tr>
                            <th class="p-3 text-left">Kegiatan</th>
                            <th class="p-3 text-left">Tanggal</th>
                            <th class="p-3 text-left">Organisasi</th>
                            <th class="p-3 text-right">Poin</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($kegiatan as $k)

                        <tr class="border-b border-gray-300 dark:border-gray-700">

                            <td class="p-3">
                                {{ $k->nama_kegiatan }}
                            </td>

                            <td class="p-3">
                                {{ \Carbon\Carbon::parse($k->tanggal_kegiatan)->format('d M Y') }}
                            </td>

                            <td class="p-3">
                                {{ $k->nama_organisasi ?? '-' }}
                            </td>

                            <td class="p-3 text-right text-green-500 font-semibold">
                                {{ $k->poin }}
                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @endif

    </div>


    {{-- RIWAYAT ORGANISASI --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">

        <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">
            🏢 Riwayat Organisasi
        </h2>

        @if($organisasi->isEmpty())

            <p class="text-gray-500 dark:text-gray-400">
                Belum ada organisasi
            </p>

        @else

            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-gray-200 dark:bg-gray-700">
                        <tr>
                            <th class="p-3 text-left">Nama Organisasi</th>
                            <th class="p-3 text-left">Peran / Jabatan</th>
                            <th class="p-3 text-left">Tanggal Bergabung</th>
                            <th class="p-3 text-right">Poin</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($organisasi as $o)

                        <tr class="border-b border-gray-300 dark:border-gray-700">

                            <td class="p-3">
                                {{ $o->nama_organisasi }}
                            </td>

                            <td class="p-3">
                                {{ $o->jabatan ?? '-' }}
                            </td>

                            <td class="p-3">
                                {{ $o->tgl_mulai ? \Carbon\Carbon::parse($o->tgl_mulai)->format('d M Y') : '-' }}
                            </td>

                            <td class="p-3 text-right text-green-500 font-semibold">
                                {{ $o->poin ?? 0 }}
                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @endif

    </div>

</div>

@endsection