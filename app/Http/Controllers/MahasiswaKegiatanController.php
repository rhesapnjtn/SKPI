<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MahasiswaKegiatanController extends Controller
{
    public function index()
    {
        // 🔐 Cek login mahasiswa
        if (!session('is_logged_in') || session('user_role') !== 'mahasiswa') {
            return redirect()->route('login');
        }

        // Ambil email dari session
        $email = session('user_email');

        // Ambil NIM dari email (7 karakter pertama)
        $nim = substr($email, 0, 7);

        // ============================
        // DATA KEGIATAN MAHASISWA
        // ============================
        $kegiatans = DB::table('detail_kegiatan_mahasiswa as dkm')
            ->join('kegiatans as k', 'dkm.kegiatan_id_ref', '=', 'k.id')
            ->leftJoin('organisasis as o', 'k.id_organisasi', '=', 'o.id')
            ->where('dkm.mahasiswa_nim', $nim)
            ->orderBy('k.tanggal_kegiatan', 'desc')
            ->select(
                'k.nama_kegiatan',
                'k.jenis_kegiatan',
                'k.tanggal_kegiatan',
                DB::raw('COALESCE(o.nama_organisasi, "-") as nama_organisasi')
            )
            ->get()
            ->map(function ($item) {

                // setiap kegiatan = 100 poin
                $item->poin = 100;

                // format tanggal
                if ($item->tanggal_kegiatan) {
                    $item->tanggal_kegiatan = Carbon::parse($item->tanggal_kegiatan)
                        ->format('d M Y');
                }

                return $item;
            });

        // ============================
        // TOTAL POIN KEGIATAN
        // ============================
        $totalPoinKegiatan = $kegiatans->sum('poin');

        // ============================
        // AMBIL DATA POIN TAMBAHAN
        // ============================
        $poinData = DB::table('poin_mahasiswas')
            ->where('nim', $nim)
            ->first();

        $poinTambahan = $poinData->poin_tambahan ?? 0;
        $alasan = $poinData->alasan ?? '-';

        // ============================
        // TOTAL POIN MAHASISWA
        // ============================
        $totalPoin = $totalPoinKegiatan + $poinTambahan;

        return view('tampilan_mahasiswa.kegiatan.index', [
            'kegiatans' => $kegiatans,
            'nim' => $nim,
            'totalPoin' => $totalPoin,
            'poinTambahan' => $poinTambahan,
            'alasan' => $alasan
        ]);
    }
}