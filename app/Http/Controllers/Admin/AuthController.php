<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    public function showForgotPassword()
{
    return view('admin.forgot-password');
}
 
/**
 * Kirim link reset password ke email admin.
 * Memakai Password broker bawaan Laravel — otomatis membuat token
 * di tabel `password_reset_tokens` dan mengirim email berisi link reset.
 */
public function forgotPassword(Request $request)
{
    $request->validate([
        'email' => ['required', 'email'],
    ], [
        'email.required' => 'Email wajib diisi.',
        'email.email'    => 'Format email tidak valid.',
    ]);
 
    $status = Password::sendResetLink(
        $request->only('email')
    );
 
    if ($status === Password::RESET_LINK_SENT) {
        return back()->with('status', 'Tautan reset password telah dikirim ke email Anda.');
    }
 
    // Pesan generik, sengaja tidak menyebutkan apakah email terdaftar
    // atau tidak, supaya tidak membocorkan data pengguna (enumerasi akun).
    return back()->withErrors([
        'email' => 'Tidak dapat mengirim tautan reset. Pastikan email terdaftar sebagai admin.',
    ]);
}
 
/**
 * Tampilkan form reset password (dibuka dari link di email).
 */
public function showResetPassword(Request $request, string $token)
{
    return view('admin.reset-password', [
        'token' => $token,
        'email' => $request->query('email'),
    ]);
}
 
/**
 * Proses simpan password baru.
 */
public function resetPassword(Request $request)
{
    $request->validate([
        'token'    => ['required'],
        'email'    => ['required', 'email'],
        'password' => ['required', 'confirmed', 'min:8'],
    ], [
        'password.min'       => 'Password minimal 8 karakter.',
        'password.confirmed' => 'Konfirmasi password tidak cocok.',
    ]);
 
    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user) use ($request) {
            $user->forceFill([
                'password' => bcrypt($request->password),
            ])->save();
        }
    );
 
    if ($status === Password::PASSWORD_RESET) {
        return redirect()
            ->route('admin.login')
            ->with('status', 'Password berhasil diubah. Silakan masuk dengan password baru Anda.');
    }
 
    return back()->withErrors([
        'email' => 'Token reset tidak valid atau sudah kedaluwarsa. Silakan ajukan permintaan reset baru.',
    ]);
}
}