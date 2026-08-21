<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $sortBy = in_array($request->sort_by, ['name', 'email', 'created_at']) ? $request->sort_by : 'created_at';
        $sortDir = in_array($request->sort_dir, ['asc', 'desc']) ? $request->sort_dir : 'desc';

        $users = User::query()
            ->with('roles') // supaya role bisa ditampilkan di tabel tanpa query tambahan per-baris
            ->when($request->search, fn($q, $v) => $q->where('name', 'like', "%{$v}%")->orWhere('email', 'like', "%{$v}%"))
            ->orderBy($sortBy, $sortDir)
            ->orderBy('id')
            ->paginate(15)
            ->appends(request()->query());

        return view('admin.users.index', compact('users', 'sortBy', 'sortDir'));
    }

    public function create(): View
    {
        return view('admin.users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', Rule::unique('users')],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role'     => ['required', Rule::in(['admin', 'editor'])],
        ], [
            'name.required'         => 'Nama wajib diisi.',
            'name.string'           => 'Nama harus berupa teks.',
            'name.max'              => 'Nama maksimal :max karakter.',
            'email.required'        => 'Email wajib diisi.',
            'email.email'           => 'Format email tidak valid.',
            'email.max'             => 'Email maksimal :max karakter.',
            'email.unique'          => 'Email sudah digunakan.',
            'password.required'     => 'Kata sandi wajib diisi.',
            'password.string'       => 'Kata sandi harus berupa teks.',
            'password.min'          => 'Kata sandi minimal :min karakter.',
            'password.confirmed'    => 'Konfirmasi kata sandi tidak cocok.',
            'role.required'         => 'Role wajib dipilih.',
            'role.in'               => 'Role tidak valid.',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->assignRole($validated['role']);

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role'     => [$user->hasRole('super_admin') ? 'nullable' : 'required', Rule::in(['admin', 'editor'])],
        ], [
            'name.required'         => 'Nama wajib diisi.',
            'name.string'           => 'Nama harus berupa teks.',
            'name.max'              => 'Nama maksimal :max karakter.',
            'email.required'        => 'Email wajib diisi.',
            'email.email'           => 'Format email tidak valid.',
            'email.max'             => 'Email maksimal :max karakter.',
            'email.unique'          => 'Email sudah digunakan.',
            'password.string'       => 'Kata sandi harus berupa teks.',
            'password.min'          => 'Kata sandi minimal :min karakter.',
            'password.confirmed'    => 'Konfirmasi kata sandi tidak cocok.',
            'role.required'         => 'Role wajib dipilih.',
            'role.in'               => 'Role tidak valid.',
        ]);

        // Cegah admin/super_admin terakhir mengubah role dirinya sendiri jadi editor
        // (supaya tidak ada kasus semua akun admin terkunci dari fitur hapus)
        if (
            $user->id === auth()->id()
            && $user->hasAnyRole(['admin', 'super_admin'])
            && $validated['role'] === 'editor'
        ) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Tidak dapat mengubah role akun sendiri menjadi editor.');
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        // super_admin tidak diubah lewat form ini untuk mencegah privilege escalation
        // yang tidak disengaja; hanya menukar antara admin <-> editor.
        if (!$user->hasRole('super_admin')) {
            $user->syncRoles([$validated['role']]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}