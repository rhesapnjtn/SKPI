<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Mahasiswa;

class LeaderboardController extends Controller
{
    public function index()
    {
        // Ambil semua mahasiswa
        $mahasiswas = Mahasiswa::all();

        $mahasiswa = $mahasiswas->map(function ($mhs) {

            // -------------------------
            // Poin kegiatan (100 / kegiatan)
            // -------------------------
            $jumlahKegiatan = DB::table('detail_kegiatan_mahasiswa')
                ->where('mahasiswa_nim', $mhs->nim)
                ->count();

            $poinKegiatan = $jumlahKegiatan * 100;

            // -------------------------
            // Poin organisasi aktif (250 / organisasi)
            // -------------------------
            $jumlahOrganisasi = DB::table('detail_organisasi_mahasiswa')
                ->where('nim', $mhs->nim)
                ->where('status_keanggotaan', 'aktif')
                ->count();

            $poinOrganisasi = $jumlahOrganisasi * 250;

            // -------------------------
            // Poin tambahan
            // -------------------------
            $poinTambahan = DB::table('poin_mahasiswas')
                ->where('nim', $mhs->nim)
                ->sum('poin_tambahan');

            // -------------------------
            // Total poin
            // -------------------------
            $totalPoin = $poinKegiatan + $poinOrganisasi + $poinTambahan;

            return [
                'nim' => $mhs->nim,
                'nama' => $mhs->nama,
                'poin_kegiatan' => $poinKegiatan,
                'poin_organisasi' => $poinOrganisasi,
                'poin_tambahan' => $poinTambahan,
                'total_poin' => $totalPoin
            ];
        })
        ->sortByDesc('total_poin')
        ->values();

        return view('tampilan_mahasiswa.leaderboard.index', compact('mahasiswa'));
    }
}