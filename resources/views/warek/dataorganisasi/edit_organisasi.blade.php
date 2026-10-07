@extends('layouts.dashboard_warek_utama')

@section('title', 'Edit Organisasi')

@section('content')
<div class="p-6">

    <!-- HEADER -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
            Edit Organisasi
        </h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">
            Perbarui informasi organisasi
        </p>
    </div>

    <!-- CARD -->
    <div class="bg-white dark:bg-gray-900 shadow-lg rounded-xl p-6 max-w-2xl">

        <!-- SUCCESS MESSAGE -->
        @if(session('success'))
        <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-700 border border-green-300">
            {{ session('success') }}
        </div>
        @endif

        <!-- FORM -->
        <form action="{{ route('warek.dataorganisasi.update', ['id_organisasi' => $organisasi->id]) }}" method="POST" class="space-y-6">
            
            @csrf
            @method('PUT')

            <!-- Nama Organisasi -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    Nama Organisasi
                </label>

                <input 
                    type="text"
                    name="nama_organisasi"
                    value="{{ old('nama_organisasi', $organisasi->nama_organisasi) }}"
                    placeholder="Masukkan nama organisasi..."
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 
                    focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                    dark:bg-gray-800 dark:border-gray-700 dark:text-white
                    dark:focus:ring-blue-400"
                >

                @error('nama_organisasi')
                <p class="text-red-500 text-sm mt-2">
                    {{ $message }}
                </p>
                @enderror
            </div>

            <!-- BUTTON -->
            <div class="flex items-center gap-3 pt-4 border-t dark:border-gray-700">

                <button 
                    type="submit"
                    class="px-5 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition"
                >
                    Simpan Perubahan
                </button>

                <a 
                    href="{{ route('warek.dataorganisasi.index') }}"
                    class="px-5 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition
                    dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600"
                >
                    Batal
                </a>

            </div>

        </form>

    </div>

</div>
@endsection