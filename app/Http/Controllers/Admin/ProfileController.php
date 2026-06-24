<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

        return redirect()->route('admin.profile.edit')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
