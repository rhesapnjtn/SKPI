<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kegiatan;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;

class WarekTambahAnggotaKegiatanController extends Controller
{
    // ============================
    // SHOW DETAIL KEGIATAN
    // ============================
    public function show($id_kegiatan)
    {
        $kegiatan = Kegiatan::with('mahasiswa')->findOrFail($id_kegiatan);
        return view('warek.datakegiatan.show', compact('kegiatan'));
    }

    // ============================
    // FORM TAMBAH MAHASISWA
    // ============================
    public function create(Request $request, $id_kegiatan)
    {
        $kegiatan = Kegiatan::with('mahasiswa')->findOrFail($id_kegiatan);

        // Ambil NIM yang sudah terdaftar
        $nimTerdaftar = $kegiatan->mahasiswa->pluck('nim');

        // Mahasiswa yang belum ikut kegiatan
        $mahasiswa = Mahasiswa::whereNotIn('nim', $nimTerdaftar)
            ->when($request->search, function ($q) use ($request) {
                $q->where('nim', 'like', '%' . $request->search . '%')
                  ->orWhere('nama', 'like', '%' . $request->search . '%');
            })
            ->orderBy('nim')
            ->get();

        return view(
            'warek.datakegiatan.tambah_mahasiswa',
            compact('kegiatan', 'mahasiswa')
        );
    }

    // ============================
    // STORE MAHASISWA KE KEGIATAN
    // ============================
    public function store(Request $request, $id_kegiatan)
    {
        $request->validate([
            'nim' => 'required|exists:mahasiswas,nim',
        ]);

        $kegiatan = Kegiatan::findOrFail($id_kegiatan);

        // 🔒 Cegah duplikasi
        $sudahAda = DB::table('detail_kegiatan_mahasiswa')
            ->where('kegiatan_id_ref', $id_kegiatan)
            ->where('mahasiswa_nim', $request->nim)
            ->exists();

        if ($sudahAda) {
            return back()->with('error', 'Mahasiswa sudah terdaftar pada kegiatan ini.');
        }

        DB::transaction(function () use ($request, $id_kegiatan) {
            DB::table('detail_kegiatan_mahasiswa')->insert([
                'kegiatan_id_ref' => $id_kegiatan,
                'mahasiswa_nim'   => $request->nim,
                'poin'            => 0,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        });

        return redirect()
            ->route('warek.datakegiatan.tambahanggota.create', $id_kegiatan)
            ->with('success', 'Mahasiswa berhasil ditambahkan ke kegiatan.');
    }

    // ============================
    // REMOVE MAHASISWA DARI KEGIATAN
    // ============================
    public function destroy($id_kegiatan, $nim)
    {
        DB::transaction(function () use ($id_kegiatan, $nim) {
            DB::table('detail_kegiatan_mahasiswa')
                ->where('kegiatan_id_ref', $id_kegiatan)
                ->where('mahasiswa_nim', $nim)
                ->delete();
        });

        return back()->with('success', 'Mahasiswa berhasil dihapus dari kegiatan.');
    }
}
