<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardAdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function statistik()
    {
        // Total mahasiswa
        $totalMahasiswa = DB::table('mahasiswas')->count();

        // Total kegiatan
        $totalKegiatan = DB::table('kegiatans')->count();

        // Total organisasi
        $totalOrganisasi = DB::table('organisasis')->count();

        // ============================
        // HITUNG TOTAL POIN GLOBAL
        // ============================

        // Total partisipasi kegiatan
        $jumlahKegiatanDiikuti = DB::table('detail_kegiatan_mahasiswa')->count();

        // Total partisipasi organisasi
        $jumlahOrganisasiDiikuti = DB::table('detail_organisasi_mahasiswa')->count();

        // Total poin tambahan dari Warek
        $totalPoinTambahan = DB::table('poin_mahasiswas')->sum('poin_tambahan');

        // Rumus sama persis dengan dashboard mahasiswa
        $totalPoin = ($jumlahKegiatanDiikuti * 100) 
                   + ($jumlahOrganisasiDiikuti * 250) 
                   + $totalPoinTambahan;

        return response()->json([
            'mahasiswa'  => $totalMahasiswa,
            'kegiatan'   => $totalKegiatan,
            'organisasi' => $totalOrganisasi,
            'poin'       => $totalPoin,
        ]);
    }
}
