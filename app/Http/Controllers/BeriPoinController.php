<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\Kegiatan;
use App\Models\DetailKegiatanMahasiswa;
use App\Models\DetailOrganisasiMahasiswa;
use App\Models\PoinMahasiswa;
use Illuminate\Support\Facades\DB;

class BeriPoinController extends Controller
{
    const POIN_KEGIATAN   = 100;
    const POIN_ORGANISASI = 250;

    // ===============================
    // HALAMAN FORM BERI POIN (WAREK)
    // ===============================
    public function index(Request $request)
    {
        $search = $request->input('search');

        $mahasiswas = Mahasiswa::select('nim','nama')
            ->when($search,function($query,$search){
                return $query->where('nama','like',"%$search%")
                             ->orWhere('nim','like',"%$search%");
            })
            ->get();

        $kegiatans = Kegiatan::select('id','nama_kegiatan','jenis_kegiatan')->get();

        return view('warek.beripoin.index',compact(
            'mahasiswas',
            'kegiatans',
            'search'
        ));
    }

    // ==================================
    // SIMPAN / TAMBAH POIN DARI WAREK
    // ==================================
    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|exists:mahasiswas,nim',
            'poin_tambahan' => 'nullable|integer',
            'kegiatan_id_ref' => 'nullable|exists:kegiatans,id',
            'alasan' => 'nullable|string|max:500'
        ]);

        DB::transaction(function () use ($request) {

            $mahasiswa = Mahasiswa::where('nim',$request->nim)->firstOrFail();
            $poinTambahanBaru = intval($request->poin_tambahan ?? 0);

            // ✅ simpan record baru untuk setiap poin tambahan
            if($poinTambahanBaru > 0 || $request->alasan){
                PoinMahasiswa::create([
                    'nim' => $mahasiswa->nim,
                    'nama' => $mahasiswa->nama,
                    'poin_tambahan' => $poinTambahanBaru,
                    'alasan' => $request->alasan,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            // jika memilih kegiatan
            if($request->kegiatan_id_ref){
                DetailKegiatanMahasiswa::create([
                    'mahasiswa_nim' => $mahasiswa->nim,
                    'kegiatan_id_ref' => $request->kegiatan_id_ref,
                    'absensi' => 'Hadir',
                    'poin' => self::POIN_KEGIATAN,
                    'tanggal' => now()
                ]);
            }

        });

        return back()->with('success', "✅ Poin tambahan WR berhasil ditambahkan.");
    }

    // ==================================
    // API FETCH NAMA + TOTAL POIN LAMA
    // ==================================
    public function getMahasiswa($nim)
    {
        $mahasiswa = Mahasiswa::where('nim',$nim)->first();

        if(!$mahasiswa){
            return response()->json([
                'nama' => '',
                'poin_lama' => 0
            ]);
        }

        $poinKegiatan =
            DetailKegiatanMahasiswa::where('mahasiswa_nim',$nim)
            ->count() * self::POIN_KEGIATAN;

        $poinOrganisasi =
            DetailOrganisasiMahasiswa::where('nim',$nim)
            ->count() * self::POIN_ORGANISASI;

        $poinTambahan =
            PoinMahasiswa::where('nim',$nim)
            ->sum('poin_tambahan');

        $totalPoin =
            $poinKegiatan +
            $poinOrganisasi +
            $poinTambahan;

        return response()->json([
            'nama' => $mahasiswa->nama,
            'poin_lama' => $totalPoin
        ]);
    }

    // ==================================
    // FORM EDIT POIN TAMBAHAN (WAREK)
    // ==================================
    public function edit($nim)
    {
        $mahasiswa = Mahasiswa::where('nim',$nim)->firstOrFail();

        $poinKegiatan =
            DetailKegiatanMahasiswa::where('mahasiswa_nim',$nim)
            ->count() * self::POIN_KEGIATAN;

        $poinOrganisasi =
            DetailOrganisasiMahasiswa::where('nim',$nim)
            ->count() * self::POIN_ORGANISASI;

        $poinTambahan =
            PoinMahasiswa::where('nim',$nim)
            ->sum('poin_tambahan');

        $totalPoin =
            $poinKegiatan +
            $poinOrganisasi +
            $poinTambahan;

        // ambil semua alasan poin tambahan (filter poin > 0)
        $poinTambahanData =
            PoinMahasiswa::where('nim',$nim)
            ->where('poin_tambahan','>',0)
            ->orderByDesc('created_at')
            ->get();

        return view('warek.beripoin.edit_poin',compact(
            'mahasiswa',
            'totalPoin',
            'poinTambahan',
            'poinTambahanData'
        ));
    }

    // ==================================
    // SIMPAN HASIL EDIT POIN TAMBAHAN
    // ==================================
    public function update(Request $request,$nim)
    {
        $request->validate([
            'poin_tambahan' => 'required|integer',
            'alasan' => 'nullable|string|max:500'
        ]);

        $mahasiswa = Mahasiswa::where('nim',$nim)->firstOrFail();

        // simpan sebagai record baru, tidak menimpa lama
        PoinMahasiswa::create([
            'nim' => $mahasiswa->nim,
            'nama' => $mahasiswa->nama,
            'poin_tambahan' => $request->poin_tambahan,
            'alasan' => $request->alasan,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()
            ->route('warek.beripoin.index')
            ->with('success', "✅ Poin tambahan WR berhasil ditambahkan.");
    }

    // ==================================
    // DETAIL MAHASISWA + RIWAYAT POIN
    // ==================================
    public function show($nim)
    {
        $mahasiswa = Mahasiswa::where('nim',$nim)->firstOrFail();

        // Riwayat kegiatan
        $kegiatan = DetailKegiatanMahasiswa::where('mahasiswa_nim',$nim)
            ->join('kegiatans','detail_kegiatan_mahasiswa.kegiatan_id_ref','=','kegiatans.id')
            ->leftJoin('organisasis','kegiatans.id_organisasi','=','organisasis.id')
            ->select(
                'kegiatans.nama_kegiatan',
                'kegiatans.tanggal_kegiatan',
                'organisasis.nama_organisasi',
                DB::raw('100 as poin')
            )
            ->orderByDesc('kegiatans.tanggal_kegiatan')
            ->get();

        // Semua poin tambahan WR (filter poin > 0)
        $poinTambahanData = PoinMahasiswa::where('nim',$nim)
            ->where('poin_tambahan','>',0)
            ->orderByDesc('created_at')
            ->get();

        $totalPoin = $kegiatan->sum('poin') + $poinTambahanData->sum('poin_tambahan');
        $poinTambahan = $poinTambahanData->sum('poin_tambahan');

        return view('warek.beripoin.show', compact(
            'mahasiswa',
            'kegiatan',
            'totalPoin',
            'poinTambahan',
            'poinTambahanData'
        ));
    }
}