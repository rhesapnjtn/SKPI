@extends('layouts.dashboard_organisasi')

@section('title', 'Tambah Kegiatan')

@section('content')
<div class="max-w-lg mx-auto bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
    <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Tambah Kegiatan</h1>

    {{-- Error Validasi --}}
    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('kegiatan-self.store') }}" method="POST">
        @csrf

        {{-- Penyelenggara --}}
        <div class="mb-4">
            <label class="block mb-1 font-medium text-gray-700 dark:text-gray-200">Penyelenggara</label>
            <select name="id_organisasi" class="w-full px-3 py-2 border rounded-lg" required>
                <option value="">-- Pilih Organisasi --</option>
                @foreach($organisasis as $org)
                    <option value="{{ $org->id }}" {{ old('id_organisasi') == $org->id ? 'selected' : '' }}>
                        {{ $org->nama_organisasi }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Nama Kegiatan --}}
        <div class="mb-4">
            <label class="block mb-1 font-medium text-gray-700 dark:text-gray-200">Nama Kegiatan</label>
            <input type="text" name="nama_kegiatan" value="{{ old('nama_kegiatan') }}"
                class="w-full px-3 py-2 border rounded-lg" required>
        </div>

        {{-- Tanggal --}}
        <div class="mb-4">
            <label class="block mb-1 font-medium text-gray-700 dark:text-gray-200">Tanggal Kegiatan</label>
            <input type="date" name="tanggal_kegiatan" value="{{ old('tanggal_kegiatan') }}"
                class="w-full px-3 py-2 border rounded-lg" required>
        </div>

        {{-- Jenis --}}
        <div class="mb-4">
            <label class="block mb-1 font-medium text-gray-700 dark:text-gray-200">Jenis Kegiatan</label>
            <select name="jenis_kegiatan" class="w-full px-3 py-2 border rounded-lg">
                <option value="">-- Pilih Jenis Kegiatan --</option>
                <option value="Major" {{ old('jenis_kegiatan') == 'Major' ? 'selected' : '' }}>Major</option>
                <option value="Reguler" {{ old('jenis_kegiatan') == 'Reguler' ? 'selected' : '' }}>Reguler</option>
            </select>
        </div>

        <button type="submit"
            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-500">
            Tambah Kegiatan
        </button>
    </form>
</div>
@endsection