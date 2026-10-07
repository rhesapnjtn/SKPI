@extends('layouts.dashboard_organisasi')

@section('title', 'Tambah Anggota Organisasi')

@section('content')
<div class="p-6 max-w-6xl mx-auto">
    <h2 class="text-2xl font-bold text-green-600 mb-4">
        ➕ Tambah Anggota: {{ $organisasi->nama_organisasi }}
    </h2>

    <p class="mb-4 text-gray-600 dark:text-gray-300">
        Mahasiswa yang muncul hanya dari fakultas <strong>{{ $organisasi->fakultas }}</strong>.
        Mahasiswa yang pernah menjadi anggota sebelumnya tetap bisa ditambahkan untuk periode baru.
    </p>

    {{-- Error validasi --}}
    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- SEARCH BAR -->
    <div class="mb-4">
        <input type="text" id="searchMahasiswa"
               placeholder="🔍 Cari NIM atau Nama Mahasiswa..."
               class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-300
                      dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600">
    </div>

    <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow-md rounded-lg">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700" id="anggotaTable">
            <thead class="bg-green-600 text-white">
                <tr>
                    <th class="py-3 px-4 text-left">NIM</th>
                    <th class="py-3 px-4 text-left">Nama</th>
                    <th class="py-3 px-4 text-left">Jabatan</th>
                    <th class="py-3 px-4 text-left">Status</th>
                    <th class="py-3 px-4 text-left">Tanggal Bergabung</th>
                    <th class="py-3 px-4 text-left">Periode</th>
                    <th class="py-3 px-4 text-left">Tanggal Berakhir</th>
                    <th class="py-3 px-4 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                @forelse ($mahasiswa as $m)
                <tr class="mahasiswa-row hover:bg-gray-50 dark:hover:bg-gray-700 transition">

                    <td class="py-2 px-4 nim">{{ $m->nim }}</td>

                    <td class="py-2 px-4 nama">
                        {{ $m->nama }}
                        @if($m->aktif_sekarang)
                            <span class="text-sm text-green-600">(aktif)</span>
                        @endif
                    </td>

                    <form action="{{ route('organisasi.self.store_anggota', $organisasi->id) }}"
                          method="POST">
                        @csrf

                        <input type="hidden" name="mahasiswa_nim" value="{{ $m->nim }}">

                        {{-- Jabatan --}}
                        <td class="py-2 px-4">
                            <select name="jabatan"
                                class="border border-gray-300 rounded px-3 py-2 jabatan-select w-full
                                       dark:bg-gray-700 dark:text-gray-200">
                                <option value="Ketua">Ketua</option>
                                <option value="Wakil">Wakil</option>
                                <option value="Sekretaris">Sekretaris</option>
                                <option value="Bendahara">Bendahara</option>
                                <option value="Divisi Akademik">Divisi Akademik</option>
                                <option value="Divisi Acara">Divisi Acara</option>
                                <option value="Divisi Olahraga">Divisi Olahraga</option>
                                <option value="Divisi Multimedia">Divisi Multimedia</option>
                                <option value="Divisi Logistik">Divisi Logistik</option>
                                <option value="Divisi Humas">Divisi Humas</option>
                                <option value="Divisi Kerohanian">Divisi Kerohanian</option>
                                <option value="lainnya">Lainnya...</option>
                            </select>

                            <input type="text" name="jabatan_lainnya"
                                   class="jabatan-lainnya-input hidden border rounded px-2 py-1 mt-1 w-full
                                          dark:bg-gray-700 dark:text-gray-200"
                                   placeholder="Isi jabatan...">
                        </td>

                        {{-- STATUS OTOMATIS --}}
                        <td class="py-2 px-4">
                            <input type="text" name="status_keanggotaan"
                                   class="border border-gray-300 rounded px-3 py-2 w-full status-input
                                          dark:bg-gray-700 dark:text-gray-200"
                                   readonly>
                        </td>

                        {{-- Tanggal Bergabung --}}
                        <td class="py-2 px-4">
                            <input type="date" name="tanggal_bergabung"
                                   value="{{ date('Y-m-d') }}"
                                   class="border border-gray-300 rounded px-3 py-2 w-full
                                          dark:bg-gray-700 dark:text-gray-200 tanggal-bergabung">
                        </td>

                        {{-- Periode --}}
                        <td class="py-2 px-4">
                            <input type="text" name="periode"
                                   class="border border-gray-300 rounded px-3 py-2 w-full periode-input
                                          dark:bg-gray-700 dark:text-gray-200"
                                   readonly>
                        </td>

                        {{-- Tanggal Berakhir --}}
                        <td class="py-2 px-4">
                            <input type="date" name="tanggal_berakhir"
                                   class="border border-gray-300 rounded px-3 py-2 w-full tanggal-berakhir
                                          dark:bg-gray-700 dark:text-gray-200"
                                   readonly>
                        </td>

                        <td class="py-2 px-4 text-center">
                            <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                Tambah
                            </button>
                        </td>

                    </form>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-4 text-gray-500">
                        Semua mahasiswa sudah terdaftar
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>

    <a href="{{ route('organisasi.self.show', $organisasi->id) }}"
       class="mt-6 inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
        ← Kembali ke Detail Organisasi
    </a>
</div>


<script>
document.addEventListener('DOMContentLoaded', () => {

    // SEARCH
    document.getElementById('searchMahasiswa').addEventListener('keyup', function () {

        const keyword = this.value.toLowerCase();

        document.querySelectorAll('.mahasiswa-row').forEach(row => {

            const nim = row.querySelector('.nim').textContent.toLowerCase();
            const nama = row.querySelector('.nama').textContent.toLowerCase();

            row.style.display = (nim.includes(keyword) || nama.includes(keyword)) ? '' : 'none';

        });
    });


    // JABATAN LAINNYA
    document.querySelectorAll('.jabatan-select').forEach(select => {

        select.addEventListener('change', () => {

            const input = select.nextElementSibling;

            input.classList.toggle('hidden', select.value !== 'lainnya');

        });

    });


    // PERIODE + STATUS OTOMATIS
    document.querySelectorAll('.tanggal-bergabung').forEach(input => {

        input.addEventListener('change', function() {

            const row = this.closest('tr');

            const tglBergabung = new Date(this.value);

            if (isNaN(tglBergabung)) return;

            const today = new Date();


            // tanggal berakhir
            const tglBerakhir = new Date(tglBergabung);

            tglBerakhir.setFullYear(tglBerakhir.getFullYear() + 1);

            row.querySelector('.tanggal-berakhir').value =
                tglBerakhir.toISOString().split('T')[0];


            // periode
            const yearStart = tglBergabung.getFullYear();

            const yearEnd = yearStart + 1;

            row.querySelector('.periode-input').value =
                yearStart + "/" + yearEnd;


            // STATUS
            const statusInput = row.querySelector('.status-input');

            if (today >= tglBergabung && today <= tglBerakhir) {

                statusInput.value = "aktif";

            } else {

                statusInput.value = "nonaktif";

            }

        });


        input.dispatchEvent(new Event('change'));

    });

});
</script>

@endsection