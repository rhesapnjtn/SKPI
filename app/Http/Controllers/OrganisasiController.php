<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organisasi;
use App\Models\Kegiatan;
use App\Models\DetailOrganisasiMahasiswa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class OrganisasiController extends Controller
{
    // ====================== INDEX ======================
    public function index(Request $request)
    {
        $search = $request->search;

        $organisasi = Organisasi::when($search, function ($query) use ($search) {
                $query->where('nama_organisasi', 'LIKE', "%{$search}%")
                      ->orWhere('id', $search)
                      ->orWhere('fakultas', 'LIKE', "%{$search}%");
            })
            ->paginate(10);

        return view('organisasi.index', compact('organisasi'));
    }

    // ====================== CREATE ======================
    public function create()
    {
        return view('organisasi.create');
    }

    // ====================== STORE ======================
    public function store(Request $request)
    {
        $request->validate([
            'nama_organisasi' => 'required|string|max:255|unique:organisasis,nama_organisasi',
            'fakultas'        => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email',
            'password'        => 'required|string|min:8|confirmed',
        ]);

        $organisasi = Organisasi::create([
            'nama_organisasi' => $request->nama_organisasi,
            'fakultas'        => $request->fakultas,
        ]);

        User::create([
            'name'          => $request->nama_organisasi,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'role'          => 'organisasi',
            'organisasi_id' => $organisasi->id,
        ]);

        return redirect()->route('organisasi.index')
                         ->with('success', 'Organisasi dan akun login berhasil dibuat.');
    }

    // ====================== SHOW ======================
    public function show(Organisasi $organisasi, Request $request)
    {
        $statusFilter = $request->get('status', 'aktif'); 
        $sortOrder    = $request->get('sort', 'desc');    
        $tahunFilter  = $request->get('periode', null);  

        $detailMahasiswa = $organisasi->anggota ?? collect();

        $anggotaList = match($statusFilter) {
            'aktif'    => $detailMahasiswa->where('status_keanggotaan', 'aktif'),
            'nonaktif' => $detailMahasiswa->where('status_keanggotaan', 'nonaktif'),
            default    => $detailMahasiswa,
        };

        if ($tahunFilter) {
            $anggotaList = $anggotaList->filter(function ($item) use ($tahunFilter) {
                $parts = explode('/', $item->periode);
                return isset($parts[0]) && str_starts_with($parts[0], $tahunFilter);
            });
        }

        $anggotaList = $anggotaList->sortBy(function($item) {
            $parts = explode('/', $item->periode);
            $tahunAkhir = $parts[1] ?? 'Sekarang';
            return $tahunAkhir === 'Sekarang' ? now()->year : (int)$tahunAkhir;
        }, SORT_REGULAR, $sortOrder === 'desc');

        $anggota = $anggotaList;

        return view('organisasi.show', compact(
            'organisasi',
            'anggota',
            'statusFilter',
            'sortOrder',
            'tahunFilter'
        ));
    }

    // ====================== EDIT ======================
    public function edit(Organisasi $organisasi)
    {
        return view('organisasi.edit', compact('organisasi'));
    }

    // ====================== UPDATE ======================
    public function update(Request $request, Organisasi $organisasi)
    {
        $request->validate([
            'nama_organisasi' => 'required|string|max:255|unique:organisasis,nama_organisasi,' . $organisasi->id,
            'fakultas'        => 'required|string|max:255',
            'ubah_email'      => 'nullable|boolean',
            'email'           => $request->ubah_email ? 'required|email|unique:users,email,' . optional($organisasi->user)->id : 'nullable',
            'ubah_password'   => 'nullable|boolean',
            'password'        => $request->ubah_password ? 'required|string|min:8|confirmed' : 'nullable',
        ]);

        $organisasi->update([
            'nama_organisasi' => $request->nama_organisasi,
            'fakultas'        => $request->fakultas,
        ]);

        if ($organisasi->user) {
            if ($request->ubah_email) {
                $organisasi->user->email = $request->email;
            }

            if ($request->ubah_password) {
                $organisasi->user->password = Hash::make($request->password);
            }

            $organisasi->user->name = $request->nama_organisasi;
            $organisasi->user->save();
        }

        return redirect()
            ->route('organisasi.index')
            ->with('success', 'Organisasi berhasil diperbarui.');
    }

    // ====================== DESTROY ======================
    public function destroy(Organisasi $organisasi)
    {
        DetailOrganisasiMahasiswa::where('id_organisasi', $organisasi->id)->delete();

        if ($organisasi->user) {
            $organisasi->user->delete();
        }

        $organisasi->delete();

        return redirect()->route('organisasi.index')
                         ->with('success', 'Organisasi dan seluruh anggotanya berhasil dihapus.');
    }

    // ====================== DASHBOARD ======================
   // ====================== DASHBOARD ======================
public function dashboard()
{
    $email = session('user_email');

    $user = User::where('email', $email)->first();

    if (!$user) {
        return redirect()->route('login')->with('error', 'User tidak ditemukan');
    }

    // cari organisasi berdasarkan nama
    $organisasi = Organisasi::where('nama_organisasi', $user->name)->first();

    if (!$organisasi) {
        return redirect()->route('login')->with('error', 'Organisasi tidak ditemukan');
    }

    $jumlahAnggota = DetailOrganisasiMahasiswa::where(
        'id_organisasi',
        $organisasi->id
    )->count();

    $totalKegiatan = Kegiatan::where(
        'id_organisasi',
        $organisasi->id
    )->count();

    $totalOrganisasi = Organisasi::count();

    $latestKegiatan = Kegiatan::where(
        'id_organisasi',
        $organisasi->id
    )
    ->orderBy('tanggal_kegiatan', 'desc')
    ->take(5)
    ->get();

    return view('tampilan_organisasi.dashboard_organisasi', compact(
        'organisasi',
        'jumlahAnggota',
        'totalKegiatan',
        'totalOrganisasi',
        'latestKegiatan'
    ));
}

}