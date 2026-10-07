@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-10 px-6">
    <div class="bg-white p-6 rounded-lg shadow-xl">
        <h2 class="text-4xl font-bold mb-6">Edit Organisasi</h2>

        <form action="{{ route('organisasi.update', $organisasi) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Nama Organisasi -->
            <div class="mb-4">
                <label for="nama_organisasi" class="block text-sm font-semibold">
                    Nama Organisasi
                </label>
                <input type="text"
                       name="nama_organisasi"
                       id="nama_organisasi"
                       value="{{ old('nama_organisasi', $organisasi->nama_organisasi) }}"
                       class="w-full p-2 border rounded @error('nama_organisasi') border-red-500 @enderror"
                       required>
                @error('nama_organisasi')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Fakultas -->
            <div class="mb-4">
                <label for="fakultas" class="block text-sm font-semibold">
                    Fakultas
                </label>
                <input type="text"
                       name="fakultas"
                       id="fakultas"
                       value="{{ old('fakultas', $organisasi->fakultas) }}"
                       class="w-full p-2 border rounded @error('fakultas') border-red-500 @enderror"
                       required>
                @error('fakultas')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Checkbox ubah email -->
            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="ubah_email" value="1" id="ubah_email" class="mr-2">
                    Ubah Email
                </label>
            </div>

            <!-- Email Login -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-semibold">
                    Email Login
                </label>
                <input type="email"
                       name="email"
                       id="email"
                       value="{{ old('email', optional($organisasi->user)->email) }}"
                       class="w-full p-2 border rounded @error('email') border-red-500 @enderror"
                       disabled>
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Checkbox ubah password -->
            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="ubah_password" value="1" id="ubah_password" class="mr-2">
                    Ubah Password
                </label>
            </div>

            <!-- Password Baru -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-semibold">Password Baru</label>
                <input type="password"
                       name="password"
                       id="password"
                       class="w-full p-2 border rounded @error('password') border-red-500 @enderror"
                       disabled>
                @error('password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Konfirmasi Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-semibold">Konfirmasi Password</label>
                <input type="password"
                       name="password_confirmation"
                       id="password_confirmation"
                       class="w-full p-2 border rounded"
                       disabled>
            </div>

            <!-- Tombol aksi -->
            <div class="flex gap-3">
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    Update
                </button>

                <a href="{{ route('organisasi.index') }}"
                   class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Script untuk aktifkan email dan password saat checkbox dicentang -->
<script>
document.getElementById('ubah_password').addEventListener('change', function() {
    document.getElementById('password').disabled = !this.checked;
    document.getElementById('password_confirmation').disabled = !this.checked;
});

document.getElementById('ubah_email').addEventListener('change', function() {
    document.getElementById('email').disabled = !this.checked;
});
</script>
@endsection