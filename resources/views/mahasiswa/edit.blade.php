@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4 text-blue-600">Edit Mahasiswa</h2>

    {{-- Tampilkan error validasi --}}
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('mahasiswa.update', $mahasiswa) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-semibold">Nama Mahasiswa</label>
            <input type="text" name="nama" class="w-full border p-2 rounded" value="{{ old('nama', $mahasiswa->nama) }}" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">NIM</label>
            <input type="text" name="nim" class="w-full border p-2 rounded" value="{{ old('nim', $mahasiswa->nim) }}" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Tempat Lahir</label>
            <input type="text" name="temp_lahir" class="w-full border p-2 rounded" value="{{ old('temp_lahir', $mahasiswa->temp_lahir) }}" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Tanggal Lahir</label>
            <input type="date" name="tgl_lahir" class="w-full border p-2 rounded" value="{{ old('tgl_lahir', $mahasiswa->tgl_lahir) }}" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Jenis Kelamin</label>
            <select name="sex" class="w-full border p-2 rounded" required>
                <option value="L" {{ old('sex', $mahasiswa->sex) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ old('sex', $mahasiswa->sex) == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Agama</label>
            <input type="text" name="agama" class="w-full border p-2 rounded" value="{{ old('agama', $mahasiswa->agama) }}" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Hobi</label>
            <input type="text" name="hobi" class="w-full border p-2 rounded" value="{{ old('hobi', $mahasiswa->hobi) }}" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Angkatan</label>
            <input type="text" name="angkatan" class="w-full border p-2 rounded" value="{{ old('angkatan', $mahasiswa->angkatan) }}" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Email</label>
            <input type="email" name="email" class="w-full border p-2 rounded" value="{{ old('email', $mahasiswa->email) }}" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Fakultas</label>
            <input type="text" name="fakultas" class="w-full border p-2 rounded" value="{{ old('fakultas', $mahasiswa->fakultas ?? '') }}" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Program Studi</label>
            <input type="text" name="prodi" class="w-full border p-2 rounded" value="{{ old('prodi', $mahasiswa->prodi ?? '') }}" required>
        </div>

        <div class="flex justify-between items-center">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Perbarui
            </button>
            <a href="{{ route('mahasiswa.index') }}" class="text-blue-500 hover:underline">← Kembali</a>
        </div>
    </form>
</div>
@endsection