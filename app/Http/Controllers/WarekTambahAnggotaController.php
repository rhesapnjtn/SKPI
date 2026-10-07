<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Organisasi;
use App\Models\Mahasiswa;
use App\Models\DetailOrganisasiMahasiswa;
use Carbon\Carbon;

class WarekTambahAnggotaController extends Controller
{

    // =======================
    // TAMPILKAN DETAIL ORGANISASI + ANGGOTA
    // =======================
    public function show(Request $request, $id_organisasi)
    {
        $organisasi = Organisasi::findOrFail($id_organisasi);

        $anggota = DetailOrganisasiMahasiswa::where('id_organisasi', $id_organisasi);

        // Filter Status
        if ($request->filled('status') && in_array($request->status, ['aktif','nonaktif'])) {
            $anggota->where('status_keanggotaan', $request->status);
        }

        // Filter Tahun
        if ($request->filled('tahun')) {
            $anggota->whereYear('tanggal_bergabung', $request->tahun);
        }

        $anggota = $anggota->orderBy('tanggal_bergabung','desc')->get();

        return view('warek.dataorganisasi.show', compact('organisasi','anggota'));
    }


    // =======================
    // FORM TAMBAH ANGGOTA
    // =======================
    public function create($id_organisasi)
{
    // ambil data organisasi
    $organisasi = Organisasi::findOrFail($id_organisasi);

    // ambil fakultas organisasi
    $fakultas = $organisasi->fakultas;

    // ambil mahasiswa yang fakultasnya sama
    $mahasiswa = Mahasiswa::where('fakultas', $fakultas)
        ->orderBy('nim')
        ->get();

    return view('warek.dataorganisasi.create', compact('organisasi', 'mahasiswa'));
}


    // =======================
    // STORE ANGGOTA BARU
    // =======================
    public function store(Request $request, $id_organisasi)
    {
        $request->validate([
            'nim' => 'required',
            'jabatan' => 'required',
            'status_keanggotaan' => 'required|in:aktif,nonaktif',
            'tanggal_bergabung' => 'nullable|date',
            'tanggal_berakhir' => 'nullable|date|after_or_equal:tanggal_bergabung',
            'jabatan_custom' => Rule::requiredIf($request->jabatan === 'lainnya'),
        ]);

        $nim = $request->nim;

        $jabatan = $request->jabatan === 'lainnya'
            ? $request->jabatan_custom
            : $request->jabatan;

        $mahasiswa = Mahasiswa::findOrFail($nim);
        $organisasi = Organisasi::findOrFail($id_organisasi);

        // Validasi fakultas harus sama
        if ($mahasiswa->fakultas_id !== $organisasi->fakultas_id) {
            return redirect()->back()->with('error','Mahasiswa tidak berasal dari fakultas yang sama!');
        }

        $tglBergabung = $request->tanggal_bergabung
            ? Carbon::parse($request->tanggal_bergabung)->format('Y-m-d')
            : now()->format('Y-m-d');

        $tglBerakhir = $request->tanggal_berakhir
            ? Carbon::parse($request->tanggal_berakhir)->format('Y-m-d')
            : null;

        // Cek duplikat periode
        $exists = DetailOrganisasiMahasiswa::where('id_organisasi', $id_organisasi)
            ->where('nim', $nim)
            ->where('tanggal_bergabung', $tglBergabung)
            ->where(function($query) use ($tglBerakhir){
                if ($tglBerakhir) {
                    $query->where('tanggal_berakhir',$tglBerakhir);
                } else {
                    $query->whereNull('tanggal_berakhir');
                }
            })
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->with('error','Mahasiswa sudah terdaftar di organisasi ini pada periode yang sama!');
        }

        DetailOrganisasiMahasiswa::create([
            'id_organisasi'      => $id_organisasi,
            'nim'                => $mahasiswa->nim,
            'nama'               => $mahasiswa->nama,
            'jabatan'            => $jabatan,
            'status_keanggotaan' => $request->status_keanggotaan,
            'tanggal_bergabung'  => $tglBergabung,
            'tanggal_berakhir'   => $tglBerakhir,
            'nama_organisasi'    => $organisasi->nama_organisasi
        ]);

        return redirect()->route('warek.dataorganisasi.show',$id_organisasi)
            ->with('success','Anggota berhasil ditambahkan.');
    }


    // =======================
    // FORM EDIT ANGGOTA
    // =======================
    public function edit($id)
    {
        $detail = DetailOrganisasiMahasiswa::findOrFail($id);

        return view('warek.dataorganisasi.edit', compact('detail'));
    }


    // =======================
    // UPDATE ANGGOTA
    // =======================
    public function update(Request $request, $id)
    {
        $request->validate([
            'jabatan' => 'required',
            'status_keanggotaan' => 'required|in:aktif,nonaktif',
            'tanggal_bergabung' => 'nullable|date',
            'tanggal_berakhir' => 'nullable|date|after_or_equal:tanggal_bergabung',
            'jabatan_custom' => Rule::requiredIf($request->jabatan === 'lainnya'),
        ]);

        $detail = DetailOrganisasiMahasiswa::findOrFail($id);

        $jabatan = $request->jabatan === 'lainnya'
            ? $request->jabatan_custom
            : $request->jabatan;

        $tglBergabung = $request->tanggal_bergabung
            ? Carbon::parse($request->tanggal_bergabung)->format('Y-m-d')
            : $detail->tanggal_bergabung;

        $tglBerakhir = $request->tanggal_berakhir
            ? Carbon::parse($request->tanggal_berakhir)->format('Y-m-d')
            : null;

        // Cek duplikat periode
        $exists = DetailOrganisasiMahasiswa::where('id_organisasi',$detail->id_organisasi)
            ->where('nim',$detail->nim)
            ->where('tanggal_bergabung',$tglBergabung)
            ->where(function($query) use ($tglBerakhir){
                if ($tglBerakhir) {
                    $query->where('tanggal_berakhir',$tglBerakhir);
                } else {
                    $query->whereNull('tanggal_berakhir');
                }
            })
            ->where('id','!=',$detail->id)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->with('error','Mahasiswa sudah terdaftar di periode yang sama!');
        }

        $detail->update([
            'jabatan' => $jabatan,
            'status_keanggotaan' => $request->status_keanggotaan,
            'tanggal_bergabung' => $tglBergabung,
            'tanggal_berakhir'  => $tglBerakhir
        ]);

        return redirect()->route('warek.dataorganisasi.show',$detail->id_organisasi)
            ->with('success','Data anggota berhasil diperbarui.');
    }


    // =======================
    // HAPUS ANGGOTA
    // =======================
    public function destroy($id)
    {
        $detail = DetailOrganisasiMahasiswa::findOrFail($id);

        $orgId = $detail->id_organisasi;

        $detail->delete();

        return redirect()->route('warek.dataorganisasi.show',$orgId)
            ->with('success','Anggota berhasil dihapus.');
    }

}