@extends('layouts.dashboard_mahasiswa')

@section('content')

<div class="max-w-6xl mx-auto">

    <!-- Card -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100">

        <!-- Header -->
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-800">
                🏆 Leaderboard Mahasiswa
            </h2>

            <span class="text-sm text-gray-500">
                Peringkat berdasarkan total poin
            </span>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">

            <table class="w-full">

                <!-- Table Head -->
                <thead class="bg-gray-50">
                    <tr class="text-sm text-gray-600 uppercase tracking-wider">
                        <th class="px-6 py-4 text-left">Rank</th>
                        <th class="px-6 py-4 text-left">NIM</th>
                        <th class="px-6 py-4 text-left">Nama</th>
                        <th class="px-6 py-4 text-left">Total Poin</th>
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody class="divide-y divide-gray-100">

                    @forelse($mahasiswa as $index => $mhs)

                        @php
                            $rank = $index + 1;

                            $rowStyle = '';

                            if ($rank == 1) {
                                $rowStyle = 'bg-yellow-50 border-l-4 border-yellow-400';
                            } elseif ($rank == 2) {
                                $rowStyle = 'bg-gray-50 border-l-4 border-gray-400';
                            } elseif ($rank == 3) {
                                $rowStyle = 'bg-orange-50 border-l-4 border-orange-400';
                            }
                        @endphp

                        <tr class="hover:bg-gray-50 transition-all duration-200 {{ $rowStyle }}">

                            <!-- Rank -->
                            <td class="px-6 py-4 font-semibold text-gray-800">

                                @if($rank == 1)
                                    🥇 #{{ $rank }}
                                @elseif($rank == 2)
                                    🥈 #{{ $rank }}
                                @elseif($rank == 3)
                                    🥉 #{{ $rank }}
                                @else
                                    #{{ $rank }}
                                @endif

                            </td>

                            <!-- NIM -->
                            <td class="px-6 py-4 text-gray-700 font-medium">
                                {{ $mhs['nim'] }}
                            </td>

                            <!-- Nama -->
                            <td class="px-6 py-4 text-gray-800">
                                {{ $mhs['nama'] }}
                            </td>

                            <!-- Poin -->
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-sm font-bold rounded-lg bg-indigo-100 text-indigo-700">
                                    {{ $mhs['total_poin'] }} poin
                                </span>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                Belum ada data leaderboard
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection