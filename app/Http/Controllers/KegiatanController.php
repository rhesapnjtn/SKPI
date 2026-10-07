<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Mahasiswa;
use App\Models\Organisasi;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    // ===============================
    // INDEX
    // ===============================
    public function index(Request $request)
    {
        $search = $request->search;

        $kegiatan = Kegiatan::with('organisasi')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('jenis_kegiatan', 'like', "%{$search}%")
                      ->orWhere('nama_kegiatan', 'like', "%{$search}%")
                      ->orWhereHas('organisasi', function ($sub) use ($search) {
                          $sub->where('nama_organisasi', 'like', "%{$search}%");
                      });
                });
            })
            ->latest('tanggal_kegiatan')
            ->paginate(10)
            ->withQueryString();

        return view('kegiatan.index', compact('kegiatan', 'search'));
    }

    // ===============================
    // CREATE
    // ===============================
    public function create()
    {
        $organisasis = Organisasi::orderBy('nama_organisasi')->get();
        return view('kegiatan.create', compact('organisasis'));
    }

    // ===============================
    // STORE
    // ===============================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_kegiatan'   => 'required|in:Major,Reguler',
            'nama_kegiatan'    => 'required|string|unique:kegiatans,nama_kegiatan',
            'tanggal_kegiatan' => 'required|date',
            'id_organisasi'    => 'nullable|exists:organisasis,id',
        ]);

        Kegiatan::create($validated);

        return redirect()->route('kegiatan.index')
            ->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    // ===============================
    // SHOW
    // ===============================
    public function show(Kegiatan $kegiatan)
    {
        $mahasiswas = $kegiatan->mahasiswa()->get(); // ambil mahasiswa terkait

        return view('kegiatan.show', compact('kegiatan', 'mahasiswas'));
    }

    // ===============================
    // EDIT
    // ===============================
    public function edit(Kegiatan $kegiatan)
    {
        $organisasis = Organisasi::orderBy('nama_organisasi')->get();
        return view('kegiatan.edit', compact('kegiatan', 'organisasis'));
    }

    // ===============================
    // UPDATE
    // ===============================
    public function update(Request $request, Kegiatan $kegiatan)
    {
        $validated = $request->validate([
            'jenis_kegiatan'   => 'required|in:Major,Reguler',
            'nama_kegiatan'    => 'required|string|unique:kegiatans,nama_kegiatan,' . $kegiatan->id,
            'tanggal_kegiatan' => 'required|date',
            'id_organisasi'    => 'nullable|exists:organisasis,id',
        ]);

        $kegiatan->update($validated);

        return redirect()->route('kegiatan.index')
            ->with('success', 'Kegiatan berhasil diperbarui.');
    }

    // ===============================
    // DESTROY
    // ===============================
    public function destroy(Kegiatan $kegiatan)
    {
        $kegiatan->delete();

        return redirect()->route('kegiatan.index')
            ->with('success', 'Kegiatan berhasil dihapus.');
    }

    // ===============================
    // FORM TAMBAH MAHASISWA
    // ===============================
    public function tambahMahasiswaForm(Kegiatan $kegiatan, Request $request)
    {
        $keyword = $request->cari;

        // ambil mahasiswa yang sudah ditambahkan
        $nimSudahDitambah = $kegiatan->mahasiswa()->pluck('nim')->toArray();

        $mahasiswa = Mahasiswa::when($keyword, function ($query) use ($keyword) {
                $query->where('nim', 'like', "%{$keyword}%")
                      ->orWhere('nama', 'like', "%{$keyword}%");
            })
            ->when($nimSudahDitambah, function ($query) use ($nimSudahDitambah) {
                $query->whereNotIn('nim', $nimSudahDitambah);
            })
            ->paginate(10)
            ->withQueryString();

        return view('kegiatan.tambah_mahasiswa', compact('kegiatan', 'mahasiswa'));
    }

    // ===============================
    // STORE MAHASISWA KE KEGIATAN
    // ===============================
    public function tambahMahasiswaStore(Request $request, Kegiatan $kegiatan)
    {
        $request->validate([
            'nim' => 'required|exists:mahasiswas,nim',
        ]);

        if ($kegiatan->mahasiswa()->where('nim', $request->nim)->exists()) {
            return back()->with('error', 'Mahasiswa sudah terdaftar di kegiatan ini.');
        }

        $kegiatan->mahasiswa()->attach($request->nim);

        return redirect()->route('kegiatan.show', $kegiatan)
            ->with('success', 'Mahasiswa berhasil ditambahkan.');
    }

    // ===============================
    // HAPUS MAHASISWA
    // ===============================
    public function hapusMahasiswa(Kegiatan $kegiatan, $nim)
    {
        $kegiatan->mahasiswa()->detach($nim);

        return redirect()->route('kegiatan.show', $kegiatan)
            ->with('success', 'Mahasiswa berhasil dihapus.');
    }
}