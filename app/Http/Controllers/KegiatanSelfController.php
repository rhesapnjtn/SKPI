<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Kegiatan;
use App\Models\Mahasiswa;
use App\Models\DetailKegiatanMahasiswa;
use App\Models\Organisasi;
use App\Models\User;

class KegiatanSelfController extends Controller
{

    // =========================
    // LIST KEGIATAN
    // =========================
    public function index(Request $request)
    {
        $email = session('user_email');
        $user  = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'User tidak ditemukan');
        }

        $fakultasLogin = $user->organisasi?->fakultas;

        $query = Kegiatan::with('organisasi');

        // SEARCH
        if ($request->filled('search')) {
            $query->where('nama_kegiatan', 'like', '%' . $request->search . '%');
        }

        // FILTER FAKULTAS
        if ($fakultasLogin) {
            $query->whereHas('organisasi', function ($q) use ($fakultasLogin) {
                $q->where('fakultas', $fakultasLogin);
            });
        }

        // PAGINATION (bukan get)
        $kegiatans = $query
            ->orderBy('tanggal_kegiatan', 'desc')
            ->paginate(10)
            ->withQueryString();

        $search = $request->search ?? '';

        return view('tampilan_kegiatan.kegiatan.index', compact('kegiatans', 'search'));
    }


    // =========================
    // FORM TAMBAH KEGIATAN
    // =========================
    public function create()
    {
        $organisasis = Organisasi::orderBy('nama_organisasi')->get();

        return view('tampilan_kegiatan.kegiatan.create', compact('organisasis'));
    }


    // =========================
    // SIMPAN KEGIATAN
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'tanggal_kegiatan' => 'required|date',
            'jenis_kegiatan' => 'nullable|string|max:255',
            'id_organisasi' => 'required|exists:organisasis,id'
        ]);

        Kegiatan::create([
            'nama_kegiatan' => $request->nama_kegiatan,
            'tanggal_kegiatan' => $request->tanggal_kegiatan,
            'jenis_kegiatan' => $request->jenis_kegiatan,
            'id_organisasi' => $request->id_organisasi
        ]);

        return redirect()->route('kegiatan-self.index')
            ->with('success', 'Kegiatan berhasil ditambahkan.');
    }


    // =========================
    // DETAIL KEGIATAN
    // =========================
    public function show($id)
    {
        $kegiatan = Kegiatan::with([
            'detailMahasiswa.mahasiswa',
            'organisasi'
        ])->findOrFail($id);

        return view('tampilan_kegiatan.kegiatan.show', compact('kegiatan'));
    }


    // =========================
    // FORM EDIT KEGIATAN
    // =========================
    public function edit($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        $organisasis = Organisasi::orderBy('nama_organisasi')->get();

        return view(
            'tampilan_kegiatan.kegiatan.edit',
            compact('kegiatan', 'organisasis')
        );
    }


    // =========================
    // UPDATE KEGIATAN
    // =========================
    public function update(Request $request, $id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        $request->validate([
            'nama_kegiatan' => [
                'required',
                'string',
                'max:255',
                Rule::unique('kegiatans')
                    ->where(fn($q) => $q->where('id_organisasi', $request->id_organisasi))
                    ->ignore($kegiatan->id),
            ],
            'tanggal_kegiatan' => 'required|date',
            'jenis_kegiatan' => 'nullable|string|max:255',
            'id_organisasi' => 'required|exists:organisasis,id'
        ]);

        $kegiatan->update([
            'nama_kegiatan' => $request->nama_kegiatan,
            'tanggal_kegiatan' => $request->tanggal_kegiatan,
            'jenis_kegiatan' => $request->jenis_kegiatan,
            'id_organisasi' => $request->id_organisasi
        ]);

        return redirect()->route('kegiatan-self.index')
            ->with('success', 'Kegiatan berhasil diperbarui.');
    }


    // =========================
    // HAPUS KEGIATAN
    // =========================
    public function destroy($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        $kegiatan->delete();

        return redirect()->route('kegiatan-self.index')
            ->with('success', 'Kegiatan berhasil dihapus.');
    }


    // =========================
    // FORM TAMBAH MAHASISWA KE KEGIATAN
    // =========================
    public function addMahasiswa($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        $nimSudahIkut = DetailKegiatanMahasiswa::where('kegiatan_id_ref', $id)
            ->pluck('mahasiswa_nim');

        $mahasiswas = Mahasiswa::whereNotIn('nim', $nimSudahIkut)
            ->orderBy('nim')
            ->get();

        return view(
            'tampilan_kegiatan.kegiatan.add_mahasiswa',
            compact('kegiatan', 'mahasiswas')
        );
    }


    // =========================
    // SIMPAN MAHASISWA KE KEGIATAN
    // =========================
    public function storeMahasiswa(Request $request, $id)
    {
        $request->validate([
            'mahasiswa_nim' => 'required|exists:mahasiswas,nim'
        ]);

        DetailKegiatanMahasiswa::firstOrCreate([
            'kegiatan_id_ref' => $id,
            'mahasiswa_nim' => $request->mahasiswa_nim
        ]);

        return redirect()->route('kegiatan-self.show', $id)
            ->with('success', 'Mahasiswa berhasil ditambahkan.');
    }


    // =========================
    // HAPUS MAHASISWA DARI KEGIATAN
    // =========================
    public function destroyMahasiswa($kegiatanId, $nim)
    {
        DetailKegiatanMahasiswa::where('kegiatan_id_ref', $kegiatanId)
            ->where('mahasiswa_nim', $nim)
            ->delete();

        return redirect()->route('kegiatan-self.show', $kegiatanId)
            ->with('success', 'Mahasiswa berhasil dihapus.');
    }

}