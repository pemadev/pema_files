<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfileContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileContentController extends Controller
{
    public function index()
    {
        $profiles = ProfileContent::all()->groupBy('type');

        return view('admin.profil.index', compact('profiles'));
    }

    public function edit(string $type)
    {
        $profile = ProfileContent::firstOrNew(['type' => $type]);

        return view('admin.profil.edit', compact('profile', 'type'));
    }

    public function update(string $type, Request $request)
{
    $validated = $request->validate([
        'title'          => ['required', 'string', 'max:255'],
        'content'        => ['required', 'string'],
        'additional_info' => ['nullable', 'string'],
        'image'          => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        'image_left'     => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        'image_right'    => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
    ], [
        'title.required'           => 'Judul wajib diisi.',
        'title.string'             => 'Judul harus berupa teks.',
        'title.max'                => 'Judul maksimal :max karakter.',
        'content.required'         => 'Konten wajib diisi.',
        'content.string'           => 'Konten harus berupa teks.',
        'additional_info.string'   => 'Informasi tambahan harus berupa teks.',
        'image.image'              => 'File harus berupa gambar.',
        'image.mimes'              => 'Format gambar harus jpg, jpeg, png, atau webp.',
        'image.max'                => 'Ukuran gambar maksimal :max KB.',
        'image_left.image'         => 'Foto kiri harus berupa gambar.',
        'image_left.mimes'         => 'Format foto kiri harus jpg, jpeg, png, atau webp.',
        'image_left.max'           => 'Ukuran foto kiri maksimal :max KB.',
        'image_right.image'        => 'Foto kanan harus berupa gambar.',
        'image_right.mimes'        => 'Format foto kanan harus jpg, jpeg, png, atau webp.',
        'image_right.max'          => 'Ukuran foto kanan maksimal :max KB.',
    ]);

    $profile = ProfileContent::firstOrCreate(['type' => $type]);

    $profile->title = $validated['title'];
    $profile->content = $validated['content'];
    $profile->additional_info = $validated['additional_info'] ?? null;

    if ($request->hasFile('image')) {
        if ($profile->image) {
            Storage::disk('public')->delete($profile->image);
        }
        $profile->image = $request->file('image')->store('profile', 'public');
    }

    if ($request->hasFile('image_left')) {
        if ($profile->image_left) {
            Storage::disk('public')->delete($profile->image_left);
        }
        $profile->image_left = $request->file('image_left')->store('profile', 'public');
    }

    if ($request->hasFile('image_right')) {
        if ($profile->image_right) {
            Storage::disk('public')->delete($profile->image_right);
        }
        $profile->image_right = $request->file('image_right')->store('profile', 'public');
    }

    $profile->save();

    return redirect()->route('admin.profil.index')
        ->with('success', 'Konten profil berhasil diperbarui.');
}

}