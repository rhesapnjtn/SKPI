<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organisasi;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class OrganisasiSelfController extends Controller
{
    // ================== INDEX ==================
    public function index(Request $request)
{
    $email = session('user_email'); // ambil email dari session
    $user  = User::where('email', $email)->first();

    if (!$user) {
        return redirect()->route('login')->with('error', 'User tidak ditemukan');
    }

    // ambil fakultas user yang login
    $fakultasLogin = $user->organisasi?->fakultas;

    $query = Organisasi::query();

    if ($request->filled('search')) {
        $query->where('nama_organisasi', 'like', '%' . $request->search . '%');
    }

    // filter berdasarkan fakultas login
    if ($fakultasLogin) {
        $query->where('fakultas', $fakultasLogin);
    }

    $organisasis = $query->orderBy('id', 'asc')->get();
    $search = $request->search ?? '';

    return view('tampilan_organisasi.organisasi.index', compact('organisasis', 'search'));
}
    // ================== CREATE ==================
    public function create()
    {
        return view('tampilan_organisasi.organisasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_organisasi' => 'required|string|max:255',
            'fakultas'        => 'nullable|string|max:255',
        ]);

        Organisasi::create([
            'nama_organisasi' => $request->nama_organisasi,
            'fakultas'        => $request->fakultas,
        ]);

        return redirect()->route('organisasi.self.index')
                         ->with('success', 'Organisasi berhasil ditambahkan.');
    }

    // ================== EDIT ==================
    public function edit($id)
    {
        $organisasi = Organisasi::findOrFail($id);
        return view('tampilan_organisasi.organisasi.edit', compact('organisasi'));
    }

    public function update(Request $request, $id)
    {
        $org = Organisasi::findOrFail($id);

        $request->validate([
            'nama_organisasi' => 'required|string|max:255',
            'fakultas'        => 'nullable|string|max:255',
        ]);

        $org->update([
            'nama_organisasi' => $request->nama_organisasi,
            'fakultas'        => $request->fakultas ?? $org->fakultas,
        ]);

        return redirect()->route('organisasi.self.index')
                         ->with('success', 'Data organisasi berhasil diperbarui!');
    }

    // ================== SHOW ==================
    // ================== SHOW ==================
