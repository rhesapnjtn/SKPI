<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PoinMahasiswa;
use App\Models\Mahasiswa;
use App\Models\DetailKegiatanMahasiswa;
use App\Models\DetailOrganisasiMahasiswa;
use Carbon\Carbon;

class PoinMahasiswaController extends Controller
{
    /**
     * Halaman daftar poin (auto update semua)
     */
   public function index(Request $request)
{
    $search = $request->input('search');

    $mahasiswas = Mahasiswa::when($search, function ($query, $search) {
            return $query->where('nama', 'like', "%$search%")
                         ->orWhere('nim', 'like', "%$search%");
        })
        ->get()
        ->map(function ($mhs) {

            // hitung poin real-time
            $poinKegiatan = DetailKegiatanMahasiswa::where('mahasiswa_nim', $mhs->nim)->count() * 100;
            $poinOrganisasi = DetailOrganisasiMahasiswa::where('nim', $mhs->nim)->count() * 250;

            $poinTambahan = PoinMahasiswa::where('nim', $mhs->nim)->value('poin_tambahan') ?? 0;

            $total = $poinKegiatan + $poinOrganisasi + $poinTambahan;

            // sisipkan ke object biar bisa dipakai di blade
            $mhs->total_poin = $total;

            return $mhs;
        })
        ->sortByDesc('total_poin');

    return view('poin.index', compact('mahasiswas', 'search'));
}


    /**
     * HITUNG ULANG TOTAL POIN MAHASISWA
     */
    private function updatePoinMahasiswa($nim)
    {
        // Ambil nama mahasiswa
        $nama = Mahasiswa::where('nim', $nim)->value('nama')
            ?? DetailKegiatanMahasiswa::where('mahasiswa_nim', $nim)->value('nama')
            ?? DetailOrganisasiMahasiswa::where('nim', $nim)->value('nama');

        if (!$nama) return false;

        // Hitung jumlah kegiatan & organisasi
        $jumlahKegiatan   = DetailKegiatanMahasiswa::where('mahasiswa_nim', $nim)->count();
        $jumlahOrganisasi = DetailOrganisasiMahasiswa::where('nim', $nim)->count();

        // Ambil poin tambahan WAREK (jangan pernah di-reset!)
        $record = PoinMahasiswa::where('nim', $nim)->first();
        $poinTambahan = $record->poin_tambahan ?? 0;

        // Hitung total poin
        $totalPoin = ($jumlahKegiatan * 100) + ($jumlahOrganisasi * 250) + $poinTambahan;

        // Simpan / update
        PoinMahasiswa::updateOrCreate(
            ['nim' => $nim],
            [
                'nama'          => $nama,
                'poin'          => $totalPoin,
                'poin_tambahan' => $poinTambahan
            ]
        );

        return true;
    }

    /**
     * DETAIL POIN MAHASISWA
     */
    public function show($nim)
    {
        $mahasiswa = Mahasiswa::where('nim', $nim)->firstOrFail();

        // ===== POIN KEGIATAN =====
        $kegiatans = DetailKegiatanMahasiswa::with('kegiatan')
            ->where('mahasiswa_nim', $nim)
            ->get()
            ->map(function ($item) {
                $item->nama_kegiatan   = $item->kegiatan->nama_kegiatan ?? '-';
                $item->jenis_kegiatan  = $item->kegiatan->jenis_kegiatan ?? '-';
                $item->tanggal_kegiatan = $item->kegiatan->tanggal_kegiatan 
                    ? Carbon::parse($item->kegiatan->tanggal_kegiatan)->format('d F Y') 
                    : '-';
                $item->poin_kegiatan = 100;
                return $item;
            });

        // ===== POIN ORGANISASI =====
        $organisasis = DetailOrganisasiMahasiswa::where('nim', $nim)
            ->get()
            ->map(function ($item) {
                $item->poin_organisasi = 250;
                return $item;
            });

        // Ambil data poin mahasiswa
        $poinData = PoinMahasiswa::where('nim', $nim)->first();

        $poinTambahan = $poinData->poin_tambahan ?? 0;

        // Hitung total ulang (biar sinkron)
        $totalPoin = ($kegiatans->count() * 100) + ($organisasis->count() * 250) + $poinTambahan;

        // Inject ke object mahasiswa (biar blade gampang)
        $mahasiswa->poin = $totalPoin;
        $mahasiswa->poin_tambahan = $poinTambahan;

        return view('poin.show', [
            'poin' => $mahasiswa,
            'kegiatans' => $kegiatans,
            'organisasis' => $organisasis,
            'poinTambahan' => $poinTambahan
        ]);
    }

    /**
     * SIMPAN POIN TAMBAHAN DARI WAREK
     */
    public function store(Request $request)
    {
        $request->validate([
            'nim'  => 'required|string|max:20',
            'poin' => 'nullable|integer|min:0',
        ]);

        $nim = $request->nim;
        $poinTambahanBaru = $request->poin ?? 0;

        // Ambil nama
        $nama = Mahasiswa::where('nim', $nim)->value('nama')
            ?? DetailKegiatanMahasiswa::where('mahasiswa_nim', $nim)->value('nama')
            ?? DetailOrganisasiMahasiswa::where('nim', $nim)->value('nama');

        if (!$nama) {
            return back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        // Ambil poin tambahan lama
        $record = PoinMahasiswa::where('nim', $nim)->first();
        $poinTambahanLama = $record->poin_tambahan ?? 0;

        // Tambahkan (BUKAN replace)
        $poinTambahanBaru = $poinTambahanLama + $poinTambahanBaru;

        // Simpan
        PoinMahasiswa::updateOrCreate(
            ['nim' => $nim],
            [
                'nama'          => $nama,
                'poin_tambahan' => $poinTambahanBaru
            ]
        );

        // Hitung ulang total
        $this->updatePoinMahasiswa($nim);

        return redirect()->route('poin.index')
            ->with('success', '✅ Poin tambahan berhasil ditambahkan.');
    }

    /**
     * HAPUS DATA POIN
     */
    public function destroy($nim)
    {
        PoinMahasiswa::where('nim', $nim)->delete();

        return redirect()->route('poin.index')
            ->with('success', 'Data poin berhasil dihapus.');
    }
}
