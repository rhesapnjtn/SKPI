<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organisasi;
use App\Models\Mahasiswa;
use App\Models\DetailOrganisasiMahasiswa;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class DetailOrganisasiMahasiswaController extends Controller
{

    // ================= CREATE =================
    public function create($organisasiId)
    {
        $organisasi = Organisasi::findOrFail($organisasiId);

        // ================= FILTER MAHASISWA =================
        // Jika organisasi adalah BEM -> tampilkan semua mahasiswa
        if ($organisasi->nama_organisasi == 'Badan Eksekutif Mahasiswa') {

            $mahasiswa = Mahasiswa::when(request('cari'), function ($query, $cari) {
                    $query->where(function ($q) use ($cari) {
                        $q->where('nim', 'like', "%$cari%")
                          ->orWhere('nama', 'like', "%$cari%");
                    });
                })
                ->orderBy('nama')
                ->paginate(10);

        } else {

            // Jika HIMA -> hanya mahasiswa fakultas yang sama
            $mahasiswa = Mahasiswa::where('fakultas', $organisasi->fakultas)
                ->when(request('cari'), function ($query, $cari) {
                    $query->where(function ($q) use ($cari) {
                        $q->where('nim', 'like', "%$cari%")
                          ->orWhere('nama', 'like', "%$cari%");
                    });
                })
                ->orderBy('nama')
                ->paginate(10);
        }

        return view('detail_organisasi_mahasiswa.create', compact(
            'organisasi',
            'mahasiswa'
        ));
    }


    // ================= STORE =================
    public function store(Request $request, $organisasiId)
    {
        $validated = $request->validate([
            'nim'                => 'required|exists:mahasiswas,nim',
            'jabatan'            => 'required|string|max:100',
            'jabatan_custom'     => 'nullable|string|max:100',
            'status_keanggotaan' => 'required|in:aktif,nonaktif',
            'tanggal_bergabung'  => 'required|date',
            'tanggal_berakhir'   => 'nullable|date|after_or_equal:tanggal_bergabung',
        ]);

        $organisasi = Organisasi::findOrFail($organisasiId);
        $mahasiswa  = Mahasiswa::where('nim', $validated['nim'])->firstOrFail();

        // ================= JABATAN =================
        $jabatan = strtolower($validated['jabatan']) === 'lainnya'
            ? $validated['jabatan_custom']
            : $validated['jabatan'];

        // ================= PERIODE =================
        $tahunMulai = Carbon::parse($validated['tanggal_bergabung'])->year;

        $periodeAkhir = $validated['status_keanggotaan'] === 'aktif'
            ? 'Sekarang'
            : ($validated['tanggal_berakhir']
                ? Carbon::parse($validated['tanggal_berakhir'])->year
                : $tahunMulai + 1);

        $periodeFinal = $tahunMulai . '/' . $periodeAkhir;

        // ================= CEK DUPLIKAT =================
        if (
            DetailOrganisasiMahasiswa::where('id_organisasi', $organisasi->id)
                ->where('nim', $mahasiswa->nim)
                ->where('periode', $periodeFinal)
                ->exists()
        ) {
            return back()->withErrors([
                'nim' => 'Mahasiswa sudah terdaftar pada periode ini.'
            ])->withInput();
        }

        // ================= SIMPAN =================
        DetailOrganisasiMahasiswa::create([
            'id_organisasi'      => $organisasi->id,
            'nim'                => $mahasiswa->nim,
            'nama'               => $mahasiswa->nama,
            'nama_organisasi'    => $organisasi->nama_organisasi,
            'jabatan'            => $jabatan,
            'status_keanggotaan' => $validated['status_keanggotaan'],
            'tanggal_bergabung'  => $validated['tanggal_bergabung'],
            'tanggal_berakhir'   => $validated['tanggal_berakhir'] ?? null,
            'periode'            => $periodeFinal,
        ]);

        return redirect()
            ->route('organisasi.show', ['organisasi' => $organisasi->id])
            ->with('success', 'Anggota berhasil ditambahkan.');
    }


    // ================= EDIT =================
    public function edit($detailId)
    {
        $detail = DetailOrganisasiMahasiswa::findOrFail($detailId);
        $organisasi = Organisasi::findOrFail($detail->id_organisasi);

        return view('detail_organisasi_mahasiswa.edit', compact(
            'detail',
            'organisasi'
        ));
    }


    // ================= UPDATE =================
    public function update(Request $request, $detailId)
    {
        $validated = $request->validate([
            'nim'                => ['required', Rule::exists('mahasiswas', 'nim')],
            'jabatan'            => 'required|string|max:100',
            'jabatan_custom'     => 'nullable|string|max:100',
            'status_keanggotaan' => 'required|in:aktif,nonaktif',
            'tanggal_bergabung'  => 'required|date',
            'tanggal_berakhir'   => 'nullable|date|after_or_equal:tanggal_bergabung',
        ]);

        $anggota   = DetailOrganisasiMahasiswa::findOrFail($detailId);
        $mahasiswa = Mahasiswa::where('nim', $validated['nim'])->firstOrFail();

        $jabatan = strtolower($validated['jabatan']) === 'lainnya'
            ? $validated['jabatan_custom']
            : $validated['jabatan'];

        $tanggal_berakhir = $request->filled('tanggal_berakhir')
            ? $request->input('tanggal_berakhir')
            : null;

        $mulai   = Carbon::parse($validated['tanggal_bergabung'])->year;
        $selesai = $tanggal_berakhir
            ? Carbon::parse($tanggal_berakhir)->year
            : 'Sekarang';

        $periode = $mulai . '/' . $selesai;

        // ================= CEK DUPLIKAT =================
        if (
            DetailOrganisasiMahasiswa::where('id_organisasi', $anggota->id_organisasi)
                ->where('nim', $mahasiswa->nim)
                ->where('periode', $periode)
                ->where('id', '!=', $anggota->id)
                ->exists()
        ) {
            return back()->withErrors([
                'nim' => 'Mahasiswa sudah terdaftar pada periode ini.'
            ])->withInput();
        }

        $anggota->update([
            'nim'                => $mahasiswa->nim,
            'nama'               => $mahasiswa->nama,
            'jabatan'            => $jabatan,
            'status_keanggotaan' => $validated['status_keanggotaan'],
            'tanggal_bergabung'  => $validated['tanggal_bergabung'],
            'tanggal_berakhir'   => $tanggal_berakhir,
            'periode'            => $periode,
        ]);

        return redirect()
            ->route('organisasi.show', ['organisasi' => $anggota->id_organisasi])
            ->with('success', 'Data anggota berhasil diperbarui.');
    }


    // ================= DELETE =================
    public function destroy($detailId)
    {
        $anggota = DetailOrganisasiMahasiswa::findOrFail($detailId);

        $id_organisasi = $anggota->id_organisasi;

        $anggota->delete();

        return redirect()
            ->route('organisasi.show', ['organisasi' => $id_organisasi])
            ->with('success', 'Anggota berhasil dihapus.');
    }
}