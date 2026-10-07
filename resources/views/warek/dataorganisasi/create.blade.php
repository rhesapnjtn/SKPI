@extends('layouts.dashboard_warek_utama')

@section('title', 'Tambah Anggota Organisasi')

@section('content')
<div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md">

    <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">
        ➕ Tambah Anggota Organisasi
    </h1>

    {{-- SEARCH --}}
    <div class="mb-6 max-w-md">
        <input
            type="text"
            id="searchMahasiswa"
            placeholder="🔍 Cari NIM atau Nama Mahasiswa..."
            class="w-full px-4 py-2 border rounded-lg
            dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
    </div>

    {{-- ================= DESKTOP TABLE ================= --}}
    <div class="hidden md:block overflow-x-auto">

        <table class="min-w-full border border-gray-200 dark:border-gray-700 rounded-lg">

            <thead class="bg-green-600 text-white text-sm">
                <tr>
                    <th class="px-4 py-3 text-left w-24">NIM</th>
                    <th class="px-4 py-3 text-left w-48">Nama</th>
                    <th class="px-4 py-3 text-left">Detail Anggota</th>
                    <th class="px-4 py-3 text-center w-28">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 text-sm">

                @forelse($mahasiswa as $m)

                <tr class="mahasiswa-row">

                    <td class="px-4 py-3 nim">
                        {{ $m->nim }}
                    </td>

                    <td class="px-4 py-3 nama break-words max-w-xs truncate">
                        {{ $m->nama }}
                    </td>

                    <td class="px-4 py-3">

                        <form
                            action="{{ route('warek.dataorganisasi.anggota.store', $organisasi->id) }}"
                            method="POST"
                            class="grid grid-cols-5 gap-2 items-end text-sm">

                            @csrf

                            <input type="hidden" name="id_organisasi" value="{{ $organisasi->id }}">
                            <input type="hidden" name="nim" value="{{ $m->nim }}">

                            {{-- JABATAN --}}
                            <div>
                                <label class="block text-xs font-medium mb-1">
                                    Jabatan
                                </label>

                                <select
                                    name="jabatan"
                                    class="jabatan-select w-full px-2 py-1 border rounded text-sm"
                                    required>
                                    <option value="">Pilih</option>
                                    <option value="Ketua">Ketua</option>
                                    <option value="Wakil">Wakil</option>
                                    <option value="Sekretaris">Sekretaris</option>
                                    <option value="Bendahara">Bendahara</option>
                                    <option value="Divisi Acara">Divisi Acara</option>
                                    <option value="Divisi Humas">Divisi Humas</option>
                                    <option value="lainnya">➕ Lainnya</option>
                                </select>

                                <input
                                    type="text"
                                    name="jabatan_custom"
                                    class="jabatan-custom hidden w-full mt-1 px-2 py-1 border rounded text-sm"
                                    placeholder="Isi jabatan...">
                            </div>

                            {{-- STATUS --}}
                            <div>
                                <label class="block text-xs font-medium mb-1">
                                    Status
                                </label>

                                <select
                                    name="status_keanggotaan"
                                    class="w-full px-2 py-1 border rounded text-sm">
                                    <option value="aktif">Aktif</option>
                                    <option value="nonaktif">Nonaktif</option>
                                </select>
                            </div>

                            {{-- TANGGAL BERGABUNG --}}
                            <div>
                                <label class="block text-xs font-medium mb-1">
                                    Bergabung
                                </label>

                                <input
                                    type="date"
                                    name="tanggal_bergabung"
                                    value="{{ date('Y-m-d') }}"
                                    class="w-full px-2 py-1 border rounded text-sm tanggal-bergabung"
                                    required>
                            </div>

                            {{-- PERIODE --}}
                            <div>
                                <label class="block text-xs font-medium mb-1">
                                    Periode
                                </label>

                                <input
                                    type="text"
                                    name="periode"
                                    class="w-full px-2 py-1 border rounded text-sm periode-input"
                                    placeholder="2026/2027"
                                    readonly>
                            </div>

                            {{-- TANGGAL BERAKHIR --}}
                            <div>
                                <label class="block text-xs font-medium mb-1">
                                    Berakhir
                                </label>

                                <input
                                    type="date"
                                    name="tanggal_berakhir"
                                    class="w-full px-2 py-1 border rounded text-sm tanggal-berakhir"
                                    readonly>
                            </div>

                            <div class="col-span-5 text-right mt-2">
                                <button
                                    type="submit"
                                    class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                                    Tambah
                                </button>
                            </div>

                        </form>

                    </td>

                    <td></td>

                </tr>

                @empty

                <tr>
                    <td colspan="4" class="text-center py-6 text-gray-500 text-sm">
                        Semua mahasiswa sudah terdaftar
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', () => {

    // SEARCH MAHASISWA
    document.getElementById('searchMahasiswa')
    .addEventListener('keyup', function () {
        const keyword = this.value.toLowerCase();
        document.querySelectorAll('.mahasiswa-row').forEach(row => {
            const nim = row.querySelector('.nim').textContent.toLowerCase();
            const nama = row.querySelector('.nama').textContent.toLowerCase();
            row.style.display = (nim.includes(keyword) || nama.includes(keyword)) ? '' : 'none';
        });
    });

    // JABATAN LAINNYA
    document.querySelectorAll('.jabatan-select').forEach(select => {
        select.addEventListener('change', function () {
            const custom = this.closest('form').querySelector('.jabatan-custom');
            if (this.value === 'lainnya') {
                custom.classList.remove('hidden');
                custom.required = true;
            } else {
                custom.classList.add('hidden');
                custom.required = false;
                custom.value = '';
            }
        });
    });

    // PERIODE & TANGGAL BERAKHIR & STATUS OTOMATIS
    document.querySelectorAll('.tanggal-bergabung').forEach(input => {
        const updateForm = () => {
            const form = input.closest('form');
            const tglBergabung = new Date(input.value);
            if (isNaN(tglBergabung)) return;

            // Tanggal Berakhir
            const tglBerakhirInput = form.querySelector('.tanggal-berakhir');
            const tglBerakhir = new Date(tglBergabung);
            tglBerakhir.setFullYear(tglBerakhir.getFullYear() + 1);
            tglBerakhirInput.value = tglBerakhir.toISOString().split('T')[0];

            // Periode
            const periodeInput = form.querySelector('.periode-input');
            const yearStart = tglBergabung.getFullYear();
            const yearEnd = yearStart + 1;
            periodeInput.value = `${yearStart}/${yearEnd}`;

            // Status Otomatis
            const statusSelect = form.querySelector('[name="status_keanggotaan"]');
            const today = new Date();
            if (tglBergabung < today) {
                // jika sudah lewat 1 tahun, nonaktif
                const diffYears = today.getFullYear() - tglBergabung.getFullYear();
                statusSelect.value = diffYears >= 1 ? 'nonaktif' : 'aktif';
            } else {
                statusSelect.value = 'aktif';
            }
        };

        input.addEventListener('change', updateForm);
        input.dispatchEvent(new Event('change'));
    });

});
</script>

@endsection