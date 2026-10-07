@extends('layouts.dashboard_mahasiswa')

@section('content')

<div class="p-6 bg-white dark:bg-gray-800 rounded-2xl shadow-md">

<h1 class="text-3xl font-bold mb-6 text-gray-900 dark:text-gray-100">
Leaderboard Mahasiswa
</h1>

<div class="overflow-x-auto">

<table class="min-w-full border border-gray-300">

<thead class="bg-gray-200">
<tr>
<th class="px-6 py-3 border text-left">Rank</th>
<th class="px-6 py-3 border text-left">NIM</th>
<th class="px-6 py-3 border text-left">Nama</th>
<th class="px-6 py-3 border text-left">Total Poin</th>
</tr>
</thead>

<tbody>

@forelse($mahasiswa as $index => $mhs)

<tr class="hover:bg-gray-50">

<td class="px-6 py-3 border">
{{ $index + 1 }}
</td>

<td class="px-6 py-3 border">
{{ $mhs->nim }}
</td>

<td class="px-6 py-3 border">
{{ $mhs->nama }}
</td>

<td class="px-6 py-3 border font-bold">
{{ $mhs->total_poin }}
</td>

</tr>

@empty

<tr>
<td colspan="4" class="px-6 py-4 text-center text-gray-500">
Tidak ada data
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>

@endsection