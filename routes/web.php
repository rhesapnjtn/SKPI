<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

// Models
use App\Models\User;
use App\Models\Organisasi;
use App\Models\Kegiatan;

// Controllers
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\OrganisasiController;
use App\Http\Controllers\SKPIController;
use App\Http\Controllers\DetailOrganisasiMahasiswaController;
use App\Http\Controllers\PoinMahasiswaController;
use App\Http\Controllers\WarekController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrganisasiSelfController;
use App\Http\Controllers\PenentuanPoinController;
use App\Http\Controllers\KegiatanSelfController;
use App\Http\Controllers\OrganisasiDashboardController;
use App\Http\Controllers\WarekPoinController;
use App\Http\Controllers\WarekOrganisasiController;
use App\Http\Controllers\WarekTambahAnggotaController;
use App\Http\Controllers\WarekKegiatanController;
use App\Http\Controllers\WarekTambahAnggotaKegiatanController;
use App\Http\Controllers\DashboardMahasiswaController;
use App\Http\Controllers\MahasiswaKegiatanController;
use App\Http\Controllers\MahasiswaOrganisasiController;
use App\Http\Controllers\MahasiswaKlaimPoinController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\WarekPenentuanPoinController;
use App\Http\Controllers\TemanController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\BeriPoinController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\WarekKegiatanController as WarekKegiatanCtrl;

// ========================== HALAMAN UTAMA ==========================
Route::get('/', fn() => redirect()->route('login'));

// ========================== LOGIN ==========================
Route::get('/login', fn() => view('login'))->name('login');
Route::post('/login', function(Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();
    if (!$user || !Hash::check($request->password, $user->password)) {
        return back()->with('error', 'Email atau password salah.');
    }

    $nim = substr($user->email, 0, 7);
    session([
        'is_logged_in' => true,
        'user_id'     => $user->id,
        'user_name'   => $user->name,
        'user_email'  => $user->email,
        'user_role'   => $user->role,
        'user_nim'    => $nim,
    ]);

    return match($user->role) {
        'admin'      => redirect()->route('admin.dashboard'),
        'warek'      => redirect()->route('warek.dashboard'),
        'mahasiswa'  => redirect()->route('mahasiswa.dashboard'),
        'organisasi' => redirect()->route('organisasi.dashboard'),
        default      => redirect()->route('login')
    };
})->name('login.submit');

// ========================== FORGOT PASSWORD ==========================
Route::get('/forgot-password', fn() => view('forgot-password'))->name('forgot-password');
Route::post('/forgot-password', function(Request $request){
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6|confirmed',
    ]);

    $user = User::where('email', $request->email)->first();
    if(!$user) return back()->with('error', 'Email tidak ditemukan.');

    $user->password = Hash::make($request->password);
    $user->save();

    return back()->with('success', 'Password berhasil diganti. Silakan login.');
});

// ========================== LOGOUT ==========================
Route::post('/logout', fn() => session()->flush() ?: redirect()->route('login'))->name('logout');
Route::post('/logout/mahasiswa', fn() => session()->flush() ?: redirect()->route('login'))->name('mahasiswa.logout');
Route::post('/logout/warek', fn() => session()->flush() ?: redirect()->route('login'))->name('logout.warek');

// ========================== DASHBOARD SESUAI ROLE ==========================
Route::middleware(['web'])->group(function () {

    // ADMIN
    Route::get('/admin/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');

    // WAREK
    Route::get('/warek/dashboard', function() {
        if (!session('is_logged_in') || session('user_role') !== 'warek') {
            return redirect()->route('login');
        }
        $totalOrganisasi = Organisasi::count();
        $totalKegiatan   = Kegiatan::count();
        return view('warek.dashboard', compact('totalOrganisasi', 'totalKegiatan'));
    })->name('warek.dashboard');

    // MAHASISWA
    Route::get('/mahasiswa/dashboard', [DashboardMahasiswaController::class, 'index'])
        ->name('mahasiswa.dashboard');
    Route::get('/mahasiswa/kegiatan', [MahasiswaKegiatanController::class, 'index'])
        ->name('mahasiswa.kegiatan');
    Route::get('/mahasiswa/organisasi', [MahasiswaOrganisasiController::class, 'index'])
        ->name('mahasiswa.organisasi');
    Route::get('/mahasiswa/klaim-poin', [MahasiswaKlaimPoinController::class, 'index'])
        ->name('mahasiswa.klaim-poin');
    Route::get('/mahasiswa/kriteria-poin', [MahasiswaController::class, 'kriteriaPoin'])
        ->name('mahasiswa.kriteria-poin');

    // DETAIL POIN MAHASISWA WAREK
    Route::get('/warek/poin/{nim}', [WarekPoinController::class, 'show'])->name('warek.poin.detail');
});

