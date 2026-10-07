@extends('layouts.dashboard_organisasi')

@section('title', 'Edit Organisasi')

@section('content')
<div class="p-6 max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold text-blue-600 mb-6">
        ✏️ Edit Organisasi: {{ $organisasi->nama_organisasi }}
    </h2>

    <form action="{{ route('organisasi.self.update', $organisasi->id) }}" 
          method="POST" 
          class="space-y-5 bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
        @csrf
        @method('PUT')

        <!-- Nama Organisasi -->
        <div>
            <label class="block text-gray-700 dark:text-gray-200 font-semibold mb-1">Nama Organisasi</label>
            <input type="text" name="nama_organisasi" 
                   value="{{ old('nama_organisasi', $organisasi->nama_organisasi) }}"
                   class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200">
            @error('nama_organisasi')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Fakultas (Dropdown) -->
        <div>
            <label class="block text-gray-700 dark:text-gray-200 font-semibold mb-1">Fakultas</label>
            <select name="fakultas" class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200">
                <option value="" disabled {{ !$organisasi->fakultas ? 'selected' : '' }}>-- Pilih Fakultas --</option>
                @php
                    $fakultasList = [
                        'Teknologi Informasi',
                        'Ekonomi',
                        'Ilmu Pendidikan',
                        'Keperawatan',
                        'Filsafat',
                        'Matematika dan Ilmu Pengetahuan Alam'
                    ];
                @endphp
                @foreach($fakultasList as $fak)
                    <option value="{{ $fak }}" {{ old('fakultas', $organisasi->fakultas) == $fak ? 'selected' : '' }}>
                        {{ $fak }}
                    </option>
                @endforeach
            </select>
            @error('fakultas')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tombol -->
        <div class="flex gap-2">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                💾 Simpan Perubahan
            </button>
            <a href="{{ route('organisasi.self.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                ← Kembali
            </a>
        </div>
    </form>
</div>
@endsection