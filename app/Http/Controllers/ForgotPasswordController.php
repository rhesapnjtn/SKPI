<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    public function form()
    {
        return view('forgot-password'); // Form input email
    }

    public function sendCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->with('error', 'Email tidak ditemukan.');
        }

        $otp = rand(100000, 999999);

        // Insert / update password_resets dengan token kosong
        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            [
                'otp' => $otp,
                'expired_at' => Carbon::now()->addMinutes(10),
                'created_at' => now(),
                'token' => '', // wajib diisi
            ]
        );

        $request->session()->put('email', $request->email);

        Mail::raw(
            "Halo {$user->name},\n\nKode OTP reset password SKPI Anda adalah: $otp\n\nKode ini berlaku selama 10 menit.",
            function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Kode OTP Reset Password SKPI');
            }
        );

        return redirect()->route('forgot.reset.form')
            ->with('success', 'Kode OTP berhasil dikirim ke email.');
    }

    public function resetForm(Request $request)
    {
        $email = $request->session()->get('email');
        if (!$email) {
            return redirect()->route('forgot.form')->with('error', 'Silakan masukkan email terlebih dahulu.');
        }
        return view('reset-password', compact('email'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric',
            'password' => 'required|min:6|confirmed',
        ]);

        $record = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('otp', $request->otp)
            ->first();

        if (!$record) return back()->with('error', 'Kode OTP salah.');
        if (Carbon::now()->greaterThan(Carbon::parse($record->expired_at))) {
            return back()->with('error', 'Kode OTP sudah kadaluarsa.');
        }

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_resets')->where('email', $request->email)->delete();
        $request->session()->forget('email');

        return redirect()->route('login')->with('success', 'Password berhasil direset.');
    }
}
