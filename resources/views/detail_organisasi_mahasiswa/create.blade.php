@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-10 px-4">

    <h2 class="text-2xl font-bold mb-6 text-green-700">
        ➕ Tambah Anggota untuk Organisasi: {{ $organisasi->nama_organisasi }}
    </h2>

    {{-- FORM SEARCH --}}
    <form method="GET" action="{{ url()->current() }}" class="mb-6">
        <input type="text" name="cari" id="searchMahasiswa"
               value="{{ request('cari') }}"
               placeholder="Cari mahasiswa berdasarkan NIM atau Nama..."
               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
    </form>

    @if ($mahasiswa->isEmpty())
        <p class="text-gray-500">🙁 Tidak ada mahasiswa ditemukan.</p>
    @else
        <div class="overflow-x-auto bg-white rounded-lg shadow border">
            <table class="min-w-full divide-y divide-gray-200 text-sm" id="anggotaTable">
                <thead class="bg-green-600 text-white">
                    <tr>
                        <th class="px-4 py-3 text-left">NIM</th>
                        <th class="px-4 py-3 text-left">Nama</th>
                        <th class="px-4 py-3 text-left">Jabatan</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Tanggal Bergabung</th>
                        <th class="px-4 py-3 text-left">Periode</th>
                        <th class="px-4 py-3 text-left">Tanggal Berakhir</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach ($mahasiswa as $mhs)
                        <tr class="mahasiswa-row hover:bg-green-50 transition">
                            <form method="POST"
                                  action="{{ route('organisasi.anggota.store', ['organisasi' => $organisasi->id]) }}">
                                @csrf

                                <input type="hidden" name="nim" value="{{ $mhs->nim }}">

                                <td class="px-4 py-2 nim">{{ $mhs->nim }}</td>
                                <td class="px-4 py-2 nama">{{ $mhs->nama }}</td>

                                {{-- JABATAN --}}
                                <td class="px-4 py-2">
                                    <select name="jabatan" class="jabatan-select border px-2 py-1 w-full rounded" required>
                                        <option value="">-- Pilih Jabatan --</option>
                                        <option value="ketua">Ketua</option>
                                        <option value="wakil">Wakil</option>
                                        <option value="bendahara">Bendahara</option>
                                        <option value="divisi acara">Divisi Acara</option>
                                        <option value="divisi olahraga">Divisi Olahraga</option>
                                        <option value="divisi multimedia">Divisi Multimedia</option>
                                        <option value="divisi logistik">Divisi Logistik</option>
                                        <option value="divisi humas">Divisi Humas</option>
                                        <option value="lainnya">➕ Lainnya</option>
                                    </select>

                                    <input type="text" name="jabatan_custom"
                                           class="jabatan-custom mt-2 hidden w-full px-2 py-1 border rounded"
                                           placeholder="Masukkan jabatan/divisi baru...">
                                </td>

                                {{-- STATUS --}}
                                <td class="px-4 py-2">
                                    <select name="status_keanggotaan" class="status-select border px-2 py-1 w-full rounded" required>
                                        <option value="aktif">Aktif</option>
                                        <option value="nonaktif">Nonaktif</option>
                                    </select>
                                </td>

                                {{-- TANGGAL BERGABUNG --}}
                                <td class="px-4 py-2">
                                    <input type="date" name="tanggal_bergabung"
                                           value="{{ old('tanggal_bergabung', date('Y-m-d')) }}"
                                           class="border px-2 py-1 rounded w-full tanggal-bergabung" required>
                                </td>

                                {{-- PERIODE OTOMATIS --}}
                                <td class="px-4 py-2">
                                    <input type="text" name="periode"
                                           class="border px-2 py-1 w-full rounded periode-input"
                                           placeholder="YYYY/YYYY+1" readonly>
                                </td>

                                {{-- TANGGAL BERAKHIR OTOMATIS --}}
                                <td class="px-4 py-2">
                                    <input type="date" name="tanggal_berakhir"
                                           class="border px-2 py-1 rounded w-full tanggal-berakhir" readonly>
                                </td>

                                {{-- BUTTON --}}
                                <td class="px-4 py-2 text-center">
                                    <button type="submit"
                                            class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 transition">
                                        Tambah
                                    </button>
                                </td>
                            </form>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $mahasiswa->appends(['cari' => request('cari')])->links() }}
        </div>
    @endif

    <div class="mt-6">
        <a href="{{ route('organisasi.show', ['organisasi' => $organisasi->id]) }}"
           class="inline-block bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300 transition">
           ← Kembali ke Detail Organisasi
        </a>
    </div>
</div>

{{-- SCRIPT --}}
<script>
document.addEventListener("DOMContentLoaded", () => {

    // SEARCH MAHASISWA
    document.getElementById('searchMahasiswa').addEventListener('keyup', function () {
        const keyword = this.value.toLowerCase();
        document.querySelectorAll('.mahasiswa-row').forEach(row => {
            const nim = row.querySelector('.nim').textContent.toLowerCase();
            const nama = row.querySelector('.nama').textContent.toLowerCase();
            row.style.display = (nim.includes(keyword) || nama.includes(keyword)) ? '' : 'none';
        });
    });

    // Jabatan Custom
    document.querySelectorAll(".jabatan-select").forEach(select => {
        select.addEventListener("change", function() {
            const input = this.parentElement.querySelector(".jabatan-custom");
            if (this.value === "lainnya") {
                input.classList.remove("hidden");
                input.setAttribute("required", "true");
            } else {
                input.classList.add("hidden");
                input.removeAttribute("required");
                input.value = "";
            }
        });
    });

    // Periode, Tanggal Berakhir & Status otomatis
    document.querySelectorAll('.tanggal-bergabung').forEach(input => {
        input.addEventListener('change', function() {
            const row = this.closest('tr');
            const tglBergabung = new Date(this.value);
            if (isNaN(tglBergabung)) return;

            // Tanggal Berakhir = +1 tahun
            const tglBerakhirInput = row.querySelector('.tanggal-berakhir');
            const tglBerakhir = new Date(tglBergabung);
            tglBerakhir.setFullYear(tglBerakhir.getFullYear() + 1);
            tglBerakhirInput.value = tglBerakhir.toISOString().split('T')[0];

            // Periode = YYYY/YYYY+1
            const periodeInput = row.querySelector('.periode-input');
            const yearStart = tglBergabung.getFullYear();
            const yearEnd = yearStart + 1;
            periodeInput.value = `${yearStart}/${yearEnd}`;

            // Status otomatis berdasarkan tanggal bergabung
            const statusSelect = row.querySelector('.status-select');
            const today = new Date();
            today.setHours(0,0,0,0); // reset jam
            if (tglBergabung < today) {
                statusSelect.value = 'nonaktif';
                tglBerakhirInput.disabled = false;
            } else {
                statusSelect.value = 'aktif';
                tglBerakhirInput.disabled = true;
            }
        });

        // Trigger change awal jika ada value default
        input.dispatchEvent(new Event('change'));
    });

    // Update status-select saat user ubah manual
    document.querySelectorAll(".status-select").forEach(select => {
        select.addEventListener("change", function() {
            const row = this.closest('tr');
            const tglBerakhir = row.querySelector(".tanggal-berakhir");

            if (this.value === 'aktif') {
                tglBerakhir.value = '';
                tglBerakhir.disabled = true;
            } else {
                tglBerakhir.disabled = false;
            }
        });

        select.dispatchEvent(new Event('change'));
    });

});
</script>

@endsection