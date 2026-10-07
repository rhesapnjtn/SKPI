{{-- resources/views/detail_organisasi_mahasiswa/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10 px-6">
    <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg">
        <h2 class="text-2xl font-bold text-blue-700 dark:text-blue-400 mb-6">
            Edit Anggota Organisasi: {{ $organisasi->nama_organisasi }}
        </h2>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 text-red-700 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('organisasi.anggota.update', $detail->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- NIM --}}
            <div>
                <label for="nim" class="block text-sm font-medium text-gray-700 dark:text-gray-300">NIM Mahasiswa</label>
                <input type="text" name="nim" id="nim" value="{{ old('nim', $detail->nim) }}"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 dark:bg-gray-700 dark:text-white">
            </div>

            {{-- Jabatan --}}
            <div>
                <label for="jabatan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jabatan</label>
                <select name="jabatan" id="jabatan" class="jabatan-select border px-2 py-1 w-full rounded" required>
                    @php
                        $jabatan_options = [
                            'ketua' => 'Ketua',
                            'wakil' => 'Wakil',
                            'bendahara' => 'Bendahara',
                            'divisi acara' => 'Divisi Acara',
                            'divisi olahraga' => 'Divisi Olahraga',
                            'divisi multimedia' => 'Divisi Multimedia',
                            'divisi logistik' => 'Divisi Logistik',
                            'divisi humas' => 'Divisi Humas',
                            'lainnya' => '➕ Lainnya'
                        ];

                        $selected_jabatan = in_array(strtolower($detail->jabatan), array_keys($jabatan_options))
                                            ? strtolower($detail->jabatan)
                                            : 'lainnya';
                    @endphp

                    <option value="">-- Pilih Jabatan --</option>
                    @foreach ($jabatan_options as $value => $label)
                        <option value="{{ $value }}" {{ old('jabatan', $selected_jabatan) == $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Jabatan Custom --}}
            <div id="jabatan_custom_wrapper" class="{{ $selected_jabatan == 'lainnya' ? '' : 'hidden' }}">
                <label for="jabatan_custom" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Jika Lainnya, tulis jabatan:
                </label>
                <input type="text" name="jabatan_custom" id="jabatan_custom"
                       value="{{ old('jabatan_custom', $selected_jabatan == 'lainnya' ? $detail->jabatan : '') }}"
                       class="mt-1 block w-full border border-gray-300 rounded-md p-2 dark:bg-gray-700 dark:text-white">
            </div>

            {{-- Status --}}
            <div>
                <label for="status_keanggotaan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status Keanggotaan</label>
                <select name="status_keanggotaan" id="status_keanggotaan" class="mt-1 block w-full border border-gray-300 rounded-md p-2 dark:bg-gray-700 dark:text-white">
                    <option value="aktif" {{ old('status_keanggotaan', $detail->status_keanggotaan) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ old('status_keanggotaan', $detail->status_keanggotaan) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            {{-- Tanggal Bergabung --}}
            <div>
                <label for="tanggal_bergabung" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Bergabung</label>
                <input type="date" name="tanggal_bergabung" id="tanggal_bergabung"
                       value="{{ old('tanggal_bergabung', $detail->tanggal_bergabung) }}"
                       class="mt-1 block w-full border border-gray-300 rounded-md p-2 dark:bg-gray-700 dark:text-white">
            </div>

            {{-- Tanggal Berakhir --}}
            <div>
                <label for="tanggal_berakhir" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Berakhir (Opsional)</label>
                <input type="date" name="tanggal_berakhir" id="tanggal_berakhir"
                       value="{{ old('tanggal_berakhir', $detail->tanggal_berakhir) }}"
                       class="mt-1 block w-full border border-gray-300 rounded-md p-2 dark:bg-gray-700 dark:text-white">
            </div>

            {{-- Buttons --}}
            <div class="flex items-center gap-4">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
                <a href="{{ route('organisasi.show', ['organisasi' => $organisasi->id]) }}"
                   class="px-6 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">Batal</a>
            </div>
        </form>
    </div>
</div>

{{-- Script untuk menampilkan input jabatan_custom jika "Lainnya" dipilih --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const jabatanSelect = document.getElementById('jabatan');
    const jabatanCustomWrapper = document.getElementById('jabatan_custom_wrapper');

    jabatanSelect.addEventListener('change', function() {
        if (this.value === 'lainnya') {
            jabatanCustomWrapper.classList.remove('hidden');
        } else {
            jabatanCustomWrapper.classList.add('hidden');
        }
    });
});
</script>

@endsection