public function show(Request $request, $id)
{
    $organisasi = Organisasi::findOrFail($id);

    $statusFilter  = $request->status ?? 'aktif'; // default hanya aktif
    $periodeFilter = $request->periode ?? null;

    $mahasiswa = DB::table('detail_organisasi_mahasiswa as dom')
        ->join('mahasiswas as m', 'dom.nim', '=', 'm.nim')
        ->where('dom.id_organisasi', $id)
        ->when($statusFilter === 'aktif', function ($query) {
            // hanya tampilkan anggota yang masih aktif
            $query->where(function ($q) {
                $q->whereNull('tanggal_berakhir')
                  ->orWhere('tanggal_berakhir', '>=', now());
            });
        })
        ->when($statusFilter === 'nonaktif', function ($query) {
            // hanya tampilkan anggota yang sudah nonaktif
            $query->where('tanggal_berakhir', '<', now());
        })
        ->when($periodeFilter, function ($query, $periodeFilter) {
            $query->where('dom.periode', $periodeFilter);
        })
        ->select('dom.*', 'm.nama')
        ->orderBy('dom.tanggal_bergabung', 'desc')
        ->get();

    // ambil semua periode untuk filter dropdown
    $allPeriode = DB::table('detail_organisasi_mahasiswa')
        ->where('id_organisasi', $id)
        ->select('periode')
        ->distinct()
        ->pluck('periode');

    return view('tampilan_organisasi.organisasi.show', compact('organisasi', 'mahasiswa', 'allPeriode', 'statusFilter', 'periodeFilter'));
}

    // ================== DELETE ==================
    public function destroy($id)
    {
        $organisasi = Organisasi::findOrFail($id);

        DB::table('detail_organisasi_mahasiswa')
            ->where('id_organisasi', $id)
            ->delete();

        $organisasi->delete();

        return redirect()->route('organisasi.self.index')
                         ->with('success', 'Organisasi berhasil dihapus.');
    }

    // ================== TAMBAH ANGGOTA ==================
    public function tambahAnggota($id)
{
    $organisasi = Organisasi::findOrFail($id);
    $periodeSaatIni = now()->year . '/' . (now()->year + 1);

    // =============================
    // CEK JIKA ORGANISASI ADALAH BEM
    // =============================
    if ($organisasi->nama_organisasi == 'Badan Eksekutif Mahasiswa' || $organisasi->fakultas == 'Universitas') {

        // tampilkan semua mahasiswa
        $mahasiswa = DB::table('mahasiswas')
            ->get()
            ->map(function ($m) use ($id) {

                $m->aktif_sekarang = DB::table('detail_organisasi_mahasiswa')
                    ->where('id_organisasi', $id)
                    ->where('nim', $m->nim)
                    ->where(function ($q) {
                        $q->whereNull('tanggal_berakhir')
                          ->orWhere('tanggal_berakhir', '>=', now());
                    })
                    ->exists();

                return $m;
            });

    } else {

        // =============================
        // ORGANISASI FAKULTAS (HIMA)
        // =============================
        $mahasiswa = DB::table('mahasiswas')
            ->where('fakultas', $organisasi->fakultas)
            ->get()
            ->map(function ($m) use ($id) {

                $m->aktif_sekarang = DB::table('detail_organisasi_mahasiswa')
                    ->where('id_organisasi', $id)
                    ->where('nim', $m->nim)
                    ->where(function ($q) {
                        $q->whereNull('tanggal_berakhir')
                          ->orWhere('tanggal_berakhir', '>=', now());
                    })
                    ->exists();

                return $m;
            });
    }

    return view(
        'tampilan_organisasi.organisasi.tambah_anggota',
        compact('organisasi', 'mahasiswa', 'periodeSaatIni')
    );
}

    public function storeAnggota(Request $request, $id)
    {
        $request->validate([
            'mahasiswa_nim'       => 'required|exists:mahasiswas,nim',
            'jabatan'             => 'nullable|string|max:255',
            'jabatan_lainnya'     => 'nullable|string|max:255',
            'status_keanggotaan'  => 'required|string|max:50',
            'status_lainnya'      => 'nullable|string|max:50',
            'tanggal_bergabung'   => 'required|date',
            'tanggal_berakhir'    => 'nullable|date|after_or_equal:tanggal_bergabung',
            'periode'             => 'required|string|max:20',
        ]);

        $organisasi = Organisasi::findOrFail($id);
        $mahasiswa = DB::table('mahasiswas')->where('nim', $request->mahasiswa_nim)->first();

        $jabatan = $request->jabatan === 'lainnya' ? $request->jabatan_lainnya : $request->jabatan;
        $status  = $request->status_keanggotaan === 'lainnya' ? $request->status_lainnya : $request->status_keanggotaan;

        DB::table('detail_organisasi_mahasiswa')->insert([
            'id_organisasi'      => $organisasi->id,
            'nama_organisasi'    => $organisasi->nama_organisasi,
            'nim'                => $mahasiswa->nim,
            'nama'               => $mahasiswa->nama,
            'jabatan'            => $jabatan,
            'status_keanggotaan' => $status,
            'tanggal_bergabung'  => $request->tanggal_bergabung,
            'tanggal_berakhir'   => $request->tanggal_berakhir ?? null,
            'periode'            => $request->periode,
        ]);

        return redirect()->route('organisasi.self.show', $id)
                         ->with('success', 'Anggota berhasil ditambahkan.');
    }

    // ================== EDIT ANGGOTA ==================
    public function editAnggota($id, $nim)
    {
        $anggota = DB::table('detail_organisasi_mahasiswa')
            ->where('id_organisasi', $id)
            ->where('nim', $nim)
            ->first();

        if (!$anggota) {
            return redirect()->route('organisasi.self.show', $id)
                             ->with('error', 'Anggota tidak ditemukan.');
        }

        // Ambil data organisasi supaya Blade bisa pakai $organisasi->id_organisasi & $organisasi->nama_organisasi
        $organisasi = Organisasi::findOrFail($id);

        return view('tampilan_organisasi.organisasi.edit_anggota', compact('anggota', 'organisasi'));
    }

    // ================== UPDATE ANGGOTA ==================
    public function updateAnggota(Request $request, $id, $nim)
    {
        $request->validate([
            'jabatan'             => 'nullable|string|max:255',
            'jabatan_lainnya'     => 'nullable|string|max:255',
            'status_keanggotaan'  => 'required|string|max:50',
            'status_lainnya'      => 'nullable|string|max:50',
            'tanggal_bergabung'   => 'required|date',
            'tanggal_berakhir'    => 'nullable|date|after_or_equal:tanggal_bergabung',
            'periode'             => 'required|string|max:20',
        ]);

        $jabatan = $request->jabatan === 'lainnya' ? $request->jabatan_lainnya : $request->jabatan;
        $status  = $request->status_keanggotaan === 'lainnya' ? $request->status_lainnya : $request->status_keanggotaan;

        DB::table('detail_organisasi_mahasiswa')
            ->where('id_organisasi', $id)
            ->where('nim', $nim)
            ->update([
                'jabatan'            => $jabatan,
                'status_keanggotaan' => $status,
                'tanggal_bergabung'  => $request->tanggal_bergabung,
                'tanggal_berakhir'   => $request->tanggal_berakhir ?? null,
                'periode'            => $request->periode,
            ]);

        return redirect()->route('organisasi.self.show', $id)
                         ->with('success', 'Data anggota berhasil diperbarui.');
    }

    // ================== DELETE ANGGOTA ==================
    // ================== DELETE ANGGOTA ==================
public function deleteAnggota(Request $request, $id, $nim)
{
    $periode = $request->periode; // ambil periode dari query atau form

    DB::table('detail_organisasi_mahasiswa')
        ->where('id_organisasi', $id)
        ->where('nim', $nim)
        ->when($periode, function ($query, $periode) {
            return $query->where('periode', $periode);
        })
        ->delete();

    return redirect()->route('organisasi.self.show', $id)
                     ->with('success', 'Anggota berhasil dihapus.');
}
}