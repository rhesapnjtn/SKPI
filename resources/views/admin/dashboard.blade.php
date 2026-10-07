@extends('layouts.app')

@section('content')
<div 
    x-data="dashboard()"
    x-init="init()"
    :class="darkMode ? 'dark bg-gray-900 text-gray-100' : 'bg-gray-100 text-gray-900'"
    class="min-h-screen p-8 transition-colors duration-500"
>

    <!-- Dark Mode -->
    <div class="flex justify-end mb-6">
        <button @click="darkMode = !darkMode"
            class="bg-gray-300 dark:bg-gray-700 px-4 py-2 rounded-full shadow">
            <span x-text="darkMode ? 'Light Mode' : 'Dark Mode'"></span>
        </button>
    </div>

    <!-- Header -->
    <header class="mb-12">
        <h1 class="text-4xl font-extrabold">🎯 Dashboard Admin</h1>
        <p class="text-gray-600 dark:text-gray-300">
            Sistem SKPI UNAI
        </p>
    </header>

    <!-- Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

        <!-- Mahasiswa -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-700 text-white p-6 rounded-xl shadow-lg hover:scale-105 transition">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold">Mahasiswa</h3>
                <div class="bg-white/20 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 11c1.657 0 3-1.567 3-3.5S13.657 4 12 4s-3 1.567-3 3.5S10.343 11 12 11zm0 2c-2.67 0-8 1.34-8 4v3h16v-3c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
            </div>

            <p class="text-3xl font-bold mt-4" x-text="countMahasiswa"></p>
            <a href="{{ route('mahasiswa.index') }}" class="text-sm mt-3 inline-block underline">
                Lihat Data →
            </a>
        </div>

        <!-- Kegiatan -->
        <div class="bg-gradient-to-br from-green-500 to-green-700 text-white p-6 rounded-xl shadow-lg hover:scale-105 transition">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold">Kegiatan</h3>
                <div class="bg-white/20 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7H3v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>

            <p class="text-3xl font-bold mt-4" x-text="countKegiatan"></p>
            <a href="{{ route('kegiatan.index') }}" class="text-sm mt-3 inline-block underline">
                Lihat Data →
            </a>
        </div>

        <!-- Organisasi -->
        <div class="bg-gradient-to-br from-yellow-400 to-yellow-600 text-white p-6 rounded-xl shadow-lg hover:scale-105 transition">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold">Organisasi</h3>
                <div class="bg-white/20 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5V4H2v16h5m10 0V10H7v10"/>
                    </svg>
                </div>
            </div>

            <p class="text-3xl font-bold mt-4" x-text="countOrganisasi"></p>
            <a href="{{ route('organisasi.index') }}" class="text-sm mt-3 inline-block underline">
                Lihat Data →
            </a>
        </div>

        <!-- Poin -->
        <div class="bg-gradient-to-br from-red-500 to-red-700 text-white p-6 rounded-xl shadow-lg hover:scale-105 transition">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold">Poin SKPI</h3>
                <div class="bg-white/20 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4M12 2a10 10 0 100 20 10 10 0 000-20z"/>
                    </svg>
                </div>
            </div>

            <p class="text-3xl font-bold mt-4" x-text="countPoin"></p>
            <a href="{{ route('poin.index') }}" class="text-sm mt-3 inline-block underline">
                Lihat Data →
            </a>
        </div>

    </div>

    <!-- Info -->
    <div class="mt-12 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 p-4 rounded-lg shadow">
        📢 Pastikan data SKPI sudah diverifikasi sebelum akhir semester
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<script>
function dashboard() {
    return {
        darkMode: false,

        countMahasiswa: 0,
        countKegiatan: 0,
        countOrganisasi: 0,
        countPoin: 0,

        async init() {
            try {
                const res = await fetch("{{ route('admin.dashboard.statistik') }}");
                const data = await res.json();

                this.animate('countMahasiswa', data.mahasiswa);
                this.animate('countKegiatan', data.kegiatan);
                this.animate('countOrganisasi', data.organisasi);
                this.animate('countPoin', data.poin);

            } catch (e) {
                console.error(e);
            }
        },

        animate(prop, target) {
            let val = 0;
            const step = Math.max(1, Math.floor(target / 100));

            const timer = setInterval(() => {
                if (val < target) {
                    val += step;
                    this[prop] = val;
                } else {
                    this[prop] = target;
                    clearInterval(timer);
                }
            }, 15);
        }
    }
}
</script>
@endpush
