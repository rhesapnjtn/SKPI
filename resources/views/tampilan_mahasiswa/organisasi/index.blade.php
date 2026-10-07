@extends('layouts.dashboard_mahasiswa')

@section('content')

<h1 class="text-2xl font-bold mb-1">Organisasi Mahasiswa</h1>
<p class="text-gray-600 mb-6">
    NIM: <span class="font-semibold">{{ $nim }}</span>
</p>

{{-- ================== TABEL ORGANISASI ================== --}}
<div class="bg-white rounded-lg shadow p-6 mb-8">
    <h2 class="text-lg font-semibold mb-4">Daftar Organisasi</h2>

    <table class="w-full text-sm border">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-4 py-2 w-12 text-center">No</th>
                <th class="border px-4 py-2 text-left">Nama Organisasi</th>
                <th class="border px-4 py-2 text-left">Jabatan</th>
                <th class="border px-4 py-2 text-center">Tanggal Bergabung</th>
                <th class="border px-4 py-2 text-center">Tanggal Berakhir</th>
                <th class="border px-4 py-2 text-center">Periode</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($organisasi as $item)

                @php
                    $mulai = \Carbon\Carbon::parse($item->tanggal_bergabung);
                    $akhir = $item->tanggal_berakhir ? \Carbon\Carbon::parse($item->tanggal_berakhir) : null;
                @endphp

                <tr class="hover:bg-gray-50">

                    <td class="border px-4 py-2 text-center">
                        {{ $loop->iteration }}
                    </td>

                    <td class="border px-4 py-2">
                        {{ $item->nama_organisasi }}
                    </td>

                    <td class="border px-4 py-2">
                        {{ ucfirst($item->jabatan) }}
                    </td>

                    <td class="border px-4 py-2 text-center">
                        {{ $mulai->format('d M Y') }}
                    </td>

                    <td class="border px-4 py-2 text-center">
                        {{ $akhir ? $akhir->format('d M Y') : 'Sekarang' }}
                    </td>

                    <td class="border px-4 py-2 text-center font-medium text-blue-600">
                        {{ $mulai->format('Y') }} - {{ $akhir ? $akhir->format('Y') : 'Sekarang' }}
                    </td>

                </tr>

            @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-gray-500">
                        Belum mengikuti organisasi
                    </td>
                </tr>
            @endforelse
        </tbody>

    </table>
</div>

{{-- ================== TABEL POIN ================== --}}
<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-lg font-semibold mb-4">Poin Organisasi</h2>

    <table class="w-full text-sm border">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-4 py-2 text-left">Keterangan</th>
                <th class="border px-4 py-2 w-32 text-center">Jumlah</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td class="border px-4 py-2">Total Organisasi Diikuti</td>
                <td class="border px-4 py-2 text-center">
                    {{ $organisasi->count() }}
                </td>
            </tr>

            <tr>
                <td class="border px-4 py-2 font-semibold">Total Poin</td>
                <td class="border px-4 py-2 text-center font-bold text-blue-600">
                    {{ $totalPoin ?? 0 }}
                </td>
            </tr>
        </tbody>

    </table>
</div>

@endsection