<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MahasiswaOrganisasiController extends Controller
{
    /**
     * Menampilkan daftar organisasi mahasiswa beserta jabatan, tanggal bergabung, tanggal berakhir, dan poin.
     */
    public function index()
    {
        // 🔐 Cek login mahasiswa
        if (!session('is_logged_in') || session('user_role') !== 'mahasiswa') {
            return redirect()->route('login');
        }

        // ✅ Ambil NIM dari email mahasiswa (7 digit pertama)
        $email = session('user_email');
        $nim   = substr($email, 0, 7);

        // Ambil data organisasi + jabatan + tanggal bergabung + tanggal berakhir
        $organisasi = DB::table('detail_organisasi_mahasiswa')
            ->select('nama_organisasi', 'jabatan', 'tanggal_bergabung', 'tanggal_berakhir')
            ->where('nim', $nim)
            ->orderBy('nama_organisasi', 'asc')
            ->get()
            ->map(function($item) {
                // Set poin default 250
                $item->poin = 250;

                // Format tanggal bergabung
                $item->tanggal_bergabung_formatted = $item->tanggal_bergabung
                    ? Carbon::parse($item->tanggal_bergabung)->translatedFormat('d F Y')
                    : '-';

                // Format tanggal berakhir
                $item->tanggal_berakhir_formatted = $item->tanggal_berakhir
                    ? Carbon::parse($item->tanggal_berakhir)->translatedFormat('d F Y')
                    : '-';

                return $item;
            });

        // Total poin dari organisasi
        $totalPoin = $organisasi->sum('poin');

        return view('tampilan_mahasiswa.organisasi.index', compact('organisasi', 'nim', 'totalPoin'));
    }
}
