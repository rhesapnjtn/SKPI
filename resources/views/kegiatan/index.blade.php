@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-10 px-6">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-2xl">
        <h2 class="text-4xl font-extrabold text-blue-600 mb-6 border-b pb-2">
            Daftar Kegiatan
        </h2>

        {{-- Alert Success --}}
        @if(session('success'))
            <div class="bg-green-100 dark:bg-green-700 text-green-800 dark:text-green-100 border border-green-300 dark:border-green-600 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Form Search --}}
        <form action="{{ route('kegiatan.index') }}" method="GET" class="mb-6 flex flex-wrap gap-2 items-center">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari berdasarkan jenis, nama, atau penyelenggara..."
                class="border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded px-3 py-2 w-full sm:w-1/3 focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
            <button
                type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition"
            >
                🔍 Cari
            </button>

            @if(request('search'))
                <a href="{{ route('kegiatan.index') }}"
                   class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                    Reset
                </a>
            @endif
        </form>

        {{-- Tombol Tambah --}}
        <a href="{{ route('kegiatan.create') }}"
           class="inline-block bg-blue-600 text-white font-semibold px-5 py-2 rounded-lg mb-4 hover:bg-blue-700">
            + Tambah Kegiatan
        </a>

        {{-- Tabel --}}
        <div class="overflow-x-auto rounded-lg shadow-lg mt-6">
            <table class="min-w-full table-auto border-separate border-spacing-0">
                <thead class="bg-blue-600 text-white text-sm uppercase">
                    <tr>
                        <th class="px-4 py-3 border-b">No</th>
                        <th class="px-4 py-3 border-b">Jenis</th>
                        <th class="px-4 py-3 border-b">Nama Kegiatan</th>
                        <th class="px-4 py-3 border-b">Penyelenggara</th>
                        <th class="px-4 py-3 border-b">Tanggal</th>
                        <th class="px-4 py-3 border-b text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="text-sm text-gray-800 dark:text-gray-200 bg-white dark:bg-gray-700">
                    @forelse($kegiatan as $index => $item)
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-600 transition">

                            {{-- Nomor urut --}}
                            <td class="border-b px-4 py-3 text-center">
                                {{ $kegiatan->firstItem() + $index }}
                            </td>

                            <td class="border-b px-4 py-3">
                                {{ $item->jenis_kegiatan }}
                            </td>

                            <td class="border-b px-4 py-3">
                                {{ $item->nama_kegiatan }}
                            </td>

                            <td class="border-b px-4 py-3">
                                {{ $item->organisasi->nama_organisasi ?? '-' }}
                            </td>

                            <td class="border-b px-4 py-3">
                                {{ \Carbon\Carbon::parse($item->tanggal_kegiatan)->translatedFormat('d F Y') }}
                            </td>

                            <td class="border-b px-4 py-3 text-center">
                                <div class="flex justify-center space-x-4">

                                    {{-- SHOW --}}
                                    <a href="{{ route('kegiatan.show', $item->id) }}"
                                       class="text-green-600 hover:text-green-800 flex items-center space-x-1">
                                        <span>👁️</span><span>Show</span>
                                    </a>

                                    {{-- EDIT --}}
                                    <a href="{{ route('kegiatan.edit', $item->id) }}"
                                       class="text-blue-600 hover:text-blue-800 flex items-center space-x-1">
                                        <span>✏️</span><span>Edit</span>
                                    </a>

                                    {{-- DELETE --}}
                                    <form action="{{ route('kegiatan.destroy', $item->id) }}"
                                          method="POST"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                onclick="return confirm('Yakin ingin menghapus kegiatan ini?')"
                                                class="text-red-600 hover:text-red-800 flex items-center space-x-1">
                                            <span>🗑️</span><span>Delete</span>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="6" class="text-gray-500 dark:text-gray-400 py-6">
                                Belum ada kegiatan yang tercatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $kegiatan->links() }}
        </div>
    </div>
</div>
@endsection