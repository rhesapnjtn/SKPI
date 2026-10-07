@extends('layouts.dashboard_organisasi')

@section('title', 'Edit Anggota Organisasi')

@section('content')
<div class="p-6 max-w-3xl mx-auto">
    <h2 class="text-2xl font-bold text-green-600 mb-6">
        ✏️ Edit Anggota: {{ $anggota->nim }}
    </h2>

    <form action="{{ route('organisasi.self.update_anggota', ['id' => $organisasi->id, 'nim' => $anggota->nim]) }}" method="POST" class="bg-white dark:bg-gray-800 shadow rounded p-6">
        @csrf
        @method('PUT')

        <!-- NIM & Nama (readonly) -->
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-200 font-medium mb-1">NIM</label>
            <input type="text" value="{{ $anggota->nim }}" readonly
                   class="w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring focus:ring-green-300 dark:bg-gray-700 dark:text-gray-200">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-200 font-medium mb-1">Nama</label>
            <input type="text" value="{{ $anggota->nama }}" readonly
                   class="w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring focus:ring-green-300 dark:bg-gray-700 dark:text-gray-200">
        </div>

        <!-- Jabatan -->
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-200 font-medium mb-1">Jabatan</label>
            <select name="jabatan" id="jabatan" onchange="toggleJabatanLainnya()"
                    class="w-full border border-gray-300 dark:border-gray-600 rounded px-2 py-1 focus:ring-2 focus:ring-green-400 dark:bg-gray-700 dark:text-gray-200">
                @php
                    $jabatanOptions = ['Ketua','Wakil','Sekretaris','Bendahara','Divisi Akademik','Divisi Acara','Divisi Olahraga','Divisi Multimedia','Divisi Logistik','Divisi Humas','Divisi Kerohanian','lainnya'];
                @endphp
                @foreach($jabatanOptions as $jabatan)
                    <option value="{{ $jabatan }}" {{ $anggota->jabatan == $jabatan ? 'selected' : '' }}>
                        {{ $jabatan }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Jabatan Lainnya -->
        <div class="mb-4" id="jabatanLainnyaDiv" style="display: {{ in_array($anggota->jabatan, $jabatanOptions) && $anggota->jabatan != 'lainnya' ? 'none' : 'block' }}">
            <label class="block text-gray-700 dark:text-gray-200 font-medium mb-1">Jabatan Lainnya</label>
            <input type="text" name="jabatan_lainnya" id="jabatan_lainnya"
                   value="{{ !in_array($anggota->jabatan, $jabatanOptions) || $anggota->jabatan == 'lainnya' ? $anggota->jabatan : '' }}"
                   class="w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring focus:ring-green-300 dark:bg-gray-700 dark:text-gray-200"
                   placeholder="Masukkan jabatan lain jika tidak ada di daftar">
        </div>

        <!-- Status -->
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-200 font-medium mb-1">Status Keanggotaan</label>
            <select name="status_keanggotaan" id="status_keanggotaan" onchange="toggleStatusLainnya()"
                    class="w-full border border-gray-300 dark:border-gray-600 rounded px-2 py-1 focus:ring-2 focus:ring-green-400 dark:bg-gray-700 dark:text-gray-200">
                <option value="aktif" {{ $anggota->status_keanggotaan == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="tidak aktif" {{ $anggota->status_keanggotaan == 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                <option value="lainnya" {{ !in_array($anggota->status_keanggotaan, ['aktif','tidak aktif']) ? 'selected' : '' }}>Lainnya</option>
            </select>
        </div>

        <!-- Status Lainnya -->
        <div class="mb-4" id="statusLainnyaDiv" style="display: {{ in_array($anggota->status_keanggotaan,['aktif','tidak aktif']) ? 'none' : 'block' }}">
            <label class="block text-gray-700 dark:text-gray-200 font-medium mb-1">Status Lainnya</label>
            <input type="text" name="status_lainnya" id="status_lainnya"
                   value="{{ !in_array($anggota->status_keanggotaan,['aktif','tidak aktif']) ? $anggota->status_keanggotaan : '' }}"
                   class="w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring focus:ring-green-300 dark:bg-gray-700 dark:text-gray-200"
                   placeholder="Masukkan status lain jika tidak ada di daftar">
        </div>

        <!-- Tanggal Bergabung -->
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-200 font-medium mb-1">Tanggal Bergabung</label>
            <input type="date" name="tanggal_bergabung" id="tanggal_bergabung" value="{{ $anggota->tanggal_bergabung ? \Carbon\Carbon::parse($anggota->tanggal_bergabung)->format('Y-m-d') : '' }}"
                   class="w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring focus:ring-green-300 dark:bg-gray-700 dark:text-gray-200">
        </div>

        <!-- Periode & Tanggal Berakhir -->
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-200 font-medium mb-1">Periode</label>
            <input type="text" name="periode" id="periode" value="{{ $anggota->periode ?? '' }}" placeholder="2026/2027"
                   class="w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring focus:ring-green-300 dark:bg-gray-700 dark:text-gray-200" readonly>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-200 font-medium mb-1">Tanggal Berakhir</label>
            <input type="date" name="tanggal_berakhir" id="tanggal_berakhir" value="{{ $anggota->tanggal_berakhir ? \Carbon\Carbon::parse($anggota->tanggal_berakhir)->format('Y-m-d') : '' }}"
                   class="w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring focus:ring-green-300 dark:bg-gray-700 dark:text-gray-200" readonly>
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('organisasi.self.show', ['id' => $organisasi->id]) }}"
               class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">Batal</a>
            <button type="submit"
                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                Update
            </button>
        </div>
    </form>
</div>

<script>
    function toggleJabatanLainnya() {
        const select = document.getElementById('jabatan');
        const div = document.getElementById('jabatanLainnyaDiv');
        div.style.display = select.value === 'lainnya' ? 'block' : 'none';
    }

    function toggleStatusLainnya() {
        const select = document.getElementById('status_keanggotaan');
        const div = document.getElementById('statusLainnyaDiv');
        div.style.display = select.value === 'lainnya' ? 'block' : 'none';
    }

    // Periode & Tanggal Berakhir otomatis
    const tglBergabung = document.getElementById('tanggal_bergabung');
    const periodeInput = document.getElementById('periode');
    const tglBerakhir = document.getElementById('tanggal_berakhir');

    tglBergabung.addEventListener('change', () => {
        const tgl = new Date(tglBergabung.value);
        if (isNaN(tgl)) return;

        // Periode YYYY/YYYY+1
        const start = tgl.getFullYear();
        periodeInput.value = `${start}/${start+1}`;

        // Tanggal Berakhir +1 tahun
        const end = new Date(tgl);
        end.setFullYear(end.getFullYear() + 1);
        tglBerakhir.value = end.toISOString().split('T')[0];
    });

    // Trigger awal jika ada value
    tglBergabung.dispatchEvent(new Event('change'));
</script>
@endsection