// ========================== ORGANISASI ==========================
Route::prefix('organisasi')->name('organisasi.')->group(function () {

    // DASHBOARD ORGANISASI
    Route::get('/dashboard', [OrganisasiController::class, 'dashboard'])->name('dashboard');

    // CRUD ORGANISASI
    Route::get('/', [OrganisasiController::class, 'index'])->name('index');
    Route::get('/create', [OrganisasiController::class, 'create'])->name('create');
    Route::post('/', [OrganisasiController::class, 'store'])->name('store');
    Route::get('/{organisasi}', [OrganisasiController::class, 'show'])->name('show');
    Route::get('/{organisasi}/edit', [OrganisasiController::class, 'edit'])->name('edit');
    Route::put('/{organisasi}', [OrganisasiController::class, 'update'])->name('update');
    Route::delete('/{organisasi}', [OrganisasiController::class, 'destroy'])->name('destroy');

    // ANGGOTA ORGANISASI
    Route::prefix('{organisasi}/anggota')->name('anggota.')->group(function () {
        Route::get('/create', [DetailOrganisasiMahasiswaController::class, 'create'])->name('create');
        Route::post('/', [DetailOrganisasiMahasiswaController::class, 'store'])->name('store');
    });

    Route::get('/anggota/{detail}/edit', [DetailOrganisasiMahasiswaController::class, 'edit'])->name('anggota.edit');
    Route::put('/anggota/{detail}', [DetailOrganisasiMahasiswaController::class, 'update'])->name('anggota.update');
    Route::delete('/anggota/{detail}', [DetailOrganisasiMahasiswaController::class, 'destroy'])->name('anggota.destroy');
});

