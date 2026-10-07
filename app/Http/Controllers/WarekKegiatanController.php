<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kegiatan;
use App\Models\Organisasi;

class WarekKegiatanController extends Controller
{
    // =========================
    // LIST KEGIATAN
    // =========================
    public function index()
    {
        $kegiatan = Kegiatan::with('organisasi')
            ->orderBy('tanggal_kegiatan', 'desc')
            ->get();

        return view('warek.datakegiatan.index', compact('kegiatan'));
    }

    // =========================
    // DETAIL KEGIATAN
    // =========================
    public function show($id)
    {
        $kegiatan = Kegiatan::with('organisasi')->findOrFail($id);
        return view('warek.datakegiatan.show', compact('kegiatan'));
    }

    // =========================
    // FORM EDIT KEGIATAN
    // =========================
    public function edit($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        $organisasis = Organisasi::orderBy('nama_organisasi')->get();

        return view('warek.datakegiatan.edit', compact('kegiatan', 'organisasis'));
    }

    // =========================
    // UPDATE KEGIATAN
    // =========================
    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis_kegiatan'   => 'required|string|max:255',
            'nama_kegiatan'    => 'required|string|max:255',
            'tanggal_kegiatan' => 'required|date',
            'id_organisasi'    => 'required|exists:organisasis,id',
        ]);

        $kegiatan = Kegiatan::findOrFail($id);

        $kegiatan->update([
            'jenis_kegiatan'   => $request->jenis_kegiatan,
            'nama_kegiatan'    => $request->nama_kegiatan,
            'tanggal_kegiatan' => $request->tanggal_kegiatan,
            'id_organisasi'    => $request->id_organisasi,
        ]);

        return redirect()
            ->route('warek.datakegiatan.index')
            ->with('success', 'Kegiatan berhasil diperbarui.');
    }

    // =========================
    // HAPUS KEGIATAN
    // =========================
    public function destroy($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        $kegiatan->delete();

        return redirect()
            ->route('warek.datakegiatan.index')
            ->with('success', 'Data kegiatan berhasil dihapus!');
    }
}