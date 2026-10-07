<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\PoinMahasiswa;
use App\Models\DetailKegiatanMahasiswa;
use App\Models\DetailOrganisasiMahasiswa;
use Illuminate\Support\Facades\DB;

class WarekPoinController extends Controller
{

    // ===========================
    // HALAMAN PENCARIAN MAHASISWA
    // ===========================
    public function index(Request $request)
    {
        $query = Mahasiswa::query();

        if ($request->filled('q')) {
            $q = $request->q;

            $query->where(function ($sub) use ($q) {
                $sub->where('nim', 'like', "%$q%")
                    ->orWhere('nama', 'like', "%$q%");
            });
        }

        $mahasiswas = $query->paginate(10);

        // HITUNG TOTAL POIN SESUAI LOGIKA
        $mahasiswas->getCollection()->transform(function ($m) {

            $jumlahKegiatan = DetailKegiatanMahasiswa::where('mahasiswa_nim', $m->nim)->count();
            $jumlahOrganisasi = DetailOrganisasiMahasiswa::where('nim', $m->nim)->count();

            $poinTambahan = PoinMahasiswa::where('nim', $m->nim)->sum('poin_tambahan');

            $poinKegiatan = $jumlahKegiatan * 100;
            $poinOrganisasi = $jumlahOrganisasi * 250;

            $m->total_poin = $poinKegiatan + $poinOrganisasi + $poinTambahan;

            return $m;
        });

        return view('warek.poin.index', compact('mahasiswas'));
    }


    // ===========================
    // DETAIL MAHASISWA
    // ===========================
    public function show($nim)
    {
        $mahasiswa = Mahasiswa::where('nim', $nim)->firstOrFail();

        // ===== HITUNG JUMLAH =====
        $jumlahKegiatan = DetailKegiatanMahasiswa::where('mahasiswa_nim', $nim)->count();
        $jumlahOrganisasi = DetailOrganisasiMahasiswa::where('nim', $nim)->count();

        // ===== HITUNG POIN =====
        $poinKegiatan = $jumlahKegiatan * 100;
        $poinOrganisasi = $jumlahOrganisasi * 250;

        $poinTambahanData = PoinMahasiswa::where('nim', $nim)->get();
        $poinTambahan = $poinTambahanData->sum('poin_tambahan');

        $totalPoin = $poinKegiatan + $poinOrganisasi + $poinTambahan;


        // ===========================
        // RIWAYAT KEGIATAN
        // ===========================
        $kegiatan = DetailKegiatanMahasiswa::select(
                'kegiatans.nama_kegiatan',
                'kegiatans.tanggal_kegiatan',
                'organisasis.nama_organisasi'
            )
            ->join('kegiatans', 'detail_kegiatan_mahasiswa.kegiatan_id_ref', '=', 'kegiatans.id')
            ->leftJoin('organisasis', 'kegiatans.id_organisasi', '=', 'organisasis.id')
            ->where('detail_kegiatan_mahasiswa.mahasiswa_nim', $nim)
            ->orderBy('kegiatans.tanggal_kegiatan', 'desc')
            ->get()
            ->map(function ($item) {
                $item->poin = 100;
                return $item;
            });


        // ===========================
        // RIWAYAT ORGANISASI
        // ===========================
        $organisasi = DetailOrganisasiMahasiswa::select(
                'nama_organisasi',
                'jabatan',
                'tanggal_bergabung as tgl_mulai',
                'tanggal_berakhir as tgl_selesai'
            )
            ->where('nim', $nim)
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($item) {
                $item->poin = 250;
                return $item;
            });


        return view('warek.poin.show', compact(
            'mahasiswa',
            'totalPoin',
            'poinTambahan',
            'poinTambahanData',
            'kegiatan',
            'organisasi'
        ));
    }


    // ===========================
    // SIMPAN POIN TAMBAHAN
    // ===========================
    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|exists:mahasiswas,nim',
            'alasan' => 'required|string|max:255',
            'poin_tambahan' => 'required|integer|min:0',
        ]);

        DB::table('poin_mahasiswas')->insert([
            'nim' => $request->nim,
            'alasan' => $request->alasan,
            'poin_tambahan' => $request->poin_tambahan,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('warek.poin.show', $request->nim)
            ->with('success', 'Poin tambahan berhasil ditambahkan.');
    }
}