// ========================== WAREK ==========================
Route::prefix('warek')->name('warek.')->group(function () {

    // DASHBOARD
    Route::get('dashboard', function() {
        if (!session('is_logged_in') || session('user_role') !== 'warek') {
            return redirect()->route('login');
        }
        $totalOrganisasi = \App\Models\Organisasi::count();
        $totalKegiatan   = \App\Models\Kegiatan::count();
        return view('warek.dashboard', compact('totalOrganisasi', 'totalKegiatan'));
    })->name('dashboard');

    // ==================== PENENTUAN POIN ====================
    Route::resource('penentuanpoin', \App\Http\Controllers\WarekPenentuanPoinController::class);

    // ==================== BERI POIN ====================
    Route::get('beripoin', [\App\Http\Controllers\BeriPoinController::class, 'index'])->name('beripoin.index');
    Route::post('beripoin', [\App\Http\Controllers\BeriPoinController::class, 'store'])->name('beripoin.store');
    Route::delete('beripoin/{id}', [\App\Http\Controllers\BeriPoinController::class, 'destroy'])->name('beripoin.destroy');
    Route::get('poin/{nim}/edit', [\App\Http\Controllers\BeriPoinController::class, 'edit'])->name('poin.edit');
    Route::match(['post','put'],'poin/{nim}/update', [\App\Http\Controllers\BeriPoinController::class, 'update'])->name('poin.update');

    // ==================== DATA POIN MAHASISWA ====================
    Route::get('poin', [\App\Http\Controllers\WarekPoinController::class, 'index'])->name('poin.index');
    Route::get('poin/{nim}', [\App\Http\Controllers\WarekPoinController::class, 'show'])->name('poin.detail');

    // ==================== DATA ORGANISASI ====================
    Route::get('dataorganisasi', [\App\Http\Controllers\WarekOrganisasiController::class, 'index'])->name('dataorganisasi.index');
    Route::get('dataorganisasi/{id_organisasi}', [\App\Http\Controllers\WarekOrganisasiController::class, 'show'])->name('dataorganisasi.show');
    Route::get('dataorganisasi/{id_organisasi}/edit', [\App\Http\Controllers\WarekOrganisasiController::class, 'editOrganisasi'])->name('dataorganisasi.edit');
    Route::put('dataorganisasi/{id_organisasi}', [\App\Http\Controllers\WarekOrganisasiController::class, 'updateOrganisasi'])->name('dataorganisasi.update');
    Route::delete('dataorganisasi/{id_organisasi}', [\App\Http\Controllers\WarekOrganisasiController::class, 'destroyOrganisasi'])->name('dataorganisasi.destroy');

    // ANGGOTA ORGANISASI
    Route::get('dataorganisasi/{id_organisasi}/anggota/create', [\App\Http\Controllers\WarekTambahAnggotaController::class, 'create'])->name('dataorganisasi.anggota.create');
    Route::post('dataorganisasi/{id_organisasi}/anggota', [\App\Http\Controllers\WarekTambahAnggotaController::class, 'store'])->name('dataorganisasi.anggota.store');
    Route::get('dataorganisasi/anggota/{id}/edit', [\App\Http\Controllers\WarekTambahAnggotaController::class, 'edit'])->name('dataorganisasi.anggota.edit');
    Route::put('dataorganisasi/anggota/{id}', [\App\Http\Controllers\WarekTambahAnggotaController::class, 'update'])->name('dataorganisasi.anggota.update');
    Route::delete('dataorganisasi/anggota/{id}', [\App\Http\Controllers\WarekTambahAnggotaController::class, 'destroy'])->name('dataorganisasi.anggota.destroy');

    // ==================== DATA KEGIATAN ====================
    Route::get('datakegiatan', [\App\Http\Controllers\WarekKegiatanController::class, 'index'])->name('datakegiatan.index');
    Route::get('datakegiatan/{id}', [\App\Http\Controllers\WarekKegiatanController::class, 'show'])->name('datakegiatan.show');
    Route::get('datakegiatan/{id}/edit', [\App\Http\Controllers\WarekKegiatanController::class, 'edit'])->name('datakegiatan.edit');
    Route::put('datakegiatan/{id}', [\App\Http\Controllers\WarekKegiatanController::class, 'update'])->name('datakegiatan.update');
    Route::delete('datakegiatan/{id}', [\App\Http\Controllers\WarekKegiatanController::class, 'destroy'])->name('datakegiatan.destroy');

    // ANGGOTA KEGIATAN
    Route::get('datakegiatan/{id}/tambah-anggota', [\App\Http\Controllers\WarekTambahAnggotaKegiatanController::class, 'create'])->name('datakegiatan.tambahanggota.create');
    Route::post('datakegiatan/{id}/tambah-anggota', [\App\Http\Controllers\WarekTambahAnggotaKegiatanController::class, 'store'])->name('datakegiatan.tambahanggota.store');
    Route::get('datakegiatan/anggota/{id}/edit', [\App\Http\Controllers\WarekTambahAnggotaKegiatanController::class, 'edit'])->name('datakegiatan.tambahanggota.edit');
    Route::put('datakegiatan/anggota/{id}', [\App\Http\Controllers\WarekTambahAnggotaKegiatanController::class, 'update'])->name('datakegiatan.tambahanggota.update');
    Route::delete('datakegiatan/anggota/{id_kegiatan}/{nim}', [\App\Http\Controllers\WarekTambahAnggotaKegiatanController::class, 'destroy'])->name('datakegiatan.tambahanggota.destroy');

});

