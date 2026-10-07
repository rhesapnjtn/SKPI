<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organisasi;
use App\Models\DetailOrganisasiMahasiswa;
use App\Models\Mahasiswa;
use Carbon\Carbon;

class WarekOrganisasiController extends Controller
{
    // ================= DAFTAR ORGANISASI =================
    public function index(Request $request)
    {
        $query = Organisasi::query();

        if ($request->filled('q')) {
            $query->where('nama_organisasi', 'like', '%' . $request->q . '%');
        }

        $organisasis = $query->orderBy('id', 'ASC')->paginate(10);

        return view('warek.dataorganisasi.index', compact('organisasis'));
    }

    // ================= DETAIL ORGANISASI + ANGGOTA =================
    public function show(Request $request, $id_organisasi)
    {
        $organisasi = Organisasi::findOrFail($id_organisasi);

        $status = $request->input('status'); // aktif / nonaktif / semua
        $tahun  = $request->input('tahun'); // contoh: 2023

        $anggotaQuery = DetailOrganisasiMahasiswa::where('id_organisasi', $id_organisasi);

        if (!$status || $status == '') {
            $anggotaQuery->where('status_keanggotaan', 'aktif');
            $status = 'aktif';
        } elseif ($status !== 'semua') {
            $anggotaQuery->where('status_keanggotaan', $status);
        }

        if ($tahun) {
            $anggotaQuery->whereYear('tanggal_bergabung', $tahun);
        }

        $anggota = $anggotaQuery->orderBy('tanggal_bergabung', 'desc')->get();

        return view('warek.dataorganisasi.show', compact('organisasi', 'anggota', 'status', 'tahun'));
    }

    // ================= STORE ANGGOTA (WAREK) =================
    public function storeAnggota(Request $request, $id_organisasi)
    {
        $validated = $request->validate([
            'nim'                => 'required|exists:mahasiswas,nim',
            'jabatan'            => 'required|string|max:100',
            'jabatan_custom'     => 'nullable|string|max:100',
            'status_keanggotaan' => 'required|in:aktif,nonaktif',
            'tanggal_bergabung'  => 'required|date',
            'tanggal_berakhir'   => 'nullable|date|after_or_equal:tanggal_bergabung',
        ]);

        $mahasiswa = Mahasiswa::where('nim', $validated['nim'])->firstOrFail();
        $organisasi = Organisasi::findOrFail($id_organisasi);

        // Tentukan jabatan
        $jabatan = strtolower($validated['jabatan']) === 'lainnya'
            ? $validated['jabatan_custom']
            : $validated['jabatan'];

        // ================= Tanggal & Periode =================
        $tglBergabung = Carbon::parse($validated['tanggal_bergabung']);
        $tglBerakhir  = $validated['tanggal_berakhir'] 
            ? Carbon::parse($validated['tanggal_berakhir'])
            : $tglBergabung->copy()->addYear();

        $periode = $tglBergabung->year . '/' . $tglBerakhir->year;

        // ================= Cek Duplikat =================
        if (DetailOrganisasiMahasiswa::where('id_organisasi', $id_organisasi)
            ->where('nim', $mahasiswa->nim)
            ->where('periode', $periode)
            ->exists()) {
            return back()->withErrors([
                'nim' => 'Mahasiswa sudah terdaftar di periode ini.'
            ])->withInput();
        }

        // ================= Simpan =================
        DetailOrganisasiMahasiswa::create([
            'id_organisasi'      => $id_organisasi,
            'nim'                => $mahasiswa->nim,
            'nama'               => $mahasiswa->nama,
            'nama_organisasi'    => $organisasi->nama_organisasi,
            'jabatan'            => $jabatan,
            'status_keanggotaan' => $validated['status_keanggotaan'],
            'tanggal_bergabung'  => $tglBergabung->format('Y-m-d'),
            'tanggal_berakhir'   => $tglBerakhir->format('Y-m-d'),
            'periode'            => $periode,
        ]);

        return redirect()->route('warek.dataorganisasi.show', $id_organisasi)
                         ->with('success', 'Anggota berhasil ditambahkan.');
    }

    // ================= UPDATE ANGGOTA =================
    public function updateAnggota(Request $request, $id_detail)
    {
        $validated = $request->validate([
            'nim'                => 'required|exists:mahasiswas,nim',
            'nama'               => 'required|string|max:255',
            'jabatan'            => 'nullable|string|max:100',
            'jabatan_custom'     => 'nullable|string|max:100',
            'status_keanggotaan' => 'nullable|in:aktif,nonaktif',
            'tanggal_bergabung'  => 'nullable|date',
            'tanggal_berakhir'   => 'nullable|date|after_or_equal:tanggal_bergabung',
        ]);

        $anggota = DetailOrganisasiMahasiswa::findOrFail($id_detail);
        $mahasiswa = Mahasiswa::where('nim', $validated['nim'])->firstOrFail();

        $jabatan = strtolower($validated['jabatan'] ?? '') === 'lainnya'
            ? $validated['jabatan_custom']
            : $validated['jabatan'];

        $tglBergabung = Carbon::parse($validated['tanggal_bergabung']);
        $tglBerakhir  = $validated['tanggal_berakhir'] 
            ? Carbon::parse($validated['tanggal_berakhir'])
            : $tglBergabung->copy()->addYear();

        $periode = $tglBergabung->year . '/' . $tglBerakhir->year;

        // ================= Update =================
        $anggota->update([
            'nim'                => $mahasiswa->nim,
            'nama'               => $mahasiswa->nama,
            'jabatan'            => $jabatan,
            'status_keanggotaan' => $validated['status_keanggotaan'],
            'tanggal_bergabung'  => $tglBergabung->format('Y-m-d'),
            'tanggal_berakhir'   => $tglBerakhir->format('Y-m-d'),
            'periode'            => $periode,
        ]);

        return redirect()->route('warek.dataorganisasi.show', $anggota->id_organisasi)
                         ->with('success', 'Data anggota berhasil diperbarui.');
    }

    // ================= DELETE ANGGOTA =================
    public function destroyAnggota($id_detail)
    {
        $anggota = DetailOrganisasiMahasiswa::findOrFail($id_detail);
        $anggota->delete();

        return redirect()->back()->with('success', 'Data anggota berhasil dihapus.');
    }

    // ================= EDIT & UPDATE ORGANISASI =================
    public function editOrganisasi($id_organisasi)
    {
        $organisasi = Organisasi::findOrFail($id_organisasi);
        return view('warek.dataorganisasi.edit_organisasi', compact('organisasi'));
    }

    public function updateOrganisasi(Request $request, $id_organisasi)
    {
        $request->validate([
            'nama_organisasi' => 'required|string|max:255'
        ]);

        $organisasi = Organisasi::findOrFail($id_organisasi);
        $organisasi->update([
            'nama_organisasi' => $request->nama_organisasi
        ]);

        return redirect()->route('warek.dataorganisasi.index')
                         ->with('success', 'Data organisasi berhasil diperbarui!');
    }

    // ================= DELETE ORGANISASI =================
    public function destroyOrganisasi($id_organisasi)
    {
        Organisasi::findOrFail($id_organisasi)->delete();
        return redirect()->back()->with('success', 'Data organisasi berhasil dihapus!');
    }
}