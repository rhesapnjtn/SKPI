<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MahasiswaKlaimPoinController extends Controller
{
    public function index()
    {
        // 🔐 Cek login mahasiswa
        if (!session('is_logged_in') || session('user_role') !== 'mahasiswa') {
            return redirect()->route('login');
        }

        // ✅ Ambil NIM dari email (7 digit)
        $email = session('user_email');
        $nim   = substr($email, 0, 7);

        /*
        |--------------------------------------------------------------------------
        | ORGANISASI
        |--------------------------------------------------------------------------
        */
        $organisasi = DB::table('detail_organisasi_mahasiswa')
            ->where('nim', $nim)
            ->select(
                'nama_organisasi',
                'jabatan',
                'status_keanggotaan'
            )
            ->get();

        $poinOrganisasi = $organisasi->count() * 250;


        /*
        |--------------------------------------------------------------------------
        | KEGIATAN + ORGANISASI PENYELENGGARA
        |--------------------------------------------------------------------------
        */
        $kegiatan = DB::table('detail_kegiatan_mahasiswa')
            ->join(
                'kegiatans',
                'detail_kegiatan_mahasiswa.kegiatan_id_ref',
                '=',
                'kegiatans.id'
            )
            ->leftJoin(
                'organisasis',
                'kegiatans.id_organisasi',
                '=',
                'organisasis.id'   // ✅ PERBAIKAN DISINI
            )
            ->where('detail_kegiatan_mahasiswa.mahasiswa_nim', $nim)
            ->select(
                'kegiatans.nama_kegiatan',
                DB::raw("COALESCE(organisasis.nama_organisasi, '-') as nama_organisasi")
            )
            ->get();

        $poinKegiatan = $kegiatan->count() * 100;


        /*
        |--------------------------------------------------------------------------
        | POIN TAMBAHAN DARI WAREK
        |--------------------------------------------------------------------------
        */
        $poinTambahan = DB::table('poin_mahasiswas')
            ->where('nim', $nim)
            ->sum('poin_tambahan');


        /*
        |--------------------------------------------------------------------------
        | TOTAL POIN
        |--------------------------------------------------------------------------
        */
        $totalPoin = $poinOrganisasi + $poinKegiatan + $poinTambahan;


        /*
        |--------------------------------------------------------------------------
        | KIRIM DATA KE VIEW
        |--------------------------------------------------------------------------
        */
        return view('tampilan_mahasiswa.klaim_poin.index', compact(
            'nim',
            'organisasi',
            'kegiatan',
            'poinOrganisasi',
            'poinKegiatan',
            'poinTambahan',
            'totalPoin'
        ));
    }
}