@extends('layouts.dashboard_warek_utama')

@section('title', 'Edit Poin Mahasiswa')

@section('content')
<div class="container mx-auto px-4 py-6">

    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-6 max-w-3xl mx-auto">

        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">
            ✏️ Edit Poin Mahasiswa (SKPI UNAI)
        </h1>

        {{-- Alert sukses --}}
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        {{-- Alert error --}}
        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM EDIT --}}
        <form action="{{ route('warek.poin.update', $mahasiswa->nim) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- NIM --}}
            <div>
                <label class="block font-semibold mb-1">NIM</label>
                <input type="text" readonly value="{{ $mahasiswa->nim }}"
                    class="w-full px-4 py-2 rounded-lg border bg-gray-100 dark:bg-gray-700 dark:text-white">
            </div>

            {{-- Nama --}}
            <div>
                <label class="block font-semibold mb-1">Nama Mahasiswa</label>
                <input type="text" readonly value="{{ $mahasiswa->nama }}"
                    class="w-full px-4 py-2 rounded-lg border bg-gray-100 dark:bg-gray-700 dark:text-white">
            </div>

            {{-- Total Poin Lama --}}
            <div>
                <label class="block font-semibold mb-1">Total Poin Saat Ini</label>
                <input type="number" id="poin_lama" readonly value="{{ $totalPoin }}"
                    class="w-full px-4 py-2 rounded-lg border bg-gray-100 dark:bg-gray-700 dark:text-white">
            </div>

            {{-- Input Perubahan Poin --}}
            <div>
                <label class="block font-semibold mb-1">
                    Ubah Poin (boleh + / -)
                </label>
                <input type="number" name="poin_tambahan" id="poin_baru"
                    required
                    value="0"
                    oninput="updatePreview();"
                    class="w-full px-4 py-2 rounded-lg border dark:bg-gray-700 dark:text-white"
                    placeholder="Contoh: 200 atau -100">

                <p class="text-sm text-gray-500 mt-1">
                    ➕ angka positif = tambah poin<br>
                    ➖ angka negatif = kurangi poin
                </p>
            </div>

            {{-- Preview --}}
            <div>
                <label class="block font-semibold mb-1">Preview Total Poin Setelah Disimpan</label>
                <input type="number" id="preview_poin" readonly
                    class="w-full px-4 py-2 rounded-lg border bg-gray-100 dark:bg-gray-700 dark:text-white">
            </div>

            {{-- Tombol --}}
            <div class="flex justify-end gap-3">
                <a href="{{ route('warek.beripoin.index') }}"
                   class="px-5 py-2 rounded-lg bg-gray-500 hover:bg-gray-600 text-white">
                    ⬅️ Kembali
                </a>

                <button type="submit"
                    class="px-6 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold">
                    💾 Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- JS Preview --}}
<script>
const poinLama = document.getElementById('poin_lama');
const poinBaru = document.getElementById('poin_baru');
const preview = document.getElementById('preview_poin');

function updatePreview() {
    let lama = parseInt(poinLama.value) || 0;
    let perubahan = parseInt(poinBaru.value) || 0;
    preview.value = lama + perubahan;
}

// init saat halaman dibuka
updatePreview();
</script>
@endsection
