@extends('layouts.dashboard_organisasi')

@section('title', 'Detail Organisasi')

@section('content')
<div class="p-6">
    <!-- Header -->
    <h2 class="text-3xl font-bold text-green-600 mb-6">
        Detail Organisasi: {{ $organisasi->nama_organisasi }}
    </h2>

    <!-- Tombol tambah anggota -->
    <div class="mb-6">
        <a href="{{ route('organisasi.self.tambah_anggota', $organisasi->id) }}"
           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition">
           ➕ Tambah Anggota
        </a>
    </div>

    <!-- FILTER STATUS & PERIODE -->
    <div class="mb-4 flex flex-wrap gap-4 items-center">
        <form method="GET" action="{{ route('organisasi.self.show', $organisasi->id) }}" class="flex gap-2 flex-wrap items-center">
            
            <!-- Status Filter -->
            <label class="text-gray-700 dark:text-gray-300 font-semibold">Status:</label>
            <select name="status" class="px-2 py-1 border rounded-lg">
                <option value="aktif" {{ $statusFilter === 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ $statusFilter === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>

            <!-- Periode Filter -->
            <label class="text-gray-700 dark:text-gray-300 font-semibold">Periode:</label>
            <select name="periode" class="px-2 py-1 border rounded-lg">
                <option value="">Semua</option>
                @foreach($allPeriode as $periode)
                    <option value="{{ $periode }}" {{ $periodeFilter === $periode ? 'selected' : '' }}>
                        {{ $periode }}
                    </option>
                @endforeach
            </select>

            <!-- Tombol Filter -->
            <button type="submit" 
                    class="px-3 py-1 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                Filter
            </button>
        </form>
    </div>

    <!-- Tabel anggota -->
    <div class="overflow-x-auto shadow-lg rounded-xl">
        <table class="min-w-full bg-white dark:bg-gray-800 divide-y divide-gray-200">
            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 uppercase text-sm">
                <tr>
                    <th class="px-6 py-3 text-left">NIM</th>
                    <th class="px-6 py-3 text-left">Nama</th>
                    <th class="px-6 py-3 text-left">Jabatan</th>
                    <th class="px-6 py-3 text-left">Status Keanggotaan</th>
                    <th class="px-6 py-3 text-left">Tanggal Bergabung</th>
                    <th class="px-6 py-3 text-left">Periode</th>
                    <th class="px-6 py-3 text-left">Tanggal Berakhir</th>
                    <th class="px-6 py-3 text-left">Aksi</th>
                </tr>
            </thead>

            <tbody class="text-gray-600 dark:text-gray-300">
                @forelse($mahasiswa as $m)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <td class="px-6 py-4">{{ $m->nim }}</td>
                    <td class="px-6 py-4">{{ $m->nama }}</td>
                    <td class="px-6 py-4">{{ $m->jabatan ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $m->status_keanggotaan ?? '-' }}</td>
                    <td class="px-6 py-4">
                        {{ $m->tanggal_bergabung 
                            ? \Carbon\Carbon::parse($m->tanggal_bergabung)->format('d F Y') 
                            : '-' }}
                    </td>
                    <td class="px-6 py-4">{{ $m->periode ?? '-' }}</td>
                    <td class="px-6 py-4">
                        {{ $m->tanggal_berakhir 
                            ? \Carbon\Carbon::parse($m->tanggal_berakhir)->format('d F Y') 
                            : '-' }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2">
                            <!-- EDIT -->
                            <a href="{{ route('organisasi.self.edit_anggota', [$organisasi->id, $m->nim]) }}"
                               class="px-3 py-1 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                                Edit
                            </a>

                            <!-- DELETE -->
                            <button
                                onclick="openDeleteModal(
                                    '{{ route('organisasi.self.delete_anggota', [$organisasi->id, $m->nim]) }}',
                                    '{{ $m->nama }}',
                                    '{{ $m->nim }}',
                                    '{{ $m->periode }}'
                                )"
                                class="px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-6 text-center text-gray-500 dark:text-gray-400">
                        Tidak ada anggota di organisasi ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Tombol kembali -->
    <div class="mt-6">
        <a href="{{ route('organisasi.self.index') }}"
           class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
           ← Kembali ke Daftar Organisasi
        </a>
    </div>
</div>

<!-- Modal Delete Anggota -->
<div id="deleteModal"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl w-full max-w-md p-6">
        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">
            ⚠️ Konfirmasi Hapus Anggota
        </h3>

        <p class="text-gray-600 dark:text-gray-300 mb-2">
            Anda yakin ingin menghapus anggota:
        </p>

        <p class="font-semibold text-red-500 mb-4">
            <span id="memberName"></span> (<span id="memberNim"></span>)
        </p>

        <div class="flex items-center mb-6">
            <input type="checkbox" id="confirmCheck"
                   class="w-4 h-4 text-red-500 focus:ring-red-400">
            <label for="confirmCheck"
                   class="ml-2 text-gray-600 dark:text-gray-300">
                Saya yakin ingin menghapus anggota ini
            </label>
        </div>

        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="flex justify-end gap-3">
                <button type="button"
                        onclick="closeDeleteModal()"
                        class="px-4 py-2 bg-gray-300 dark:bg-gray-600 
                               text-gray-800 dark:text-gray-200 rounded-lg 
                               hover:bg-gray-400 transition">
                    Batal
                </button>

                <button type="submit"
                        id="deleteButton"
                        disabled
                        class="px-4 py-2 bg-red-600 text-white rounded-lg 
                               opacity-50 cursor-not-allowed transition">
                    Hapus
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openDeleteModal(action, name, nim, periode) {
        const url = new URL(action, window.location.origin);
        url.searchParams.set('periode', periode);
        document.getElementById('deleteForm').action = url.toString();

        document.getElementById('memberName').innerText = name;
        document.getElementById('memberNim').innerText = nim;

        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('deleteModal').classList.add('flex');

        document.getElementById('confirmCheck').checked = false;
        toggleDeleteButton(false);
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.getElementById('deleteModal').classList.remove('flex');
    }

    function toggleDeleteButton(enabled) {
        const btn = document.getElementById('deleteButton');
        btn.disabled = !enabled;
        btn.classList.toggle('opacity-50', !enabled);
        btn.classList.toggle('cursor-not-allowed', !enabled);
    }

    document.getElementById('confirmCheck').addEventListener('change', function () {
        toggleDeleteButton(this.checked);
    });
</script>
@endsection