@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10 p-8 bg-white rounded-lg shadow-xl">
    <h2 class="text-3xl font-bold text-blue-600 mb-6 border-b pb-2">📚 Detail Mahasiswa 🎓</h2>

    <div class="space-y-4">
        <div>
            <strong class="text-lg text-gray-700">👤 Nama:</strong>
            <p class="text-gray-900">{{ $mahasiswa->nama }}</p>
        </div>

        <div>
            <strong class="text-lg text-gray-700">🆔 NIM:</strong>
            <p class="text-gray-900">{{ $mahasiswa->nim }}</p>
        </div>

        <div>
            <strong class="text-lg text-gray-700">🏠 Tempat Lahir:</strong>
            <p class="text-gray-900">{{ $mahasiswa->temp_lahir }}</p>
        </div>

        <div>
            <strong class="text-lg text-gray-700">📅 Tanggal Lahir:</strong>
            <p class="text-gray-900">{{ \Carbon\Carbon::parse($mahasiswa->tgl_lahir)->translatedFormat('d F Y') }}</p>
        </div>

        <div>
            <strong class="text-lg text-gray-700">🔲 Jenis Kelamin:</strong>
            <p class="text-gray-900">{{ $mahasiswa->sex == 'L' ? 'Laki-laki 👨' : 'Perempuan 👩' }}</p>
        </div>

        <div>
            <strong class="text-lg text-gray-700">⛪ Agama:</strong>
            <p class="text-gray-900">{{ $mahasiswa->agama }}</p>
        </div>

        <div>
            <strong class="text-lg text-gray-700">🎯 Hobi:</strong>
            <p class="text-gray-900">{{ $mahasiswa->hobi }}</p>
        </div>

        <div>
            <strong class="text-lg text-gray-700">📅 Angkatan:</strong>
            <p class="text-gray-900">{{ $mahasiswa->angkatan }}</p>
        </div>

        <div>
            <strong class="text-lg text-gray-700">📧 Email:</strong>
            <p class="text-gray-900">{{ $mahasiswa->email }}</p>
        </div>

        {{-- Tambahkan Fakultas --}}
        <div>
            <strong class="text-lg text-gray-700">🏫 Fakultas:</strong>
            <p class="text-gray-900">{{ $mahasiswa->fakultas ?? '-' }}</p>
        </div>

        {{-- Tambahkan Program Studi --}}
        <div>
            <strong class="text-lg text-gray-700">💼 Program Studi:</strong>
            <p class="text-gray-900">{{ $mahasiswa->prodi ?? '-' }}</p>
        </div>
    </div>

    <div class="mt-6 text-center">
        <a href="{{ route('mahasiswa.index') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow-md hover:bg-blue-700 transition duration-300 ease-in-out">
            🔙 Kembali ke Daftar Mahasiswa 📜
        </a>
    </div>
</div>
@endsection