// ========================== ORGANISASI SELF ==========================
Route::prefix('org-self')->name('organisasi.self.')->group(function () {
    Route::get('/', [OrganisasiSelfController::class, 'index'])->name('index');
    Route::get('/create', [OrganisasiSelfController::class, 'create'])->name('create');
    Route::post('/store', [OrganisasiSelfController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [OrganisasiSelfController::class, 'edit'])->name('edit');
    Route::put('/{id}/update', [OrganisasiSelfController::class, 'update'])->name('update');
    Route::delete('/{id}/delete', [OrganisasiSelfController::class, 'destroy'])->name('destroy');
    Route::get('/{id}', [OrganisasiSelfController::class, 'show'])->name('show');

    // ======= TAMBAH & EDIT ANGGOTA =======
    Route::get('/{id}/tambah-anggota', [OrganisasiSelfController::class, 'tambahAnggota'])->name('tambah_anggota');
    Route::post('/{id}/tambah-anggota', [OrganisasiSelfController::class, 'storeAnggota'])->name('store_anggota');

    Route::get('/{id}/edit-anggota/{nim}', [OrganisasiSelfController::class, 'editAnggota'])->name('edit_anggota');
    Route::put('/{id}/edit-anggota/{nim}', [OrganisasiSelfController::class, 'updateAnggota'])->name('update_anggota');
    Route::delete('/{id}/hapus-anggota/{nim}', [OrganisasiSelfController::class, 'deleteAnggota'])->name('delete_anggota');
});

// ========================== KEGIATAN SELF ==========================
Route::prefix('kegiatan-self')->name('kegiatan-self.')->group(function () {
    Route::get('/', [KegiatanSelfController::class, 'index'])->name('index');
    Route::get('/create', [KegiatanSelfController::class, 'create'])->name('create');
    Route::post('/store', [KegiatanSelfController::class, 'store'])->name('store');
    Route::get('/{id}', [KegiatanSelfController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [KegiatanSelfController::class, 'edit'])->name('edit');
    Route::post('/{id}/update', [KegiatanSelfController::class, 'update'])->name('update');
    Route::delete('/{id}', [KegiatanSelfController::class, 'destroy'])->name('destroy');
    Route::get('/{id}/add-mahasiswa', [KegiatanSelfController::class, 'addMahasiswa'])->name('addMahasiswa');
    Route::post('/{id}/store-mahasiswa', [KegiatanSelfController::class, 'storeMahasiswa'])->name('storeMahasiswa');
    Route::delete('/{id}/mahasiswa/{nim}', [KegiatanSelfController::class, 'destroyMahasiswa'])->name('destroyMahasiswa');
});

// ========================== KEGIATAN ==========================
Route::resource('kegiatan', KegiatanController::class);
Route::get('/kegiatan/{kegiatan}/tambah-mahasiswa', [KegiatanController::class, 'tambahMahasiswaForm'])
    ->name('kegiatan.tambahMahasiswaForm');
Route::post('/kegiatan/{kegiatan}/tambah-mahasiswa', [KegiatanController::class, 'tambahMahasiswaStore'])
    ->name('kegiatan.tambahMahasiswaStore');
Route::delete('/kegiatan/{kegiatan}/mahasiswa/{nim}', [KegiatanController::class, 'hapusMahasiswa'])
    ->name('kegiatan.hapusMahasiswa');

// ========================== POIN MAHASISWA ==========================
Route::get('/poin/export', [PoinMahasiswaController::class, 'export'])->name('poin.export');
Route::get('/poin/latest/all', [PoinMahasiswaController::class, 'getAllLatestPoin'])->name('poin.latestAll');
Route::resource('poin', PoinMahasiswaController::class);

// ========================== SISTEM SKPI ==========================
Route::prefix('skpi')->middleware(['web'])->group(function () {
    Route::get('/', [SKPIController::class, 'index'])->name('skpi.form');
    Route::post('/generate', [SKPIController::class, 'generate'])->name('skpi.generate');
    Route::post('/generate-diploma', [SKPIController::class, 'generateDiploma'])->name('skpi.generateDiploma');
});

// ========================== PROFILE ==========================
Route::get('/penentuan-poin', [PenentuanPoinController::class, 'index'])->name('penentuan-poin.index');
Route::resource('penentuan_poin', PenentuanPoinController::class);

// ========================== MAHASISWA ==========================
Route::get('/mahasiswa/data', [MahasiswaController::class, 'dataMahasiswa'])->name('mahasiswa.data');
Route::resource('mahasiswa', MahasiswaController::class);

// ========================== MAHASISWA - TEMAN & LEADERBOARD ==========================
Route::prefix('mahasiswa')->name('mahasiswa.')->middleware(['web'])->group(function () {
    Route::get('/profil', [ProfileController::class, 'index'])->name('profil');
    Route::get('/teman', [TemanController::class, 'index'])->name('teman.index');
    Route::get('/teman/list', [TemanController::class, 'listOnline'])->name('teman.list');
    Route::post('/teman/store', [TemanController::class, 'store'])->name('teman.store');
    Route::post('/teman/respond/{id}/{action}', [TemanController::class, 'respond'])->name('teman.respond');
    Route::delete('/teman/{id}', [TemanController::class, 'destroy'])->name('teman.destroy');
});

// Leaderboard
Route::get('/mahasiswa-leaderboard', [LeaderboardController::class, 'index'])->name('mahasiswa.leaderboard');
Route::get('/mahasiswa-profil', [ProfileController::class, 'index'])->name('mahasiswa.profil');

// ========================== API DASHBOARD ADMIN ==========================
Route::get('/api/admin/dashboard/statistik', [DashboardAdminController::class, 'statistik'])->name('admin.dashboard.statistik');

// ========================== FORGOT PASSWORD VIA EMAIL ==========================
Route::post('forgot-password', [ForgotPasswordController::class, 'sendCode'])->name('forgot.send');
Route::get('reset-password', [ForgotPasswordController::class, 'resetForm'])->name('forgot.reset.form');
Route::post('reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('forgot.reset');
