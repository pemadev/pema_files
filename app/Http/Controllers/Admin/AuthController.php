<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

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
 
    try {
        $status = Password::sendResetLink($request->only('email'));
    } catch (\Throwable $e) {
        // Biasanya karena pengaturan email (SMTP) di .env belum benar
        Log::error('Gagal mengirim email reset password: ' . $e->getMessage());

        return back()->withInput()->withErrors([
            'email' => 'Email tidak dapat dikirim saat ini karena gangguan server email. Silakan coba lagi nanti atau hubungi tim IT.',
        ]);
    }

    if ($status === Password::RESET_THROTTLED) {
        return back()->withInput()->withErrors([
            'email' => 'Tautan reset baru saja dikirim. Tunggu sekitar 1 menit sebelum meminta lagi.',
        ]);
    }

    // Pesan sama untuk email terdaftar maupun tidak, supaya tidak membocorkan
    // email mana yang terdaftar sebagai admin (enumerasi akun).
    return back()->with('status', 'Jika email tersebut terdaftar sebagai admin, tautan reset password sudah dikirim. Periksa kotak masuk atau folder spam Anda.');
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
                'password'       => Hash::make($request->password),
                'remember_token' => Str::random(60), // keluarkan sesi "ingat saya" yang lama
            ])->save();

            event(new PasswordReset($user));
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