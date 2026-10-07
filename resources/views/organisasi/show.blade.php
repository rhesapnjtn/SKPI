@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto mt-12 px-4 sm:px-6 lg:px-8">

    {{-- Detail Organisasi --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 sm:p-8 border border-yellow-300 mb-8">
        <h2 class="text-2xl sm:text-3xl font-extrabold text-yellow-600 mb-4">
            Detail Organisasi
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

            <div>
                <p class="text-gray-700 dark:text-gray-300">
                    <span class="font-semibold">Nama Organisasi:</span>
                    {{ $organisasi->nama_organisasi }}
                </p>
            </div>

            <div>
                <p class="text-gray-700 dark:text-gray-300">
                    <span class="font-semibold">Dibuat:</span>
                    {{ \Carbon\Carbon::parse($organisasi->created_at)->format('d M Y') }}
                </p>

                <p class="text-gray-700 dark:text-gray-300">
                    <span class="font-semibold">Terakhir Update:</span>
                    {{ \Carbon\Carbon::parse($organisasi->updated_at)->format('d M Y') }}
                </p>
            </div>

        </div>
    </div>


    {{-- Tabel Anggota --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 sm:p-8 border border-blue-300">

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl sm:text-2xl font-bold text-blue-600">
                Anggota Organisasi
            </h2>

            <a href="{{ route('organisasi.anggota.create', $organisasi->id) }}"
               class="bg-green-500 text-white px-4 py-1 rounded hover:bg-green-600">
                Tambah Anggota
            </a>
        </div>


        {{-- Filter --}}
        <form method="GET" class="mb-4 flex flex-col sm:flex-row gap-2 items-start sm:items-center">

            <div>
                <label class="text-gray-700 dark:text-gray-300 mr-2">
                    Status:
                </label>

                <select name="status"
                        class="border rounded px-2 py-1 dark:bg-gray-700 dark:text-gray-200">

                    <option value="semua" {{ request('status') == 'semua' ? 'selected' : '' }}>
                        Semua
                    </option>

                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>
                        Aktif
                    </option>

                    <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>
                        Nonaktif
                    </option>

                </select>
            </div>


            <div>
                <label class="text-gray-700 dark:text-gray-300 mr-2">
                    Periode:
                </label>

                <input type="text"
                       name="periode"
                       placeholder="Contoh: 2024/2025"
                       value="{{ request('periode') }}"
                       class="border rounded px-2 py-1 dark:bg-gray-700 dark:text-gray-200">
            </div>


            <button type="submit"
                    class="bg-blue-500 text-white px-4 py-1 rounded hover:bg-blue-600">
                Filter
            </button>

        </form>


        {{-- Tabel --}}
        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">

                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>

                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                            NIM
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                            Nama Mahasiswa
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                            Jabatan
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                            Status
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                            Tanggal Bergabung
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                            Tanggal Berakhir
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                            Periode
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                            Aksi
                        </th>

                    </tr>
                </thead>


                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">

                @forelse($anggota as $a)

                    @php
                        $tglMulai = \Carbon\Carbon::parse($a->tanggal_bergabung);
                        $tglAkhir = $tglMulai->copy()->addYear();
                    @endphp

                    <tr>

                        <td class="px-6 py-4">
                            {{ $a->nim }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $a->nama }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $a->jabatan }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $a->status_keanggotaan }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $tglMulai->format('d M Y') }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $tglAkhir->format('d M Y') }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $tglMulai->format('Y') }} - {{ $tglAkhir->format('Y') }}
                        </td>

                        <td class="px-6 py-4">

                            <a href="{{ route('organisasi.anggota.edit', $a->id) }}"
                               class="text-blue-600 hover:underline">
                                Edit
                            </a>

                            <form action="{{ route('organisasi.anggota.destroy', $a->id) }}"
                                  method="POST"
                                  class="inline form-hapus">

                                @csrf
                                @method('DELETE')

                                <button type="button"
                                        class="text-red-600 hover:underline ml-2 btn-hapus">
                                    Hapus
                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="8"
                            class="text-center px-6 py-6 text-gray-500 italic">

                            Tidak ada anggota untuk filter
                            "{{ request('status') ?? 'semua' }}
                            {{ request('periode') ? ' dan periode '.request('periode') : '' }}".

                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>



{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

document.querySelectorAll('.btn-hapus').forEach(button => {

    button.addEventListener('click', function () {

        let form = this.closest('.form-hapus');

        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data anggota akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {

            if (result.isConfirmed) {
                form.submit();
            }

        });

    });

});

</script>

@endsection