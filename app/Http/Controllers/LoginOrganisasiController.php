<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Organisasi;
use Illuminate\Support\Facades\Hash;

class LoginOrganisasiController extends Controller
{

    // tampilkan form login
    public function form()
    {
        return view('login.organisasi');
    }

    // proses login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)
                    ->where('role', 'organisasi')
                    ->first();

        if (!$user) {
            return back()->with('error', 'Akun organisasi tidak ditemukan');
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Password salah');
        }

        // cari organisasi berdasarkan email
        $organisasi = Organisasi::where('email', $user->email)->first();

        // simpan session
        session([
            'is_logged_in' => true,
            'user_role' => 'organisasi',
            'user_email' => $user->email,
            'id_organisasi' => $organisasi->id ?? null
        ]);

        return redirect()->route('organisasi.dashboard');
    }

    // logout
    public function logout()
    {
        session()->flush();
        return redirect('/login/organisasi');
    }
}