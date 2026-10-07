@extends('layouts.dashboard_organisasi')

@section('title', 'Daftar Organisasi')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">📂 Daftar Organisasi</h1>

        <!-- TABEL ORGANISASI -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Nama Organisasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Fakultas</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>

                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($organisasis as $org)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="px-6 py-4">{{ $org->nama_organisasi }}</td>
                            <td class="px-6 py-4">{{ $org->fakultas }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <!-- SHOW -->
                                    <a href="{{ route('organisasi.self.show', ['id' => $org->id]) }}" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 transition">Lihat</a>

                                    <!-- EDIT (opsional) -->
                                    <a href="{{ route('organisasi.self.edit', ['id' => $org->id]) }}" class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600 transition">Edit</a>

                                    
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500 dark:text-gray-300">Belum ada data organisasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection