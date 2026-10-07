@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-6 mt-8">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-blue-600">Tambah Kegiatan</h1>
        <a href="{{ route('kegiatan.index') }}"
           class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition">
            ⬅ Kembali
        </a>
    </div>

    {{-- Alert Error Global --}}
    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-800 rounded">
            <strong>Terjadi kesalahan:</strong>
            <ul class="list-disc list-inside mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Tambah Kegiatan --}}
    <form action="{{ route('kegiatan.store') }}" method="POST"
          class="bg-white shadow-lg rounded-lg p-6 space-y-5">
        @csrf

        {{-- Jenis Kegiatan --}}
        <div>
            <label class="block font-medium mb-1">Jenis Kegiatan</label>
            <select name="jenis_kegiatan"
                    class="w-full border rounded px-3 py-2 focus:ring focus:border-blue-400"
                    required>
                <option value="">-- Pilih Jenis --</option>
                <option value="Major" {{ old('jenis_kegiatan') == 'Major' ? 'selected' : '' }}>Major</option>
                <option value="Reguler" {{ old('jenis_kegiatan') == 'Reguler' ? 'selected' : '' }}>Reguler</option>
            </select>

            @error('jenis_kegiatan')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Nama Kegiatan --}}
        <div>
            <label class="block font-medium mb-1">Nama Kegiatan</label>
            <input type="text" name="nama_kegiatan"
                   value="{{ old('nama_kegiatan') }}"
                   placeholder="Contoh: Seminar Data Science"
                   class="w-full border rounded px-3 py-2 focus:ring focus:border-blue-400"
                   required>

            @error('nama_kegiatan')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Penyelenggara --}}
        <div>
            <label class="block font-medium mb-1">Penyelenggara</label>
            <select name="id_organisasi"
                    class="w-full border rounded px-3 py-2 focus:ring focus:border-blue-400">
                <option value="">-- Pilih Organisasi --</option>
                @foreach($organisasis as $org)
                    <option value="{{ $org->id }}"
                        {{ old('id_organisasi') == $org->id ? 'selected' : '' }}>
                        {{ $org->nama_organisasi }}
                    </option>
                @endforeach
            </select>

            @error('id_organisasi')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tanggal Kegiatan --}}
        <div>
            <label class="block font-medium mb-1">Tanggal Kegiatan</label>
            <input type="date" name="tanggal_kegiatan"
                   value="{{ old('tanggal_kegiatan') }}"
                   class="w-full border rounded px-3 py-2 focus:ring focus:border-blue-400"
                   required>

            @error('tanggal_kegiatan')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tombol Simpan --}}
        <div class="text-right pt-4">
            <button type="submit"
                    class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">
                💾 Simpan
            </button>
        </div>

    </form>

</div>
@endsection