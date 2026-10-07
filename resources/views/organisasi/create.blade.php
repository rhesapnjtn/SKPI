@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10 px-6">
    <div class="bg-white p-6 rounded-lg shadow-xl">

        <h2 class="text-2xl font-bold mb-6">
            Tambah Organisasi Baru & Akun Login
        </h2>

        {{-- ERROR VALIDASI --}}
        @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <strong>Terjadi kesalahan:</strong>
                <ul class="list-disc list-inside mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        {{-- PESAN SUKSES --}}
        @if (session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif


        <form action="{{ route('organisasi.store') }}" method="POST">
        @csrf


        {{-- NAMA ORGANISASI --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">
                Nama Organisasi
            </label>

            <input type="text"
                name="nama_organisasi"
                value="{{ old('nama_organisasi') }}"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400"
                placeholder="Contoh: Himpunan Mahasiswa Sistem Informasi"
                required>
        </div>


        {{-- FAKULTAS / LEVEL ORGANISASI --}}
        <div class="mb-4">

            <label class="block text-gray-700 font-medium mb-1">
                Fakultas / Level Organisasi
            </label>

            <select name="fakultas"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400"
                required>

                <option value="" disabled selected>
                    -- Pilih Fakultas / Universitas --
                </option>


                {{-- ORGANISASI UNIVERSITAS --}}
                <option value="Universitas"
                {{ old('fakultas') == 'Universitas' ? 'selected' : '' }}>
                Universitas (BEM / UKM)
                </option>


                {{-- FAKULTAS --}}
                <option value="Teknologi Informasi"
                {{ old('fakultas') == 'Teknologi Informasi' ? 'selected' : '' }}>
                Teknologi Informasi
                </option>

                <option value="Ekonomi"
                {{ old('fakultas') == 'Ekonomi' ? 'selected' : '' }}>
                Ekonomi
                </option>

                <option value="Ilmu Pendidikan"
                {{ old('fakultas') == 'Ilmu Pendidikan' ? 'selected' : '' }}>
                Ilmu Pendidikan
                </option>

                <option value="Keperawatan"
                {{ old('fakultas') == 'Keperawatan' ? 'selected' : '' }}>
                Keperawatan
                </option>

                <option value="Filsafat"
                {{ old('fakultas') == 'Filsafat' ? 'selected' : '' }}>
                Filsafat
                </option>

                <option value="Matematika dan Ilmu Pengetahuan Alam"
                {{ old('fakultas') == 'Matematika dan Ilmu Pengetahuan Alam' ? 'selected' : '' }}>
                Matematika dan Ilmu Pengetahuan Alam
                </option>

            </select>
        </div>



        {{-- EMAIL LOGIN --}}
        <div class="mb-4">

            <label class="block text-gray-700 font-medium mb-1">
                Email Login Organisasi
            </label>

            <input type="email"
                name="email"
                value="{{ old('email') }}"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400"
                placeholder="email@organisasi.com"
                required>
        </div>



        {{-- PASSWORD --}}
        <div class="mb-4">

            <label class="block text-gray-700 font-medium mb-1">
                Password Login
            </label>

            <input type="password"
                name="password"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400"
                placeholder="Minimal 8 karakter"
                required>
        </div>



        {{-- KONFIRMASI PASSWORD --}}
        <div class="mb-4">

            <label class="block text-gray-700 font-medium mb-1">
                Konfirmasi Password
            </label>

            <input type="password"
                name="password_confirmation"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400"
                placeholder="Ketik ulang password"
                required>
        </div>



        {{-- BUTTON --}}
        <div class="flex justify-between mt-6">

            <a href="{{ route('organisasi.index') }}"
            class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400 transition">
                ← Kembali
            </a>


            <button type="submit"
            class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                💾 Simpan & Buat Akun
            </button>

        </div>


        </form>
    </div>
</div>
@endsection