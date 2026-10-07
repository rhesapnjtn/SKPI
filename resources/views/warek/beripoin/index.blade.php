@extends('layouts.dashboard_warek_utama')

@section('title', 'Beri Poin Mahasiswa')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">
            🎯 Beri Poin Mahasiswa (SKPI UNAI)
        </h1>

        {{-- Alert --}}
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-lg">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Beri Poin --}}
        <form action="{{ route('warek.beripoin.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                {{-- NIM --}}
                <div>
                    <label class="block font-semibold mb-1">NIM Mahasiswa</label>
                    <input list="listMahasiswa" id="nim" name="nim"
                        class="w-full px-4 py-2 rounded-lg border dark:bg-gray-700 dark:text-white"
                        placeholder="Pilih atau ketik NIM" required>

                    <datalist id="listMahasiswa">
                        @foreach($mahasiswas as $mhs)
                            <option value="{{ $mhs->nim }}">
                                {{ $mhs->nim }} - {{ $mhs->nama }}
                            </option>
                        @endforeach
                    </datalist>
                </div>

                {{-- Nama --}}
                <div>
                    <label class="block font-semibold mb-1">Nama Mahasiswa</label>
                    <input type="text" id="nama" readonly
                        class="w-full px-4 py-2 rounded-lg border bg-gray-100 dark:bg-gray-700 dark:text-white">
                </div>

                {{-- Total Poin Lama --}}
                <div>
                    <label class="block font-semibold mb-1">Total Poin Lama</label>
                    <input type="number" id="poin_lama" readonly value="0"
                        class="w-full px-4 py-2 rounded-lg border bg-gray-100 dark:bg-gray-700 dark:text-white">
                </div>

                {{-- Poin Tambahan --}}
                <div>
                    <label class="block font-semibold mb-1">Tambah Poin (Opsional)</label>
                    <input type="number" name="poin_tambahan" id="poin_tambahan" min="0" value="0"
                        oninput="this.value = this.value.replace(/[^0-9]/g,''); updateTotalPoin();"
                        class="w-full px-4 py-2 rounded-lg border dark:bg-gray-700 dark:text-white">
                </div>

                {{-- Total Poin Akhir --}}
                <div>
                    <label class="block font-semibold mb-1">Total Poin Akhir</label>
                    <input type="number" id="total_poin" readonly value="0"
                        class="w-full px-4 py-2 rounded-lg border bg-gray-100 dark:bg-gray-700 dark:text-white">
                </div>

                {{-- Pilih Kegiatan --}}
                <div class="md:col-span-2">
                    <label class="block font-semibold mb-1">Pilih Kegiatan (Opsional)</label>
                    <select id="selectKegiatan" name="kegiatan_id_ref"
                        class="w-full px-4 py-2 rounded-lg border dark:bg-gray-700 dark:text-white">
                        <option value="">-- Tidak memilih kegiatan --</option>
                        @foreach($kegiatans as $kegiatan)
                            <option value="{{ $kegiatan->id }}">
                                {{ $kegiatan->nama_kegiatan }} ({{ $kegiatan->jenis_kegiatan }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- ALASAN --}}
                <div class="md:col-span-2">
                    <label class="block font-semibold mb-1">Alasan Pemberian Poin</label>
                    <textarea name="alasan" rows="3"
                        placeholder="Tuliskan alasan pemberian poin mahasiswa..."
                        class="w-full px-4 py-2 rounded-lg border dark:bg-gray-700 dark:text-white"></textarea>
                </div>

            </div>

            {{-- Tombol --}}
            <div class="flex justify-between mt-6">

                {{-- Tombol Edit Poin --}}
                <button type="button" id="btnEdit"
                    onclick="goEditPoin()"
                    disabled
                    class="px-5 py-2 rounded-lg bg-yellow-500 hover:bg-yellow-600 text-white font-semibold disabled:opacity-50 disabled:cursor-not-allowed">
                    ✏️ Edit Poin Mahasiswa
                </button>

                {{-- Tombol Simpan --}}
                <button type="submit"
                    class="px-6 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold">
                    💾 Simpan Poin
                </button>

            </div>
        </form>
    </div>
</div>

{{-- JS Auto-fill + Hitung Total + Edit --}}
<script>

const nimInput = document.getElementById('nim');
const namaInput = document.getElementById('nama');
const poinLamaInput = document.getElementById('poin_lama');
const poinTambahanInput = document.getElementById('poin_tambahan');
const totalPoinInput = document.getElementById('total_poin');
const btnEdit = document.getElementById('btnEdit');

nimInput.addEventListener('change', function() {

    let nim = this.value.trim();

    if(!nim){
        namaInput.value = '';
        poinLamaInput.value = 0;
        btnEdit.disabled = true;
        updateTotalPoin();
        return;
    }

    fetch(`/api/mahasiswa/${nim}`)
        .then(res => res.ok ? res.json() : Promise.reject())
        .then(data => {

            namaInput.value = data.nama ?? '';
            poinLamaInput.value = data.poin_lama ?? 0;

            btnEdit.disabled = false;

            updateTotalPoin();

        })
        .catch(() => {

            namaInput.value = '';
            poinLamaInput.value = 0;
            btnEdit.disabled = true;

            updateTotalPoin();

        });

});

function updateTotalPoin(){

    let poinLama = parseInt(poinLamaInput.value) || 0;
    let poinTambahan = parseInt(poinTambahanInput.value) || 0;

    totalPoinInput.value = poinLama + poinTambahan;

}

function goEditPoin(){

    let nim = nimInput.value.trim();

    if(!nim){
        alert('Pilih NIM dulu sebelum edit poin');
        return;
    }

    window.location.href = `/warek/poin/${nim}/edit`;

}

poinTambahanInput.addEventListener('input', updateTotalPoin);

</script>
@endsection