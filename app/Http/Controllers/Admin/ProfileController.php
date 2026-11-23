<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        $user = Auth::user();

        return view('admin.profile.edit', compact('user'));
    }

    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ], [
            'name.required'  => 'Nama wajib diisi.',
            'name.string'    => 'Nama harus berupa teks.',
            'name.max'       => 'Nama maksimal :max karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
            'email.max'      => 'Email maksimal :max karakter.',
            'email.unique'   => 'Email sudah digunakan.',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        // Foto profil
        if ($request->hasFile("avatar") || $request->boolean("remove_avatar")) {
            if (! User::supportsAvatar()) {
                return back()->withInput()->with("error", "Kolom foto profil belum ada di database. Jalankan dulu SQL penambahan kolom avatar pada tabel users.");
            }

            $request->validate([
                "avatar" => ["nullable", "image", "mimes:jpg,jpeg,png,webp", "max:2048", "dimensions:min_width=64,min_height=64"],
            ], [
                "avatar.image"      => "Foto profil harus berupa gambar.",
                "avatar.mimes"      => "Format foto profil harus JPG, PNG, atau WebP.",
                "avatar.max"        => "Ukuran foto profil maksimal 2MB.",
                "avatar.dimensions" => "Foto profil minimal 64 x 64 piksel.",
            ]);

            $lama = $user->avatar;

            if ($request->hasFile("avatar")) {
                $user->avatar = $request->file("avatar")->store("avatars", "public");
            } else {
                $user->avatar = null;
            }

            if ($lama && $lama !== $user->avatar) {
                $fileLama = $lama; // dihapus setelah data tersimpan
            }
        }

        if ($request->filled('password')) {
            $request->validate([
                'current_password' => ['required', 'current_password'],
                'password'         => ['required', 'string', 'min:8', 'confirmed'],
            ], [
                'current_password.required'        => 'Kata sandi saat ini wajib diisi.',
                'current_password.current_password' => 'Kata sandi saat ini tidak cocok.',
                'password.required'                => 'Kata sandi baru wajib diisi.',
                'password.string'                  => 'Kata sandi baru harus berupa teks.',
                'password.min'                     => 'Kata sandi baru minimal :min karakter.',
                'password.confirmed'               => 'Konfirmasi kata sandi baru tidak cocok.',
            ]);

            $user->password = Hash::make($request->password);
        }

        $user->save();

        if (! empty($fileLama)) {
            Storage::disk('public')->delete($fileLama);
        }

        return redirect()->route('admin.profile.edit')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
