<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TeamController extends Controller
{
    public function index(Request $request): View
    {
        $sortBy = in_array($request->sort_by, ['name', 'position', 'category', 'sort_order']) ? $request->sort_by : 'sort_order';
        $sortDir = in_array($request->sort_dir, ['asc', 'desc']) ? $request->sort_dir : 'asc';

        $teams = Team::query()
            ->when($request->search, fn($q, $v) => $q->where('name', 'like', "%{$v}%"))
            ->when($request->filter, fn($q, $v) => $q->where('category', $v))
            ->orderBy($sortBy, $sortDir)
            ->orderBy('id')
            ->paginate(15)
            ->appends(request()->query());

        return view('admin.team.index', compact('teams', 'sortBy', 'sortDir'));
    }

    public function create(): View
    {
        $members = Team::orderBy('category')->orderBy('sort_order')->get();

        return view('admin.team.form', [
            'team' => new Team(),
            'members' => $members,
        ]);
    }

    public function edit(Team $team): View
    {
        $members = Team::where('id', '!=', $team->id)->orderBy('category')->orderBy('sort_order')->get();

        return view('admin.team.form', compact('team', 'members'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'position'   => ['required', 'string', 'max:255'],
            'category'   => ['required', 'in:direksi,komisaris'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'photo'      => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ], [
            'name.required'       => 'Nama wajib diisi.',
            'name.string'         => 'Nama harus berupa teks.',
            'name.max'            => 'Nama maksimal :max karakter.',
            'position.required'   => 'Jabatan wajib diisi.',
            'position.string'     => 'Jabatan harus berupa teks.',
            'position.max'        => 'Jabatan maksimal :max karakter.',
            'category.required'   => 'Kategori wajib diisi.',
            'category.in'         => 'Kategori harus salah satu dari: direksi atau komisaris.',
            'sort_order.integer'  => 'Urutan harus berupa angka.',
            'sort_order.min'      => 'Urutan minimal 0.',
            'photo.image'         => 'File harus berupa gambar.',
            'photo.mimes'         => 'Format foto harus jpeg, png, jpg, atau webp.',
            'photo.max'           => 'Ukuran foto maksimal :max KB.',
        ]);

        // Ensure unique sort_order within category
        $sortOrder = $validated['sort_order'] ?? 0;
        while (Team::where('category', $validated['category'])->where('sort_order', $sortOrder)->exists()) {
            $sortOrder++;
        }
        $validated['sort_order'] = $sortOrder;

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('team', 'public');
        }

        Team::create($validated);

        return redirect()->route('admin.team.index')
            ->with('success', 'Anggota tim berhasil ditambahkan.');
    }

    public function update(Request $request, Team $team): RedirectResponse
    {
        $validated = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'position'   => ['required', 'string', 'max:255'],
            'category'   => ['required', 'in:direksi,komisaris'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'photo'      => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ], [
            'name.required'       => 'Nama wajib diisi.',
            'name.string'         => 'Nama harus berupa teks.',
            'name.max'            => 'Nama maksimal :max karakter.',
            'position.required'   => 'Jabatan wajib diisi.',
            'position.string'     => 'Jabatan harus berupa teks.',
            'position.max'        => 'Jabatan maksimal :max karakter.',
            'category.required'   => 'Kategori wajib diisi.',
            'category.in'         => 'Kategori harus salah satu dari: direksi atau komisaris.',
            'sort_order.integer'  => 'Urutan harus berupa angka.',
            'sort_order.min'      => 'Urutan minimal 0.',
            'photo.image'         => 'File harus berupa gambar.',
            'photo.mimes'         => 'Format foto harus jpeg, png, jpg, atau webp.',
            'photo.max'           => 'Ukuran foto maksimal :max KB.',
        ]);

        // Ensure unique sort_order within category (exclude current item)
        $sortOrder = $validated['sort_order'] ?? 0;
        while (Team::where('category', $validated['category'])
            ->where('id', '!=', $team->id)
            ->where('sort_order', $sortOrder)
            ->exists()) {
            $sortOrder++;
        }
        $validated['sort_order'] = $sortOrder;

        if ($request->hasFile('photo')) {
            if ($team->photo) {
                Storage::disk('public')->delete($team->photo);
            }
            $validated['photo'] = $request->file('photo')->store('team', 'public');
        }

        $team->update($validated);

        return redirect()->route('admin.team.index')
            ->with('success', 'Anggota tim berhasil diperbarui.');
    }

    public function destroy(Team $team): RedirectResponse
    {
        if ($team->photo) {
            Storage::disk('public')->delete($team->photo);
        }

        $team->delete();

        return redirect()->route('admin.team.index')
            ->with('success', 'Anggota tim berhasil dihapus.');
    }
}
