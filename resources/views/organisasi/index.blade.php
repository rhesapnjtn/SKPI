@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-10 px-4">

    {{-- HEADER + TOMBOL TAMBAH --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-green-700">
            📋 Daftar Organisasi
        </h2>

        <a href="{{ route('organisasi.create') }}"
           class="px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition">
            ➕ Tambah Organisasi
        </a>
    </div>

    {{-- FLASH MESSAGE --}}
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    {{-- TABEL --}}
    <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-xl shadow-lg">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        No
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Nama Organisasi
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>

            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($organisasi as $index => $org)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $organisasi->firstItem() + $index }}
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $org->nama_organisasi }}
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap flex gap-2">

                        {{-- SHOW --}}
                        <a href="{{ route('organisasi.show', $org) }}"
                           class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                            Lihat
                        </a>

                        {{-- EDIT --}}
                        <a href="{{ route('organisasi.edit', $org) }}"
                           class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
                            Edit
                        </a>

                        {{-- DELETE --}}
                        <form action="{{ route('organisasi.destroy', $org) }}"
                              method="POST"
                              onsubmit="return confirm('Yakin ingin hapus organisasi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition">
                                Hapus
                            </button>
                        </form>

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center px-6 py-6 text-gray-500 italic">
                        Belum ada organisasi.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- PAGINATION --}}
        <div class="p-4">
            {{ $organisasi->links() }}
        </div>
    </div>
</div>
@endsection